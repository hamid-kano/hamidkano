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

class Promo Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('promo_model', 'promo');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(5)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $this->load->library("Coupon");
        $this->li_a = 'promo';

    }

    public function index()
    {

        $head['title'] = "Promo";
        $data['totalt'] = $this->promo->count_all();
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('promo/index', $data);
        $this->load->view('fixed/footer');
    }


    public function create()
    {
        if ($this->input->post()) {
            $code = $this->input->post('code', true);
            $amount = numberClean($this->input->post('amount'));
            $qty = (int)$this->input->post('qty');
            $valid = datefordatabase($this->input->post('valid'));
            $link_ac = $this->input->post('link_ac');
            $pay_acc = $this->input->post('pay_acc');
            $note = $this->input->post('note', true);
            $this->promo->create($code, $amount, $qty, $valid, $link_ac, $pay_acc, $note);
        } else {

            $data['accounts'] = $this->promo->accountslist();
            $head['title'] = "Add Promo";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('promo/create', $data);
            $this->load->view('fixed/footer');
        }
    }


    public function delete_i()
    {
        $id = $this->input->post('deleteid');
        if ($id) {
            $this->db->select('*');
            $this->db->from('geopos_promo');
            $this->db->where('id', $id);
            $this->db->where('company_id', getCompanyId());
            $query = $this->db->get();
            $promo = $query->row_array();

            if ($promo['reflect'] > 0) {
                $amount = $promo['amount'] * $promo['available'];
                $this->db->select('holder');
                $this->db->from('geopos_accounts');
                $this->db->where('company_id', getCompanyId());
                $this->db->where('id', $promo['reflect']);
                $query = $this->db->get();
                $account = $query->row_array();
                $data = array(
                    'payerid' => 0,
                    'payer' => $this->lang->line('Coupon') . '-' . $promo['code'],
                    'acid' => $promo['reflect'],
                    'account' => $account['holder'],
                    'date' => date('Y-m-d'),
                    'debit' => 0,
                    'credit' => $amount,
                    'type' => 'Income',
                    'cat' => $this->lang->line('Coupon'),
                    'method' => 'Transfer',
                    'eid' => $this->aauth->get_user()->id,
                    'note' => $this->lang->line('Coupon') . ' ' . $this->lang->line('Delete') . ' ' . $this->lang->line('Qty') . '-' . $promo['available'],
                    'loc' => $this->aauth->get_user()->loc,'company_id'=>getCompanyId(),'hash_code'=>getHashCode() 
                );
                $this->db->set('lastbal', "lastbal+$amount", FALSE);
                $this->db->where('id', $promo['reflect']);
                $this->db->where('company_id', getCompanyId());
                $this->db->update('geopos_accounts');
                $this->db->insert('geopos_transactions', $data);
            }
            $this->db->delete('geopos_promo', array('id' => $id,'company_id'=>getCompanyId(),));


            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    public function load_list()
    {
        $list = $this->promo->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $promo) {
            $no++;
            switch ($promo->active) {
                case 0 :
                    $promo_status = '<span class="st-paid">' . $this->lang->line('Active') . '</a>';
                    break;
                case 1 :
                    $promo_status = '<span class="st-partial">' . $this->lang->line('Used') . '</a>';
                    break;
                case 2 :
                    $promo_status = '<span class="st-due">' . $this->lang->line('Expired') . '</a>';
                    break;
            }
            $row = array();
            $row[] = $no;
            $row[] = $promo->code;
            $row[] = amountExchange($promo->amount, 0, $this->aauth->get_user()->loc);
            $row[] = $promo->valid;
            $row[] = $promo_status;
            $row[] = $promo->available . ' (' . $promo->qty . ')';
            $row[] = '<a href="#" class="btn btn-primary btn-sm rounded set-task" data-id="' . $promo->id . '" data-stat="0"> SET </a> <a href="#" data-object-id="' . $promo->id . '&ref='.$promo->hash_code.'" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a>';


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->promo->count_all(),
            "recordsFiltered" => $this->promo->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function promo_stats()
    {

        $this->promo->promo_stats();


    }

    public function set_status()
    {
        $id = $this->input->post('tid');
        $stat = $this->input->post('stat');
        $this->promo->set_status($id, $stat);
        echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED'), 'pstatus' => 'Success'));


    }


}