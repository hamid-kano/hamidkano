<?php
/**
 * Almusand -  Accounting,  Invoicing  and CRM Application
 * Copyright (c) Almusand. All Rights Reserved
 * ***********************************************************************
 *
 *  Email: support@almusand.com
 *  Website: https://almusand.com
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Printer
{
    function __construct()
    {
          $this->PI = &get_instance();
    }

    function check($id=0)
    {
        $this->PI->db->where('type', 1);
        $this->PI->db->where('val4', $id);
        $this->PI->db->where('company_id', getCompanyId());
        $this->PI->db->order_by('id', 'DESC');
        $query = $this->PI->db->get('geopos_config');
        $result = $query->row_array();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
}