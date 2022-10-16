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

class Status extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('status_model', 'status');
        $this->load->model('customers_model', 'customers');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(3)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $this->load->library("Custom");
        $this->li_a = 'crm';
    }

    public function index()
    {
        $customer_id = $this->input->get('id');
        $hash_code = $this->input->get('ref');
        $data['customer'] = $this->customers->details($customer_id,$hash_code);
        if(!$customer_id || !$data['customer']) redirect('/customers', 'refresh');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = $this->lang->line('Customer Status')." | ".$data['customer']['name'];
        $data['status'] = $this->status->view($customer_id);
        $this->load->view('fixed/header', $head);
        $this->load->view('status/index',$data);
        $this->load->view('fixed/footer');
    }

    public function create()
    {
        $customer_id = $this->input->get('id');
        $hash_code = $this->input->get('ref');
        $data['customer'] = $this->customers->details($customer_id,$hash_code);
        if(!$customer_id || !$data['customer']) redirect('/customers', 'refresh');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = $this->lang->line('Add New Status')." | ".$data['customer']['name'];
        $this->load->view('fixed/header', $head);
        $this->load->view('status/create',$data);
        $this->load->view('fixed/footer');
    }


    public function store()
    {
        $customer_id = $this->input->post('customer_id',true);
        $content = $this->input->post('content',true);
        $hash_code = $this->input->post('ref',true);
        $data['customer'] = $this->customers->details($customer_id,$hash_code);
        if(!$customer_id || !$data['customer']) echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        $this->status->create($customer_id,$content);
    }

}