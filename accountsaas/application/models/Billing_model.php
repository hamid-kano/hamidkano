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

class Billing_model extends CI_Model
{
    
    protected $accounts = [];

    public function paynow($tid, $amount, $note, $pmethod, $loc = false,$bill_date=null,$account_d=0)
    {
        $this->load->model('journals_model','journals');
        $this->load->model('transactions_model', 'transactions');
        $this->db->select('geopos_invoices.*,geopos_customers.name as customer_name,geopos_customers.id AS cid');
        $this->db->from('geopos_invoices');
        $this->db->where('geopos_invoices.id', $tid);
        $this->db->where('geopos_invoices.company_id', getCompanyId());
        $this->db->join('geopos_customers', 'geopos_invoices.csd = geopos_customers.id', 'left');

        $query = $this->db->get();
        $invoice = $query->row_array();

        if(!$bill_date) $bill_date = date('Y-m-d');
        
        /* Journals Code Amr Mahmoud */
        $date = datefordatabase($bill_date);
        $journal_data = [
            'date'=>$date,
            'note'=>$note,
            'files'=>null,
            'total_lines'=>3,
            'sum'=>$invoice['total'],
        ];
        $this->db->trans_start();
        $journal_id = $this->journals->store($journal_data);
        
        $payer_account_number = 10102; // account nakdeyah
        switch ($pmethod) {
            case 'Cash' :
                $payer_account_number = 10102; // account nakdeyah
                break;
            case 'Card Swipe' :
                $payer_account_number = 1010101; // account bank Al Ahly
                break;
            case 'Bank' :
                $payer_account_number = 1010101; // account bank Al Ahly
                break;
                 case 'Cash Card' :
                $payer_account_number = 10102; // account nakdeyah
                break;
        }
        
        $payer_account_id = $this->get_account_id_by_number($payer_account_number);

        $transactions = [
            [
                'debit'=>$invoice['total'],
                'credit'=>0,
                'pay_acc'=>$payer_account_id,
            ],    
            [
                'credit'=>$invoice['total'] - $invoice['tax'],
                'debit'=>0,
                'pay_acc'=>$this->get_account_id_by_number(401), // account mabey3aat
            ],    
            [
                'credit'=>$invoice['tax'],
                'debit'=>0,
                'pay_acc'=>$this->get_account_id_by_number(20101), // account VAT
            ]   
        ];
        
        foreach ($transactions as $transaction) {
            $credit = $transaction['credit'] ?? 0;
            $debit = $transaction['debit'] ?? 0;
            $pay_acc = $transaction['pay_acc'];
            $pay_cat = "غير محدد";
            $pay_type = ($credit > $debit) ? "Income" : "Expense";
            $paymethod = "غير محدد";
            if(!$this->transactions->addtrans($invoice['cid'], $invoice['customer_name'], $pay_acc, $date, $debit, $credit, $pay_type, $pay_cat, $pmethod, $note, $invoice['eid'], $invoice['loc'], $payer_ty = 0,  $journal_id)) {
                return json_encode(array('status' => 'Error', 'message' =>
                'Error!'));
            }
        }
        /* Journals Code Amr Mahmoud */
        
        $this->aauth->applog("[Payment Invoice".$tid."] ", $this->aauth->get_user()->username);
        if ($this->db->trans_complete()) {
            return true;
        } else {
            return false;
        }
    }
    
    protected function get_account_id_by_number($account_number) {
        if(!$this->accounts) {
            $this->accounts = $this->db->select('id, acn')->from('geopos_accounts')->where('company_id',getCompanyId())->get()->result_array();
        }
        foreach($this->accounts as $account) {
            if($account['acn'] == $account_number) return $account['id'];
        }
    }

    public function gateway($id,$hash_code)
    {

        $this->db->from('geopos_gateways');
        $this->db->where('id', $id);
        $this->db->where('company_id', getCompanyId());
        $this->db->where('hash_code', $hash_code);
        $query = $this->db->get();
        return $query->row_array();
    }


    public function gateway_list($enable = '')
    {

        $this->db->from('geopos_gateways');

        if ($enable == 'Yes') {
            $this->db->where('enable', 'Yes');
        }
       $this->db->where('company_id', getCompanyId());
        $query = $this->db->get();
        return $query->result_array();
    }

    public function bank_accounts($enable = '')
    {

        $this->db->from('geopos_bank_ac');
        if ($enable == 'Yes') {
            $this->db->where('enable', 'Yes');
        }
        $this->db->where('company_id', getCompanyId());
        $query = $this->db->get();
        return $query->result_array();
    }

    public function bank_account_info($id,$hash_code)
    {

        $this->db->from('geopos_bank_ac');
        $this->db->where('id', $id);
        $this->db->where('hash_code', $hash_code);
        $this->db->where('company_id', getCompanyId());
        $query = $this->db->get();
        return $query->row_array();
    }


    public function gateway_update($gid, $currency, $key1, $key2, $enable, $devmode, $p_fee)
    {
        $data = array(
            'key1' => $key1,
            'key2' => $key2,
            'enable' => $enable,
            'dev_mode' => $devmode,
            'currency' => $currency,
            'surcharge' => $p_fee
        );


        $this->db->set($data);
        $this->db->where('company_id', getCompanyId());
        $this->db->where('id', $gid);

        if ($this->db->update('geopos_gateways')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function online_pay_settings()
    {

        $this->db->select('univarsal_api.key1 AS default_acid,univarsal_api.key2 AS currency_code,univarsal_api.url AS enable,univarsal_api.method AS bank, geopos_accounts.*');
        $this->db->from('univarsal_api');
        $this->db->where('univarsal_api.id', 54);
        $this->db->where('univarsal_api.company_id', getCompanyId());
        $this->db->join('geopos_accounts', 'univarsal_api.key1 = geopos_accounts.id
             ', 'left');
        $query = $this->db->get();
        return $query->row_array();
    }


    public function payment_settings($id, $enable, $bank)
    {
        $data = array(
            'key1' => $id,
            'url' => $enable,
            'method' => $bank
        );


        $this->db->set($data);
        $this->db->where('company_id', getCompanyId());
        $this->db->where('id', 54);

        if ($this->db->update('univarsal_api')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }


    public function bank_ac_add($name, $acn, $code, $enable, $bank, $branch, $address)
    {
        $data = array(
            'name' => $name,
            'acn' => $acn,
            'code' => $code,
            'enable' => $enable,
            'note' => $bank,
            'branch' => $branch,
            'address' => $address
            ,'company_id'=>getCompanyId(),'hash_code'=>getHashCode() 
        );


        if ($this->db->insert('geopos_bank_ac', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }


    public function bank_ac_update($gid, $name, $acn, $code, $enable, $bank, $branch, $address)
    {
        $data = array(
            'name' => $name,
            'acn' => $acn,
            'code' => $code,
            'enable' => $enable,
            'note' => $bank,
            'branch' => $branch,
            'address' => $address,
        );


        $this->db->set($data);
        $this->db->where('company_id', getCompanyId());
        $this->db->where('id', $gid);

        if ($this->db->update('geopos_bank_ac')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function add_currency($code, $symbol, $spos, $rate, $decimal, $thous_sep, $deci_sep)
    {
        $data = array(
            'code' => $code,
            'symbol' => $symbol,
            'rate' => $rate,
            'thous' => $thous_sep,
            'dpoint' => $deci_sep,
            'decim' => $decimal,
            'cpos' => $spos,
            'company_id'=>getCompanyId(),
            'hash_code'=>getHashCode() 
        );


        if ($this->db->insert('geopos_currencies', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function edit_currency($gid, $code, $symbol, $spos, $rate, $decimal, $thous_sep, $deci_sep)
    {
        $data = array(
            'code' => $code,
            'symbol' => $symbol,
            'rate' => $rate,
            'thous' => $thous_sep,
            'dpoint' => $deci_sep,
            'decim' => $decimal,
            'cpos' => $spos
        );
        $this->db->set($data);
        $this->db->where('id', $gid);
        $this->db->where('company_id', getCompanyId());
        if ($this->db->update('geopos_currencies')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }


    public function exchange($currency, $key1, $key2, $enable, $reverse = 0)
    {
        $data = array(
            'key1' => $key1,
            'key2' => $key2,
            'url' => $currency,
            'other' => $reverse,
            'active' => $enable
        );

        $this->db->set($data);
        $this->db->where('id', 5);
        $this->db->where('company_id', getCompanyId());
        if ($this->db->update('univarsal_api')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }


    public function recharge_done($id, $amount)
    {

        $this->db->set('balance', "balance+$amount", FALSE);
        $this->db->where('id', $id);
        $this->db->where('company_id', getCompanyId());
        $this->db->update('geopos_customers');

        $data = array(
            'type' => 21,
            'rid' => $id,
            'col1' => $amount,
            'col2' => date('Y-m-d H:i:s') . ' Account Recharge',
            'company_id'=>getCompanyId(),
            'hash_code'=>getHashCode() 
        );


        if ($this->db->insert('geopos_metadata', $data)) {
            $this->aauth->applog("[Wallet Payment $id]  Amt - $amount ", $this->aauth->get_user()->username);
            return true;
        } else {
            return false;
        }

    }

    public function pos_paynow($tid, $amount, $note, $pmethod)
    {

        $this->db->select('geopos_accounts.id,geopos_accounts.holder,');
        $this->db->from('univarsal_api');
        $this->db->where('univarsal_api.id', 54);
        $this->db->join('geopos_accounts', 'univarsal_api.key1 = geopos_accounts.id', 'left');
        $this->db->where('company_id', getCompanyId());
        $query = $this->db->get();
        $account = $query->row_array();

        $this->db->select('geopos_invoices.*,geopos_customers.name,geopos_customers.id AS cid');
        $this->db->from('geopos_invoices');
        $this->db->where('geopos_invoices.id', $tid);
        $this->db->where('company_id', getCompanyId());
        $this->db->join('geopos_customers', 'geopos_invoices.csd = geopos_customers.id', 'left');
        $this->db->where('company_id', getCompanyId());
        $query = $this->db->get();
        $invoice = $query->row_array();

        // print_r($invoice);


        $data = array(
            'acid' => $account['id'],
            'account' => $account['holder'],
            'type' => 'Income',
            'cat' => 'Sales',
            'credit' => $amount,
            'payer' => $invoice['name'],
            'payerid' => $invoice['csd'],
            'method' => $pmethod,
            'date' => date('Y-m-d'),
            'eid' => $invoice['eid'],
            'tid' => $tid,
            'note' => $note,
            'loc' => $invoice['loc'],
            'company_id'=>getCompanyId(),
            'hash_code'=>getHashCode() 
        );
        $this->db->trans_start();
        $this->db->insert('geopos_transactions', $data);
        $trans = $this->db->insert_id();


        $totalrm = $invoice['total'] - $invoice['pamnt'];

        if ($totalrm > $amount) {
            $this->db->set('pmethod', $pmethod);
            $this->db->set('pamnt', "pamnt+$amount", FALSE);

            $this->db->set('status', 'partial');
            $this->db->where('id', $tid);
            $this->db->where('company_id', getCompanyId());
            $this->db->update('geopos_invoices');


            //account update
            $this->db->set('lastbal', "lastbal+$amount", FALSE);
            $this->db->where('id', $account['id']);
            $this->db->where('company_id', getCompanyId());
            $this->db->update('geopos_accounts');

        } else {
            $this->db->set('pmethod', $pmethod);
            $this->db->set('pamnt', "pamnt+$amount", FALSE);
            $this->db->set('status', 'paid');
            $this->db->where('id', $tid);
            $this->db->where('company_id', getCompanyId());
            $this->db->update('geopos_invoices');
            //acount update
            $this->db->set('lastbal', "lastbal+$amount", FALSE);
            $this->db->where('id', $account['id']);
            $this->db->where('company_id', getCompanyId());
            $this->db->update('geopos_accounts');

        }
        $this->aauth->applog("[Payment Invoice $tid]  Transaction-$trans - $amount ", $this->aauth->get_user()->username);
        if ($this->db->trans_complete()) {
            return true;
        } else {
            return false;
        }
    }

    public function token($in=0,$type=1)
    {
        if($type==1){
             $data = array(
            'type' => 71,
            'rid' => $in,
            'col1' => 1,
            'col2' => 2,
            'd_date' => date('Y-m-d'),
            'company_id'=>getCompanyId(),
            'hash_code'=>getHashCode() 
        );
        $this->db->insert('geopos_metadata', $data);
        return true;
        }elseif($type==2){
            $this->db->from('geopos_metadata');
            $this->db->where('type', 71);

        $this->db->where('company_id', getCompanyId());
            $this->db->where('rid', $in);
           $query = $this->db->get();
           return $query->row_array();
        }else{
              $this->db->delete('geopos_metadata', array('type' => 71,'rid'=> $in,'company_id'=>getCompanyId()));
        }
    }


}