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

class Restservice_model extends CI_Model
{

    public function customers($id = '')
    {

        $this->db->select('*');
        $this->db->from('geopos_customers');
        $this->db->where('company_id', getCompanyId());
        if ($id != '') {
            $this->db->where('id', $id);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function delete_customer($id)
    {
        return $this->db->delete('geopos_customers', array('id' => $id,'company_id'=>getCompanyId()));
    }

    public function products($id = '')
    {

        $this->db->select('*');
        $this->db->from('geopos_products');
        $this->db->where('company_id', getCompanyId());
        if ($id != '') {

            $this->db->where('id', $id);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function invoice($id)
    {
        $this->db->select('geopos_invoices.*, geopos_invoices.id AS InvoiceId , geopos_customers.*,geopos_customers.id AS cid,geopos_terms.id AS termid,geopos_terms.title AS termtit,geopos_terms.terms AS terms');
        $this->db->from('geopos_invoices');
        $this->db->where('geopos_invoices.id', $id);
        $this->db->where('geopos_invoices.company_id', getCompanyId());
        $this->db->join('geopos_customers', 'geopos_customers.id = geopos_invoices.csd', 'inner');
        $this->db->join('geopos_terms', 'geopos_terms.id = geopos_invoices.term', 'inner');
        $query = $this->db->get();
        $invoice = $query->row_array();
        $loc = location($invoice['loc']);
        $this->db->select('geopos_invoice_items.*');
        $this->db->from('geopos_invoice_items');
        $this->db->where('geopos_invoice_items.tid', $id);
        $this->db->where('geopos_invoice_items.company_id', getCompanyId());
        $query = $this->db->get();
        $items = $query->result_array();
        $invoice['id'] = $invoice['InvoiceId'];
        return array(array('invoice' => $invoice, 'company' => $loc, 'items' => $items, 'currency' => "SAR"));
    }
    
    public function invoices()
    {
        $this->db->select('geopos_invoices.*, geopos_invoices.id AS InvoiceId, geopos_customers.*,geopos_terms.title AS termtit,geopos_terms.terms AS terms');
        $this->db->from('geopos_invoices');
        $this->db->join('geopos_customers', 'geopos_customers.id = geopos_invoices.csd', 'left');
        $this->db->join('geopos_terms', 'geopos_terms.id = geopos_invoices.term', 'left');
        $this->db->where('geopos_invoices.company_id', getCompanyId());
        $query = $this->db->get();
        $invoices = $query->result_array();
        $final_invoices = [];
        foreach($invoices as $invoice) {
            $invoice['id'] = $invoice['InvoiceId'];
            array_push($final_invoices,$invoice);
        }
        $loc = location($invoices[0]['loc']);
        return array(array('invoices' => $final_invoices, 'company' => $loc,  'currency' => "SAR"));
    }


}