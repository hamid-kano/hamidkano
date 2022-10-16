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

class Manager Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('manager_model', 'manager');
        //$this->load->model('projects_model', 'projects');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        $this->li_a = 'manager';
    }

    public function todo()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'ToDo List';
        $this->load->view('fixed/header', $head);
        $this->load->view('todo/employee');
        $this->load->view('fixed/footer');
    }


    public function set_task()
    {
        $id = $this->input->post('tid');
        $stat = $this->input->post('stat');
        $this->manager->settask($id, $stat);
        echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED'), 'pstatus' => 'Success'));


    }

    public function view_task()
    {
        $id = $this->input->post('tid');

        $task = $this->manager->viewtask($id);

        echo json_encode(array('name' => $task['name'], 'description' => $task['description'], 'employee' => $task['emp'], 'assign' => $task['assign'], 'priority' => $task['priority']));
    }


    public function todo_load_list()
    {
        $cday = $this->input->get('cday');
        $list = $this->manager->task_datatables($cday);
        $data = array();
        $no = $this->input->post('start');

        foreach ($list as $task) {
            $no++;
            $name = '<a class="check text-default" data-id="' . $task->id . '" data-stat="Due"> <i class="fa fa-check"></i> </a><a href="#" data-id="' . $task->id . '" class="view_task">' . $task->name . '</a>';
            if ($task->status == 'Done') {
                $name = '<a class="check text-success" data-id="' . $task->id . '" data-stat="Done"> <i class="fa fa-check"></i> </a><a href="#" data-id="' . $task->id . '" class="view_task">' . $task->name . '</a>';
            }
            $row = array();
            $row[] = $no;
            $row[] = '<a href="#" class="btn btn-primary btn-sm rounded set-task" data-id="' . $task->id . '" data-stat="0"> SET </a>' . $name;
            $row[] = $task->duedate;
            $row[] = $task->start;
            $row[] = '<span class="task_' . $task->status . '">' . $this->lang->line($task->status) . '</span>';

            $row[] = '<a href="#" data-id="' . $task->id . '" class="view_task btn-sm btn-purple"> <i class="icon-eye">'.$this->lang->line('View').'</i> </a>';


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->manager->task_count_all($cday),
            "recordsFiltered" => $this->manager->task_count_filtered($cday),
            "data" => $data,
        );
        echo json_encode($output);
    }


    public function pendingtasks()
    {
        $user = $this->aauth->get_user()->id;

        $tasks = $this->manager->pending_tasks_user($user);

        $tlist = '';
        $tc = 0;
        foreach ($tasks as $row) {


            $tlist .= '<a href="javascript:void(0)" >
                      <div class="media">
                        <div class="media-left valign-middle"><i class="fa fa-bullhorn icon-bg-circle bg-cyan"></i></div>
                        <div class="media-body">
                          <h6 class="media-heading">' . $row['name'] . '</h6>
                          <p class="notification-text font-small-2 text-muted">Due date is ' . $row['duedate'] . '.</p><small>
                            Start date <time  class="media-meta text-muted">' . $row['start'] . '</time></small>
                        </div>
                      </div></a>';
            $tc++;
        }

        echo json_encode(array('tasks' => $tlist, 'tcount' => $tc));


    }

    //projects

    public function projects()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Project List';
        $data['totalt'] = $this->manager->project_count_all();

        $this->load->view('fixed/header', $head);
        $this->load->view('manager/index', $data);
        $this->load->view('fixed/footer');

    }


    public function project_load_list()
    {
        $cday = $this->input->get('cday');
        $list = $this->manager->project_datatables($cday);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $project) {
            $no++;
            $name = '<a href="' . base_url() . 'manager/explore?id=' . $project->id . '">' . $project->name . '</a>';

            $row = array();
            $row[] = $no;
            $row[] = $name;
            $row[] = dateformat($project->sdate);
            $row[] = $project->customer;
            $row[] = '<span class="project_' . $project->status . '">' . $this->lang->line($project->status) . '</span>';

            $row[] = '<a href="' . base_url() . 'manager/explore?id=' . $project->id . '" class="btn btn-primary btn-sm rounded" data-id="' . $project->id . '" data-stat="0"> ' . $this->lang->line('View') . ' </a>';


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->manager->project_count_all($cday),
            "recordsFiltered" => $this->manager->project_count_filtered($cday),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function projects_stats()
    {

        $project = $this->input->get('id');
        //echo $project;
        $this->manager->project_stats($project);


    }

    public function explore()
    {
        $id = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Project Overview';
        $data['totalt'] = $this->manager->ptask_count_all($id);
        $explore = $this->manager->explore($id);
        $data['thread_list'] = $this->manager->task_thread($id);
        $data['milestones'] = $this->manager->milestones_list($id);
        $data['activities'] = $this->manager->activities($id);
        $data['p_files'] = $this->manager->p_files($id);
        $data['comments_list'] = $this->manager->comments_thread($id);
        $data['emp'] = $this->manager->list_project_employee($id);
        $data['clock'] = $explore['clock'];
        $data['project'] = $explore['project'];
        // $data['customer']=$explore['customer'];
        //$data['invoices'] = $explore['invoices'];

        $this->load->view('fixed/header', $head);
        $this->load->view('manager/explore', $data);
        $this->load->view('fixed/footer');

    }


    public function task_stats()
    {
        $id = $this->input->get('id');
        $this->manager->task_stats(intval($id));

    }


    public function ptodo_load_list()
    {
        $pid = $this->input->post('pid');
        $list = $this->manager->ptask_datatables($pid);
        $data = array();
        $no = $this->input->post('start');

        foreach ($list as $task) {
            $no++;
            $name = '<a class="check text-default" data-id="' . $task->id . '" data-stat="Due"> <i class="icon-check"></i> </a><a href="#" data-id="' . $task->id . '" class="view_task">' . $task->name . '</a>';
            if ($task->status == 'Done') {
                $name = '<a class="check text-success" data-id="' . $task->id . '" data-stat="Done"> <i class="icon-check"></i> </a><a href="#" data-id="' . $task->id . '" class="view_task">' . $task->name . '</a>';
            }
            $row = array();
            $row[] = $no;
            $row[] = '<a href="#" class="btn btn-primary btn-sm rounded set-task" data-id="' . $task->id . '" data-stat="0"> SET </a>' . $name;
            $row[] = dateformat($task->duedate);
            $row[] = dateformat($task->start);
            $row[] = '<span class="task_' . $task->status . '">' . $this->lang->line($task->status) . '</span>';


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->manager->ptask_count_all($pid),
            "recordsFiltered" => $this->manager->ptask_count_filtered($pid),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function addtask()
    {
        /*

      $this->load->model('employee_model', 'employee');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Add Task';
        $data['prid'] = $this->input->get('id');
        $data['milestones'] = $this->manager->milestones($data['prid']);
        $data['emp'] = $this->employee->list_project_employee($data['prid']);

        $this->load->view('fixed/header', $head);
        $this->load->view('manager/addtask', $data);
        $this->load->view('fixed/footer');
           */

    }

    public function addmilestone()
    {

        if ($this->input->post()) {
            $name = $this->input->post('name', true);
            $stdate = $this->input->post('staskdate', true);
            $tdate = $this->input->post('taskdate', true);
            $content = $this->input->post('content', true);
            $color = $this->input->post('color');
            $prid = $this->input->post('project', true);
            $stdate = datefordatabase($stdate);
            $tdate = datefordatabase($tdate);

            if ($this->manager->add_milestone($name, $stdate, $tdate, $content, $color, $prid)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . '&nbsp; Return to project <a href="' . base_url("manager/explore?id=" . $prid) . '" class="btn btn-primary btn-xs"><i class="icon-eye"></i> ' . $this->lang->line('Yes') . '</a>'));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }

        } else {

            $this->load->model('employee_model', 'employee');
            $head['usernm'] = $this->aauth->get_user()->username;
            $data['emp'] = $this->employee->list_employee();
            $head['title'] = 'Add milestone';
            $data['prid'] = $this->input->get('id');

            $this->load->view('fixed/header', $head);
            $this->load->view('manager/addmilestone', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function b_save_addtask()
    {
        $name = $this->input->post('name', true);
        $status = $this->input->post('status', true);
        $priority = $this->input->post('priority', true);
        $stdate = $this->input->post('staskdate', true);
        $tdate = $this->input->post('taskdate', true);
        $employee = $this->input->post('employee');
        $content = $this->input->post('content', true);
        $prid = $this->input->post('project', true);
        $milestone = $this->input->post('milestone', true);
        $assign = $this->aauth->get_user()->id;
        $stdate = datefordatabase($stdate);
        $tdate = datefordatabase($tdate);
        // $out=$this->projects->addtask($name, $status, $priority, $stdate, $tdate, $employee, $assign, $content, $prid, $milestone);
        // print_r($out);
        if ($this->manager->paddtask($name, $status, $priority, $stdate, $tdate, $employee, $assign, $content, $prid, $milestone)) {

            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('New Task Added') . '&nbsp; Return to project <a href="' . base_url("manager/explore?id=" . $prid) . '" class="btn btn-primary btn-xs"><i class="icon-eye"></i> ' . $this->lang->line('Yes') . '</a>'));

        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }

    }


    public function addactivity()
    {

        if ($this->input->post()) {
            $name = $this->input->post('name', true);
            $prid = $this->input->post('project', true);

            if ($this->manager->add_activity($name, $prid)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . '&nbsp; Return to project <a href="' . base_url("manager/explore?id=" . $prid) . '" class="btn btn-primary btn-xs"><i class="icon-eye"></i> ' . $this->lang->line('Yes') . '</a>'));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }

        } else {

            $this->load->model('employee_model', 'employee');
            $head['usernm'] = $this->aauth->get_user()->username;
            $data['emp'] = $this->employee->list_employee();
            $head['title'] = 'Add activity';
            $data['prid'] = $this->input->get('id');

            $this->load->view('fixed/header', $head);
            $this->load->view('manager/addactivity', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function file_handling()
    {
        $id = $this->input->get('id');
        $this->load->library("Uploadhandler_generic", array(
            'accept_file_types' => '/\.(gif|jpe?g|png|docx|docs|txt|pdf|xls)$/i', 'upload_dir' => FCPATH . 'userfiles/project/', 'upload_url' => base_url() . 'userfiles/project/'
        ));
        $files = (string)$this->uploadhandler_generic->filenaam();
        if ($files != '') {
            $fid = rand(100, 9999);
            $this->manager->meta_insert($id, 9, $fid, $files);
        }


    }

    public function delete_file()
    {
        $fileid = $this->input->post('object_id');
        $pid = $this->input->post('project_id');
        $this->manager->deletefile($pid, $fileid);


        echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));


    }

        public function clock_in()
    {
        $this->load->model('projects_model', 'projects');
        $id = $this->input->get('id');
        $eid = $this->aauth->get_user()->id;
        $this->projects->clockin($id, $eid);
        redirect('manager/explore?id=' . $id);
    }

    public function clock_out()
    {
        $this->load->model('projects_model', 'projects');
        $id = $this->input->get('id');
        $eid = $this->aauth->get_user()->id;
        $this->projects->clockout($id, $eid);
        redirect('manager/explore?id=' . $id);
    }


}