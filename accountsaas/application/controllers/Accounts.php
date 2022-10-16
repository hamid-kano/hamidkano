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

class Accounts Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

        if (!$this->aauth->premission(5)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $this->load->model('accounts_model', 'accounts');
        $this->li_a = 'accounts';
    }

    public function index()
    {
        $company_id= getCompanyId();
        $data['accounts'] = $this->accounts->accountslist($company_id);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Accounts';
        $this->load->view('fixed/header', $head);
        $this->load->view('accounts/list', $data);
        $this->load->view('fixed/footer');
    }

    public function view()
    {
        $acid = $this->input->get('id');
        $hash_code = $this->input->get('ref');
        $data['account'] = $this->accounts->details_view($acid,$hash_code);
        if(!empty($data['account']) and isset($data['account'])){
            $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'View Account';
        $this->load->view('fixed/header', $head);
        $this->load->view('accounts/view', $data);
            $this->load->view('fixed/footer');
        }else{
             redirect(base_url(), 'refresh');
       }
        
    }

    public function add()
    {
        $company_id= getCompanyId();
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->model('locations_model');
        $this->load->model('accounts_model');
        $data['locations'] = $this->locations_model->locations_list2();
        $data['accounts'] = $this->accounts_model->accountslist($company_id);
        $head['title'] = 'Add Account';
        $this->load->view('fixed/header', $head);
        $this->load->view('accounts/add', $data);
        $this->load->view('fixed/footer');
    }

    public function addacc()
    {
        $this->load->model('accounts_model');
        if($this->input->post('parent_id')){
            $parent = $this->accounts_model->details($this->input->post('parent_id'));
            $analytical = $this->input->post('analytical');
            if($analytical) {
                $acn = $this->accounts_model->last_account_no($this->input->post('parent_id'));
                if($acn) {
                    if(substr($acn, -3) == "999") echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
                    $accno = $acn+1;
                }else {
                    $accno = $parent['acn'].sprintf('%03d',1);
                }
            } else {
                $acn = $this->accounts_model->last_account_no($this->input->post('parent_id'));
                if($acn) {
                    if(substr($acn, -2) == "99") echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
                    $accno = $acn+1;
                }else {
                    $accno = $parent['acn']."01";
                }
            }
        } else {
            $acn = $this->accounts_model->last_account_no();
            $accno = $acn+1;
        }
        $holder = $this->input->post('holder');
        $intbal = numberClean($this->input->post('intbal'));
        $acode = $this->input->post('acode');
        $lid = $this->input->post('lid');
        $type = $this->input->post('type');

        $this->load->model('accounts_model');

        $account_parent_id = ($this->input->post('parent_id')) ? $this->input->post('parent_id') : null;
        $analytical = $this->input->post('analytical');
        $account_type = "Basic";

        if ($this->aauth->get_user()->loc) {
            $lid = $this->aauth->get_user()->loc;
        }

        if ($accno) {
            $this->accounts->addnew($accno, $holder, $intbal, $acode, $lid, $account_type,$account_parent_id,$analytical,$type);

        }
    }

    public function delete_i()
    {
        $id = $this->input->post('deleteid');
        $hash_code = $this->input->post('ref');
        $haveSubAccounts = $this->db->select('*')->from('geopos_accounts')->where('parent_id',$id)->get()->num_rows();
        if ($id && !$haveSubAccounts) {
            $whr = array('id' => $id,'company_id'=>getCompanyId());
            if ($this->aauth->get_user()->loc) {
                $whr = array('id' => $id, 'loc' => $this->aauth->get_user()->loc,'company_id'=>getCompanyId());
            }
            $this->db->where('company_id', getCompanyId());
           // $this->db->where('hash_code', $hash_code);
            $this->db->delete('geopos_accounts', $whr);
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ACC_DELETED')));
        } else {
            if($haveSubAccounts) {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('Can not Be Deleted')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        }
    }

//view for edit
    public function edit()
    {
        $catid = $this->input->get('id');
        $hash_code = $this->input->get('ref');
        $this->db->select('*');
        $this->db->from('geopos_accounts');
        $this->db->where('id', $catid);
        $this->db->where('company_id', getCompanyId());
        $this->db->where('hash_code', $hash_code);
        if ($this->aauth->get_user()->loc) {
            $this->db->where('loc', $this->aauth->get_user()->loc);
        }
        $query = $this->db->get();
        $data['account'] = $query->row_array();
        $this->load->model('locations_model');
        $data['locations'] = $this->locations_model->locations_list();
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Edit Account';

        $this->load->view('fixed/header', $head);
        $this->load->view('accounts/edit', $data);
        $this->load->view('fixed/footer');

    }

    public function editacc()
    {
        $acid = $this->input->post('acid');
        $accno = $this->input->post('accno');
        $holder = $this->input->post('holder');
        $acode = $this->input->post('acode');
        $lid = $this->input->post('lid');
        $analytical = $this->input->post('analytical');
        $type = $this->input->post('type');
        $equity = numberClean($this->input->post('balance'));
        $hash_code = $this->input->post('hash_code');

        if ($this->aauth->get_user()->loc) {
            $lid = $this->aauth->get_user()->loc;
        }
        if ($acid) {
            $this->accounts->edit($acid, $accno, $holder, $acode, $lid, $equity, $analytical, $type,$hash_code);
        }
    }

    public function balancesheet()
    {


        $head['title'] = "Balance Summary";
        $head['usernm'] = $this->aauth->get_user()->username;
        if($this->input->get('sdate') && $this->input->get('edate')){
        $sdate = datefordatabase($this->input->get('sdate'));
        $edate = datefordatabase($this->input->get('edate'));
        }
        $data['accounts'] = $this->accounts->accountslist(getCompanyId());
        $this->load->model('transactions_model', 'transactions');
        
        $data['transactions'] = $this->transactions->details($sdate , $edate);
        if(isset($sdate)) {
        $data['old_transactions'] = $this->transactions->details($sdate);
        } else {
            $data['old_transactions'] = [];
        }

        $this->load->view('fixed/header', $head);
        $this->load->view('transactions/balance', $data);
        $this->load->view('fixed/footer');

    }
    
    public function summary()
    {


        $head['title'] = "Balance Summary";
        $head['usernm'] = $this->aauth->get_user()->username;
        if($this->input->get('sdate') && $this->input->get('edate')){
        $sdate = datefordatabase($this->input->get('sdate'));
        $edate = datefordatabase($this->input->get('edate'));
        }
        $data['accounts'] = $this->accounts->accountslist(getCompanyId());
        $this->load->model('transactions_model', 'transactions');
        
        $data['transactions'] = $this->transactions->details($sdate , $edate);
        if(isset($sdate)) {
        $data['old_transactions'] = $this->transactions->details($sdate);
        } else {
            $data['old_transactions'] = [];
        }

        $this->load->view('fixed/header', $head);
        $this->load->view('transactions/balance_sheet', $data);
        $this->load->view('fixed/footer');

    }

    public function account_stats()
    {
        $company_id= getCompanyId();
        $this->accounts->account_stats($company_id);
    }


}