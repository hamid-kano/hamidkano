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


class Printer_model extends CI_Model
{
    var $table = 'geopos_config';

    public function __construct()
    {
        parent::__construct();
    }

    public function printers_list()
    {
        $this->db->select('*');
        $this->db->from('geopos_config');
        $this->db->where('company_id', getCompanyId());
        $this->db->where('type', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function printer_details($id,$hash_code)
    {
        $this->db->select('*');
        $this->db->from('geopos_config');
        $this->db->where('company_id', getCompanyId());
        $this->db->where('id', $id);
        $this->db->where('hash_code', $hash_code);
        $this->db->where('type', 1);
        $query = $this->db->get();
        return $query->row_array();
    }


    public function create($p_name, $p_type, $p_connect, $lid, $mode)
    {
        $data = array(
            'type' => 1,
            'val1' => $p_name,
            'val2' => $p_type,
            'val3' => $p_connect,
            'val4' => $lid,
            'other' => $mode,'company_id'=>getCompanyId(),'hash_code'=>getHashCode() 
        );
        if ($this->db->insert('geopos_config', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }

    public function edit($id, $p_name, $p_type, $p_connect, $lid, $mode)
    {
        $data = array(
            'type' => 1,
            'val1' => $p_name,
            'val2' => $p_type,
            'val3' => $p_connect,
            'val4' => $lid,
            'other' => $mode
        );


        $this->db->set($data);
        $this->db->where('id', $id);
        $this->db->where('company_id', getCompanyId());

        if ($this->db->update('geopos_config')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }


}