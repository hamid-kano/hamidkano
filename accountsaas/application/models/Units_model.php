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

class Units_model extends CI_Model
{


    public function units_list()
    {
        $query = $this->db->query("SELECT * FROM geopos_units WHERE type=0 and company_id=".getCompanyId()." ORDER BY id DESC");
        return $query->result_array();
    }


    public function view($id,$hash_code)
    {

        $this->db->from('geopos_units');
        $this->db->where('id', $id);
        $this->db->where('hash_code', $hash_code);
        $this->db->where('company_id', getCompanyId());
        $query = $this->db->get();
        $result = $query->row_array();
        return $result;


    }

    public function create($name, $code)
    {
        $data = array(
            'name' => $name,
            'code' => $code,'company_id'=>getCompanyId(),'hash_code'=>getHashCode() 
        );

        if ($this->db->insert('geopos_units', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function edit($id, $name, $code)
    {
        $data = array(
            'name' => $name,
            'code' => $code
        );

        $this->db->set($data);
        $this->db->where('company_id', getCompanyId());
        $this->db->where('id', $id);

        if ($this->db->update('geopos_units')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function variations_list()
    {
        $query = $this->db->query("SELECT * FROM geopos_units WHERE type=1 and company_id=".getCompanyId()." ORDER BY id DESC");
        return $query->result_array();
    }

    public function create_va($name, $type = 0)
    {
        $data = array(
            'name' => $name,
            'type' => $type,'company_id'=>getCompanyId(),'hash_code'=>getHashCode() 
        );

        if ($this->db->insert('geopos_units', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function edit_va($id, $name)
    {
        $data = array(
            'name' => $name
        );

        $this->db->set($data);
        $this->db->where('company_id', getCompanyId());
        $this->db->where('id', $id);

        if ($this->db->update('geopos_units')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function variables_list()
    {
        //   $query = $this->db->query("SELECT * FROM geopos_units WHERE type=2 ORDER BY id DESC");
        //    return $query->result_array();
        $this->db->select('u.id,u.name,u2.name AS variation,u.hash_code');
        $this->db->join('geopos_units u2', 'u.rid = u2.id', 'left');
        $this->db->where('u.type', 2);
        $this->db->where('u2.company_id', getCompanyId());
        $this->db->order_by('u.name', 'asc');
        $query = $this->db->get('geopos_units u');
        return $query->result_array();
    }

    public function create_vb($name, $var_id)
    {
        $data = array(
            'name' => $name,
            'type' => 2,
            'rid' => $var_id,'company_id'=>getCompanyId(),'hash_code'=>getHashCode() 
        );

        if ($this->db->insert('geopos_units', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function edit_vb($id, $name, $var_id)
    {
        $data = array(
            'name' => $name,
            'rid' => $var_id
        );

        $this->db->set($data);
        $this->db->where('company_id', getCompanyId());
        $this->db->where('id', $id);

        if ($this->db->update('geopos_units')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }


}