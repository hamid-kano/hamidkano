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


class Journals_model extends CI_Model
{
    var $table = 'journals';
    var $column_order = array('date', 'note', 'sum', 'total_lines');
    var $column_search = array('id', 'note');
    var $order = array('id' => 'desc');

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        $this->db->select('journals.*,journals.id as id');
        $this->db->from($this->table);
        $this->db->where('company_id', getCompanyId());

        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            if ($this->input->post('search')['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $this->input->post('search')['value']);
                } else {
                    $this->db->or_like($item, $this->input->post('search')['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        $this->db->where('company_id', getCompanyId());
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }


    function count_filtered()
    {
        $this->db->from($this->table);
        $this->db->where('company_id', getCompanyId());
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        $this->db->where('company_id', getCompanyId());
        return $this->db->count_all_results();
    }

    public function get_journal($id,$hash_code)
    {

        $this->db->select('*');
        $this->db->from('journals');
        $this->db->where('id',$id);
        $this->db->where('hash_code',$hash_code);
        $this->db->where('company_id', getCompanyId());
        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_transactions($id) {
        $this->db->select('*');
        $this->db->from('geopos_transactions');
        $this->db->where('journal_id',$id);
        $this->db->where('company_id', getCompanyId());
        $query = $this->db->get();
        return $query->result_array();
    }

    public function store($data)
    {

        $this->db->insert('journals',$data);
        return $this->db->insert_id();
    }

    public function deletefile($journal_id, $file_name)
    {

        $this->db->select('files');
        $this->db->from('journals');
        $this->db->where('id', $journal_id);
        $this->db->where('company_id', getCompanyId());
        $query = $this->db->get();
        $result = $query->row_array();
        unlink(FCPATH . 'userfiles/journal/' . $file_name);
        $files = explode(',', $result['files']);
        if (($key = array_search($file_name, $files)) !== false) {
            unset($files[$key]);
        }
        $this->db->where('id', $journal_id)->update('journals', array('files' => implode(',', $files)));
    }

    public function addfile($journal_id, $file_name)
    {

        $this->db->select('files');
        $this->db->from('journals');
        $this->db->where('id', $journal_id);
        $this->db->where('company_id', getCompanyId());
        $query = $this->db->get();
        $result = $query->row_array();
        $files = explode(',', $result['files']);
        array_push($files, $file_name);
        $this->db->where('id', $journal_id)->update('journals', array('files' => implode(',', $files)));
    }

}