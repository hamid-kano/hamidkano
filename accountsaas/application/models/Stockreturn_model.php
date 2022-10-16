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

class Stockreturn_model extends CI_Model
{
    var $table = 'geopos_stock_r';
    var $column_order = array(null, 'geopos_stock_r.tid', 'name', 'geopos_stock_r.invoicedate', 'geopos_stock_r.total', 'geopos_stock_r.status', null);
    var $column_search = array('geopos_stock_r.tid', 'name', 'geopos_stock_r.invoicedate', 'geopos_stock_r.total','geopos_stock_r.status');
    var $order = array('geopos_stock_r.tid' => 'desc');

    public function __construct()
    {
        parent::__construct();
    }

    public function lastpurchase()
    {
        $this->db->select('tid');
        $this->db->from($this->table);
        $this->db->where('company_id', getCompanyId());
        $this->db->order_by('tid', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->tid;
        } else {
            return 1000;
        }
    }

    public function warehouses()
    {
        $this->db->select('*');
        $this->db->from('geopos_warehouse');
    if ($this->aauth->get_user()->loc) {
            $this->db->where('loc', $this->aauth->get_user()->loc);
          if(BDATA)  $this->db->or_where('loc', 0);
        }  elseif(!BDATA) { $this->db->where('loc', 0); }
        $this->db->where('company_id', getCompanyId());
        $query = $this->db->get();
        return $query->result_array();

    }

    public function currencies()
    {

        $this->db->select('*');
        $this->db->from('geopos_currencies');
        $this->db->where('company_id', getCompanyId());
        $query = $this->db->get();
        return $query->result_array();
    }

    public function purchase_details($id,$hash_code)
    {

        $this->db->select('geopos_stock_r.i_class');
        $this->db->from($this->table);
        $this->db->where('geopos_stock_r.id', $id);
        $this->db->where('company_id', getCompanyId());
        $this->db->where('hash_code', $hash_code);
        $query = $this->db->get();
        $out = $query->row_array();

        if (isset($out['i_class']) and $out['i_class']) {
            $this->db->select('geopos_stock_r.*,geopos_stock_r.hash_code hash_code_main ,geopos_stock_r.id AS iid,SUM(geopos_stock_r.shipping + geopos_stock_r.ship_tax) AS shipping,geopos_customers.*,geopos_stock_r.loc as loc,geopos_customers.id AS cid,geopos_terms.id AS termid,geopos_terms.title AS termtit,geopos_terms.terms AS terms');
            $this->db->from($this->table);
            $this->db->where('geopos_stock_r.id', $id);
            $this->db->join('geopos_customers', 'geopos_stock_r.csd = geopos_customers.id', 'left');
            $this->db->join('geopos_terms', 'geopos_terms.id = geopos_stock_r.term', 'left');
             $this->db->where('geopos_stock_r.company_id', getCompanyId());
             $this->db->where('geopos_stock_r.hash_code', $hash_code);
               if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_stock_r.loc', $this->aauth->get_user()->loc);
        } elseif (!BDATA) {
            $this->db->where('geopos_stock_r.loc', 0);
        }
            $query = $this->db->get();
            return $query->row_array();
        } else {

            $this->db->select('geopos_stock_r.*,geopos_stock_r.hash_code hash_code_main ,geopos_stock_r.id AS iid,SUM(geopos_stock_r.shipping + geopos_stock_r.ship_tax) AS shipping,geopos_supplier.*,geopos_stock_r.loc as loc,geopos_supplier.id AS cid,geopos_terms.id AS termid,geopos_terms.title AS termtit,geopos_terms.terms AS terms');
            $this->db->from($this->table);
            $this->db->where('geopos_stock_r.id', $id);
            $this->db->join('geopos_supplier', 'geopos_stock_r.csd = geopos_supplier.id', 'left');
            $this->db->join('geopos_terms', 'geopos_terms.id = geopos_stock_r.term', 'left');
            $this->db->where('geopos_stock_r.company_id', getCompanyId());
            $this->db->where('geopos_stock_r.hash_code', $hash_code);
              if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_stock_r.loc', $this->aauth->get_user()->loc);
        } elseif (!BDATA) {
            $this->db->where('geopos_stock_r.loc', 0);
        }
            $query = $this->db->get();
            return $query->row_array();
        }

    }

    public function purchase_products($id)
    {

        $this->db->select('*');
        $this->db->from('geopos_stock_r_items');
        $this->db->where('tid', $id);
        $this->db->where('company_id', getCompanyId());
        $query = $this->db->get();
        return $query->result_array();

    }

    public function purchase_transactions($id)
    {

        $this->db->select('*');
        $this->db->from('geopos_transactions');
        $this->db->where('tid', $id);
        $this->db->where('company_id', getCompanyId());
        $this->db->where('ext', 6);
        $query = $this->db->get();
        return $query->result_array();

    }

    public function purchase_delete($id)
    {

        $this->db->trans_start();

        $this->db->select('pid,qty');
        $this->db->from('geopos_stock_r_items');
        $this->db->where('tid', $id);
        $this->db->where('company_id', getCompanyId());
        $query = $this->db->get();
        $prevresult = $query->result_array();

        $this->db->select('i_class');
        $this->db->from('geopos_stock_r');
        $this->db->where('id', $id);
        $this->db->where('company_id', getCompanyId());
        $query = $this->db->get();
        $stock = $query->row_array();
        if (($stock['i_class'] != 2 && $this->aauth->premission(2)) OR ($stock['i_class'] == 2 && $this->aauth->premission(1))) {
            foreach ($prevresult as $prd) {
                $amt = $prd['qty'];
                $this->db->set('qty', "qty+$amt", FALSE);
                $this->db->where('pid', $prd['pid']);
                $this->db->where('company_id', getCompanyId());
                $this->db->update('geopos_products');
            }
            $whr = array('id' => $id);
            if ($this->aauth->get_user()->loc) {
                $whr = array('id' => $id, 'loc' => $this->aauth->get_user()->loc,'company_id' =>getCompanyId());
            }
            $this->db->delete('geopos_stock_r', $whr);
            if ($this->db->affected_rows()) $this->db->delete('geopos_stock_r_items', array('tid' => $id,'company_id' =>getCompanyId()));
            if ($this->db->trans_complete()) {
                return true;
            } else {
                return false;
            }
        }
    }


    private function _get_datatables_query($type = 0)
    {
        if ($type) {

            $this->db->select('geopos_stock_r.id,geopos_stock_r.hash_code,geopos_stock_r.tid,geopos_stock_r.invoicedate,geopos_stock_r.invoiceduedate,geopos_stock_r.total,geopos_stock_r.status,geopos_customers.name');
            $this->db->from($this->table);
            $this->db->where('geopos_stock_r.i_class', $type);
            $this->db->join('geopos_customers', 'geopos_stock_r.csd=geopos_customers.id', 'left');
            $this->db->where('geopos_stock_r.company_id', getCompanyId());
                  if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_stock_r.loc', $this->aauth->get_user()->loc);
        }
        elseif(!BDATA) { $this->db->where('geopos_stock_r.loc', 0); }
        } else {
            $this->db->select('geopos_stock_r.id,geopos_stock_r.hash_code,geopos_stock_r.tid,geopos_stock_r.invoicedate,geopos_stock_r.invoiceduedate,geopos_stock_r.total,geopos_stock_r.status,geopos_supplier.name');
            $this->db->from($this->table);
            $this->db->where('geopos_stock_r.i_class', $type);
            $this->db->where('geopos_stock_r.company_id', getCompanyId());
            $this->db->join('geopos_supplier', 'geopos_stock_r.csd=geopos_supplier.id', 'left');
                 if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_stock_r.loc', $this->aauth->get_user()->loc);
        }
        elseif(!BDATA) { $this->db->where('geopos_stock_r.loc', 0); }
        }
                    if ($this->input->post('start_date') && $this->input->post('end_date')) // if datatable send POST for search
        {
            $this->db->where('DATE(geopos_stock_r.invoicedate) >=', datefordatabase($this->input->post('start_date')));
            $this->db->where('DATE(geopos_stock_r.invoicedate) <=', datefordatabase($this->input->post('end_date')));
            $this->db->where('geopos_stock_r.company_id', getCompanyId());
        }
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

    function get_datatables($type = 0)
    {
        $this->_get_datatables_query($type);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $this->db->where('geopos_stock_r.company_id', getCompanyId());
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
         $this->db->where('geopos_stock_r.company_id', getCompanyId());
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
               if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_stock_r.loc', $this->aauth->get_user()->loc);
        }
        elseif(!BDATA) { $this->db->where('geopos_stock_r.loc', 0); }
        $this->db->where('geopos_stock_r.company_id', getCompanyId());
        return $this->db->count_all_results();
    }


    public function billingterms()
    {
        $this->db->select('id,title');
        $this->db->from('geopos_terms');
        $this->db->where('company_id', getCompanyId());
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

        $data = array('type' => $type, 'rid' => $id, 'col1' => $meta_data,'company_id' =>getCompanyId(),'hash_code' =>getHashCode());
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
        $this->db->where('geopos_metadata.type', 4);
        $this->db->where('geopos_metadata.rid', $id);
        $this->db->where('geopos_metadata.company_id', getCompanyId());
        $query = $this->db->get();
        return $query->result_array();
    }

    public function meta_delete($id, $type, $name)
    {
        if (@unlink(FCPATH . 'userfiles/attach/' . $name)) {
            return $this->db->delete('geopos_metadata', array('rid' => $id, 'type' => $type, 'col1' => $name,'company_id' =>getCompanyId()));
        }
    }


        public function check_product_is_company($id)
    {
        $this->db->select('count(pid) as counts');
        $this->db->from('geopos_products');
        $this->db->where('geopos_products.pid', $id);
        $this->db->where('geopos_products.company_id', getCompanyId());
        $query = $this->db->get();
        return $query->row_array();
    }

}