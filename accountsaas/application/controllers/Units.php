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

class Units Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('units_model', 'units');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < 4) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }


    }

    public function index()
    {

        $head['title'] = "Measurement Units";
        $data['units'] = $this->units->units_list();
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('units/index', $data);
        $this->load->view('fixed/footer');
    }


    public function create()
    {
        if ($this->input->post()) {
            $name = $this->input->post('name', true);
            $code = $this->input->post('code', true);

            $this->units->create($name, $code);
        } else {


            $head['title'] = "Add Unit";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('units/create');
            $this->load->view('fixed/footer');
        }
    }

    public function edit()
    {
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $name = $this->input->post('name', true);
            $code = $this->input->post('code', true);
            $this->units->edit($id, $name, $code);
        } else {


            $head['title'] = "Edit Unit";
            $head['usernm'] = $this->aauth->get_user()->username;
            $data = $this->units->view($this->input->get('id'),$this->input->get('ref'));
            $this->load->view('fixed/header', $head);
            $this->load->view('units/edit', $data);
            $this->load->view('fixed/footer');
        }
    }


    public function delete_i()
    {
        $id = $this->input->post('deleteid');
        if ($id) {

            $this->db->delete('geopos_units', array('id' => $id,'company_id'=>getCompanyId()));


            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    //variations
    public function variations()
    {

        $head['title'] = "Variations Units";
        $data['units'] = $this->units->variations_list();
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('units/variations', $data);
        $this->load->view('fixed/footer');
    }

    public function create_va()
    {
        if ($this->input->post()) {
            $name = $this->input->post('name', true);


            $this->units->create_va($name, 1);
        } else {


            $head['title'] = "Add variation";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('units/create_va');
            $this->load->view('fixed/footer');
        }
    }

    public function edit_va()
    {
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $name = $this->input->post('name', true);

            $this->units->edit_va($id, $name);
        } else {


            $head['title'] = "Edit variation";
            $head['usernm'] = $this->aauth->get_user()->username;
            $data = $this->units->view($this->input->get('id'),$this->input->get('ref'));
            $this->load->view('fixed/header', $head);
            $this->load->view('units/edit_va', $data);
            $this->load->view('fixed/footer');
        }
    }


    public function delete_va_i()
    {
        $id = $this->input->post('deleteid');
        if ($id) {

            $this->db->delete('geopos_units', array('id' => $id));


            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    //varriables
    public function variables()
    {

        $head['title'] = "Variations variables";
        $data['units'] = $this->units->variables_list();
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('units/variables', $data);
        $this->load->view('fixed/footer');
    }

    public function create_vb()
    {
        if ($this->input->post()) {
            $name = $this->input->post('name', true);
            $var_id = $this->input->post('pvars');


            $this->units->create_vb($name, $var_id);
        } else {


            $head['title'] = "Add variation variable";
            $head['usernm'] = $this->aauth->get_user()->username;
            $data['variations'] = $this->units->variations_list();
            $this->load->view('fixed/header', $head);
            $this->load->view('units/create_vb', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function edit_vb()
    {
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $name = $this->input->post('name', true);
            $var_id = $this->input->post('var_id');

            $this->units->edit_vb($id, $name, $var_id);
        } else {


            $head['title'] = "Edit variation variable";
            $head['usernm'] = $this->aauth->get_user()->username;
            $data = $this->units->view($this->input->get('id'),$this->input->get('ref'));
            $this->load->view('fixed/header', $head);
            $this->load->view('units/edit_va', $data);
            $this->load->view('fixed/footer');
        }
    }


    public function delete_vb_i()
    {
        $id = $this->input->post('deleteid');
        if ($id) {

            $this->db->delete('geopos_units', array('id' => $id,'company_id'=>getCompanyId()));


            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }


}