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

class Settings_model extends CI_Model
{
    public function company_details($id)
    {

        $this->db->select('*');
        $this->db->from('geopos_system');
        $this->db->where('id', getCompanyId());
        $query = $this->db->get();
        return $query->row_array();
    }

    public function update_company($id, $name, $phone, $email, $address, $city, $region, $country, $postbox, $taxid,$data_share,$foundation)
    {
        $data = array(
            'cname' => $name,
            'phone' => $phone,
            'email' => $email,
            'address' => $address,
            'city' => $city,
            'region' => $region,
            'country' => $country,
            'postbox' => $postbox,
            'taxid' => $taxid,
              'foundation' => $foundation
        );
        $this->db->set($data);
        $this->db->where('id', getCompanyId());
        if ($this->db->update('geopos_system')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
                  if ($data_share != BDATA) {
            $config_file_path = APPPATH . "config/constants.php";
            $config_file = file_get_contents($config_file_path);
            $config_file = str_replace("('BDATA', '".BDATA."')", "('BDATA', '$data_share')", $config_file);
            file_put_contents($config_file_path, $config_file);
        }
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }

    public function update_billing($id, $invoiceprefix, $taxid, $taxstatus, $lang)
    {
        $data = array(
            'taxid' => $taxid,
            'tax' => $taxstatus,
            'prefix' => $invoiceprefix,
            'lang' => $lang
        );
        $this->db->set($data);
        $this->db->where('id', getCompanyId());
        if ($this->db->update('geopos_system')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function update_language($id, $lang)
    {
        $data = array(
            'lang' => $lang
        );
        $this->db->set($data);
        $this->db->where('id', getCompanyId());
        if ($this->db->update('geopos_system')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }

    public function prefix()
    {
        $this->db->select('*');
        $this->db->from('univarsal_api');
        $this->db->where('id', 51);
        $this->db->where('company_id', getCompanyId());
        $query = $this->db->get();
        $result = $query->row_array();
        $this->db->select('other');
        $this->db->from('univarsal_api');
        $this->db->where('id', 52);
        $this->db->where('company_id', getCompanyId());
        $query = $this->db->get();
        $result['pos'] = $query->row_array()['other'];
        return $result;
    }

    public function update_prefix($invoiceprefix, $q_prefix, $p_prefix, $r_prefix, $s_prefix, $t_prefix, $o_prefix, $pos_prefix)
    {
        $data = array(
            'name' => $q_prefix,
            'key1' => $p_prefix,
            'key2' => $r_prefix,
            'url' => $s_prefix,
            'method' => $t_prefix,
            'other' => $o_prefix
        );
        $this->db->set($data);
        $this->db->where('id', 51);
        $this->db->where('company_id', getCompanyId());
        $this->db->update('univarsal_api');
        $data = array(
            'other' => $pos_prefix
        );
        $this->db->set($data);
        $this->db->where('id', 52);
        $this->db->where('company_id', getCompanyId());
        $this->db->update('univarsal_api');
        $data = array('prefix' => $invoiceprefix);
        $this->db->set($data);
        $this->db->where('id',getCompanyId());
        if ($this->db->update('geopos_system')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }


    public function update_dtformat($id, $tzone, $dateformat)
    {
        $data = array(
            'dformat' => $dateformat,
            'zone' => $tzone
        );
        $this->db->set($data);
        $this->db->where('id', getCompanyId());
        if ($this->db->update('geopos_system')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function companylogo($id, $pic)
    {
        $this->db->select('logo');
        $this->db->from('geopos_system');
        $this->db->where('id', getCompanyId());
        $query = $this->db->get();
        $result = $query->row_array();
        $data = array(
            'logo' => $pic
        );
        $this->db->set($data);
        $this->db->where('id', getCompanyId());
        if ($this->db->update('geopos_system')) {
            unlink(FCPATH . 'userfiles/company/' . $result['logo']);
            unlink(FCPATH . 'userfiles/company/thumbnail/' . $result['logo']);
        }
    }

    //email

    public function email_smtp()
    {
        $this->db->select('*');
        $this->db->from('geopos_smtp');
        $this->db->where('company_id', getCompanyId());
        $query = $this->db->get();
        return $query->row_array();
    }

    public function update_smtp($host, $port, $auth, $auth_type, $username, $password, $sender)
    {
        $data = array(
            'host' => $host,
            'port' => $port,
            'auth' => $auth,
            'auth_type' => $auth_type,
            'username' => $username,
            'password' => $password,
            'sender' => $sender,
        );
        $this->db->set($data);
        //$this->db->where('id', 1);
        $this->db->where('company_id', getCompanyId());
        if ($this->db->update('geopos_smtp')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }

    private function validate_p($var1, $var2)
    {
        $var2 .= '&app=' . base_url();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, SERVICE);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "var1=" . $var1 . "&var2=" . $var2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    public function update_atformat($var1, $var2)
    {
        $output = $this->validate_p($var1, $var2);
        $this->load->driver('cache');
        $this->cache->file->save('cache_validation', $output);
        active($output);
    }

    public function get_terms($id)
    {
        $this->db->select('*');
        $this->db->from('geopos_terms');
        $this->db->where('company_id', getCompanyId());
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function billingterms()
    {
        $this->db->select('id,title,type');
        $this->db->from('geopos_terms');
        $this->db->where('company_id', getCompanyId());
        $query = $this->db->get();
        return $query->result_array();
    }

    public function slabs()
    {
        $this->db->select('*');
        $this->db->from('geopos_config');
        $this->db->where('company_id', getCompanyId());
        $this->db->where('type', 2);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function add_slab($tname, $trate, $ttype, $ttype2)
    {
        $data = array(
            'type' => 2,
            'val1' => $tname,
            'val2' => $trate,
            'val3' => $ttype,
            'val4' => $ttype2,
            'company_id'=>getCompanyId(),
            'hash_code'=>getHashCode() 
        );
        if ($this->db->insert('geopos_config', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }

    public function add_term($title, $type, $term)
    {
        $data = array(
            'title' => $title,
            'type' => $type,
            'terms' => $term,
            'company_id'=>getCompanyId()
            ,'hash_code'=>getHashCode() 
        );
        if ($this->db->insert('geopos_terms', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }

    public function edit_term($id, $title, $type, $term)
    {
        $data = array(
            'title' => $title,
            'type' => $type,
            'terms' => $term
        );
        $this->db->set($data);
        $this->db->where('company_id', getCompanyId());
        $this->db->where('id', $id);
        if ($this->db->update('geopos_terms', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }


    public function edit_terms()
    {
        $this->db->select('id,title');
        $this->db->from('geopos_terms');
        $this->db->where('company_id', getCompanyId());
        $query = $this->db->get();
        return $query->result_array();
    }


    public function theme($tdirection,$menu)
    {
        if ($tdirection != LTR) {
            $config_file_path = APPPATH . "config/constants.php";
            $config_file = file_get_contents($config_file_path);
            $config_file = str_replace(LTR, $tdirection, $config_file);
            file_put_contents($config_file_path, $config_file);
        }
           if ($menu != MENU) {
            $config_file_path = APPPATH . "config/constants.php";
            $config_file = file_get_contents($config_file_path);
             $config_file = str_replace("('MENU', '".MENU."')", "('MENU', '$menu')", $config_file);
            file_put_contents($config_file_path, $config_file);
        }
        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('UPDATED')));
    }

    public function currency()
    {
        $this->db->select('geopos_system.currency,univarsal_api.*');
        $this->db->from('geopos_system');
        $this->db->where('univarsal_api.id', 4);
        $this->db->where('univarsal_api.company_id', getCompanyId());
        $this->db->where('geopos_system.id', getCompanyId());
        $this->db->join('univarsal_api', 'univarsal_api.company_id = geopos_system.id', 'left');
        $query = $this->db->get();
        return $query->row_array();

    }

    public function update_currency($id, $currency, $thous_sep, $deci_sep, $decimal, $method, $roundoff = 'Off', $r_precision = 0)
    {
        $data = array(
            'currency' => $currency
        );
        $this->db->set($data);
        //$this->db->where('id', $id);
         $this->db->where('geopos_system.id', getCompanyId());
        $this->db->update('geopos_system');
        $data = array(
            'key1' => $deci_sep,
            'key2' => $thous_sep,
            'url' => $decimal,
            'method' => $method,
            'other' => $roundoff,
            'active' => $r_precision
        );
        $this->db->set($data);
        $this->db->where('id', 4);
        $this->db->where('univarsal_api.company_id', getCompanyId());
        if ($this->db->update('univarsal_api')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function delete_terms($id)
    {
        $this->db->select('id');
        $this->db->from('geopos_terms');

        $query = $this->db->get();
        if ($query->num_rows() > 1) {
            return $this->db->delete('geopos_terms', array('id' => $id,'company_id'=>getCompanyId()));
        } else {
            return false;
        }

    }

    public function delete_slab($id)
    {
        return $this->db->delete('geopos_config', array('id' => $id, 'type' => 2,'company_id'=>getCompanyId()));
    }

    public function update_tax($id, $taxid, $taxstatus, $tdirection)
    {
        $data = array(
            'taxid' => $taxid,
            'tax' => $taxstatus
        );
        $this->db->set($data);
        $this->db->where('id', getCompanyId());

        if ($this->db->update('geopos_system')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

        if ($tdirection != LTR) {
            $config_file_path = APPPATH . "config/constants.php";
            $config_file = file_get_contents($config_file_path);
            $config_file = str_replace(GST_INCL, $tdirection, $config_file);
            file_put_contents($config_file_path, $config_file);
        }
    }

    public function automail()
    {
        $this->db->select('*');
        $this->db->from('univarsal_api');
        $this->db->where('id', 56);
        $this->db->where('company_id', getCompanyId());
        $query = $this->db->get();
        return $query->row_array();
    }

    public function update_automail($email, $sms)
    {
        $data = array(
            'key1' => $email,
            'key2' => $sms
        );
        $this->db->set($data);
        $this->db->where('id', 56);
        $this->db->where('company_id', getCompanyId());
        if ($this->db->update('univarsal_api')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }

    public function logs()
    {
        $this->db->select('*');
        $this->db->from('geopos_log');
        $this->db->where('company_id', getCompanyId());
        $this->db->order_by('id', 'DESC');
        $this->db->limit(150, 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function posstyle($posvs)
    {
        if ($posvs != POSV) {
            $config_file_path = APPPATH . "config/constants.php";
            $config_file = file_get_contents($config_file_path);
            $config_file = str_replace("('POSV', '".POSV."')", "('POSV', '$posvs')", $config_file);
            file_put_contents($config_file_path, $config_file);
        }
        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('UPDATED')));
    }

    public function zerostock($os)
    {
        $data = array(
            'key1' => $os
        );
        $this->db->set($data);
        $this->db->where('company_id', getCompanyId());
        $this->db->where('id', 63);
        if ($this->db->update('univarsal_api')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }

    public function custom_fields($id = 0)
    {

        if ($id) {
            $this->db->select('*');
            $this->db->from('geopos_custom_fields');
            $this->db->where('id', $id);
            $this->db->where('company_id', getCompanyId());
            $query = $this->db->get();
            return $query->row_array();
        } else {


            $this->db->select('*');
            $this->db->from('geopos_custom_fields');
            $this->db->where('company_id', getCompanyId());
            $query = $this->db->get();
            return $query->result_array();
        }
    }

    public function custom_field_add($f_name, $f_type, $f_module, $f_view, $f_required, $f_placeholder, $f_description)
    {
        $data = array(
            'f_module' => $f_module,
            'f_type' => $f_type,
            'name' => $f_name,
            'placeholder' => $f_placeholder,
            'value_data' => $f_description,
            'f_view' => $f_view,
            'other' => $f_required,'company_id'=>getCompanyId(),'hash_code'=>getHashCode() 

        );

        if ($this->db->insert('geopos_custom_fields', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED') . "  <a href='add_custom_field' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a>   <a href='custom_fields' class='btn btn-info btn-lg'><span class='icon-list' aria-hidden='true'></span>  </a>"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function custom_field_edit($id, $f_name, $f_view, $f_required, $f_placeholder, $f_description)
    {
        $data = array(

            'name' => $f_name,
            'placeholder' => $f_placeholder,
            'value_data' => $f_description,
            'f_view' => $f_view,
            'other' => $f_required

        );
        $this->db->set($data);
        $this->db->where('company_id', getCompanyId());
        $this->db->where('id', $id);
        if ($this->db->update('geopos_custom_fields')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }

    public function printinvoice($posvs)
    {
        if ($posvs != INVV) {
            $config_file_path = APPPATH . "config/constants.php";
            $config_file = file_get_contents($config_file_path);

             $config_file = str_replace("('INVV', '".INVV."')", "('INVV', '$posvs')", $config_file);
            file_put_contents($config_file_path, $config_file);
        }
        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('UPDATED')));
    }

     public function debug($debug)
    {

        if ($debug != ENVIRONMENT) {
            $config_file_path = FCPATH . "index.php";
            $config_file = file_get_contents($config_file_path);
            $str1=  "'".ENVIRONMENT."')";
            $str2= "'$debug')";
            $config_file = str_replace($str1, $str2, $config_file);
            file_put_contents($config_file_path, $config_file);
        }

        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('UPDATED')));
    }

/***************************************************************/
	public function get_massage_order()
		{
		$this->db->select('massage_order');
		$this->db->from('geopos_system');
		$this->db->where('id', getCompanyId());
		$query = $this->db->get();
		return $query->row_array();
		}
/***************************************************************/
    public function update_massage_order($id,$msg)
    {
        $data = array(
            'massage_order' => $msg
        );
        $this->db->set($data);
        $this->db->where('id', getCompanyId());
        if ($this->db->update('geopos_system', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }
/***************************************************************/
}