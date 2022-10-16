<?php
/**
 * Geo POS -  Accounting,  Invoicing  and CRM Software
 * Copyright (c) Rajesh Dukiya. All Rights Reserved
 * ***********************************************************************
 *
 *  Email: support@ultimatekode.com
 *  Website: https://www.ultimatekode.com
 *
 *  ************************************************************************
 *  * This software is furnished under a license and may be used and copied
 *  * only  in  accordance  with  the  terms  of such  license and with the
 *  * inclusion of the above copyright notice.
 *  * If you Purchased from Codecanyon, Please read the full License from
 *  * here- http://codecanyon.net/licenses/standard/
 * ***********************************************************************
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Invoices_model extends CI_Model
{
    var $table = 'geopos_invoices';
    var $column_order = array(null, 'tid', 'name', 'invoicedate', 'total', 'status', null);
    var $column_search = array('tid', 'name', 'invoicedate', 'total');
    var $order = array('tid' => 'desc');

    public function __construct()
    {
        parent::__construct();
    }




        public function invoice_details($id)
    {
        $this->db->select('geopos_invoices.*,geopos_customers.*,geopos_invoices.loc as loc,geopos_invoices.id AS iid,geopos_customers.id AS cid,geopos_terms.id AS termid,geopos_terms.title AS termtit,geopos_terms.terms AS terms');
        $this->db->from($this->table);
        $this->db->where('geopos_invoices.id', $id);


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
        $query = $this->db->get();
        return $query->result_array();

    }

    public function invoice_transactions($id)
    {

        $this->db->select('*');
        $this->db->from('geopos_transactions');
        $this->db->where('id', $id);
        $this->db->where('ext', 0);
        $query = $this->db->get();
        return $query->result_array();

    }


    private function _get_datatables_query()
    {

         $this->db->select('geopos_invoices.id,geopos_invoices.tid,geopos_invoices.invoicedate,geopos_invoices.invoiceduedate,geopos_invoices.total,geopos_invoices.status,geopos_invoices.multi,geopos_customers.name');
        $this->db->from($this->table);
        $this->db->where('geopos_invoices.csd', $this->session->userdata('user_details')[0]->cid);
     //     $this->db->where('geopos_invoices.i_class');
        $this->db->join('geopos_customers', 'geopos_invoices.csd=geopos_customers.id', 'left');

        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
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

    function get_datatables()
    {

        $this->_get_datatables_query();
        $this->db->where('geopos_invoices.csd', $this->session->userdata('user_details')[0]->cid);
         // $this->db->where('geopos_invoices.i_class', 0);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $this->db->where('geopos_invoices.csd', $this->session->userdata('user_details')[0]->cid);
     //     $this->db->where('geopos_invoices.i_class', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        $this->db->where('geopos_invoices.csd', $this->session->userdata('user_details')[0]->cid);
    //      $this->db->where('geopos_invoices.i_class', 0);
        return $this->db->count_all_results();
    }


    public function billingterms()
    {
        $this->db->select('id,title');
        $this->db->from('geopos_terms');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function employee($id)
    {
        $this->db->select('geopos_employees.name,geopos_employees.sign,geopos_users.roleid');
        $this->db->from('geopos_employees');
        $this->db->where('geopos_employees.id', $id);
        $this->db->join('geopos_users', 'geopos_employees.id =geopos_users.id', 'left');
        $query = $this->db->get();
        return $query->row_array();
    }


}