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

use Twilio\Rest\Client;

class Sms Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('plugins_model', 'plugins');
        $this->load->model('sms_model', 'sms');

        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        $this->load->library('parser');
        $this->config->load('sms');


    }

    public function index()
    {

    }

    // section

    public function template()
    {

        $id = $this->input->post('invoiceid');
        $hash_code = $this->input->post('ref');
        $ttype = $this->input->post('ttype');
        if ($ttype == 'quote') {

            $invoice['tid'] = $id;
            $this->load->model('quote_model', 'quote');
            $invoice = $this->quote->quote_details($id,$hash_code);
            $validtoken = hash_hmac('ripemd160', 'q' . $id, $this->config->item('encryption_key'));

            $link = base_url('billing/quoteview?id=' . $id . '&token=' . $validtoken.'&ref='.$hash_code);
        } elseif ($ttype == 'purchase') {
            $invoice['tid'] = $id;
            $this->load->model('purchase_model', 'purchase');
            $invoice = $this->purchase->purchase_details($id,'',$hash_code);
            $validtoken = hash_hmac('ripemd160', $id, $this->config->item('encryption_key'));

            $link = base_url('billing/purchase?id=' . $id . '&token=' . $validtoken.'&ref='.$hash_code);
        } else {
            $invoice['tid'] = $id;

            $this->load->model('invoices_model', 'invoices');
            $invoice = $this->invoices->invoice_details($id,'',$hash_code);

            $validtoken = hash_hmac('ripemd160', $id, $this->config->item('encryption_key'));

            $link = base_url('billing/view?id=' . $id . '&token=' . $validtoken.'&ref='.$hash_code);
        }

        $sms_service = $this->plugins->universal_api(1);

        if ($sms_service['active']) {

            $this->load->library("Shortenurl");
            $this->shortenurl->setkey($sms_service['key1']);
            $link = $this->shortenurl->shorten($link);

        }

        $this->load->model('templates_model', 'templates');
        switch ($ttype) {
            case 'notification':
                $template = $this->templates->template_info(30);
                break;

            case 'reminder':
                $template = $this->templates->template_info(31);
                break;

            case 'refund':
                $template = $this->templates->template_info(32);
                break;


            case 'received':
                $template = $this->templates->template_info(33);
                break;

            case 'overdue':
                $template = $this->templates->template_info(34);
                break;


            case 'quote':
                $template = $this->templates->template_info(35);
                break;


            case 'purchase':
                $template = $this->templates->template_info(36);
                break;


        }

        $data = array(
            'BillNumber' => $invoice['tid'],
            'URL' => $link,
            'DueDate' => dateformat($invoice['invoiceduedate']),
            'Amount' => amountExchange($invoice['total'], $invoice['multi'])
        );
        $message = $this->parser->parse_string($template['other'], $data, TRUE);


        echo json_encode(array('message' => $message));
    }


    public function send_sms()
    {
        $mobile = $this->input->post('mobile');
        $text_message = $this->input->post('text_message');
        $this->sms->send_sms($mobile, $text_message);
    }


}


