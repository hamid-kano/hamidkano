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

class Emailinvoice Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('tools_model', 'tools');
        $this->load->model('templates_model', 'templates');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        $this->load->library('parser');

    }

    //todo section

    public function template()
    {

        $id = $this->input->post('invoiceid');
        $hash_code = $this->input->post('ref');
        $ttype = $this->input->post('ttype');
        $itype = $this->input->post('itype');

        switch ($ttype) {
            case 'quote':
                $this->load->model('quote_model', 'quote');
                $invoice = $this->quote->quote_details($id,$hash_code);
                $validtoken = hash_hmac('ripemd160', 'q' . $id, $this->config->item('encryption_key'));
                $link = base_url('billing/quoteview?id=' . $id . '&token=' . $validtoken.'&ref='.$hash_code);
                break;
            case 'purchase':
                $this->load->model('purchase_model', 'purchase');
                $invoice = $this->purchase->purchase_details($id,'',$hash_code);
                $validtoken = hash_hmac('ripemd160', 'p' . $id, $this->config->item('encryption_key'));
                $link = base_url('billing/purchase?id=' . $id . '&token=' . $validtoken.'&ref='.$hash_code);
                break;
            case 'stock':
                $this->load->model('stockreturn_model', 'stockreturn');
                $invoice = $this->stockreturn->purchase_details($id,'',$hash_code);
                $validtoken = hash_hmac('ripemd160', 's' . $id, $this->config->item('encryption_key'));
                $link = base_url('billing/stockreturn?id=' . $id . '&token=' . $validtoken.'&ref='.$hash_code);
                break;
            default :
                $this->load->model('invoices_model', 'invoices');
                $invoice = $this->invoices->invoice_details($id,'',$hash_code);
                $validtoken = hash_hmac('ripemd160', $id, $this->config->item('encryption_key'));
                $link = base_url('billing/view?id=' . $id . '&token=' . $validtoken.'&ref='.$hash_code);
                break;
        }

        switch ($ttype) {
            case 'notification':
                $template = $this->templates->template_info(6);
                break;
            case 'reminder':
                $template = $this->templates->template_info(7);
                break;
            case 'refund':
                $template = $this->templates->template_info(8);
                break;
            case 'received':
                $template = $this->templates->template_info(9);
                break;
            case 'overdue':
                $template = $this->templates->template_info(10);
                break;
            case 'quote':
                $template = $this->templates->template_info(11);
                break;
            case 'purchase':
                $template = $this->templates->template_info(12);
                $invoice['multi'] = 0;
                break;
            case 'stock':
                $template = $this->templates->template_info(13);
                $invoice['multi'] = 0;
                break;
        }


        $data = array(
            'Company' => $this->config->item('ctitle'),
            'BillNumber' => $invoice['tid']
        );
        $subject = $this->parser->parse_string($template['key1'], $data, TRUE);


        $data = array(
            'Company' => $this->config->item('ctitle'),
            'BillNumber' => $invoice['tid'],
            'URL' => "<a href='$link'>$link</a>",
            'Name' => $invoice['name'],
            'CompanyDetails' => '<h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
<address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
             ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email'),
            'DueDate' => dateformat($invoice['invoiceduedate']),
            'Amount' => amountExchange($invoice['total'], $invoice['multi'], $invoice['loc'])
        );
        $message = $this->parser->parse_string($template['other'], $data, TRUE);


        echo json_encode(array('subject' => $subject, 'message' => $message));
    }


}


