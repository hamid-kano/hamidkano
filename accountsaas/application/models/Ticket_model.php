<?php
/**
 * Almusand -  Accounting,  Invoicing  and CRM Application
 * Copyright (c) Almusand. All Rights Reserved
 * ***********************************************************************
 *
 *  Email: support@almusand.com
 *  Website: https://almusand.com
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket_model extends CI_Model
{


    //documents list

    var $doccolumn_order = array(null, 'subject', 'created', null);
    var $doccolumn_search = array('subject', 'created');


    public function thread_list($id,$hash_code)
    {
        $this->db->select('geopos_tickets_th.*,geopos_customers.name AS custo,geopos_employees.name AS emp');
        $this->db->from('geopos_tickets_th');
        $this->db->join('geopos_customers', 'geopos_tickets_th.cid=geopos_customers.id', 'left');
        $this->db->join('geopos_employees', 'geopos_tickets_th.eid=geopos_employees.id', 'left');
        $this->db->where('geopos_tickets_th.tid', $id);
        $this->db->where('geopos_tickets_th.company_id', getCompanyId());
        $query = $this->db->get();
        return $query->result_array();
    }

     private function send_email($mailto, $mailtotitle, $subject, $message, $attachmenttrue = false, $attachment = '')
    {
        $this->load->library('ultimatemailer');
        $this->db->select('host,port,auth,auth_type,username,password,sender');
        $this->db->from('geopos_smtp');
        $query = $this->db->get();
        $smtpresult = $query->row_array();
        $host = $smtpresult['host'];
        $port = $smtpresult['port'];
        $auth = $smtpresult['auth'];
		$auth_type = $smtpresult['auth_type'];
        $username = $smtpresult['username'];;
        $password = $smtpresult['password'];
        $mailfrom = $smtpresult['sender'];
        $mailfromtilte = $this->config->item('ctitle');

        $this->ultimatemailer->load($host, $port, $auth, $auth_type, $username, $password, $mailfrom, $mailfromtilte, $mailto, $mailtotitle, $subject, $message, $attachmenttrue, $attachment);

    }


    public function thread_info($id,$hash_code)
    {
        $this->db->select('geopos_tickets.*, geopos_customers.name,geopos_customers.email');
        $this->db->from('geopos_tickets');
        $this->db->join('geopos_customers', 'geopos_tickets.cid=geopos_customers.id', 'left');
        $this->db->where('geopos_tickets.id', $id);
        $this->db->where('geopos_tickets.company_id', getCompanyId());
        $this->db->where('geopos_tickets.hash_code', $hash_code);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function ticket()
    {
        $this->db->select('*');
        $this->db->from('univarsal_api');
        $this->db->where('id', 3);
        $this->db->where('company_id', getCompanyId());
        $query = $this->db->get();
        return $query->row();
    }

    function addreply($thread_id, $message, $filename,$hash_code)
    {
        $customer = $this->thread_info($thread_id,$hash_code);
        $data = array('tid' => $thread_id, 'message' => $message, 'cid' => 0, 'eid' => $this->aauth->get_user()->id, 'cdate' => date('Y-m-d H:i:s'), 'attach' => $filename,'company_id' =>getCompanyId(),'hash_code' =>getHashCode());
       /* if ($this->ticket()->key2) {

            $this->send_email($customer['email'], $customer['name'], '[Customer Ticket] #' . $thread_id, $message . $this->ticket()->other, $attachmenttrue = false, $attachment = '');

        }*/
        
        $this->db->select('geopos_project_meta.* , geopos_users.id as employee_id, geopos_users.email as employee_email, geopos_projects.id as project_id, geopos_projects.name as project_name');
        $this->db->from('geopos_project_meta');
        $this->db->join('geopos_users', 'geopos_project_meta.meta_data=geopos_users.id', 'left');
        $this->db->join('geopos_projects', 'geopos_project_meta.pid=geopos_projects.id', 'left');
        $this->db->where('geopos_project_meta.pid', $customer['project_id']);
        $this->db->where('geopos_project_meta.meta_key', 19);
        $this->db->where('geopos_project_meta.company_id', getCompanyId());
        $query = $this->db->get();
        $results = $query->result_array();
        $emails = array_column($results,'employee_email');
        $names = array_column($results,'project_name');
        if (($key = array_search($this->aauth->get_user()->email, $emails)) !== false) {
            unset($emails[$key]);
        }
        foreach($emails as $email) {
            $this->send_email($email, $customer['name'], '[Customer Reply] #' . $thread_id . ' | '.$names[0], $message, $attachmenttrue = false, $attachment = '');
        }
        
        return $this->db->insert('geopos_tickets_th', $data);

    }
    
    function addticket($subject, $message, $filename, $project_id = null)
    {
        $this->db->select('geopos_projects.*,geopos_customers.email AS customer_email');
        $this->db->from('geopos_projects');
        $this->db->where('geopos_projects.id', $project_id);
        $this->db->where('geopos_projects.company_id', getCompanyId());
        $this->db->join('geopos_customers', 'geopos_projects.cid = geopos_customers.id', 'left');
        $query = $this->db->get();
        $project = $query->row_array();
        $data = array('subject' => $subject, 'created' => date('Y-m-d H:i:s'), "project_id"=> $project_id, 'cid' => $project['cid'], 'status' => 'Waiting','company_id' =>getCompanyId(),'hash_code' =>getHashCode());
        if(!$this->db->insert('geopos_tickets', $data)) {
            return false;
        }
        $thread_id = $this->db->insert_id();

    $message2 = 'تم إنشاء تذكرة جديدة';
    $message2.= '<h6><strong>' . $this->config->item('ctitle') . ',</strong></h6><address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');
       
        $data = array('tid' => $thread_id, 'message' => $message, 'cid' => 0, 'eid' => $this->aauth->get_user()->id, 'cdate' => date('Y-m-d H:i:s'), 'attach' => $filename);
        if($this->db->insert('geopos_tickets_th', $data)) {
       $email= $this->send_email($project['customer_email'], $subject, '[Customer Ticket] #' . $thread_id, $message2, $attachmenttrue = false, $attachment = '');
        return true;
        } else {
            return false;
        }


    }

    function deleteticket($id,$hash_code)
    {
        $this->db->delete('geopos_tickets', array('id' => $id,'company_id' =>getCompanyId(),'hash_code'=>$hash_code));

        $this->db->select('attach');
        $this->db->from('geopos_tickets_th');
        $this->db->where('tid', $id);
        $this->db->where('company_id', getCompanyId());
        $query = $this->db->get();
        $result = $query->result_array();
        foreach ($result as $row) {
            if ($row['attach'] != '') {

                unlink(FCPATH . 'userfiles/support/' . $row['attach']);

            }
        }
        $this->db->delete('geopos_tickets_th', array('tid' => $id,'company_id' =>getCompanyId()));
        return true;
    }

    public function ticket_stats()
    {

        $query = $this->db->query("SELECT
				COUNT(IF( status = 'Waiting', id, NULL)) AS Waiting,
				COUNT(IF( status = 'Processing', id, NULL)) AS Processing,
				COUNT(IF( status = 'Solved', id, NULL)) AS Solved
				FROM geopos_tickets where company_id=".getCompanyId()." ");
        echo json_encode($query->result_array());

    }


    function ticket_datatables($filt)
    {
        $this->ticket_datatables_query($filt);
        $this->db->where('geopos_tickets.company_id', getCompanyId());
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    private function ticket_datatables_query($filt)
    {
        $this->db->select('geopos_tickets.* , geopos_customers.name AS customer, geopos_projects.name AS project');
        $this->db->from('geopos_tickets');
        $this->db->join('geopos_customers', 'geopos_tickets.cid=geopos_customers.id', 'left');
        $this->db->join('geopos_projects', 'geopos_tickets.project_id=geopos_projects.id', 'left');
        if ($filt == 'unsolved') {
            $this->db->where('geopos_tickets.status!=', 'Solved');
        }
        $this->db->where('geopos_tickets.company_id', getCompanyId());

        $i = 0;

        foreach ($this->doccolumn_search as $item) // loop column
        {
            $search = $this->input->post('search');
        if(isset($search['value'])){
            $value = $search['value'];
        }else{
            $value= '';
        }
            
            if ($value) {

                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $value);
                } else {
                    $this->db->or_like($item, $value);
                }

                if (count($this->doccolumn_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $search = $this->input->post('order');
        if ($search) {
            $this->db->order_by($this->doccolumn_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function ticket_count_filtered($filt)
    {
        $this->ticket_datatables_query($filt);
        $this->db->where('geopos_tickets.company_id', getCompanyId());
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function ticket_count_all($filt)
    {
        $this->ticket_datatables_query($filt);
        $this->db->where('geopos_tickets.company_id', getCompanyId());
        $query = $this->db->get();
        return $query->num_rows();
    }


}