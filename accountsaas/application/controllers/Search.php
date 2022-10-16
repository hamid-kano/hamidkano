<?php
/**
 * Geo POS -  Accounting,  Invoicing  and CRM Application
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

class Search extends CI_Controller
{
    public function __construct()
    {

        parent::__construct();
        $this->load->model('search_model', 'search');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

    }

    public function search_invoice()
    {
        $invoicenumber = $this->input->post('');

        $data['search'] = $this->search->invoice($invoicenumber);

        $this->load->model('transactions_model');
        $data['accounts'] = $this->transactions_model->acc_list();
        $head['title'] = "Product Categories";
        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);
        $this->load->view('search/invoice', $data);
        $this->load->view('fixed/footer');

    }


    public function invoice()
    {
        $result = array();
        $out = array();
        $tid = $this->input->get('keyword', true);
        $whr = '';
        if ($this->aauth->get_user()->loc) {
            $whr = ' (loc=' . $this->aauth->get_user()->loc . ' ) AND ';
            if (BDATA) $whr = ' (loc=' . $this->aauth->get_user()->loc . ' OR loc=0) AND ';
            $this->db->group_end();
        } elseif (!BDATA) {
            $whr = ' ( loc=0) AND ';
        }

        if ($tid) {
            $query = $this->db->query("SELECT tid FROM geopos_invoices WHERE company_id=".getCompanyId()." and  $whr (UPPER(tid)  LIKE '" . $tid . "%')  LIMIT 4");

            $result = $query->result_array();

            echo '<ul>';
            $i = 1;
            foreach ($result as $row) {


                echo "<li ><a href='" . base_url('invoices/view?id=' . $row['tid'].'ref='.$row['hash_code']) . "'>" . $row['tid'] . "</a></li>";
                $i++;
            }
            echo '</ul>';


        }

    }

    public function customer()
    {

        $name = $this->input->get('keyword', true);
        $whr = '';
        if ($this->aauth->get_user()->loc) {
            $whr = ' (loc=' . $this->aauth->get_user()->loc . ' ) AND ';
            if (BDATA) $whr = ' (loc=' . $this->aauth->get_user()->loc . ' OR loc=0) AND ';
            $this->db->group_end();
        } elseif (!BDATA) {
            $whr = ' ( loc=0) AND ';
        }

        if ($name) {
            $query = $this->db->query("SELECT id,name,address,city,phone,email FROM geopos_customers WHERE company_id=".getCompanyId()." and  $whr (UPPER(name)  LIKE '%" . strtoupper($name) . "%' OR UPPER(phone)  LIKE '" . strtoupper($name) . "%') LIMIT 6");

            $result = $query->result_array();


            $i = 1;
            echo '<span class="dropdown-item">';
            foreach ($result as $row) {


                echo ' 
                
                    <a href="' . base_url('customers/view?id=' . $row['id'].'&ref='.$row["hash_code"]) . '" class="list-group-item">  <div class="media">
                        <div class="valign-middle"><i class="icon-user icon-bg-circle bg-cyan"></i></div>
                        <div class="media-body">
                          <h6 class="media-heading">' . $row['name'] . '</h6>
                          <p class="notification-text font-small-3 text-muted">' . $row['address'] . ',' . $row['city'] . '</p><small><i class="icon-phone"></i> ' . $row['phone'] . '</small>
                        </div>
                      </div></a>
                 
               ';
                $i++;
            }
            echo '</span>';


        }

    }

    public function user()
    {

        $name = $this->input->get('username', true);
        $whr = '';
        if ($this->aauth->get_user()->loc) {
            $whr = ' (loc=' . $this->aauth->get_user()->loc . ' ) AND ';
            if (BDATA) $whr = ' (loc=' . $this->aauth->get_user()->loc . ' OR loc=0) AND ';

        } elseif (!BDATA) {
            $whr = ' ( loc=0) AND ';
        }
        if ($name != NULL) {
            $query = $this->db->query("SELECT id,username FROM geopos_users WHERE  company_id=".getCompanyId()." and $whr username  LIKE '%" . $name . "%' LIMIT 6");

            $result = $query->result_array();


            $i = 1;
            echo '<div>';
            foreach ($result as $row) {


                echo '<kbd class="selectuser black" data-username="' . $row['username'] . '" data-userid="' . $row['id'] . '">' . $row['username'] . '</kbd> ';

            }
            echo '</div>';


        }

    }

    public function customer_select()
    {

        $name = $this->input->post('customer', true);
        $whr = '';
        if ($this->aauth->get_user()->loc) {
            $whr = ' (loc=' . $this->aauth->get_user()->loc . ' ) AND ';
            if (BDATA) $whr = ' (loc=' . $this->aauth->get_user()->loc . ' OR loc=0) AND ';
            $this->db->group_end();
        } elseif (!BDATA) {
            $whr = ' ( loc=0) AND ';
        }
     

        if ($name) {
            $query = $this->db->query("SELECT id,name,address,city,phone,email FROM geopos_customers WHERE company_id=".getCompanyId()." and $whr (UPPER(name)  LIKE '" . strtoupper($name['term']) . "%' OR UPPER(phone)  LIKE '" . strtoupper($name['term']) . "%') LIMIT 6");

            $result = $query->result_array();


            echo json_encode($result);


        }

    }

    public function supplier_select()
    {

        $name = $this->input->post('supplier', true);
        $whr = '';
        if ($this->aauth->get_user()->loc) {
            $whr = ' (loc=' . $this->aauth->get_user()->loc . ' ) AND ';
            if (BDATA) $whr = ' (loc=' . $this->aauth->get_user()->loc . ' OR loc=0) AND ';
            $this->db->group_end();
        } elseif (!BDATA) {
            $whr = ' ( loc=0) AND ';
        }

        if ($name) {
            $query = $this->db->query("SELECT id,name,address,city,phone,email FROM geopos_supplier WHERE company_id=".getCompanyId()." and $whr (UPPER(name)  LIKE '" . strtoupper($name['term']) . "%' OR UPPER(phone)  LIKE '" . strtoupper($name['term']) . "%') LIMIT 6");

            $result = $query->result_array();


            echo json_encode($result);


        }

    }


}