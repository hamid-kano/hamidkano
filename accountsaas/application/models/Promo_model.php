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

class Promo_model extends CI_Model
{

    var $table = 'geopos_promo';
    var $column_order = array(null, 'code', 'valid', 'amount', null);
    var $column_search = array('code', 'valid', 'amount');
    var $order = array('id' => 'desc');

    private function _get_datatables_query($id = '')
    {

        $this->db->from($this->table);
        $this->db->where('company_id', getCompanyId());
                if ($this->aauth->get_user()->loc) {
            $this->db->group_start();
            $this->db->where('location', $this->aauth->get_user()->loc);
            if (BDATA) $this->db->or_where('location', 0);
            $this->db->group_end();
        } elseif (!BDATA) {
            $this->db->where('location', 0);
        }
        if ($id != '') {
            $this->db->where('gid', $id);
        }
        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            $search = $this->input->post('search');
        if(isset($search['value'])){
            $value = $search['value'];
        }else{
            $value = '';
        }
            
            if ($value) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $value);
                } else {
                    $this->db->or_like($item, $value);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $search = $this->input->post('order');
        if ($search) // here order processing
        {
            $this->db->order_by($this->column_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($id = '')
    {
        $this->_get_datatables_query($id);
        $this->db->where('company_id', getCompanyId());
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
                     if ($this->aauth->get_user()->loc) {
            $this->db->group_start();
            $this->db->where('location', $this->aauth->get_user()->loc);
            if (BDATA) $this->db->or_where('location', 0);
            $this->db->group_end();
        } elseif (!BDATA) {
            $this->db->where('location', 0);
        }
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($id = '')
    {
        $this->_get_datatables_query();
        $this->db->where('company_id', getCompanyId());
                     if ($this->aauth->get_user()->loc) {
            $this->db->group_start();
            $this->db->where('location', $this->aauth->get_user()->loc);
            if (BDATA) $this->db->or_where('location', 0);
            $this->db->group_end();
        } elseif (!BDATA) {
            $this->db->where('location', 0);
        }
        $query = $this->db->get();
        return $query->num_rows($id = '');
    }

    public function count_all($id = '')
    {
        $this->_get_datatables_query();
        $this->db->where('company_id', getCompanyId());
                     if ($this->aauth->get_user()->loc) {
            $this->db->group_start();
            $this->db->where('location', $this->aauth->get_user()->loc);
            if (BDATA) $this->db->or_where('location', 0);
            $this->db->group_end();
        } elseif (!BDATA) {
            $this->db->where('location', 0);
        }
        $query = $this->db->get();
        return $query->num_rows($id = '');
    }

    public function details($custid)
    {

        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id', $custid);
        $this->db->where('company_id', getCompanyId());
        $query = $this->db->get();
        return $query->row_array();
    }


    public function create($code, $amount, $qty, $valid, $link_ac, $pay_acc, $note)
    {

        if ($link_ac == 'no') {
            $pay_acc = 0;
        }

        $data = array(
            'code' => $code,
            'amount' => $amount,
            'valid' => $valid,
            'active' => 0,
            'note' => $note,
            'reflect' => $pay_acc,
            'qty' => $qty,
            'available' => $qty,
            'location' => $this->aauth->get_user()->loc,'company_id'=>getCompanyId(),'hash_code'=>getHashCode() 
        );

        if ($this->db->insert('geopos_promo', $data)) {
            //$cid = $this->db->insert_id();
            if ($pay_acc > 0) {
                $amount = $amount * $qty;
                $this->db->select('holder');
                $this->db->from('geopos_accounts');
                $this->db->where('id', $pay_acc);
                $this->db->where('company_id', getCompanyId());
                $query = $this->db->get();
                $account = $query->row_array();
                $data = array(
                    'payerid' => 0,
                    'payer' => $this->lang->line('Coupon') . '-' . $code,
                    'acid' => $pay_acc,
                    'account' => $account['holder'],
                    'date' => date('Y-m-d'),
                    'debit' => $amount,
                    'credit' => 0,
                    'type' => 'Expense',
                    'cat' => $this->lang->line('Coupon'),
                    'method' => 'Transfer',
                    'eid' => $this->aauth->get_user()->id,
                    'note' => $this->lang->line('Coupon') . ' ' . $this->lang->line('Qty') . '-' . $qty,
                    'loc' => $this->aauth->get_user()->loc,'company_id'=>getCompanyId(),'hash_code'=>getHashCode() 
                );
                $this->db->set('lastbal', "lastbal-$amount", FALSE);
                $this->db->where('id', $pay_acc);
                $this->db->where('company_id', getCompanyId());
                $this->db->update('geopos_accounts');
                $this->db->insert('geopos_transactions', $data);
            }
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED')));

        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }


    public function promo_stats()
    {  $whr='';
             if ($this->aauth->get_user()->loc) {
            $whr = ' WHERE location=' . $this->aauth->get_user()->loc;
             if(BDATA) $whr .= 'OR location=0 ';
        } elseif (!BDATA) {
            $whr = ' WHERE location=0 ';
        }
        if(empty($whr)){
            $whr = ' WHERE company_id='.getCompanyId();
        }else{
            $whr = $whr .' and '.'company_id='.getCompanyId();
        }


        $query = $this->db->query("SELECT
				COUNT(IF( active = '0', id, NULL)) AS Active,
				COUNT(IF( active = '1', id, NULL)) AS Used,
				COUNT(IF( active = '2', id, NULL)) AS Expired
				FROM geopos_promo $whr");
        echo json_encode($query->result_array());

    }

    public function accountslist()
    {
        $this->db->select('*');
        $this->db->from('geopos_accounts');
        $this->db->where('company_id', getCompanyId());
                    if ($this->aauth->get_user()->loc) {
            $this->db->group_start();
            $this->db->where('loc', $this->aauth->get_user()->loc);
            if (BDATA) $this->db->or_where('loc', 0);
            $this->db->group_end();
        } elseif (!BDATA) {
            $this->db->where('loc', 0);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function set_status($id, $stat)
    {

        $data = array('active' => $stat);
        $this->db->set($data);
        $this->db->where('id', $id);
         $this->db->where('company_id', getCompanyId());
        return $this->db->update('geopos_promo');
    }


}