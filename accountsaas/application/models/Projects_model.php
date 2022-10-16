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

class Projects_model extends CI_Model
{

    var $column_order = array('geopos_projects.status', 'geopos_projects.name', 'geopos_projects.edate', 'geopos_projects.worth', null, null);
    var $column_search = array('geopos_projects.name', 'geopos_projects.status');
    var $tcolumn_order = array('status', 'name', 'duedate', 'start', null, null);
    var $tcolumn_search = array('name', 'edate', 'status');
    var $order = array('id' => 'desc');


    public function explore($id,$hash_code)
    {
        //project
        $this->db->select('geopos_projects.*,geopos_customers.name AS customer,geopos_customers.email,geopos_customers.phone');
        $this->db->from('geopos_projects');
        $this->db->where('geopos_projects.id', $id);
        $this->db->where('geopos_projects.hash_code', $hash_code);
        $this->db->where('geopos_projects.company_id', getCompanyId());
        $this->db->join('geopos_customers', 'geopos_projects.cid = geopos_customers.id', 'left');
        $query = $this->db->get();
        $project = $query->row_array();
        //employee
        $this->db->select('geopos_employees.name');
        $this->db->from('geopos_project_meta');
        $this->db->where('geopos_project_meta.pid', $id);
        $this->db->where('geopos_project_meta.company_id', getCompanyId());
        $this->db->where('geopos_project_meta.meta_key', 6);
        $this->db->join('geopos_employees', 'geopos_project_meta.meta_data = geopos_employees.id', 'left');
        $query = $this->db->get();
        $employee = $query->result_array();
        //invoices
        $this->db->select('geopos_invoices.*');
        $this->db->from('geopos_project_meta');
        $this->db->where('geopos_project_meta.pid', $id);
        $this->db->where('geopos_project_meta.company_id', getCompanyId());
        $this->db->where('geopos_project_meta.meta_key', 11);
        $this->db->join('geopos_invoices', 'geopos_project_meta.meta_data = geopos_invoices.id', 'left');
        $query = $this->db->get();
        $invoices = $query->result_array();
            //clock
        $this->db->select('*');
        $this->db->from('geopos_project_meta');
        $this->db->where('pid', $id);
        $this->db->where('geopos_project_meta.company_id', getCompanyId());
        $this->db->where('meta_key', 29);
        $this->db->where('meta_data', $this->aauth->get_user()->id);
        $query = $this->db->get();
        $clock = $query->row_array();

        return array('project' => $project, 'employee' => $employee, 'invoices' => $invoices,'clock'=>$clock);

    }

    public function details($id)
    {
//project
        $this->db->select('geopos_projects.*,geopos_projects.id AS prj, geopos_customers.name AS customer,geopos_project_meta.*');
        $this->db->from('geopos_projects');
        $this->db->where('geopos_projects.id', $id);
        $this->db->where('geopos_projects.company_id', getCompanyId());
        $this->db->where('geopos_project_meta.meta_key', 2);
        $this->db->join('geopos_customers', 'geopos_projects.cid = geopos_customers.id', 'left');
        $this->db->join('geopos_project_meta', 'geopos_project_meta.pid = geopos_projects.id', 'left');

        $query = $this->db->get();
        return $query->row_array();
    }

    private function _project_datatables_query($cday = '', $eid = '')
    {
        $this->db->select("geopos_projects.*,geopos_customers.name AS customer");
        $this->db->from('geopos_projects');
        $this->db->join('geopos_customers', 'geopos_projects.cid = geopos_customers.id', 'left');
        if ($eid) {

            $this->db->join('geopos_project_meta', 'geopos_projects.id = geopos_project_meta.pid', 'left');
            $this->db->where('geopos_project_meta.meta_key', 19);
            $this->db->where('geopos_project_meta.meta_data', $eid);
        }
        if ($cday) {
            $this->db->where('DATE(geopos_projects.edate)=', $cday);
        }
        $this->db->where('geopos_projects.company_id', getCompanyId());


        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            $search = $this->input->post('search');
        if(!isset($search['value'])){
            $search['value'] = '';
        }
            $value = $search['value'];
            if ($value) {

                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $value);
                } else {
                    $this->db->or_like($item, $value);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $search = $this->input->post('order');
        if ($search) {
            $this->db->order_by($this->column_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function project_datatables($cday = '', $eid = '')
    {


        $this->_project_datatables_query($cday, $eid);
        $this->db->where('geopos_projects.company_id', getCompanyId());
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    function project_count_filtered($cday = '', $eid = '')
    {
        $this->_project_datatables_query($cday, $eid);
        $this->db->where('geopos_projects.company_id', getCompanyId());
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function project_count_all($cday = '', $eid = '')
    {
        $this->_project_datatables_query($cday, $eid);
        $this->db->where('geopos_projects.company_id', getCompanyId());
        $this->db->where('geopos_projects.company_id', getCompanyId());
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function addproject($name, $status, $priority, $progress, $customer, $sdate, $edate, $tag, $phase, $content, $budget, $customerview, $customer_comment, $link_to_cal, $color, $ptype, $employee)
    {
        $data = array('name' => $name, 'status' => $status, 'priority' => $priority, 'progress' => $progress, 'cid' => $customer, 'sdate' => $sdate, 'edate' => $edate, 'tag' => $tag, 'phase' => $phase, 'note' => $content, 'worth' => $budget, 'ptype' => $ptype ,'company_id'=> getCompanyId(),'hash_code'=> getHashCode());
        $this->db->insert('geopos_projects', $data);
        $last = $this->db->insert_id();
        $title = '[Project Created] ';
        $this->add_activity($title, $last);
        $data = array('pid' => $last, 'meta_key' => 2, 'meta_data' => $customerview, 'value' => $customer_comment ,'company_id'=> getCompanyId(),'hash_code'=> getHashCode());
        $this->db->insert('geopos_project_meta', $data);

        if ($employee) {
            foreach ($employee as $key => $value) {

                $data = array('pid' => $last, 'meta_key' => 19, 'meta_data' => $value ,'company_id'=> getCompanyId(),'hash_code'=> getHashCode());
                $this->db->insert('geopos_project_meta', $data);
            }
        } else {
            $data = array('pid' => $last, 'meta_key' => 19, 'meta_data' => $this->aauth->get_user()->id ,'company_id'=> getCompanyId(),'hash_code'=> getHashCode());
            $this->db->insert('geopos_project_meta', $data);
        }


        if ($link_to_cal > 0) {
            if ($link_to_cal == 1) {
                $sdate = $edate;
            }
            $data = array(
                'title' => '[Project] ' . $name,
                'start' => $sdate,
                'end' => $edate,
                'description' => $priority . ' priority. Start date: ' . $sdate . ' End Date: ' . $edate, 'color' => $color,
                'rel' => 1,
                'rid' => $last ,'company_id'=> getCompanyId(),'hash_code'=> getHashCode()
            );
            $this->db->insert('geopos_events', $data);
        }

        return $last;
    }

    public function editproject($id, $name, $status, $priority, $progress, $customer, $sdate, $edate, $tag, $phase, $content, $budget, $customerview, $customer_comment, $link_to_cal, $color, $ptype, $employee,$hash_code)
    {
        $title = '[Project Edited] ';
        $this->add_activity($title, $id);
        $data = array('name' => $name, 'status' => $status, 'priority' => $priority, 'progress' => $progress, 'cid' => $customer, 'sdate' => $sdate, 'edate' => $edate, 'tag' => $tag, 'phase' => $phase, 'note' => $content, 'worth' => $budget, 'ptype' => $ptype);
        $this->db->set($data);
        $this->db->where('id', $id);
        $this->db->where('hash_code', $hash_code);
        $this->db->where('company_id', getCompanyId());
        $out = $this->db->update('geopos_projects');

        $this->db->delete('geopos_events', array('rel' => 1, 'rid' => $id,'company_id'=>getCompanyId()));
        if ($link_to_cal > 0) {
            if ($link_to_cal == 1) {
                $sdate = $edate;
            }
            $data = array(
                'title' => '[Project] ' . $name,
                'start' => $sdate,
                'end' => $edate,
                'description' => $priority . ' priority. Start date: ' . $sdate . ' End Date: ' . $edate, 'color' => $color,
                'rel' => 1,
                'rid' => $id ,'company_id'=> getCompanyId(),'hash_code'=> getHashCode()
            );
            $this->db->insert('geopos_events', $data);
        }
        if ($employee) {
            $this->db->delete('geopos_project_meta', array('pid' => $id, 'meta_key' => 19,'company_id'=>getCompanyId()));
            foreach ($employee as $key => $value) {

                $data = array('pid' => $id, 'meta_key' => 19, 'meta_data' => $value ,'company_id'=> getCompanyId(),'hash_code'=> getHashCode());
                $this->db->insert('geopos_project_meta', $data);
            }
        }

        $data1 = array('meta_data' => $customerview, 'value' => $customer_comment);
        $this->db->set($data1);
        $this->db->where('pid', $id);
        $this->db->where('meta_key', 2);
        $this->db->where('company_id', getCompanyId());

        return $this->db->update('geopos_project_meta');
    }


    public function addtask($name, $status, $priority, $stdate, $tdate, $employee, $assign, $content, $prid, $milestone)
    {

        $data = array('tdate' => date('Y-m-d H:i:s'), 'name' => $name, 'status' => $status, 'start' => $stdate, 'duedate' => $tdate, 'description' => $content, 'eid' => $employee, 'aid' => $assign, 'related' => 1, 'priority' => $priority, 'rid' => $prid,'company_id'=> getCompanyId(),'hash_code'=> getHashCode());
        if ($prid) {

            $this->db->insert('geopos_todolist', $data);
            $last = $this->db->insert_id();
            
            $this->add_activity("[Task Created : ".$name."] ", $prid);
            
            if ($milestone) {
                $this->meta_insert($prid, 8, $milestone, $last);
            }

            $out = $this->communication($prid, $name);

            return 1;
        } else {
            return 0;
        }
    }

    public function add_milestone($name, $stdate, $tdate, $content, $color, $prid,$hash_code_project)
    {

        $data = array('pid' => $prid, 'name' => $name, 'sdate' => $stdate, 'edate' => $tdate, 'color' => $color, 'exp' => $content,'company_id'=> getCompanyId(),'hash_code'=> getHashCode());
        if ($prid) {

            $title = '[Milestone] ' . $name;
            $this->add_activity($title, $prid);
                
            $project_data = $this->explore($prid,$hash_code_project);
            $message = " تم اضافة مستحقات جديدة للمشروع الخاص بك : <br> الاسم: ".$name.'<br> المحتوى : '.$content;
            $this->send_email($project_data['project']['email'], $project_data['project']['customer'], "[Milestone]  - Project #".$prid, $message);

            return $this->db->insert('geopos_milestones', $data);

        } else {
            return 0;
        }
    }

    public function edittask($id, $name, $status, $priority, $stdate, $tdate, $employee, $content,$hash_code)
    {

        $data = array('tdate' => date('Y-m-d H:i:s'), 'name' => $name, 'status' => $status, 'start' => $stdate, 'duedate' => $tdate, 'description' => $content, 'eid' => $employee,  'priority' => $priority);
        $this->db->set($data);
        $this->db->where('id', $id);
        $this->db->where('company_id', getCompanyId());
        $this->db->where('hash_code', $hash_code);
        return $this->db->update('geopos_todolist');
        //return $this->db->insert('geopos_todolist', $data);
    }

    public function settask($id, $stat)
    {

        $data = array('status' => $stat);
        $this->db->set($data);
        $this->db->where('id', $id);
        $this->db->where('company_id', getCompanyId());
        return $this->db->update('geopos_todolist');
    }

    public function setnote($id, $stat)
    {

        $data = array('note' => $stat);
        $this->db->set($data);
        $this->db->where('id', $id);
        $this->db->where('company_id', getCompanyId());
        return $this->db->update('geopos_projects');
    }

    public function deletetask($id,$hash_code)
    {

        return $this->db->delete('geopos_todolist', array('id' => $id,'hash_code'=>$hash_code,'company_id'=>getCompanyId()));
    }

    public function deleteproject($id,$hash_code)
    {
        $this->db->delete('geopos_todolist', array('related' => 1, 'rid' => $id,'company_id'=>getCompanyId()));

        return $this->db->delete('geopos_projects', array('id' => $id));
    }

    public function viewtask($id)
    {

        $this->db->select('geopos_todolist.*,geopos_employees.name AS emp, assi.name AS assign');
        $this->db->from('geopos_todolist');
        $this->db->where('geopos_todolist.id', $id);
        $this->db->join('geopos_employees', 'geopos_employees.id = geopos_todolist.eid', 'left');
        $this->db->join('geopos_employees AS assi', 'assi.id = geopos_todolist.aid', 'left');
        $this->db->where('geopos_todolist.company_id', getCompanyId());
        $query = $this->db->get();
        return $query->row_array();
    }

    public function project_stats($project)
    {

        $query = $this->db->query("SELECT
				COUNT(IF( status = 'Waiting', id, NULL)) AS Waiting,
				COUNT(IF( status = 'Progress', id, NULL)) AS Progress,
				COUNT(IF( status = 'Finished', id, NULL)) AS Finished			
				FROM geopos_projects where company_id =".getCompanyId()." ");

        echo json_encode($query->result_array());

    }

    //project tasks

    private function _task_datatables_query($cday = '')
    {

        $this->db->from('geopos_todolist');
        $this->db->where('related', 1);
        $this->db->where('company_id', getCompanyId());
        if ($cday) {

            $this->db->where('rid=', $cday);
        }


        $i = 0;

        foreach ($this->tcolumn_search as $item) // loop column
        {
            $search = $this->input->post('search');
        if(!isset($search['value'])){
            $search['value'] = '';
        }
            $value = $search['value'];
            if ($value) {

                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $value);
                } else {
                    $this->db->or_like($item, $value);
                }

                if (count($this->tcolumn_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $search = $this->input->post('order');
        if ($search) {
            $this->db->order_by($this->tcolumn_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function task_datatables($cday = '')
    {


        $this->_task_datatables_query($cday);
        $this->db->where('company_id', getCompanyId());
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $this->db->where('related', 1);
        $this->db->where('rid=', $cday);
        $query = $this->db->get();
        return $query->result();
    }

    function task_count_filtered($cday = '')
    {
        $this->_task_datatables_query($cday);
        $this->db->where('company_id', getCompanyId());
        $this->db->where('related', 1);
        $this->db->where('rid=', $cday);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function task_count_all($cday = '')
    {
        $this->_task_datatables_query($cday);
        $this->db->where('company_id', getCompanyId());
        $this->db->where('related', 1);
        $this->db->where('rid=', $cday);
        $query = $this->db->get();
        return $query->num_rows();
    }

    //thread task


    public function task_thread($id)
    {

        $this->db->select('geopos_todolist.*, geopos_employees.name AS emp');
        $this->db->from('geopos_todolist');
        $this->db->where('geopos_todolist.related', 1);
        $this->db->where('geopos_todolist.rid', $id);
        $this->db->where('geopos_todolist.company_id', getCompanyId());
        $this->db->join('geopos_employees', 'geopos_todolist.eid = geopos_employees.id', 'left');
        $this->db->order_by('geopos_todolist.id', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }


    public function milestones($id)
    {

        $this->db->select('*');
        $this->db->from('geopos_milestones');
        $this->db->where('geopos_milestones.company_id', getCompanyId());
        $this->db->where('pid', $id);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function milestones_list($id)
    {

        $query = $this->db->query('SELECT geopos_milestones.*,geopos_todolist.name as task FROM geopos_milestones LEFT JOIN geopos_project_meta ON geopos_project_meta.meta_data=geopos_milestones.id AND geopos_project_meta.meta_key=8 LEFT JOIN geopos_todolist ON geopos_project_meta.value=geopos_todolist.id WHERE geopos_milestones.pid=' . $id . ' and geopos_milestones.company_id='.getCompanyId().' ORDER BY geopos_milestones.id DESC;');
        return $query->result_array();


    }

    public function activities($id)
    {

        $this->db->select('geopos_project_meta.value');
        $this->db->from('geopos_project_meta');
        $this->db->where('pid', $id);
        $this->db->where('geopos_project_meta.company_id', getCompanyId());
        $this->db->where('meta_key', 12);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function p_files($id)
    {

        $this->db->select('*');
        $this->db->from('geopos_project_meta');
        $this->db->where('pid', $id);
        $this->db->where('geopos_project_meta.company_id', getCompanyId());
        $this->db->where('meta_key', 9);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function add_activity($name, $prid)
    {

        $data = array('pid' => $prid, 'meta_key' => 12, 'value' => $name . ' @' . date('Y-m-d H:i:s'),'company_id'=> getCompanyId(),'hash_code'=> getHashCode());
        if ($prid) {
            return $this->db->insert('geopos_project_meta', $data);
        } else {
            return 0;
        }
    }

    public function meta_insert($prid, $meta_key, $meta_data, $value, $key3 = null,$hash_prject)
    {


        $data = array('pid' => $prid, 'meta_key' => $meta_key, 'meta_data' => $meta_data, 'value' => $value,"key3"=>$key3,'company_id'=> getCompanyId(),'hash_code'=> getHashCode());
        if ($prid) {
             $hash_prject  =str_replace('"', '', $hash_prject);
             $project_data = $this->explore($prid,$hash_prject);

           $message = "  تم اضافة  ملف جديد للمشروع الخاص بك  ";
            $this->send_email($project_data['project']['email'], $project_data['project']['customer'], "[New File]  - Project #".$prid, $message);
            
            return $this->db->insert('geopos_project_meta', $data);
        } else {
            return 0;
        }
    }

    public function deletefile($pid, $mid)
    {

        $this->db->select('value');
        $this->db->from('geopos_project_meta');
        $this->db->where('pid', $pid);
        $this->db->where('meta_key', 9);
        $this->db->where('meta_data', $mid);
        $this->db->where('geopos_project_meta.company_id', getCompanyId());
        $query = $this->db->get();
        $result = $query->row_array();
        unlink(FCPATH . 'userfiles/project/' . $result['value']);
        $this->db->delete('geopos_project_meta', array('pid' => $pid, 'meta_key' => 9, 'meta_data' => $mid,'company_id'=> getCompanyId()));
    }

    public function deletemilestone($mid)
    {
        $this->db->delete('geopos_milestones', array('id' => $mid,'company_id'=> getCompanyId()));
    }

    //comments

    public function comments_thread($id)
    {

        $this->db->select('geopos_project_meta.value, geopos_project_meta.key3,geopos_employees.name AS employee, geopos_customers.name AS customer');
        $this->db->from('geopos_project_meta');
        $this->db->where('geopos_project_meta.company_id', getCompanyId());
        $this->db->where('geopos_project_meta.pid', $id);
        $this->db->where('geopos_project_meta.meta_key', 13);
        $this->db->join('geopos_employees', 'geopos_project_meta.meta_data = geopos_employees.id', 'left');
        $this->db->join('geopos_customers', 'geopos_project_meta.key3 = geopos_customers.id', 'left');
        $this->db->order_by('geopos_project_meta.id', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function add_comment($comment, $prid, $emp)
    {

        $data = array('pid' => $prid, 'meta_key' => 13, 'meta_data' => $emp, 'value' => $comment . '<br><small>@' . date('Y-m-d H:i:s') . '</small>','company_id'=> getCompanyId(),'hash_code'=> getHashCode());
        if ($prid) {
            
            $project_data = $this->explore($prid);
           $message = " تم اضافة تعليق جديد للمشروع الخاص بك : <br> المحتوى : ".$comment;
            $this->send_email($project_data['project']['email'], $project_data['project']['customer'], "[New Comment]  - Project #".$prid, $message);
            
            return $this->db->insert('geopos_project_meta', $data);
        } else {
            return 0;
        }
    }

    public function progress($id, $val,$hash_code)
    {
        if ($val == 100) $stat = 'Finished'; else $stat = 'Progress';
        $data = array('status' => $stat, 'progress' => $val);
        $project_data = $this->explore($id);
        $this->db->set($data);
        $this->db->where('id', $id);
        $this->db->where('hash_code', $hash_code);
        $this->db->where('company_id', getCompanyId());
        $this->db->update('geopos_projects');
        $message = "تم تحديث نسبة انجاز المشروع الى : ".$val."%   وحالة المشروع هى : ".$this->lang->line($stat);
        $this->send_email($project_data['project']['email'], $project_data['project']['customer'], '[Project Update] #' . $project_data['project']['id'], $message);
    }


    public function task_stats($id)
    {
        $query = $this->db->query("SELECT
				COUNT(IF( status = 'Due', id, NULL)) AS Due,
				COUNT(IF( status = 'Progress', id, NULL)) AS Progress,
				COUNT(IF( status = 'Done', id, NULL)) AS Done
				FROM geopos_todolist WHERE related=1 and company_id=".getCompanyId()." AND rid=$id");

        echo json_encode($query->result_array());

    }

    public function list_project_employee($id)
    {
        $this->db->select('geopos_employees.*');
        $this->db->from('geopos_project_meta');
        $this->db->where('geopos_project_meta.pid', $id);
        $this->db->where('geopos_employees.company_id', getCompanyId());
        $this->db->where('geopos_project_meta.meta_key', 19);
        $this->db->join('geopos_employees', 'geopos_employees.id = geopos_project_meta.meta_data and geopos_employees.company_id='.getCompanyId().'', 'left');
        $this->db->join('geopos_users', 'geopos_employees.id = geopos_users.id', 'left');
        $this->db->order_by('geopos_users.roleid', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

        public function list_project_time($id)
    {
        $this->db->select('geopos_employees.*,geopos_project_meta.key4');
        $this->db->from('geopos_project_meta');
        $this->db->where('geopos_project_meta.pid', $id);
        $this->db->where('geopos_project_meta.meta_key', 29);
        $this->db->where('geopos_project_meta.company_id', getCompanyId());
        $this->db->join('geopos_employees', 'geopos_employees.id = geopos_project_meta.meta_data', 'left');
        $this->db->join('geopos_users', 'geopos_employees.id = geopos_users.id', 'left');
        $this->db->order_by('geopos_users.roleid', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    private function communication($id, $sub)
    {

        $this->db->select('geopos_projects.name as pname,geopos_projects.ptype,geopos_customers.name as cust,geopos_customers.email');
        $this->db->from('geopos_projects');
        $this->db->where('geopos_projects.id', $id);
        $this->db->where('geopos_projects.company_id', getCompanyId());
        $this->db->join('geopos_customers', "geopos_customers.id = geopos_projects.cid", 'left');
        $query = $this->db->get();
        $result = $query->row_array();

        if ($result['ptype'] == '1') {
            $this->db->select('geopos_users.email,geopos_users.username');
            $this->db->from('geopos_project_meta');
            $this->db->where('geopos_project_meta.pid', $id);
            $this->db->where('geopos_project_meta.meta_key', 19);
            $this->db->where('geopos_project_meta.company_id', getCompanyId());
            $this->db->join('geopos_users', "geopos_project_meta.meta_data = geopos_users.id", 'left');
            $query = $this->db->get();
            $result_c = $query->result_array();
            $message = '<h3>Dear Project Participant,</h3>
                        <p>This is an update mail regarding your project ' . $result['pname'] . '</p> <p>A new task has been added ' . $sub . '</p><p>With Reagrds,<br>Project Communication Manager';
            foreach ($result_c as $row) {
                $this->send_email($row['email'], $row['username'], '[Task Added]' . $sub, $message);
            }


        } else if ($result['ptype'] == '2') {

            $this->db->select('geopos_users.email,geopos_users.username');
            $this->db->from('geopos_project_meta');
            $this->db->where('geopos_project_meta.pid', $id);
            $this->db->where('geopos_project_meta.company_id', getCompanyId());
            $this->db->where('geopos_project_meta.meta_key', 19);
            $this->db->join('geopos_users', "geopos_project_meta.meta_data = geopos_users.id", 'left');
            $query = $this->db->get();
            $result_c = $query->result_array();
            $message = '<h3>Dear Project Participant,</h3>
                        <p>This is an update mail regarding your project ' . $result['pname'] . '</p> <p>A new task has been added <strong>' . $sub . '</strong></p><p>With Regards,<br>Project Communication Manager</p>';
            foreach ($result_c as $row) {
                $this->send_email($row['email'], $row['username'], '[Task Added] ' . $sub, $message);
            }

            $message = '<h3>Dear Customer,</h3>
                        <p>This is an update mail regarding your project ' . $result['pname'] . '</p> <p>A new task has been added <strong>' . $sub . '</strong></p><p>With Warm Regards,<br>Project Communication Manager</p>';

            $this->send_email($result['email'], $result['cust'], '[Task Added] ' . $sub, $message);

        }

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
//  private function send_email($mailto, $mailtotitle, $subject, $message, $attachmenttrue = false, $attachment = '')
//     {
//         $this->load->library('ultimatemailer');
//         $this->db->select('host,port,auth,auth_type,username,password,sender');
//         $this->db->from('geopos_smtp');
//         $query = $this->db->get();
//         $smtpresult = $query->row_array();
//         $host = $smtpresult['host'];
//         $port = $smtpresult['port'];
//         $auth_type = $smtpresult['auth_type'];
//         $auth = $smtpresult['auth'];
//         $username = $smtpresult['username'];;
//         $password = $smtpresult['password'];
//         $mailfrom = $smtpresult['sender'];
//         $mailfromtilte = "Almusand";

//         $this->ultimatemailer->bin_send($host, $port, $auth, $auth_type, $username, $password, $mailfrom, $mailfromtilte, $mailto, $mailtotitle, $subject, $message, $attachmenttrue, $attachment);

//     }
    
    public function clockin($id, $eid,$hash_code)
    {
        $this->db->select('*');
        $this->db->where('pid', $id);
        $this->db->where('meta_key', 29);
        $this->db->where('meta_data', $eid);
        $this->db->where('geopos_project_meta.company_id', getCompanyId());
        $this->db->from('geopos_project_meta');
        $query = $this->db->get();
        $emp = $query->row_array();
        if (!$emp['key3'] AND $emp['pid']) {
            $this->db->set('value', time());
            $this->db->set('key3', 1);
            $this->db->where('id', $emp['id']);
            $this->db->where('geopos_project_meta.company_id', getCompanyId());
            $this->db->update('geopos_project_meta');
            $this->aauth->applog("[Employee ClockIn]  Project ID $id", $this->aauth->get_user()->username);
        } else if (!$emp['key3'] AND !$emp['pid']) {
            $total_time = time();
            $data = array(
                'pid' => $id,
                'meta_key' => 29,
                'meta_data' => $eid,
                'value' => $total_time,
                'key3' => 1,
                'key4' => 0,'company_id'=> getCompanyId(),'hash_code'=> getHashCode()
            );
            $this->db->insert('geopos_project_meta', $data);
            $this->aauth->applog("[Employee ClockIn]  Project ID $id", $this->aauth->get_user()->username);
        }
        return true;
    }

    public function clockout($id,$eid)
    {

        $this->db->select('*');
        $this->db->where('pid', $id);
        $this->db->where('meta_key', 29);
        $this->db->where('meta_data', $eid);
        $this->db->where('geopos_project_meta.company_id', getCompanyId());
        $this->db->from('geopos_project_meta');
        $query = $this->db->get();
        $emp = $query->row_array();
        if ($emp['key3'] AND $emp['pid']) {
            $total_time = time() - $emp['value'];
            $this->db->set('key4', "key4+$total_time", FALSE);
            $this->db->set('value',0);
            $this->db->set('key3', 0);
            $this->db->where('id', $emp['id']);
            $this->db->where('geopos_project_meta.company_id', getCompanyId());
            $this->db->update('geopos_project_meta');
            $this->aauth->applog("[Employee ClockOut]  Project ID $id", $this->aauth->get_user()->username);
        }
        return true;
    }
    
    public function tickets($id)
    {
        $this->db->select('*');
        $this->db->from('geopos_tickets');
        $this->db->where('project_id', $id);
        $this->db->where('geopos_tickets.company_id', getCompanyId());
        $query = $this->db->get();
        return $query->result_array();
    }


}