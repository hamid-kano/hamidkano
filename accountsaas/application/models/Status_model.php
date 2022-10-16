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

class Status_model extends CI_Model
{

    var $table = 'geopos_customer_status';
    public function view($id)
    {
        $query = $this->db->query("SELECT * FROM geopos_customer_status WHERE customer_id = ".$id." and company_id=".getCompanyId()." ORDER BY id DESC");
        return $query->result_array();
    }

    public function create($customer_id, $content)
    {
        $data = array(
            'customer_id' => $customer_id,
            'content' => $content,
            'company_id' => getCompanyId(),
            'hash_code' => getHashCode()
        );

        if ($this->db->insert('geopos_customer_status', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }
}