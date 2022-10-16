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

class Clientgroup extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('clientgroup_model', 'clientgroup');
        $this->load->model('customers_model', 'customers');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(3)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $this->li_a = 'crm';
    }

    //groups
    public function index()
    {
        $data['group'] = $this->customers->group_list();
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Client Groups';
        $this->load->view('fixed/header', $head);
        $this->load->view('groups/groups', $data);
        $this->load->view('fixed/footer');
    }

    //view
    public function groupview()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $id = $this->input->get('id');
        $ref = $this->input->get('ref');
        $data['group'] = $this->clientgroup->details($id,$ref);
        $head['title'] = 'Group View';
        $this->load->view('fixed/header', $head);
        $this->load->view('groups/groupview', $data);
        $this->load->view('fixed/footer');
    }

    //datatable
    public function grouplist()

    {

        $id = $this->input->get('id');
        $list = $this->customers->get_datatables($id);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $customers) {
            $no++;

            $row = array();
            $row[] = $no;
            $row[] = '<span class="avatar-sm align-baseline"><img class="rounded-circle"  src="' . base_url() . 'userfiles/customers/thumbnail/' . $customers->picture . '" ></span> &nbsp;<a href="customers/view?id=' . $customers->id . '&ref=' . $customers->hash_code . '">' . $customers->name . '</a>';
            $row[] = $customers->address . ',' . $customers->city . ',' . $customers->country;
            $row[] = $customers->email;
            $row[] = $customers->phone;
            $row[] = '<a href="' . base_url() . 'customers/view?id=' . $customers->id . '&ref=' . $customers->hash_code . '" class="btn btn-info btn-sm"><span class="fa fa-eye"></span>  ' . $this->lang->line('View') . '</a> <a href="' . base_url() . 'customers/edit?id=' . $customers->id . '&ref=' . $customers->hash_code . '" class="btn btn-success btn-sm"><span class="icon-pencil"></span> ' . $this->lang->line('Edit') . '</a> <a href="#"  data-object-ref="' . $customers->hash_code . '" data-object-id="' . $customers->id . '" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->customers->count_all($id),
            "recordsFiltered" => $this->customers->count_filtered($id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function create()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Create Group';
        $this->load->view('fixed/header', $head);
        $this->load->view('groups/add');
        $this->load->view('fixed/footer');
    }

    public function add()
    {
        $group_name = $this->input->post('group_name', true);
        $group_desc = $this->input->post('group_desc', true);

        if ($group_name) {
            $this->clientgroup->add($group_name, $group_desc);
        }
    }

    public function editgroup()
    {
        $gid = $this->input->get('id');
        $hash_code = $this->input->get('ref');
        $this->db->select('*');
        $this->db->from('geopos_cust_group');
        $this->db->where('id', $gid);
        $this->db->where('company_id', getCompanyId());
        $this->db->where('hash_code', $hash_code);

        $query = $this->db->get();
        $data['group'] = $query->row_array();
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Edit Group';
        $this->load->view('fixed/header', $head);
        $this->load->view('groups/groupedit', $data);
        $this->load->view('fixed/footer');

    }

    public function editgroupupdate()
    {
        $gid = $this->input->post('gid', true);
        $hash_code = $this->input->post('ref_id', true);
        $group_name = $this->input->post('group_name', true);
        $group_desc = $this->input->post('group_desc', true);
        if ($gid) {
            $this->clientgroup->editgroupupdate($gid, $group_name, $group_desc,$hash_code);
        }
    }

    public function delete_i()
    {
        if ($this->aauth->premission(11)) {
            $id = $this->input->post('deleteid');
            $hash_code = $this->input->post('ref');
            if ($id != 1) {
                $this->db->delete('geopos_cust_group', array('id' => $id,'company_id'=>getCompanyId(),'hash_code'=>$hash_code));
                $this->db->set(array('gid' => 1));
                $this->db->where('gid', $id);
                $this->db->where('company_id', getCompanyId());
               // $this->db->where('hash_code', $hash_code);
                $this->db->update('geopos_customers');
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
            } else if ($id == 1) {
                echo json_encode(array('status' => 'Error', 'message' => 'You can not delete the default group!'));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }

    function sendGroup()
    {
        $id = $this->input->post('gid');
        $subject = $this->input->post('subject', true);
        $message = $this->input->post('text');
        $hash_code = $this->input->post('ref');
        $attachmenttrue = false;
        $attachment = '';
        $recipients = $this->clientgroup->recipients($id,$hash_code);
        $this->load->model('communication_model');
        $this->communication_model->group_email($recipients, $subject, $message, $attachmenttrue, $attachment);
    }

    public function discount_update()
    {
        $gid = $this->input->post('gid', true);
        $hash_code = $this->input->post('ref', true);
        $disc_rate = (float)$this->input->post('disc_rate', true);

        if ($gid) {
            $this->clientgroup->editgroupdiscountupdate($gid, $disc_rate,$hash_code);
        }
    }
}