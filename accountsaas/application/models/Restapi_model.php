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


class Restapi_model extends CI_Model
{
    var $table = 'geopos_restkeys';

    public function __construct()
    {
        parent::__construct();
    }

    public function keylist()
    {
        $this->db->select('*');
        $this->db->from('geopos_restkeys');
        $this->db->where('company_id', getCompanyId());
        $query = $this->db->get();
        return $query->result_array();
    }


    public function addnew($return_key = false)
    {

        $random = substr(md5(mt_rand()), 0, 24);
        $data = array(
            'user_id' => 0,
            'key' => $random,
            'level' => 0,
            'date_created' => date('Y-m-d'),'company_id'=>getCompanyId(),'hash_code'=>getHashCode()


        );

        if ($this->db->insert('geopos_restkeys', $data)) {
            return $return_key ? $random : true;
        } else {
            return false;

        }

    }


}