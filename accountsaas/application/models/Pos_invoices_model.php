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

class Pos_invoices_model extends CI_Model
{
    var $table = 'geopos_invoices';
    var $column_order = array(null, 'geopos_invoices.tid', 'geopos_customers.name', 'geopos_invoices.invoicedate', 'geopos_invoices.total', 'geopos_invoices.status', null);
    var $column_search = array('geopos_invoices.tid', 'geopos_customers.name', 'geopos_invoices.invoicedate', 'geopos_invoices.total','geopos_invoices.status');
    var $order = array('geopos_invoices.tid' => 'desc');

    public function __construct()
    {
        parent::__construct();
    }

    public function lastinvoice()
    {
        $this->db->select('tid');
        $this->db->from($this->table);
        $this->db->where('company_id', getCompanyId());
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $this->db->where('i_class', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
          
            return $query->row()->tid;
        } else {
            return 1000;
        }
    }


    public function invoice_details($id, $eid = '',$hash_code)
    {

        $this->db->select('geopos_invoices.*, SUM(geopos_invoices.shipping + geopos_invoices.ship_tax) AS shipping,geopos_customers.*,geopos_invoices.loc as loc,geopos_invoices.id AS iid,geopos_customers.id AS cid,geopos_terms.id AS termid,geopos_terms.title AS termtit,geopos_terms.terms AS terms');
        $this->db->from($this->table);
        $this->db->where('geopos_invoices.id', $id);
        $this->db->where('geopos_invoices.company_id', getCompanyId());
        $this->db->where('geopos_invoices.hash_code', $hash_code);
        if ($eid) {
            $this->db->where('geopos_invoices.eid', $eid);
        }
        if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_invoices.loc', $this->aauth->get_user()->loc);
        }  elseif(!BDATA) { $this->db->where('geopos_invoices.loc', 0); }
        $this->db->join('geopos_customers', 'geopos_invoices.csd = geopos_customers.id', 'left');
        $this->db->join('geopos_terms', 'geopos_terms.id = geopos_invoices.term', 'left');
        $query = $this->db->get();
        return $query->row_array();

    }

    public function invoice_products($id)
    {

        $this->db->select('*');
        $this->db->from('geopos_invoice_items');
        $this->db->where('tid', $id);
        $this->db->where('company_id', getCompanyId());
        $query = $this->db->get();
        return $query->result_array();

    }
 public function active_register_cashInvoice($id)
    {
        $pmethod = array('Cash', 'Cash Card');

        $this->db->select('*');
        $this->db->from('geopos_invoices');
        $this->db->where('register_id', $id);
        $this->db->where('company_id', getCompanyId());
        $this->db->where_in('pmethod', $pmethod);
        $query = $this->db->get();
         $str = $this->db->last_query();
   $cash=$query->result_array();
$this->db->select('SUM(geopos_invoices.total) as cashTotal');
        $this->db->from('geopos_invoices');
        $this->db->where('register_id', $id);
        $this->db->where('company_id', getCompanyId());
        $this->db->where('pmethod', 'Cash');
        $query = $this->db->get();
         $str = $this->db->last_query();
   $cash['cashTotal']=$query->result_array();
   $this->db->select('SUM(geopos_invoices.amount_cash) as cashTotal');
        $this->db->from('geopos_invoices');
        $this->db->where('register_id', $id);
        $this->db->where('company_id', getCompanyId());
        $this->db->where('pmethod', 'Cash Card');
        $query = $this->db->get();
         $str = $this->db->last_query();
   $cash['cashTotal2']=$query->result_array();

        return $cash ;
       
    }
    public function active_register_cardInvoice($id)
    {
        // ,SUM(geopos_invoices.total) as cardTotal
       $pmethod = array('Card Swipe', 'Cash Card');

        $this->db->select('*');
        $this->db->from('geopos_invoices');
        $this->db->where('register_id', $id);
        $this->db->where('company_id', getCompanyId());
        $this->db->where_in('pmethod', $pmethod);
        $query = $this->db->get();
        $cards=$query->result_array();

        $this->db->select('SUM(geopos_invoices.total) as cardTotal');
        $this->db->from('geopos_invoices');
        $this->db->where('register_id', $id);
        $this->db->where('company_id', getCompanyId());
        $this->db->where('pmethod', 'Card Swipe');
        $query = $this->db->get();
        $cards['cardTotal']=$query->result_array();
         $this->db->select('SUM(geopos_invoices.amount_card) as cardTotal');
        $this->db->from('geopos_invoices');
        $this->db->where('register_id', $id);
        $this->db->where('company_id', getCompanyId());
        $this->db->where('pmethod', 'Cash Card');
        $query = $this->db->get();
        $cards['cardTotal2']=$query->result_array();
 
        return $cards;
    }
        public function active_register_onAccountInvoice($id)
    {
        $this->db->select('*');
        $this->db->from('geopos_invoices');
        $this->db->where('register_id', $id);
        $this->db->where('company_id', getCompanyId());
        $this->db->where('pmethod', 'bank');
        $query = $this->db->get();
        $onAccount= $query->result_array();
         $this->db->select('SUM(geopos_invoices.total) as onAccountTotal');
        $this->db->from('geopos_invoices');
        $this->db->where('register_id', $id);
        $this->db->where('company_id', getCompanyId());
        $this->db->where('pmethod', 'Bank');
        $query = $this->db->get();
        $onAccount['onAccountTotal']=$query->result_array();
        return $onAccount;
        
    }
    
    public function invoices_by_date($open_date = null , $open_t_date = null)
    {

       $this->db->select('*');
       $this->db->from('geopos_invoices');
       $this->db->where('company_id', getCompanyId());
      if($open_date)  $this->db->where('DATE(geopos_invoices.invoicedate) >=',$open_date);
      if($open_t_date)  $this->db->where('DATE(geopos_invoices.invoicedate) <=',$open_t_date);
        $query = $this->db->get();
        $invoices = $query->result_array();

        return $invoices;
       
    }
    public function active_cardInvoice($open_date = null , $open_t_date = null ,$open_time = '0:00',$open_t_time = '0:00')
    {
        // ,SUM(geopos_invoices.total) as cardTotal
       $pmethod = array('Card Swipe', 'Cash Card');

        $this->db->select('*');
        $this->db->from('geopos_invoices');
        $this->db->where('register_id', $id);
        $this->db->where('company_id', getCompanyId());
        $this->db->where_in('pmethod', $pmethod);
        $query = $this->db->get();
        $cards=$query->result_array();

        $this->db->select('SUM(geopos_invoices.total) as cardTotal');
        $this->db->from('geopos_invoices');
        $this->db->where('register_id', $id);
        $this->db->where('company_id', getCompanyId());
        $this->db->where('pmethod', 'Card Swipe');
        $query = $this->db->get();
        $cards['cardTotal']=$query->result_array();
         $this->db->select('SUM(geopos_invoices.amount_card) as cardTotal');
        $this->db->from('geopos_invoices');
        $this->db->where('register_id', $id);
        $this->db->where('company_id', getCompanyId());
        $this->db->where('pmethod', 'Cash Card');
        $query = $this->db->get();
        $cards['cardTotal2']=$query->result_array();
 
        return $cards;
    }
        public function active_onAccountInvoice($open_date = null , $open_t_date = null ,$open_time = '0:00',$open_t_time = '0:00')
    {
        $this->db->select('*');
        $this->db->from('geopos_invoices');
        $this->db->where('register_id', $id);
        $this->db->where('company_id', getCompanyId());
        $this->db->where('pmethod', 'bank');
        $query = $this->db->get();
        $onAccount= $query->result_array();
         $this->db->select('SUM(geopos_invoices.total) as onAccountTotal');
        $this->db->from('geopos_invoices');
        $this->db->where('register_id', $id);
        $this->db->where('company_id', getCompanyId());
        $this->db->where('pmethod', 'Bank');
        $query = $this->db->get();
        $onAccount['onAccountTotal']=$query->result_array();
        return $onAccount;
        
    }
    public function currencies()
    {

        $this->db->select('*');
        $this->db->from('geopos_currencies');
        $this->db->where('company_id', getCompanyId());
        $query = $this->db->get();
        return $query->result_array();

    }

    public function currency_d($id)
    {
        $this->db->select('*');
        $this->db->from('geopos_currencies');
        $this->db->where('company_id', getCompanyId());
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function warehouses()
    {
        $this->db->select('*');
        $this->db->from('geopos_warehouse');
        $this->db->where('company_id', getCompanyId());
       if ($this->aauth->get_user()->loc) {
            $this->db->where('loc', $this->aauth->get_user()->loc);
          if(BDATA)  $this->db->or_where('loc', 0);
        }  elseif(!BDATA) { $this->db->where('loc', 0); }

        $query = $this->db->get();

        return $query->result_array();

    }

    public function invoice_transactions($id)
    {

        $this->db->select('*');
        $this->db->from('geopos_transactions');
        $this->db->where('company_id', getCompanyId());
        $this->db->where('tid', $id);
        $this->db->where('ext', 0);
        $query = $this->db->get();
        return $query->result_array();

    }

    public function invoice_delete($id, $eid = '')
    {

        $this->db->trans_start();

        $this->db->select('status');
        $this->db->from('geopos_invoices');
        $this->db->where('company_id', getCompanyId());
        $this->db->where('id', $id);
        $query = $this->db->get();
        $result = $query->row_array();

          if ($this->aauth->get_user()->loc) {
            if ($eid) {

                $res = $this->db->delete('geopos_invoices', array('id' => $id, 'eid' => $eid, 'loc' => $this->aauth->get_user()->loc,'company_id'=>getCompanyId()));


            } else {
                $res = $this->db->delete('geopos_invoices', array('id' => $id, 'loc' => $this->aauth->get_user()->loc,'company_id'=>getCompanyId()));
            }
        }

        else {
            if (BDATA) {
                if ($eid) {

                    $res = $this->db->delete('geopos_invoices', array('id' => $id, 'eid' => $eid,'company_id'=>getCompanyId()));


                } else {
                    $res = $this->db->delete('geopos_invoices', array('id' => $id,'company_id'=>getCompanyId()));
                }
            } else {


                if ($eid) {

                    $res = $this->db->delete('geopos_invoices', array('id' => $id, 'eid' => $eid, 'loc' => 0,'company_id'=>getCompanyId()));


                } else {
                    $res = $this->db->delete('geopos_invoices', array('id' => $id, 'loc' => 0,'company_id'=>getCompanyId()));
                }
            }
        }
        $affect = $this->db->affected_rows();
        if ($res) {
            if ($result['status'] != 'canceled') {
                $this->db->select('pid,qty');
                $this->db->from('geopos_invoice_items');
                $this->db->where('tid', $id);
                $this->db->where('company_id', getCompanyId());
                $query = $this->db->get();
                $prevresult = $query->result_array();
                foreach ($prevresult as $prd) {
                    $amt = $prd['qty'];
                    $this->db->set('qty', "qty+$amt", FALSE);
                    $this->db->where('pid', $prd['pid']);
                    $this->db->where('company_id', getCompanyId());
                    $this->db->update('geopos_products');
                }
            }
            if ($affect) $this->db->delete('geopos_invoice_items', array('tid' => $id,'company_id'=>getCompanyId()));
            $data = array('type' => 9, 'rid' => $id,'company_id'=>getCompanyId());
            $this->db->delete('geopos_metadata', $data);
            if ($this->db->trans_complete()) {
                return true;
            } else {
                return false;
            }
        }
    }


    private function _get_datatables_query($opt = '')
    {
        $this->db->select('geopos_invoices.id,geopos_invoices.hash_code hash_code_main,geopos_invoices.tid,geopos_invoices.invoicedate,geopos_invoices.invoiceduedate,geopos_invoices.invoicetime,geopos_invoices.total,geopos_invoices.status,geopos_customers.name');
        $this->db->from($this->table);
        $this->db->where('geopos_invoices.i_class', 1);
        $this->db->where('geopos_invoices.company_id', getCompanyId());
        if ($opt) {
            $this->db->where('geopos_invoices.eid', $opt);
        }
        if ($this->input->post('start_date') && $this->input->post('end_date')) // if datatable send POST for search
        {
            $this->db->where('DATE(geopos_invoices.invoicedate) >=', datefordatabase($this->input->post('start_date')));
            $this->db->where('DATE(geopos_invoices.invoicedate) <=', datefordatabase($this->input->post('end_date')));
        }
        if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_invoices.loc', $this->aauth->get_user()->loc);
        }
          elseif(!BDATA) { $this->db->where('geopos_invoices.loc', 0); }
        $this->db->join('geopos_customers', 'geopos_invoices.csd=geopos_customers.id', 'left');

        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            if ($this->input->post('search')['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $this->input->post('search')['value']);
                } else {
                    $this->db->or_like($item, $this->input->post('search')['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($opt = '')
    {
        $this->_get_datatables_query($opt);
        $this->db->where('geopos_invoices.company_id', getCompanyId());
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();
        $this->db->where('geopos_invoices.i_class', 1);
        if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_invoices.loc', $this->aauth->get_user()->loc);
        }
          elseif(!BDATA) { $this->db->where('geopos_invoices.loc', 0); }
        return $query->result();
    }

    function count_filtered($opt = '')
    {
        $this->_get_datatables_query($opt);
        $this->db->where('geopos_invoices.company_id', getCompanyId());
        if ($opt) {
            $this->db->where('eid', $opt);

        }
        if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_invoices.loc', $this->aauth->get_user()->loc);
        }  elseif(!BDATA) { $this->db->where('geopos_invoices.loc', 0); }
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($opt = '')
    {
        $this->db->select('geopos_invoices.id');
        $this->db->from($this->table);
        $this->db->where('geopos_invoices.company_id', getCompanyId());
        $this->db->where('geopos_invoices.i_class', 1);
        if ($opt) {
            $this->db->where('geopos_invoices.eid', $opt);
        }
        if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_invoices.loc', $this->aauth->get_user()->loc);
        }  elseif(!BDATA) { $this->db->where('geopos_invoices.loc', 0); }
        return $this->db->count_all_results();
    }


    public function billingterms()
    {
        $this->db->select('id,title');
        $this->db->from('geopos_terms');
        $this->db->where('company_id', getCompanyId());
        $this->db->where('type', 1);
        $this->db->or_where('type', 0);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function employee($id)
    {
        $this->db->select('geopos_employees.name,geopos_employees.sign,geopos_users.roleid');
        $this->db->from('geopos_employees');
        $this->db->where('geopos_employees.id', $id);
        $this->db->join('geopos_users', 'geopos_employees.id = geopos_users.id', 'left');
        $this->db->where('geopos_employees.company_id', getCompanyId());
        $query = $this->db->get();
        return $query->row_array();
    }

    public function meta_insert($id, $type, $meta_data)
    {

        $data = array('type' => $type, 'rid' => $id, 'col1' => $meta_data,'company_id'=>getCompanyId(),'hash_code'=>getHashCode() );
        if ($id) {
            return $this->db->insert('geopos_metadata', $data);
        } else {
            return 0;
        }
    }

    public function attach($id)
    {
        $this->db->select('geopos_metadata.*');
        $this->db->from('geopos_metadata');
        $this->db->where('geopos_metadata.type', 1);
        $this->db->where('geopos_metadata.rid', $id);
        $this->db->where('geopos_metadata.company_id', getCompanyId());
        $query = $this->db->get();
        return $query->result_array();
    }

    public function meta_delete($id, $type, $name)
    {
        if (@unlink(FCPATH . 'userfiles/attach/' . $name)) {
            return $this->db->delete('geopos_metadata', array('rid' => $id, 'type' => $type, 'col1' => $name,'company_id'=>getCompanyId()));
        }
    }

    public function gateway_list($enable = '')
    {

        $this->db->from('geopos_gateways');
        if ($enable == 'Yes') {
            $this->db->where('enable', 'Yes');
        }
        $this->db->where('company_id', getCompanyId());
        $query = $this->db->get();
        return $query->result_array();
    }

    public function drafts()
    {


        $this->db->select('geopos_draft.id,geopos_draft.tid,geopos_draft.invoicedate');
        $this->db->from('geopos_draft');
       $this->db->where('geopos_draft.loc', $this->aauth->get_user()->loc);
       $this->db->where('company_id', getCompanyId());
        $this->db->order_by('id', 'DESC');
        $this->db->limit(12);
        $query = $this->db->get();
        return $query->result_array();

    }

    public function draft_products($id)
    {

        $this->db->select('*');
        $this->db->from('geopos_draft_items');
        $this->db->where('tid', $id);
        $this->db->where('company_id', getCompanyId());
        $query = $this->db->get();
        return $query->result_array();

    }

    public function draft_details($id, $eid = '')
    {

        $this->db->select('geopos_draft.*,SUM(geopos_draft.shipping + geopos_draft.ship_tax) AS shipping,geopos_customers.*,geopos_customers.id AS cid,geopos_draft.id AS iid,geopos_terms.id AS termid,geopos_terms.title AS termtit,geopos_terms.terms AS terms');
        $this->db->from('geopos_draft');
        $this->db->where('geopos_draft.id', $id);
        $this->db->where('geopos_draft.company_id', getCompanyId());
        if ($eid) {
            $this->db->where('geopos_draft.eid', $eid);
        }
        $this->db->join('geopos_customers', 'geopos_draft.csd = geopos_customers.id', 'left');
        $this->db->join('geopos_terms', 'geopos_terms.id = geopos_draft.term', 'left');
        $query = $this->db->get();
        return $query->row_array();

    }

        public function accountslist()
    {
        $this->db->select('*');
        $this->db->from('geopos_accounts');
        $this->db->where('company_id', getCompanyId());
        if ($this->aauth->get_user()->loc) {
            $this->db->where('loc', $this->aauth->get_user()->loc);
           if(BDATA) $this->db->or_where('loc', 0);
        }else{
             if(!BDATA) $this->db->where('loc', 0);
        }

        $query = $this->db->get();
        return $query->result_array();
    }
}