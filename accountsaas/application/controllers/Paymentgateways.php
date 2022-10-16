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

class Paymentgateways extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('billing_model', 'billing');
        $this->load->model('invoices_model', 'invoices');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < 5) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
    }

    public function index()
    {

        $data['gateway'] = $this->billing->gateway_list();
        $this->load->view('fixed/header');
        $this->load->view('payment/list', $data);
        $this->load->view('fixed/footer');
    }


    public function edit()
    {
        if ($this->input->post()) {

            $gid = $this->input->post('gid');
            $hash_code = $this->input->post('ref');
            $currency = $this->input->post('currency');
            $key1 = $this->input->post('key1');
            $key2 = $this->input->post('key2');
            $enable = $this->input->post('enable');
            $devmode = $this->input->post('devmode');
            $p_fee = $this->input->post('p_fee');

            if ($key2 == '') {
                $key2 = 'none';
            }

            $this->billing->gateway_update($gid, $currency, $key1, $key2, $enable, $devmode, $p_fee);

        } else {

            $id = intval($this->input->get('id'));
            $hash_code = $this->input->get('ref');
            $data['gateway'] = $this->billing->gateway($id,$hash_code);
            $this->load->view('fixed/header');
            $this->load->view('payment/gateway-edit', $data);
            $this->load->view('fixed/footer');

        }

    }


    public function settings()
    {
        if ($this->input->post()) {

            $id = $this->input->post('account');
            $enable = $this->input->post('enable');
            $bank_enable = $this->input->post('bank');
            $pos_list = $this->input->post('pos_list');

            $this->billing->payment_settings($id, $enable, $bank_enable);

              if ($pos_list != PAC) {
            $config_file_path = APPPATH . "config/constants.php";
            $config_file = file_get_contents($config_file_path);
            $config_file = str_replace("('PAC', '".PAC."')", "('PAC', '$pos_list')", $config_file);
            file_put_contents($config_file_path, $config_file);
        }

        } else {
            $this->load->model('accounts_model');
            $data['acclist'] = $this->accounts_model->accountslist();
            $data['online_pay'] = $this->billing->online_pay_settings();
            $this->load->view('fixed/header');
            $this->load->view('payment/settings', $data);
            $this->load->view('fixed/footer');

        }

    }

    function bank_accounts()
    {

        $data['bank_accounts'] = $this->billing->bank_accounts();
        $this->load->view('fixed/header');
        $this->load->view('payment/bank_list', $data);
        $this->load->view('fixed/footer');
    }


    public function add_bank_ac()
    {
        if ($this->input->post()) {


            $name = $this->input->post('name', true);
            $acn = $this->input->post('acn', true);
            $code = $this->input->post('code', true);
            $enable = $this->input->post('enable');
            $branch = $this->input->post('branch', true);
            $address = $this->input->post('address', true);
            $bank = $this->input->post('bank', true);

            $this->billing->bank_ac_add($name, $acn, $code, $enable, $bank, $branch, $address);

        } else {

            $head['title'] = "Add Bank Account";
            $this->load->view('fixed/header', $head);
            $this->load->view('payment/bank-add');
            $this->load->view('fixed/footer');

        }

    }


    public function edit_bank_ac()
    {
        if ($this->input->post()) {

            $gid = $this->input->post('gid');
            $name = $this->input->post('name', true);
            $acn = $this->input->post('acn', true);
            $code = $this->input->post('code', true);
            $enable = $this->input->post('enable', true);
            $branch = $this->input->post('branch', true);
            $address = $this->input->post('address', true);
            $bank = $this->input->post('bank', true);

            $this->billing->bank_ac_update($gid, $name, $acn, $code, $enable, $bank, $branch, $address);

        } else {

            $id = intval($this->input->get('id'));
            $hash_code = $this->input->get('ref');
            $head['title'] = "Edit Bank Account";
            $data['bank_account'] = $this->billing->bank_account_info($id,$hash_code);
            $this->load->view('fixed/header', $head);
            $this->load->view('payment/bank-edit', $data);
            $this->load->view('fixed/footer');

        }

    }


    public function delete_bank_ac()
    {
        $id = $this->input->post('deleteid');
        if ($id) {
            $this->db->delete('geopos_bank_ac', array('id' => $id,'company_id'=>getCompanyId()));
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }


    function currencies()
    {

        $data['currency_list'] = $this->invoices->currencies();
        $this->load->view('fixed/header');
        $this->load->view('payment/currency_list', $data);
        $this->load->view('fixed/footer');
    }

    public function add_currency()
    {
        if ($this->input->post()) {


            $code = $this->input->post('code', true);
            $symbol = $this->input->post('symbol', true);
            $spos = $this->input->post('spos');
            $rate = $this->input->post('rate');
            $decimal = $this->input->post('decimal');
            $thous_sep = $this->input->post('thous_sep');
            $deci_sep = $this->input->post('deci_sep');

            $this->billing->add_currency($code, $symbol, $spos, $rate, $decimal, $thous_sep, $deci_sep);

        } else {

            $head['title'] = "Add Currency";
            $this->load->view('fixed/header', $head);
            $this->load->view('payment/add_currency');
            $this->load->view('fixed/footer');

        }

    }


    public function edit_currency()
    {
        if ($this->input->post()) {

            $gid = $this->input->post('gid');
            $code = $this->input->post('code', true);
            $symbol = $this->input->post('symbol', true);
            $spos = $this->input->post('spos');
            $rate = $this->input->post('rate');
            $decimal = $this->input->post('decimal');
            $thous_sep = $this->input->post('thous_sep');
            $deci_sep = $this->input->post('deci_sep');

            $this->billing->edit_currency($gid, $code, $symbol, $spos, $rate, $decimal, $thous_sep, $deci_sep);

        } else {

            $id = intval($this->input->get('id'));
            $hash_code = $this->input->get('ref');
            $head['title'] = "Edit Currency";
            $data['currency_d'] = $this->invoices->currency_d($id,'',$hash_code);
            $this->load->view('fixed/header', $head);
            $this->load->view('payment/currency-edit', $data);
            $this->load->view('fixed/footer');

        }

    }

    public function delete_currency()
    {
        $id = $this->input->post('deleteid');
        if ($id) {
            $this->db->delete('geopos_currencies', array('id' => $id,'company_id'=>getCompanyId()));
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }


    function exchange()
    {
        if ($this->input->post()) {

            $currency = $this->input->post('currency', true);
            $key1 = $this->input->post('key1', true);
            $key2 = $this->input->post('key2', true);
            $enable = $this->input->post('enable');
            $reverse = $this->input->post('reverse');


            $this->billing->exchange($currency, $key1, $key2, $enable, $reverse);

        } else {

            $this->load->model('plugins_model', 'plugins');
            $data['exchange'] = $this->plugins->universal_api(5);
            $this->load->view('fixed/header');
            $this->load->view('payment/exchange', $data);
            $this->load->view('fixed/footer');
        }
    }


}