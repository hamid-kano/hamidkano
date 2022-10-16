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

class Projects Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('projects_model', 'projects');

        if (!is_login()) {
            redirect(base_url() . 'user/profile', 'refresh');
        }

    }

    //todo section

    public function index()
    {
        $head['title'] = "Payments";
        $data['totalt'] = $this->projects->project_count_all();
        $this->load->view('includes/header');
        $this->load->view('projects/index', $data);
        $this->load->view('includes/footer');

    }

    public function explore()
    {
        $data['comment'] = false;
        if ($this->input->post('content')) {
            $comment = $this->input->post('content');
            $id = $this->input->post('nid');

            $head['title'] = 'Add Comment';

            if ($this->projects->add_comment($comment, $id, $this->session->userdata('user_details')[0]->cid)) {
                $data['comment'] = true;

            }

            $head['title'] = 'Project Overview';
            $data['totalt'] = $this->projects->task_count_all($id);
            $explore = $this->projects->explore($id);
            $data['thread_list'] = $this->projects->task_thread($id);
            $data['milestones'] = $this->projects->milestones_list($id);

            $data['p_files'] = $this->projects->p_files($id);
            $data['comments_list'] = $this->projects->comments_thread($id);

            $data['project'] = $explore['project'];

            $data['invoices'] = $explore['invoices'];

            $this->load->view('includes/header');
            $this->load->view('projects/explore', $data);
            $this->load->view('includes/footer');
        } else {


            $id = $this->input->get('id');

            $head['title'] = 'Project Overview';
            $data['totalt'] = $this->projects->task_count_all($id);


            $explore = $this->projects->explore($id);
            $data['thread_list'] = $this->projects->task_thread($id);
            $data['milestones'] = $this->projects->milestones_list($id);

            $data['p_files'] = $this->projects->p_files($id);
            $data['comments_list'] = $this->projects->comments_thread($id);

            $data['project'] = $explore['project'];
            // $data['customer']=$explore['customer'];
            $data['invoices'] = $explore['invoices'];

            $this->load->view('includes/header');
            $this->load->view('projects/explore', $data);
            $this->load->view('includes/footer');
        }

    }


    //tasks section


    public function view_task()
    {
        $id = $this->input->post('tid');

        $task = $this->projects->viewtask($id);

        echo json_encode(array('name' => $task['name'], 'description' => $task['description'], 'employee' => $task['emp'], 'assign' => $task['assign'], 'priority' => $task['priority']));
    }

    public function projects_stats()
    {

        $project = $this->input->get('id');
        //echo $project;
        $this->projects->project_stats($project);


    }


    public function project_load_list()
    {
        $cday = $this->input->get('cday');
        $list = $this->projects->project_datatables($cday);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $project) {
            $no++;
            $name = '<a href="' . base_url() . 'projects/explore?id=' . $project->id . '">' . $project->name . '</a>';

            $row = array();
            $row[] = $no;
            $row[] = $name;
            $row[] = $project->sdate;
            $row[] = $project->progress . ' %';
            $row[] = '<span class="project_' . $project->status . '">' . $this->lang->line($project->status) . '</span>';


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->projects->project_count_all($cday),
            "recordsFiltered" => $this->projects->project_count_filtered($cday),
            "data" => $data,
        );
        echo json_encode($output);
    }


    //tasks

    public function todo_load_list()
    {
        $pid = $this->input->post('pid');
        $list = $this->projects->task_datatables($pid);
        $data = array();
        $no = $this->input->post('start');

        foreach ($list as $task) {
            $no++;

            $row = array();
            $row[] = $no;
            $row[] = $task->name;
            $row[] = $task->duedate;
            $row[] = $task->start;
            $row[] = '<span class="task_' . $task->status . '">' . $this->lang->line($task->status) . '</span>';


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->projects->task_count_all($pid),
            "recordsFiltered" => $this->projects->task_count_filtered($pid),
            "data" => $data,
        );
        echo json_encode($output);
    }


}