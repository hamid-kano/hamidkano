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

class Register Extends CI_Controller
{
    public function __construct()
    {

        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }


        $this->load->library("Registerlog");
        $this->load->model('register_model', 'register');
        $this->li_a = 'data';


    }

    public function index()
    {
        if (!$this->aauth->premission(10)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }


        $head['title'] = "Register";

        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('register/index');
        $this->load->view('fixed/footer');

    }


    public function view()
    {
        if (!$this->aauth->premission(10)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $status = $this->registerlog->view($this->input->post('rid'));


        echo json_encode(array('cash' => $status['cash'], 'card' => $status['card'], 'bank' => $status['bank'], 'change' => $status['r_change'], 'date' => $status['o_date']));


    }


    public function status()
    {

        $status = $this->registerlog->check($this->aauth->get_user()->id);
        if ($status) {
            echo json_encode(array('cash' => $status['cash'], 'card' => $status['card'], 'bank' => $status['bank'], 'change' => $status['r_change'], 'date' => $status['o_date']));
        }

    }


    public function close()
    {

        $this->registerlog->close($this->aauth->get_user()->id);
        redirect('dashboard');


    }


    public function create()
    {

        if (!$this->aauth->premission(1)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        if ($this->registerlog->check($this->aauth->get_user()->id)) {
            redirect('pos_invoices/create');
        }
        if ($this->input->post()) {
            $cash = (float)$this->input->post('cash');
            $card = (float)$this->input->post('card');
            $bank = (float)$this->input->post('bank');
            $cash_card = 0.00;
            $cheque = (float)$this->input->post('cheque');

            if ($this->registerlog->create($this->aauth->get_user()->id, $cash, $card, $bank, $cash_card,$cheque)) {

                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . " <a href='" . base_url() . "pos_invoices/create' class='btn btn-info btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span> " . $this->lang->line('POS') . "  </a>"));


            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {


            $head['title'] = "Add Register";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('register/create');
            $this->load->view('fixed/footer');
        }
    }


    public function delete_i()
    {
        if (!$this->aauth->premission(10)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }

        $id = $this->input->post('deleteid');
        if ($id) {

            $this->db->delete('geopos_register', array('id' => $id,'company_id'=>getCompanyId()));


            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    public function load_list()
    {
        if (!$this->aauth->premission(10)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $list = $this->register->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $promo) {
            $no++;
            switch ($promo->active) {
                case 1 :
                    $promo_status = '<span class="st-paid">' . $this->lang->line('Active') . '</a>';
                    break;
                case 0 :
                    $promo_status = '<span class="st-due">' . $this->lang->line('Close') . '</a>';
                    break;
            }
            $row = array();
            $row[] = $no;
            $row[] = $promo->username;
            $row[] = $promo->o_date;
            $row[] = $promo->c_date;
            $row[] = $promo_status;
            $row[] = '<a href="#" class="btn btn-primary btn-sm rounded set-reg" data-id="' . $promo->id . '" data-stat="0"  data-toggle="modal" data-target="#view_register" > ' . $this->lang->line('View') . ' </a> <a href="#" data-object-id="' . $promo->id . '" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->register->count_all(),
            "recordsFiltered" => $this->register->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

}