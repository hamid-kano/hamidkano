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

class Plugins Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('plugins_model', 'plugins');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < 5) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }

    }


    public function recaptcha()
    {

        if ($this->input->post()) {
            $public_key = $this->input->post('publickey', true);
            $private_key = $this->input->post('privatekey', true);
            $captcha = $this->input->post('captcha');

            $this->plugins->recaptcha($captcha, $public_key, $private_key);

        } else {

            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'reCaptcha Security';
            $data['captcha'] = $this->plugins->config_general();
            $this->load->view('fixed/header', $head);
            $this->load->view('plugins/security', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function shortner()
    {

        if ($this->input->post()) {
            $key1 = $this->input->post('key1');
            $enable = $this->input->post('enable');

            $this->plugins->update_api(1, $key1, '', $enable);

        } else {

            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'URL Shortner';
            $data['universal'] = $this->plugins->universal_api(1);
            $this->load->view('fixed/header', $head);
            $this->load->view('plugins/shortner', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function twilio()
    {

        if ($this->input->post()) {
            $key1 = $this->input->post('key1');
            $key2 = $this->input->post('key2');
            $sender = $this->input->post('sender');
            $enable = $this->input->post('enable');
            $this->plugins->update_api(2, $key1, $key2, $enable, $sender);

        } else {

            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Twilio SMS';
            $data['universal'] = $this->plugins->universal_api(2);
            $this->load->view('fixed/header', $head);
            $this->load->view('plugins/twilio', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function woocommerce()
    {
        $this->load->model('cronjob_model', 'cronjob');
        $corn = $this->cronjob->config();
        $data['cornkey'] = $corn['cornkey'];

        if ($this->input->post()) {

        } else {
            $this->load->model('employee_model', 'employee');
            $data['emp'] = $this->employee->list_employee();
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'WooCommerce Integration';

            $this->load->view('fixed/header', $head);
            echo 'Not Installed';
            $this->load->view('fixed/footer');
        }


    }


}


