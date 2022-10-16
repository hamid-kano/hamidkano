<?php
/**
 * Geo POS -  Accounting,  Invoicing  and CRM Software
 * Copyright (c) Rajesh Dukiya. All Rights Reserved
 * ***********************************************************************
 *
 *  Email: support@ultimatekode.com
 *  Website: https://www.ultimatekode.com
 *
 *  ************************************************************************
 *  * This software is furnished under a license and may be used and copied
 *  * only  in  accordance  with  the  terms  of such  license and with the
 *  * inclusion of the above copyright notice.
 *  * If you Purchased from Codecanyon, Please read the full License from
 *  * here- http://codecanyon.net/licenses/standard/
 * ***********************************************************************
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Quote extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('quote_model', 'quote');
        if (!is_login()) {
            redirect(base_url() . 'user/profile', 'refresh');
        }
    }


    //invoices list
    public function index()
    {
        $head['title'] = "Manage Quote";

        $this->load->view('includes/header', $head);
        $this->load->view('quotes/quotes');
        $this->load->view('includes/footer');
    }

    
    public function ajax_list()
    {

        $list = $this->quote->get_datatables();
        $data = array();

        $no = $this->input->post('start');


        foreach ($list as $invoices) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $invoices->tid;
            $row[] = $invoices->name;
            $row[] = dateformat($invoices->invoicedate);
            $row[] = amountFormat($invoices->total);
            $row[] = '<span class="st-' . $invoices->status . '">' . $this->lang->line(ucwords($invoices->status)) . '</span>';
            $row[] = '<a href="' . base_url("quote/view?id=$invoices->id") . '" class="btn btn-success btn-xs"><i class="icon-file-text"></i> ' . $this->lang->line('View') . '</a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->quote->count_all(),
            "recordsFiltered" => $this->quote->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);

    }

    public function view()
    {
        $tid = $this->input->get('id');
        $data['id'] = $tid;
        $head['title'] = "Quote $tid";
        $data['invoice'] = $this->quote->quote_details($tid);
        if($data['invoice']['csd']==$this->session->userdata('user_details')[0]->cid) {
            $data['products'] = $this->quote->quote_products($tid);


            $data['employee'] = $this->quote->employee($data['invoice']['eid']);

            $this->load->view('includes/header', $head);
            $this->load->view('quotes/view', $data);
            $this->load->view('includes/footer');
        }

    }









}