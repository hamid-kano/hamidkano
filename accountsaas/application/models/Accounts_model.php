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


class Accounts_model extends CI_Model
{
    var $table = 'geopos_accounts';

    public function __construct()
    {
        parent::__construct();
    }

    public function accountslist($company_id=0)
    {
        $this->db->select('*');
        $this->db->from($this->table);

        if ($this->aauth->get_user()->loc) {
            $this->db->where('loc', $this->aauth->get_user()->loc);
           if(BDATA) $this->db->or_where('loc', 0);
        }else{
             if(!BDATA) $this->db->where('loc', 0);
        }
        $this->db->where('company_id', getCompanyId());
        $query = $this->db->get();
        $result = $query->result_array();
        
        usort($result, function($a, $b){
            for($i = 1; $i <= 12; $i++) {
        if(substr($a['acn'], 0, $i) < substr($b['acn'], 0, $i)) {
            return -1;
            break;
        }
        if(substr($a['acn'], 0, $i) > substr($b['acn'], 0, $i)) {
            return 1;
            break;
        }
        if($i >= strlen($a['acn']) || $i >= $b['acn']) {
            break;
        }
    if(isset($a['acn']) and isset($b['acn'])){
        if(intval(substr($a['acn'], $i)) - intval(substr($b['acn'], $i))) continue;
    }
        

            }
        
        });
        return $result;
    }

    public function details($acid,$hash_code='')
    {

        $this->db->select('*');
        $this->db->from('geopos_accounts');
        $this->db->where('id', $acid);
        if ($this->aauth->get_user()->loc) {
            $this->db->group_start();
            $this->db->where('loc', $this->aauth->get_user()->loc);
            if(BDATA)  $this->db->or_where('loc', 0);
            $this->db->group_end();
        }
        $this->db->where('company_id', getCompanyId());
        if(!empty($hash_code)){
            $this->db->where('hash_code', $hash_code);
        }
        $query = $this->db->get();
        return $query->row_array();
    }

    public function details_view($acid,$hash_code)
    {

        $this->db->select('*');
        $this->db->from('geopos_accounts');
        $this->db->where('id', $acid);
        if ($this->aauth->get_user()->loc) {
            $this->db->group_start();
            $this->db->where('loc', $this->aauth->get_user()->loc);
            if(BDATA)  $this->db->or_where('loc', 0);
            $this->db->group_end();
        }
        $this->db->where('company_id', getCompanyId());
        $this->db->where('hash_code', $hash_code);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function count_accounts_related_to_parent($parent_id)
    {

        $this->db->select('*');
        $this->db->from('geopos_accounts');
        $this->db->where('parent_id', $parent_id);
        $this->db->where('company_id', getCompanyId());
        return $this->db->count_all_results();
    }
    public function last_account_no($parent = null)
    {
        $this->db->select('*');
        $this->db->from('geopos_accounts');
        $this->db->where(['parent_id'=>$parent]);
        $this->db->where('company_id', getCompanyId());
        $this->db->order_by('acn',"desc")->limit(1);
        $query = $this->db->get();
        if($query->row_array()) return $query->row_array()['acn'];
        return 0;
    }

    public function addnew($accno, $holder, $intbal, $acode, $lid,$account_type,$account_parent_id,$analytical, $type)
    {
        $data = array(
            'acn' => $accno,
            'holder' => $holder,
            'adate' => date('Y-m-d H:i:s'),
            'lastbal' => $intbal,
            'initial_balance' => $intbal,
            'code' => $acode,
            'loc' => $lid,
            'account_type'=>$account_type,
            'parent_id'=>$account_parent_id,
            'analytical'=>$analytical,
            'type'=> $type,
            'company_id'=>getCompanyId(),
            'hash_code'=>getHashCode() 
        );

        if ($this->db->insert('geopos_accounts', $data)) {
            $this->aauth->applog("[Account Created] $accno - $intbal ID " . $this->db->insert_id(), $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED'). "  <a href='".base_url('accounts')."' class='btn btn-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a> <a href='add' class='btn btn-info btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a>"));
        } else {

            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
//var_dump($this->db->error());exit;
    }

    public function edit($acid, $accno, $holder, $acode, $lid,$account_equity='',$analytical, $type,$hash_code)
    {
        if($account_equity){
               $data = array(
            'acn' => $accno,
            'holder' => $holder,
            'code' => $acode,
            'loc' => $lid,
            'lastbal'=>$account_equity,
            'analytical'=>$analytical,
            'type'=>$type
        );
        }
        else{
               $data = array(
            'acn' => $accno,
            'holder' => $holder,
            'code' => $acode,
            'loc' => $lid,
            'analytical'=>$analytical,
            'type'=>$type
        );
        }

        $this->db->set($data);
        $this->db->where('id', $acid);
        $this->db->where('company_id', getCompanyId());
        $this->db->where('hash_code', $hash_code);
         if ($this->aauth->get_user()->loc) {
           $this->db->where('loc', $this->aauth->get_user()->loc);
         }

        if ($this->db->update('geopos_accounts')) {
            $this->aauth->applog("[Account Edited] $accno - ID " . $acid, $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function account_stats($company_id)
    {
        $whr = ' ';
        if ($this->aauth->get_user()->loc) {
            $whr = ' WHERE loc=' . $this->aauth->get_user()->loc;
             if(BDATA) $whr .= 'OR loc=0 ';
        }
        //$this->db->where('company_id', $company_id);

        $query = $this->db->query("SELECT SUM(lastbal) AS balance,COUNT(id) AS count_a FROM geopos_accounts $whr
            and company_id= $company_id");

        $result = $query->row_array();
        echo json_encode(array(0 => array('balance' => amountExchange($result['balance'], 0, $this->aauth->get_user()->loc), 'count_a' => $result['count_a'])));

    }

}