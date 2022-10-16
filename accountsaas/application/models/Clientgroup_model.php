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

class Clientgroup_model extends CI_Model
{


    public function details($id,$hash_code)
    {

        $this->db->select('*');
        $this->db->from('geopos_cust_group');
        $this->db->where('id', $id);
        $this->db->where('company_id', getCompanyId());
        $this->db->where('hash_code', $hash_code);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function recipients($id)
    {

        $this->db->select('id,name,email');
        $this->db->from('geopos_customers');
        $this->db->where('gid', $id);
        $this->db->where('company_id', getCompanyId());
        $query = $this->db->get();
        return $query->result_array();
    }


    public function add($group_name, $group_desc)
    {
        $data = array(
            'title' => $group_name,
            'summary' => $group_desc,
            'company_id' =>getCompanyId(),
            'hash_code' =>getHashCode()
        );

        if ($this->db->insert('geopos_cust_group', $data)) {
            $this->aauth->applog("[Group Created] $group_name ID " . $this->db->insert_id(), $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }


    public function editgroupupdate($gid, $group_name, $group_desc,$hash_code)
    {
        $data = array(
            'title' => $group_name,
            'summary' => $group_desc
        );


        $this->db->set($data);
        $this->db->where('id', $gid);
        $this->db->where('company_id', getCompanyId());
        $this->db->where('hash_code', $hash_code);

        if ($this->db->update('geopos_cust_group')) {
            $this->aauth->applog("[Group updated] $group_name ID " . $gid, $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function editgroupdiscountupdate($gid, $disc_rate,$hash_code)
    {
        $data = array(
            'disc_rate' => $disc_rate
        );
        $this->db->set($data);
        $this->db->where('id', $gid);
        $this->db->where('company_id', getCompanyId());
       // $this->db->where('hash_code', $hash_code);

        if ($this->db->update('geopos_cust_group')) {

            $data = array(
                'discount_c' => $disc_rate
            );
            $this->db->set($data);
            $this->db->where('gid', $gid);
            $this->db->where('company_id', getCompanyId());
            $this->db->update('geopos_customers');

            $this->aauth->applog("[Group discount updated] %" . $disc_rate . " GID-" . $gid, $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }
}