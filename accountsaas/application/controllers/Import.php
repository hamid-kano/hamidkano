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

use PhpOffice\PhpSpreadsheet\IOFactory;

class Import extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('export_model', 'export');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
            exit;
        }

        if ($this->aauth->get_user()->roleid < 5) {

            exit('Not Allowed!');
        }
        $this->date = 'backup_' . date('Y_m_d_H_i_s');


    }


    function products()
    {
        $this->load->helper(array('form'));
        $this->load->model('categories_model');
        $head['title'] = "Import Products";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['cat'] = $this->categories_model->category_list();
        $data['warehouse'] = $this->categories_model->warehouse_list();
        $this->load->view('fixed/header', $head);
        $this->load->view('import/products', $data);
        $this->load->view('fixed/footer');

    }

    public function products_upload()
    {

        $this->load->helper(array('form'));
        $data['response'] = 3;
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Import Product';

        $this->load->view('fixed/header', $head);

        if ($this->input->post('product_cat', true)) {
            $data['pc'] = $this->input->post('product_cat', true);
            $data['wid'] = $this->input->post('product_warehouse', true);
            $config['upload_path'] = './userfiles';
            $config['allowed_types'] = 'csv';
            $config['max_size'] = 6000;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('userfile')) {
                $data['response'] = 0;
                $data['responsetext'] = 'File Upload Error';

            } else {
                $data['response'] = 1;
                $data['responsetext'] = 'Document Uploaded Successfully.';
                $data['filename'] = $this->upload->data()['file_name'];

            }

            $this->load->view('import/wizard', $data);
        } else {


            echo ' error';


        }
        $this->load->view('fixed/footer');


    }


    public function start_process()
    {
        require APPPATH . 'third_party/vendor/autoload.php';

        $name = $this->input->post('name');
        $pcat = $this->input->post('pc');
        $warehouse = $this->input->post('wid');
        $inputFileName = FCPATH . 'userfiles/' . $name;

        $spreadsheet = IOFactory::load($inputFileName);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, false);
//print_r($sheetData);

        $products = array();

        foreach ($sheetData as $row) {
            $barcode = rand(100, 999) . '-' . rand(0, 9) . '-' . rand(1000000, 9999999) . '-' . rand(0, 9);

            $products[] = array(
                'pid' => null,
                'pcat' => $pcat,
                'warehouse' => $warehouse,
                'product_name' => $row[0],
                'product_code' => $row[1],
                'product_price' => $row[2],
                'fproduct_price' => $row[3],
                'taxrate' => $row[4],
                'disrate' => $row[5],
                'qty' => $row[6],
                'product_des' => $row[7],
                'alert' => $row[8],
                'barcode' => $barcode,
                'company_id'=>getCompanyId(),
                'hash_code'=>getHashCode() 

            );


        }
        unlink(FCPATH . 'userfiles/' . $name);
        if (count($sheetData[0]) == 9) {
            $out = $this->db->insert_batch('geopos_products', $products);
            if ($out) {
                echo json_encode(array('status' => 'Success', 'message' =>
                    "Product Data Imported Successfully!"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    "Database Import Error! Please use proper encoding of file and its content."));
            }
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                "Please correct the format of CSV file, it should be as per template."));
        }


    }


    //customer


    function customers()
    {
        $this->load->helper(array('form'));
        $this->load->model('categories_model');
        $head['title'] = "Import Products";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['cat'] = $this->categories_model->category_list();
        $data['warehouse'] = $this->categories_model->warehouse_list();
        $this->load->view('fixed/header', $head);
        $this->load->view('import/customers', $data);
        $this->load->view('fixed/footer');

    }

    public function customers_upload()
    {

        $this->load->helper(array('form'));
        $data['response'] = 3;
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Import Customers';

        $this->load->view('fixed/header', $head);


        $config['upload_path'] = FCPATH . '/userfiles';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = 6000;
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('userfile')) {
            $data['response'] = 0;
            $data['responsetext'] = 'File Upload Error';

        } else {
            $data['response'] = 1;
            $data['responsetext'] = 'Document Uploaded Successfully.';
            $data['filename'] = $this->upload->data()['file_name'];
            $data['password_s'] = $this->input->post('c_password');
            $data['password_v'] = $this->input->post('c_password_static');

        }

        $this->load->view('import/wizard2', $data);

        $this->load->view('fixed/footer');

    }


    public function customers_start_process()
    {
        require APPPATH . 'third_party/vendor/autoload.php';

        $name = $this->input->post('name');
        $c_pass = $this->input->post('c_pass');
        $c_pass_v = $this->input->post('c_pass_v');

        $inputFileName = FCPATH . 'userfiles/' . $name;

        $spreadsheet = IOFactory::load($inputFileName);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, false);
//print_r($sheetData);

        $data = array();
        $data2 = array();

        $this->db->select('id');
        $this->db->from('geopos_customers');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $l_id = +$query->row()->id + 1;
        } else {
            $l_id = 1;
        }

        foreach ($sheetData as $row) {


            $data[] = array(
                'id' => $l_id,
                'name' => $row[0],
                'phone' => $row[1],
                'address' => $row[2],
                'city' => $row[3],
                'region' => $row[4],
                'country' => $row[5],
                'postbox' => $row[6],
                'email' => $row[7],
                'gid' => $row[8],
                'taxid' => $row[9],
                'company' => $row[10],
                'name_s' => $row[11],
                'phone_s' => $row[12],
                'email_s' => $row[13],
                'address_s' => $row[14],
                'city_s' => $row[15],
                'region_s' => $row[16],
                'country_s' => $row[17],
                'postbox_s' => $row[18],
                'company_id'=>getCompanyId(),
                'hash_code'=>getHashCode() 
            );

            if ($c_pass == 'random') {
                $temp_password = rand(200000, 999999);
                $pass = password_hash($temp_password, PASSWORD_DEFAULT);
            } else {
                $pass = password_hash($c_pass_v, PASSWORD_DEFAULT);
            }

            $data2[] = array(
                'users_id' => null,
                'user_id' => 1,
                'status' => 'active',
                'is_deleted' => 0,
                'name' => $row[0],
                'password' => $pass,
                'email' => $row[7],
                'profile_pic' => $row[5],
                'user_type' => 'Member',
                'cid' => $l_id,
                'company_id'=>getCompanyId(),
                'hash_code'=>getHashCode() 
            );
            $l_id++;


        }
        // unlink(FCPATH . 'userfiles/' . $name);
        if (count($sheetData[0]) == 19) {
            $out = $this->db->insert_batch('geopos_customers', $data);
            $out = $this->db->insert_batch('users', $data2);
            if ($out) {
                echo json_encode(array('status' => 'Success', 'message' =>
                    "Customer Data Imported Successfully!"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    "Database Import Error! Please use proper encoding of file and its content."));
            }
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                "Please correct the format of CSV file, it should be as per template."));
        }


    }


}