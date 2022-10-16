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

class Transactions extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('invoices_model');
        $this->load->model('transactions_model', 'transactions');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        $this->load->library("Custom");
        $this->li_a = 'accounts';
    }

    public function index()
    {
        if (!$this->aauth->premission(5)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $head['title'] = "Transaction";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('transactions/index');
        $this->load->view('fixed/footer');

    }

    public function add()
    {
        if (!$this->aauth->premission(5)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $data['dual'] = $this->custom->api_config(65,getCompanyId());

        $data['cat'] = $this->transactions->categories();
        $data['accounts'] = $this->transactions->acc_list();
        $head['title'] = "Add Transaction";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('transactions/create', $data);
        $this->load->view('fixed/footer');

    }

    public function transfer()
    {
        if (!$this->aauth->premission(5)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }

        $data['cat'] = $this->transactions->categories();
        $data['accounts'] = $this->transactions->acc_list();
        $head['title'] = "New Transfer";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('transactions/transfer', $data);
        $this->load->view('fixed/footer');

    }

    public function payinvoice()
    {

        if (!$this->aauth->premission(1)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $amount2 = 0;
        $tid = $this->input->post('tid');
        $amount = rev_amountExchange_s($this->input->post('amount', true), 0, $this->aauth->get_user()->loc);
        $paydate = $this->input->post('paydate', true);
        $note = $this->input->post('shortnote', true);
        $pmethod = $this->input->post('pmethod', true);
        $acid = $this->input->post('account', true);
        $cid = $this->input->post('cid', true);
        $cname = $this->input->post('cname', true);
        $paydate = datefordatabase($paydate);

        $this->db->select('holder');
        $this->db->from('geopos_accounts');
        $this->db->where('id', $acid);
        $this->db->where('company_id', getCompanyId());
        $query = $this->db->get();
        $account = $query->row_array();

        if ($pmethod == 'Balance') {

            $customer = $this->transactions->check_balance($cid);
            if (rev_amountExchange_s($customer['balance'], 0, $this->aauth->get_user()->loc) >= $amount) {

                $this->db->set('balance', "balance-$amount", FALSE);
                $this->db->where('id', $cid);
                $this->db->where('company_id', getCompanyId());
                $this->db->update('geopos_customers');
            } else {

                $amount = rev_amountExchange_s($customer['balance'], 0, $this->aauth->get_user()->loc);
                $this->db->set('balance', 0, FALSE);
                $this->db->where('id', $cid);
                $this->db->where('company_id', getCompanyId());
                $this->db->update('geopos_customers');
            }
        }

        $data = array(
            'acid' => $acid,
            'account' => $account['holder'],
            'type' => 'Income',
            'cat' => 'Sales',
            'credit' => $amount,
            'payer' => $cname,
            'payerid' => $cid,
            'method' => $pmethod,
            'date' => $paydate,
            'eid' => $this->aauth->get_user()->id,
            'tid' => $tid,
            'note' => $note,
            'loc' => $this->aauth->get_user()->loc,
            'company_id'=>getCompanyId(),
            'hash_code'=>getHashCode() 
        );

        $this->db->insert('geopos_transactions', $data);
        $tttid = $this->db->insert_id();

        $this->db->select('total,csd,pamnt');
        $this->db->from('geopos_invoices');
        $this->db->where('id', $tid);
        $this->db->where('company_id', getCompanyId());
        $query = $this->db->get();
        $invresult = $query->row();

        $totalrm = $invresult->total - $invresult->pamnt;

        if ($totalrm > $amount) {
            $this->db->set('pmethod', $pmethod);
            $this->db->set('pamnt', "pamnt+$amount", FALSE);

            $this->db->set('status', 'partial');
            $this->db->where('id', $tid);
            $this->db->where('company_id', getCompanyId());
            $this->db->update('geopos_invoices');


            //account update
            $this->db->set('lastbal', "lastbal+$amount", FALSE);
            $this->db->where('id', $acid);
            $this->db->where('company_id', getCompanyId());
            $this->db->update('geopos_accounts');
            $paid_amount = $invresult->pamnt + $amount;
            $status = 'Partial';
            $totalrm = $totalrm - $amount;
        } else {
            if ($totalrm < $amount) {
                $diff = $totalrm - $amount;
                $diff = abs($diff);
                $amount2 = $amount;
                $amount = $totalrm;
                $this->db->set('balance', "balance+$diff", FALSE);
                $this->db->where('id', $cid);
                $this->db->where('company_id', getCompanyId());
                $this->db->update('geopos_customers');

            }
            $this->db->set('pmethod', $pmethod);
            $this->db->set('pamnt', "pamnt+$totalrm", FALSE);
            $this->db->set('status', 'paid');
            $this->db->where('id', $tid);
            $this->db->where('company_id', getCompanyId());
            $this->db->update('geopos_invoices');
            //account update
            $this->db->set('lastbal', "lastbal+$totalrm", FALSE);
            $this->db->where('id', $acid);
            $this->db->where('company_id', getCompanyId());
            $this->db->update('geopos_accounts');
            $totalrm = 0;
            $status = 'Paid';
        }
        $amount += $amount2;

        $activitym = "<tr><td>" . '<a href="' . base_url('invoices') . '/view_payslip?id=' . $tttid . '&inv=' . $tid . '" class="btn btn-blue btn-sm"><span class="fa fa-print" aria-hidden="true"></span></a> ' . substr($paydate, 0, 10) . "</td><td>$pmethod</td><td>" . amountExchange_s($amount, 0, $this->aauth->get_user()->loc) . "</td><td>$note</td></tr>";
        $dual = $this->custom->api_config(65);
        if ($dual['key1']) {

            $this->db->select('holder');
            $this->db->from('geopos_accounts');
            $this->db->where('id', $dual['key2']);
            $query = $this->db->get();
            $account = $query->row_array();
            if(!isset($account['holder'])){
                $account['holder'] = '';
            }
            $data['credit'] = 0;
            $data['debit'] = $amount;
            $data['type'] = 'Expense';
            $data['acid'] = $dual['key2'];
            $data['account'] = $account['holder'];
            $data['note'] = 'Debit ' . $data['note'];
            $data['company_id'] = getCompanyId();
            $data['hash_code'] = getHashCode();

            $this->db->insert('geopos_transactions', $data);

            //account update
            $this->db->set('lastbal', "lastbal-$amount", FALSE);
            $this->db->where('id', $dual['key2']);
            $this->db->where('company_id', getCompanyId());
            $this->db->update('geopos_accounts');
        }
        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('Transaction has been added'), 'pstatus' => $this->lang->line($status), 'activity' => $activitym, 'amt' => $totalrm, 'ttlpaid' => amountExchange_s($amount, 0, $this->aauth->get_user()->loc)));
    }

    public function paypurchase()
    {

        if (!$this->aauth->premission(2)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }

        $tid = $this->input->post('tid', true);
        $amount = $this->input->post('amount', true);
        $paydate = $this->input->post('paydate', true);
        $note = $this->input->post('shortnote', true);
        $pmethod = $this->input->post('pmethod', true);
        $acid = $this->input->post('account', true);
        $cid = $this->input->post('cid', true);
        $cname = $this->input->post('cname', true);
        $paydate = datefordatabase($paydate);
        $this->db->select('holder');
        $this->db->from('geopos_accounts');
        $this->db->where('id', $acid);
        $query = $this->db->get();
        $account = $query->row_array();
        $data = array(
            'acid' => $acid,
            'account' => $account['holder'],
            'type' => 'Expense',
            'cat' => 'Purchase',
            'debit' => $amount,
            'payer' => $cname,
            'payerid' => $cid,
            'method' => $pmethod,
            'date' => $paydate,
            'eid' => $this->aauth->get_user()->id,
            'tid' => $tid,
            'note' => $note,
            'ext' => 1,
            'loc' => $this->aauth->get_user()->loc,'company_id'=>getCompanyId(),'hash_code'=>getHashCode() 
        );
        $this->db->insert('geopos_transactions', $data);
        $this->db->insert_id();
        $this->db->select('total,csd,pamnt');
        $this->db->from('geopos_purchase');
        $this->db->where('id', $tid);
        $query = $this->db->get();
        $invresult = $query->row();
        $totalrm = $invresult->total - $invresult->pamnt;
        if ($totalrm > $amount) {
            $this->db->set('pmethod', $pmethod);
            $this->db->set('pamnt', "pamnt+$amount", FALSE);
            $this->db->set('status', 'partial');
            $this->db->where('id', $tid);
            $this->db->where('company_id', getCompanyId());
            $this->db->update('geopos_purchase');
            //account update
            $this->db->set('lastbal', "lastbal-$amount", FALSE);
            $this->db->where('id', $acid);
            $this->db->where('company_id', getCompanyId());
            $this->db->update('geopos_accounts');
            $paid_amount = $invresult->pamnt + $amount;
            $status = 'Partial';
            $totalrm = $totalrm - $amount;
        } else {
            $this->db->set('pmethod', $pmethod);
            $this->db->set('pamnt', "pamnt+$amount", FALSE);
            $this->db->set('status', 'paid');
            $this->db->where('id', $tid);
            $this->db->where('company_id', getCompanyId());
            $this->db->update('geopos_purchase');
            //acount update
            $this->db->set('lastbal', "lastbal-$amount", FALSE);
            $this->db->where('id', $acid);
            $this->db->where('company_id', getCompanyId());
            $this->db->update('geopos_accounts');
            $totalrm = 0;
            $status = 'Paid';
            $paid_amount = $amount;
        }

        $dual = $this->custom->api_config(65);
        if ($dual['key1']) {

            $this->db->select('holder');
            $this->db->from('geopos_accounts');
            $this->db->where('id', $dual['url']);
            $this->db->where('company_id', getCompanyId());
            $query = $this->db->get();
            $account = $query->row_array();
            if(!isset($account['holder'])){
                $account['holder'] = 0;
            }
            $data['debit'] = 0;
            $data['credit'] = $amount;
            $data['type'] = 'Income';
            $data['acid'] = $dual['url'];
            $data['account'] = $account['holder'];
            $data['note'] = 'Credit ' . $data['note'];
            $data['company_id'] = getCompanyId();
            $data['hash_code'] = getHashCode();

            $this->db->insert('geopos_transactions', $data);

            //account update
            $this->db->set('lastbal', "lastbal+$amount", FALSE);
            $this->db->where('id', $dual['url']);
            $this->db->where('company_id', getCompanyId());
            $this->db->update('geopos_accounts');
        }
        $activitym = "<tr><td>" . substr($paydate, 0, 10) . "</td><td>$pmethod</td><td>$amount</td><td>$note</td></tr>";


        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('Transaction has been added'), 'pstatus' => $this->lang->line($status), 'activity' => $activitym, 'amt' => $totalrm, 'ttlpaid' => $paid_amount));
    }


    public function cancelinvoice()
    {
        if (!$this->aauth->premission(1)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }


        $tid = intval($this->input->post('tid'));
        $hash_code = $this->input->post('ref_id_delete');


        $this->db->set('pamnt', "0.00", FALSE);
        $this->db->set('total', "0.00", FALSE);
        $this->db->set('items', 0);
        $this->db->set('status', 'canceled');
        $this->db->where('id', $tid);
        $this->db->where('hash_code', $hash_code);
        $this->db->where('company_id', getCompanyId());
        $this->db->update('geopos_invoices');
        //reverse
        $this->db->select('credit,debit,acid');
        $this->db->from('geopos_transactions');
        $this->db->where('company_id', getCompanyId());
        $this->db->where('tid', $tid);
        $query = $this->db->get();
        $revresult = $query->result_array();
        foreach ($revresult as $trans) {
            $amt = $trans['credit'] - $trans['debit'];
            $this->db->set('lastbal', "lastbal-$amt", FALSE);
            $this->db->where('id', $trans['acid']);
            $this->db->where('company_id', getCompanyId());
            $this->db->update('geopos_accounts');
        }
        $this->db->select('pid,qty');
        $this->db->from('geopos_invoice_items');
        $this->db->where('company_id', getCompanyId());
        $this->db->where('tid', $tid);
        $query = $this->db->get();
        $prevresult = $query->result_array();
        foreach ($prevresult as $prd) {
            $amt = $prd['qty'];
            $this->db->set('qty', "qty+$amt", FALSE);
            $this->db->where('pid', $prd['pid']);
            $this->db->where('company_id', getCompanyId());
            $this->db->update('geopos_products');
        }
        $this->db->delete('geopos_transactions', array('tid' => $tid,'company_id'=>getCompanyId()));
        $data = array('type' => 9, 'rid' => $tid);
        $this->db->delete('geopos_metadata', $data);
        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('Invoice canceled')));
    }


    public function cancelpurchase()
    {
        if (!$this->aauth->premission(2)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $tid = intval($this->input->post('tid'));
        $this->db->set('pamnt', "0.00", FALSE);
        $this->db->set('status', 'canceled');
        $this->db->where('id', $tid);
        $this->db->where('company_id', getCompanyId());
        $this->db->update('geopos_purchase');
        //reverse
        $this->db->select('debit,credit,acid');
        $this->db->from('geopos_transactions');
        $this->db->where('tid', $tid);
        $this->db->where('company_id', getCompanyId());
        $this->db->where('ext', 1);
        $query = $this->db->get();
        $revresult = $query->result_array();
        foreach ($revresult as $trans) {
            $amt = $trans['debit'] - $trans['credit'];
            $this->db->set('lastbal', "lastbal+$amt", FALSE);
            $this->db->where('id', $trans['acid']);
            $this->db->where('company_id', getCompanyId());
            $this->db->update('geopos_accounts');
        }
        $this->db->select('pid,qty');
        $this->db->from('geopos_purchase_items');
        $this->db->where('tid', $tid);
        $this->db->where('company_id', getCompanyId());
        $query = $this->db->get();
        $prevresult = $query->result_array();
        foreach ($prevresult as $prd) {
            $amt = $prd['qty'];
            $this->db->set('qty', "qty-$amt", FALSE);
            $this->db->where('pid', $prd['pid']);
            $this->db->where('company_id', getCompanyId());
            $this->db->update('geopos_products');
        }
        $this->db->delete('geopos_transactions', array('tid' => $tid, 'ext' => 1));
        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('Purchase canceled!')));
    }

    public function translist()
    {
        if (!$this->aauth->premission(5)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $ttype = $this->input->get('type');
        $list = $this->transactions->get_datatables($ttype);
        $data = array();
        // $no = $_POST['start'];
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $pid = $prd->id;
            $row[] = dateformat($prd->date);
            $row[] = $prd->account;
            $row[] = amountExchange($prd->debit, 0, $this->aauth->get_user()->loc);
            $row[] = amountExchange($prd->credit, 0, $this->aauth->get_user()->loc);
            $row[] = $prd->payer;
            $row[] = $this->lang->line($prd->method);
            $row[] = '<a href="' . base_url() . 'transactions/view?id=' . $pid . '&ref='.$prd->hash_code.'" class="btn btn-primary btn-sm"><span class="fa fa-eye"></span>  ' . $this->lang->line('View') . '</a> <a href="' . base_url() . 'transactions/print_t?id=' . $pid . '&ref='.$prd->hash_code.'" class="btn btn-info btn-sm"  title="Print"><span class="fa fa-print"></span></a>&nbsp; &nbsp;<a  href="#" data-object-id="' . $pid . '" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->transactions->count_all(),
            "recordsFiltered" => $this->transactions->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    // Category
    public function categories()
    {
        $this->li_a = 'misc_settings';
        if ($this->aauth->get_user()->roleid < 5) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }

        $data['catlist'] = $this->transactions->categories();
        $head['title'] = "Category";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('transactions/cat', $data);
        $this->load->view('fixed/footer');
    }

    public function createcat()
    {
        if ($this->aauth->get_user()->roleid < 5) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }

        $head['title'] = "Category";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('transactions/cat_create');
        $this->load->view('fixed/footer');
    }

    public function editcat()
    {

        if ($this->aauth->get_user()->roleid < 5) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }

        $head['title'] = "Category";
        $head['usernm'] = $this->aauth->get_user()->username;

        $id = $this->input->get('id');
        $hash_code = $this->input->get('ref');

        $data['cat'] = $this->transactions->cat_details($id,$hash_code);

        $this->load->view('fixed/header', $head);
        $this->load->view('transactions/trans-cat-edit', $data);
        $this->load->view('fixed/footer');

    }

    public function save_createcat()
    {

        if ($this->aauth->get_user()->roleid < 5) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }

        $name = $this->input->post('catname');

        if ($this->transactions->addcat($name)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function editcatsave()
    {
        if ($this->aauth->get_user()->roleid < 5) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }

        $id = $this->input->post('catid');
        $hash_code = $this->input->post('ref');
        $name = $this->input->post('cat_name');

        if ($this->transactions->cat_update($id, $name,$hash_code)) {

            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>
                'Error!'));
        }


    }

    public function delete_cat()
    {
        if ($this->aauth->get_user()->roleid < 5) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }

        $id = $this->input->post('deleteid');
        if ($id) {
            $this->db->delete('geopos_trans_cat', array('id' => $id,'company_id'=>getCompanyId()));
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Error!'));
        }
    }

    public function save_trans()
    {
        if (!$this->aauth->premission(5)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $dual = $this->custom->api_config(65);

        $credit = 0;
        $debit = 0;
        $payer_id = $this->input->post('payer_id', true);
        $payer_ty = $this->input->post('ty_p', true);
        $payer_name = $this->input->post('payer_name', true);
        $pay_acc = $this->input->post('pay_acc', true);
        $date = $this->input->post('date', true);
        $amount = numberClean($this->input->post('amount', true));
        $pay_type = $this->input->post('pay_type', true);
        if ($pay_type == 'Income') {
            $credit = $amount;
        } elseif ($pay_type == 'Expense') {
            $debit = $amount;
        }
        $pay_cat = $this->input->post('pay_cat');
        $paymethod = $this->input->post('paymethod');
        $note = $this->input->post('note');
        $date = datefordatabase($date);
        if ($amount > 0) {
            if ($this->transactions->addtrans($payer_id, $payer_name, $pay_acc, $date, $debit, $credit, $pay_type, $pay_cat, $paymethod, $note, $this->aauth->get_user()->id, $this->aauth->get_user()->loc, $payer_ty)) {
                $lid = $this->db->insert_id();

                if ($dual['key1']) {
                    $pay_acc = $this->input->post('f_pay_acc', true);
                    $pay_cat = $this->input->post('f_pay_cat');
                    $paymethod = $this->input->post('f_paymethod');
                    $note = $this->input->post('f_note');
                    if ($pay_type == 'Income') {
                        $debit = $amount;
                        $credit = 0;
                        $pay_type_r = 'Expense';
                    } elseif ($pay_type == 'Expense') {
                        $credit = $amount;
                        $debit = 0;
                        $pay_type_r = 'Income';
                    }

                    $this->transactions->addtrans($payer_id, $payer_name, $pay_acc, $date, $debit, $credit, $pay_type_r, $pay_cat, $paymethod, $note, $this->aauth->get_user()->id, $this->aauth->get_user()->loc, $payer_ty);
                }

                echo json_encode(array('status' => 'Success', 'message' =>
                    $this->lang->line('Transaction has been') . "  <a href='" . base_url() . "transactions/add' class='btn btn-blue '><span class='fa fa-plus-circle' aria-hidden='true'></span> " . $this->lang->line('New') . "  </a> <a href='" . base_url() . 'transactions/view?id=' . $lid . "' class='btn btn-primary btn-xs'><span class='fa fa-eye'></span>  " . $this->lang->line('View') . "</a> <a href='" . base_url() . "transactions' class='btn btn-pink '><span class='fa fa-list-alt aria-hidden='true'></span></a>"));
            }
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                'Error!'));
        }

        $alert = $this->custom->api_config(66);
        if ($alert['key1'] == 1) {
            $this->load->model('communication_model');
            $subject = $payer_name . ' ' . $this->lang->line('Transaction has been');
            $body = $subject . '<br> ' . $this->lang->line('Credit') . ' ' . $this->lang->line('Amount') . ' ' . $credit . '<br> ' . $this->lang->line('Debit') . ' ' . $this->lang->line('Amount') . ' ' . $debit . '<br> ID# ' . $lid;
            $out = $this->communication_model->send_corn_email($alert['url'], $alert['url'], $subject, $body, false, '');
        }


    }

    public function save_transfer()
    {
        if (!$this->aauth->premission(5)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }

        $pay_acc = $this->input->post('pay_acc');
        $pay_acc2 = $this->input->post('pay_acc2');
        $amount = (float)$this->input->post('amount', true);

        if ($amount > 0) {
            if ($this->transactions->addtransfer($pay_acc, $pay_acc2, $amount, $this->aauth->get_user()->id, $this->aauth->get_user()->loc)) {
                echo json_encode(array('status' => 'Success', 'message' =>
                    "Transfer has been successfully done! <a href='" . base_url() . "transactions/transfer' class='btn btn-indigo btn-sm'><span class='icon-plus-circle' aria-hidden='true'></span> " . $this->lang->line('New') . "  </a> <a href='" . base_url() . "accounts' class='btn btn-indigo btn-sm'><span class='icon-list-ul' aria-hidden='true'></span></a>"));
            }
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                'Error!'));
        }


    }


    public function delete_i()
    {
        if (!$this->aauth->premission(5)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }

        $id = $this->input->post('deleteid');
        if ($id) {


            echo json_encode($this->transactions->delt($id));
            $alert = $this->custom->api_config(66);

        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Error!'));
        }
    }

    public function income()
    {
        if (!$this->aauth->premission(5)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $head['title'] = "Income Transaction";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('transactions/income');
        $this->load->view('fixed/footer');

    }

    public function expense()
    {
        if (!$this->aauth->premission(5)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $head['title'] = "Expense Transaction";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('transactions/expense');
        $this->load->view('fixed/footer');

    }

    public function view()
    {
        if (!$this->aauth->premission(5)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $head['title'] = "View Transaction";
        $head['usernm'] = $this->aauth->get_user()->username;
        $id = $this->input->get('id');
        $hash_code = $this->input->get('ref');
        $data['trans'] = $this->transactions->view($id,$hash_code);

        if ($data['trans']['payerid'] > 0) {
            $data['cdata'] = $this->transactions->cview($data['trans']['payerid'], $data['trans']['ext']);
        } else {
            $data['cdata'] = array('address' => 'Not Registered', 'city' => '', 'phone' => '', 'email' => '');
        }
        $this->load->view('fixed/header', $head);
        if ($data['trans']['id']) $this->load->view('transactions/view', $data);
        $this->load->view('fixed/footer');

    }


    public function print_t()
    {
        if (!$this->aauth->premission(5)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $head['title'] = "View Transaction";
        $head['usernm'] = $this->aauth->get_user()->username;
        $id = $this->input->get('id');
        $hash_code = $this->input->get('ref');
        $data['trans'] = $this->transactions->view($id,$hash_code);
        if ($data['trans']['payerid'] > 0) {
            $data['cdata'] = $this->transactions->cview($data['trans']['payerid'], $data['trans']['ext']);
        } else {
            $data['cdata'] = array('address' => 'Not Registered', 'city' => '', 'phone' => '', 'email' => '');
        }


        ini_set('memory_limit', '64M');

        $html = $this->load->view('transactions/view-print', $data, true);

        //PDF Rendering
        $this->load->library('pdf');

        $pdf = $this->pdf->load_en();

        $pdf->SetHTMLFooter('<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;"><tr><td width="33%"></td><td width="33%" align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td><td width="33%" style="text-align: right; ">#' . $id . '</td></tr></table>');

        if ($data['trans']['id']) $pdf->WriteHTML($html);

        if ($this->input->get('d')) {

            $pdf->Output('Trans_#' . $id . '.pdf', 'D');
        } else {
            $pdf->Output('Trans_#' . $id . '.pdf', 'I');
        }


    }


}