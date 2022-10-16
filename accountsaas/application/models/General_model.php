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

class General_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function public_key()
    {
        $this->db->select('key1 AS recaptcha_p,key2 AS captcha,url AS recaptcha_s');
        $this->db->from('univarsal_api');
        $query = $this->db->get();
        $this->db->where('company_id', getCompanyId());
        $this->db->where('id', 53);
        return $query->row();
    }

    public function reset($key = '')
    {
        $file = APPPATH . "config/lic.php";
        $key_o = file_get_contents($file);
        if ($key == (string)$key_o) {
            file_put_contents($file, " ");
        }
    }

}