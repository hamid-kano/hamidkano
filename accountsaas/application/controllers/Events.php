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

class Events extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();

        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

        if (!$this->aauth->premission(6)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $this->load->model('events_model');
        $this->li_a = 'misc';

    }


    public function index()
    {
        $this->load->view('fixed/header');
        $this->load->view('events/cal');
        $this->load->view('fixed/footer');


    }

    /*Get all Events */

    public function getEvents()
    {
        $start = $this->input->get('start');
        $end = $this->input->get('end');
        $result = $this->events_model->getEvents($start, $end);
        echo json_encode($result);
    }

    /*Add new event */
    public function addEvent()
    {
        $title = $this->input->post('title', true);
        $start = $this->input->post('start', true);
        $end = $this->input->post('end', true);
        $description = $this->input->post('description', true);
        $color = $this->input->post('color');

        $result = $this->events_model->addEvent($title, $start, $end, $description, $color);

    }

    /*Update Event */
    public function updateEvent()
    {
        $title = $this->input->post('title', true);
        $id = $this->input->post('id');
        $description = $this->input->post('description', true);
        $color = $this->input->post('color');
        $result = $this->events_model->updateEvent($id, $title, $description, $color);
        echo $result;
    }

    /*Delete Event*/
    public function deleteEvent()
    {
        $result = $this->events_model->deleteEvent();
        echo $result;
    }

    public function dragUpdateEvent()
    {

        $result = $this->events_model->dragUpdateEvent();
        echo $result;
    }

}