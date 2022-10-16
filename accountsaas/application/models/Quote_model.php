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

class Quote_model extends CI_Model
{
    var $table = 'geopos_quotes';
    var $column_order = array(null, 'geopos_quotes.tid', 'geopos_customers.name', 'geopos_quotes.invoicedate', 'geopos_quotes.total', 'geopos_quotes.status', null);
    var $column_search = array('geopos_quotes.tid', 'geopos_customers.name', 'geopos_quotes.invoicedate', 'geopos_quotes.total','geopos_quotes.status',);
    var $order = array('geopos_quotes.tid' => 'desc');

    public function __construct()
    {
        parent::__construct();
    }

    public function lastquote()
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
        $this->db->where('company_id', getCompanyId());
       if ($this->aauth->get_user()->loc) {
            $this->db->where('loc', $this->aauth->get_user()->loc);
          if(BDATA)  $this->db->or_where('loc', 0);
        }  elseif(!BDATA) { $this->db->where('loc', 0); }


        $query = $this->db->get();
        return $query->result_array();

    }

    public function quote_details($id,$hash_code)
    {

        $this->db->select('geopos_quotes.*,geopos_quotes.id AS iid,SUM(geopos_quotes.shipping + geopos_quotes.ship_tax) AS shipping,geopos_customers.*,geopos_quotes.loc as loc,geopos_customers.id AS cid,geopos_terms.id AS termid,geopos_terms.title AS termtit,IF(ISNULL(geopos_terms.id), geopos_quotes.text_terms, geopos_terms.terms) as terms');
        $this->db->from($this->table);
        $this->db->where($this->table.'.company_id', getCompanyId());
        //$this->db->where($this->table.'.hash_code', $hash_code);
        $this->db->where('geopos_quotes.id', $id);
         if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_quotes.loc', $this->aauth->get_user()->loc);
        } elseif (!BDATA) {
            $this->db->where('geopos_quotes.loc', 0);
        }
        $this->db->join('geopos_customers', 'geopos_quotes.csd = geopos_customers.id', 'left');
        $this->db->join('geopos_terms', 'geopos_terms.id = geopos_quotes.term', 'left');
        $query = $this->db->get();
        return $query->row_array();

    }

    public function quote_products($id)
    {

        $this->db->select('*');
        $this->db->from('geopos_quotes_items');
        $this->db->where('tid', $id);
        $this->db->where('company_id', getCompanyId());
        $query = $this->db->get();
        return $query->result_array();

    }


    public function quote_delete($id)
    {
        $this->db->trans_start();
          if ($this->aauth->get_user()->loc) {
                $res = $this->db->delete('geopos_quotes', array('id' => $id, 'loc' => $this->aauth->get_user()->loc,'company_id'=>getCompanyId()));
        }
        else {
            if (BDATA) {
                    $res = $this->db->delete('geopos_quotes', array('id' => $id,'company_id'=>getCompanyId()));

            } else {
                    $res = $this->db->delete('geopos_quotes', array('id' => $id,'loc' => 0,'company_id'=>getCompanyId()));
            }
        }
        if ($this->db->affected_rows()) $this->db->delete('geopos_quotes_items', array('tid' => $id,'company_id'=>getCompanyId()));
        if ($this->db->trans_complete()) {
            return true;
        } else {
            return false;
        }
    }


    private function _get_datatables_query($eid)
    {

        $this->db->select('geopos_quotes.id,geopos_quotes.tid,geopos_quotes.invoicedate,geopos_quotes.invoiceduedate,geopos_quotes.total,geopos_quotes.status,geopos_customers.name,geopos_quotes.hash_code hash_code_main');
        $this->db->from($this->table);
        $this->db->where($this->table.'.company_id', getCompanyId());
        if ($eid) $this->db->where('geopos_quotes.eid', $eid);
                if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_quotes.loc', $this->aauth->get_user()->loc);
        }
        elseif(!BDATA) { $this->db->where('geopos_quotes.loc', 0); }
                        if ($this->input->post('start_date') && $this->input->post('end_date')) // if datatable send POST for search
        {
            $this->db->where('DATE(geopos_quotes.invoicedate) >=', datefordatabase($this->input->post('start_date')));
            $this->db->where('DATE(geopos_quotes.invoicedate) <=', datefordatabase($this->input->post('end_date')));
        }

        $this->db->join('geopos_customers', 'geopos_quotes.csd=geopos_customers.id', 'left');

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

    function get_datatables($eid)
    {
        $this->_get_datatables_query($eid);
        $this->db->where('geopos_quotes.company_id', getCompanyId());
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_quotes.loc', $this->aauth->get_user()->loc);
        }  elseif(!BDATA) { $this->db->where('geopos_quotes.loc', 0); }
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($eid)
    {
        $this->_get_datatables_query($eid);
        $this->db->where('geopos_quotes.company_id', getCompanyId());
    if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_quotes.loc', $this->aauth->get_user()->loc);
        }  elseif(!BDATA) { $this->db->where('geopos_quotes.loc', 0); }
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($eid)
    {
        $this->db->select('geopos_quotes.id');
        $this->db->from($this->table);
        $this->db->where('geopos_quotes.company_id', getCompanyId());
         if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_quotes.loc', $this->aauth->get_user()->loc);
        }  elseif(!BDATA) { $this->db->where('geopos_quotes.loc', 0); }
        if ($eid) $this->db->where('geopos_quotes.eid', $eid);
        return $this->db->count_all_results();
    }


    public function billingterms()
    {
        $this->db->select('id,title');
        $this->db->from('geopos_terms');
        $this->db->where('geopos_terms.company_id', getCompanyId());
        $this->db->where('type', 2);
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

    public function convert($id,$hash_code)
    {

        $invoice = $this->quote_details($id,$hash_code);
        $products = $this->quote_products($id);
        $this->db->trans_start();
        $this->db->select('tid');
        $this->db->from('geopos_invoices');
        $this->db->where('i_class', 0);
        $this->db->where('geopos_invoices.company_id', getCompanyId());
        $this->db->order_by('tid', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $iid = $query->row()->tid + 1;
        } else {
            $iid = 1000;
        }
        $productlist = array();
        $prodindex = 0;
        if($invoice['loc']==$this->aauth->get_user()->loc) {
            $data = array('tid' => $iid, 'invoicedate' => $invoice['invoicedate'], 'invoiceduedate' => $invoice['invoicedate'], 'subtotal' => $invoice['invoicedate'], 'shipping' => $invoice['shipping'], 'discount' => $invoice['discount'], 'tax' => $invoice['tax'], 'total' => $invoice['total'], 'notes' => $invoice['notes'], 'csd' => $invoice['csd'], 'eid' => $invoice['eid'], 'items' => $invoice['items'], 'taxstatus' => $invoice['taxstatus'], 'discstatus' => $invoice['discstatus'], 'format_discount' => $invoice['format_discount'], 'refer' => $invoice['refer'], 'term' => $invoice['term'],'multi' => $invoice['multi'], 'loc' => $invoice['loc'],'company_id'=>getCompanyId(),'hash_code'=>getHashCode() );
            $this->db->insert('geopos_invoices', $data);
            $iid = $this->db->insert_id();
            foreach ($products as $row) {
                $amt = $row['qty'];
                $data = array(
                    'tid' => $iid,
                    'pid' => $row['pid'],
                    'product' => $row['product'],
                    'code' => $row['code'],
                    'qty' => $amt,
                    'price' => $row['price'],
                    'tax' => $row['tax'],
                    'discount' => $row['discount'],
                    'subtotal' => $row['subtotal'],
                    'totaltax' => $row['totaltax'],
                    'totaldiscount' => $row['totaldiscount'],
                    'product_des' => $row['product_des'],
                    'unit' => $row['unit'],
                    'company_id'=>getCompanyId(),
                    'hash_code'=>getHashCode() 
                );
                $productlist[$prodindex] = $data;
                $prodindex++;
                $this->db->set('qty', "qty-$amt", FALSE);
                $this->db->where('pid', $row['pid']);
                $this->db->where('company_id', getCompanyId());
                $this->db->update('geopos_products');
            }


            $this->db->insert_batch('geopos_invoice_items', $productlist);


            //profit calculation
            $t_profit = 0;
            $this->db->select('geopos_invoice_items.pid, geopos_invoice_items.price, geopos_invoice_items.qty, geopos_products.fproduct_price');
            $this->db->from('geopos_invoice_items');
            $this->db->join('geopos_products', 'geopos_products.pid = geopos_invoice_items.pid', 'left');
            $this->db->where('geopos_invoice_items.tid', $iid);
            $this->db->where('geopos_invoice_items.company_id', getCompanyId());
            $query = $this->db->get();
            $pids = $query->result_array();
            foreach ($pids as $profit) {
                $t_cost = $profit['fproduct_price'] * $profit['qty'];
                $s_cost = $profit['price'] * $profit['qty'];
                $t_profit += $s_cost - $t_cost;
            }

            $data = array('type' => 9, 'rid' => $iid, 'col1' => rev_amountExchange_s($t_profit, $invoice['multi']),'company_id'=>getCompanyId(),'hash_code'=>getHashCode() , 'd_date' => $invoice['invoicedate']);
          //  var_dump($data);exit;
            $this->db->insert('geopos_metadata', $data);

            if ($this->db->trans_complete()) {
                $this->db->set('status', 'accepted');
                $this->db->where('id', $id);
                $this->db->where('company_id', getCompanyId());
                $this->db->update('geopos_quotes');
                return true;
            } else {
                return false;
            }
        }else{

                return false;

        }

    }

     public function convert_po($id,$person,$hash_code)
    {

        $invoice = $this->quote_details($id,$hash_code);
        $products = $this->quote_products($id);
        $this->db->trans_start();
        $this->db->select('tid');
        $this->db->from('geopos_purchase');
        $this->db->where('geopos_purchase.company_id', getCompanyId());
        $this->db->order_by('tid', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $iid = $query->row()->tid + 1;
        } else {
            $iid = 1000;
        }
        $productlist = array();
        $prodindex = 0;
        if($invoice['loc']==$this->aauth->get_user()->loc) {
            $data = array('tid' => $iid, 'invoicedate' => $invoice['invoicedate'], 'invoiceduedate' => $invoice['invoicedate'], 'subtotal' => $invoice['invoicedate'], 'shipping' => $invoice['shipping'], 'discount' => $invoice['discount'], 'tax' => $invoice['tax'], 'total' => $invoice['total'], 'notes' => $invoice['notes'], 'csd' => $person, 'eid' => $invoice['eid'], 'items' => $invoice['items'], 'taxstatus' => $invoice['taxstatus'], 'discstatus' => $invoice['discstatus'], 'format_discount' => $invoice['format_discount'], 'refer' => $invoice['refer'], 'term' => $invoice['term'],'multi' => $invoice['multi'], 'loc' => $invoice['loc'],'company_id'=>getCompanyId(),'hash_code'=>getHashCode() );
            $this->db->insert('geopos_purchase', $data);
            $iid = $this->db->insert_id();
            foreach ($products as $row) {
                $amt = $row['qty'];
                $data = array(
                    'tid' => $iid,
                    'pid' => $row['pid'],
                    'product' => $row['product'],
                    'code' => $row['code'],
                    'qty' => $amt,
                    'price' => $row['price'],
                    'tax' => $row['tax'],
                    'discount' => $row['discount'],
                    'subtotal' => $row['subtotal'],
                    'totaltax' => $row['totaltax'],
                    'totaldiscount' => $row['totaldiscount'],
                    'product_des' => $row['product_des'],
                    'unit' => $row['unit'],
                    'company_id'=>getCompanyId(),
                    'hash_code'=>getHashCode() 
                );
                $productlist[$prodindex] = $data;
                $prodindex++;
                $this->db->set('qty', "qty+$amt", FALSE);
                $this->db->where('pid', $row['pid']);
                $this->db->where('company_id', getCompanyId());
                $this->db->update('geopos_products');
            }


            $this->db->insert_batch('geopos_purchase_items', $productlist);




            if ($this->db->trans_complete()) {
                $this->db->set('status', 'accepted');
                $this->db->where('id', $id);
                $this->db->where('company_id', getCompanyId());
                $this->db->update('geopos_quotes');
                return true;
            } else {
                return false;
            }
        }else{

                return false;

        }

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
        $this->db->where('geopos_metadata.type', 2);
        $this->db->where('geopos_metadata.rid', $id);
        $this->db->where('company_id', getCompanyId());
        $query = $this->db->get();
        return $query->result_array();
    }

    public function meta_delete($id, $type, $name)
    {
        if (@unlink(FCPATH . 'userfiles/attach/' . $name)) {
            return $this->db->delete('geopos_metadata', array('rid' => $id, 'type' => $type, 'col1' => $name,'company_id'=>getCompanyId()));
        }
    }


}