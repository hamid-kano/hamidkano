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

class Register_model extends CI_Model
{

    var $table = 'geopos_register';
    var $column_order = array(null, 'DATE(geopos_register.o_date)', 'geopos_register.c_date', 'geopos_register.active', null);
    var $column_search = array('geopos_register.o_date', 'geopos_register.c_date');
    var $order = array('geopos_register.id' => 'desc');

    private function _get_datatables_query()
    {
        $this->db->select('geopos_register.*,geopos_users.username');
        $this->db->from($this->table);
        $this->db->join('geopos_users', 'geopos_register.uid=geopos_users.id', 'left');
        $this->db->where('geopos_register.company_id', getCompanyId());
            if ($this->aauth->get_user()->loc) {
            $this->db->group_start();
            $this->db->where('geopos_users.loc', $this->aauth->get_user()->loc);
            if (BDATA) $this->db->or_where('geopos_users.loc', 0);
            $this->db->group_end();
        } elseif (!BDATA) {
            $this->db->where('geopos_users.loc', 0);
        }
        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            $search = $this->input->post('search');
        if(!isset($search['value'])){
            $search['value'] = '';
        }
            $value = $search['value'];
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

    function get_datatables()
    {
        $this->_get_datatables_query();
        $this->db->where('geopos_register.company_id', getCompanyId());
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $this->db->where('geopos_register.company_id', getCompanyId());
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->_get_datatables_query();
        $this->db->where('geopos_register.company_id', getCompanyId());
        $query = $this->db->get();
        return $query->num_rows();
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





}