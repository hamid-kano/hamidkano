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

class Tools Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

        $this->load->model('tools_model', 'tools');
        $this->li_a = 'misc';

    }

    //todo section

    public function todo()
    {
        $this->li_a = 'project';
        if (!$this->aauth->premission(4)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'ToDo List';
        $data['totalt'] = $this->tools->task_count_all();

        $this->load->view('fixed/header', $head);
        $this->load->view('todo/index', $data);
        $this->load->view('fixed/footer');

    }

    public function addtask()
    {
        $this->li_a = 'project';
        if (!$this->aauth->premission(4)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $this->load->model('employee_model', 'employee');
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['emp'] = $this->employee->list_employee();
        $head['title'] = 'Add Task';

        $this->load->view('fixed/header', $head);
        $this->load->view('todo/addtask', $data);
        $this->load->view('fixed/footer');

    }

    public function edittask()
    {
        $this->li_a = 'project';
        if (!$this->aauth->premission(4)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $hash_code = $this->input->post('ref_id');
            $name = $this->input->post('name', true);
            $status = $this->input->post('status');
            $priority = $this->input->post('priority');
            $stdate = $this->input->post('staskdate', true);
            $tdate = $this->input->post('taskdate', true);
            $employee = $this->input->post('employee');
            $content = $this->input->post('content');
            $stdate = datefordatabase($stdate);
            $tdate = datefordatabase($tdate);

            if ($this->tools->edittask($id, $name, $status, $priority, $stdate, $tdate, $employee, $content,$hash_code)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED') . "  <a href='todo' class='btn btn-blue btn-lg'><span class='fa fa-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {

            $this->load->model('employee_model', 'employee');

            $head['usernm'] = $this->aauth->get_user()->username;
            $data['emp'] = $this->employee->list_employee();
            $head['title'] = 'Edit Task';

            $id = $this->input->get('id');
            $hash_code = $this->input->get('ref_id');
            $data['task'] = $this->tools->viewtask($id,$hash_code);

            $this->load->view('fixed/header', $head);
            $this->load->view('todo/edittask', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function save_addtask()
    {
        if (!$this->aauth->premission(4)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $name = $this->input->post('name', true);
        $status = $this->input->post('status');
        $priority = $this->input->post('priority');
        $stdate = $this->input->post('staskdate');
        $tdate = $this->input->post('taskdate');
        $employee = $this->input->post('employee');
        $content = $this->input->post('content');
        $assign = $this->aauth->get_user()->id;
        $stdate = datefordatabase($stdate);
        $tdate = datefordatabase($tdate);

        if ($this->tools->addtask($name, $status, $priority, $stdate, $tdate, $employee, $assign, $content)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('New Task Added') . "  <a href='addtask' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a>   <a href='todo' class='btn btn-blue btn-lg'><span class='icon-list-ul' aria-hidden='true'></span>  </a>"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }

    }

    public function set_task()
    {
        if (!$this->aauth->premission(4)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $id = $this->input->post('tid');
        $stat = $this->input->post('stat');
        $hash_code = $this->input->post('ref_id');
        $this->tools->settask($id, $stat,$hash_code);
        echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED'), 'pstatus' => 'Success'));


    }

    public function view_task()
    {
        if (!$this->aauth->premission(4)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $id = $this->input->post('tid');
        $hash_code = $this->input->post('ref_id');

        $task = $this->tools->viewtask($id,$hash_code);

        echo json_encode(array('name' => $task['name'], 'description' => $task['description'], 'employee' => $task['emp'], 'assign' => $task['assign'], 'priority' => $task['priority']));
    }

    public function task_stats()
    {
        if (!$this->aauth->premission(4)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $this->tools->task_stats();


    }

    public function delete_i()
    {
        if (!$this->aauth->premission(4)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $id = $this->input->post('deleteid');
        $hash_code = $this->input->post('hash_code');

        if ($this->tools->deletetask($id,$hash_code)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }


    public function todo_load_list()
    {
        if (!$this->aauth->premission(4)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $cday = $this->input->get('cday');
        $list = $this->tools->task_datatables($cday);
        $data = array();
        $no = $this->input->post('start');

        foreach ($list as $task) {
            $no++;
            $name = '<a class="check text-default" data-id="' . $task->id . '&ref_id='.$task->hash_code.'" data-stat="Due"> <i class="fa fa-check"></i> </a><a href="#" data-id="' . $task->id . '" data-ref="' . $task->hash_code . '" class="view_task">' . $task->name . '</a>';
            if ($task->status == 'Done') {
                $name = '<a class="check text-success" data-ref="' . $task->hash_code . '" data-id="' . $task->id . '" data-stat="Done"> <i class="fa fa-check"></i> </a><a href="#" data-id="' . $task->id . '" data-ref="' . $task->hash_code . '" class="view_task">' . $task->name . '</a>';
            }
            $row = array();
            $row[] = $no;
            $row[] = '<a href="#" data-ref="' . $task->hash_code . '" class="btn btn-primary btn-sm rounded set-task" data-id="' . $task->id . '" data-stat="0"> SET </a>' . $name;
            $row[] = dateformat($task->duedate);
            $row[] = dateformat($task->start);
            $row[] = '<span class="task_' . $task->status . '">' . $this->lang->line($task->status) . '</span>';

            $row[] = '<a class="btn-info btn-sm" href="edittask?id=' . $task->id . '&ref_id=' . $task->hash_code . '" data-object-id="' . $task->id . '" data-ref="' . $task->hash_code . '"> <i class="fa fa-pencil"></i> </a>&nbsp;<a class="btn-danger btn-sm delete-object" href="#" data-object-id="' . $task->id . '"> <i class="fa fa-trash"></i> </a>';


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->tools->task_count_all($cday),
            "recordsFiltered" => $this->tools->task_count_filtered($cday),
            "data" => $data,
        );
        echo json_encode($output);
    }


    //set goals

    public function setgoals()
    {
        if ($this->aauth->get_user()->roleid < 5) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $this->li_a = 'company';
        if ($this->input->post('income')) {

            $income = (float)$this->input->post('income');
            $expense = (float)$this->input->post('expense');
            $sales = (float)$this->input->post('sales');
            $netincome = (float)$this->input->post('netincome');


            if ($this->tools->setgoals($income, $expense, $sales, $netincome)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Set Goals';
            $data['goals'] = $this->tools->goals(1);

            $this->load->view('fixed/header', $head);
            $this->load->view('goals/index', $data);
            $this->load->view('fixed/footer');
        }

    }

    //notes

    public function notes()
    {
        if (!$this->aauth->premission(6)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Notes';
        $this->load->view('fixed/header', $head);
        $this->load->view('notes/index');
        $this->load->view('fixed/footer');
    }


    public function notes_load_list()
    {
        if (!$this->aauth->premission(6)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $list = $this->tools->notes_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $note) {
            $row = array();
            $no++;
            $row[] = $no;
            $row[] = $note->title;
            $row[] = dateformat($note->cdate);

            $row[] = '<a href="editnote?id=' . $note->id . '&ref_id=' . $note->hash_code . '" class="btn btn-info btn-sm"><span class="fa fa-eye"></span> ' . $this->lang->line('View') . '</a> <a class="btn btn-danger btn-sm delete-object" href="#" data-object-ref="' . $note->hash_code . '" data-object-id="' . $note->id . '"> <i class="fa fa-trash"></i> </a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->tools->notes_count_all(),
            "recordsFiltered" => $this->tools->notes_count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function addnote()
    {
        if (!$this->aauth->premission(6)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        if ($this->input->post('title')) {

            $title = $this->input->post('title', true);
            $content = $this->input->post('content');

            if ($this->tools->addnote($title, $content)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='addnote' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Add Note';
            $this->load->view('fixed/header', $head);
            $this->load->view('notes/addnote');
            $this->load->view('fixed/footer');
        }

    }

    public function editnote()
    {
        if (!$this->aauth->premission(6)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        if ($this->input->post('title')) {
            $id = $this->input->post('id');
            $title = $this->input->post('title', true);
            $content = $this->input->post('content');
            $hash_code = $this->input->post('ref_id');

            if ($this->tools->editnote($id, $title, $content,$hash_code)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED') . "  <a href='editnote?id=$id' class='btn btn-blue btn-lg'><span class='fa fa-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $id = $this->input->get('id');
            $data['note'] = $this->tools->note_v($id);
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Edit';
            $this->load->view('fixed/header', $head);
            $this->load->view('notes/editnote', $data);
            $this->load->view('fixed/footer');
        }

    }


    public function delete_note()
    {
        if (!$this->aauth->premission(6)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $id = $this->input->post('deleteid');
        $hash_code = $this->input->post('ref_id');

        if ($this->tools->deletenote($id,$hash_code)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }


    //documents


    public function documents()
    {
        if (!$this->aauth->premission(6)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Documents';
        $this->load->view('fixed/header', $head);
        $this->load->view('notes/documents');
        $this->load->view('fixed/footer');


    }

    public function document_load_list()
    {
        if (!$this->aauth->premission(6)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $list = $this->tools->document_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $document) {
            $row = array();
            $no++;
            $row[] = $no;
            $row[] = $document->title;
            $row[] = dateformat($document->cdate);

            $row[] = '<a href="' . base_url('userfiles/documents/' . $document->filename) . '" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> ' . $this->lang->line('View') . '</a> <a class="btn btn-danger btn-xs delete-object" href="#" data-object-id="' . $document->id . '"> <i class="fa fa-trash"></i> </a>';


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->tools->document_count_all(),
            "recordsFiltered" => $this->tools->document_count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }


    public function adddocument()
    {
        if (!$this->aauth->premission(6)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $this->load->helper(array('form'));
        $data['response'] = 3;
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Add Document';

        $this->load->view('fixed/header', $head);

        if ($this->input->post('title')) {
            $title = $this->input->post('title', true);
            $config['upload_path'] = './userfiles/documents';
            $config['allowed_types'] = 'docx|docs|txt|pdf|xls';
            $config['encrypt_name'] = TRUE;
            $config['max_size'] = 100000;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('userfile')) {
                $data['response'] = 0;
                $data['responsetext'] = 'File Upload Error';

            } else {
                $data['response'] = 1;
                $data['responsetext'] = 'Document Uploaded Successfully. <a href="documents"
                                       class="btn btn-blue btn-md"><i
                                                class="fa fa-folder"></i>
                                    </a>';
                $filename = $this->upload->data()['file_name'];
                $this->tools->adddocument($title, $filename);
            }

            $this->load->view('notes/adddocument', $data);
        } else {


            $this->load->view('notes/adddocument', $data);


        }
        $this->load->view('fixed/footer');


    }


    public function delete_document()
    {
        if (!$this->aauth->premission(6)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $id = $this->input->post('deleteid');
        $hash_code = $this->input->post('ref_id');

        if ($this->tools->deletedocument($id,$hash_code)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }


    public function pendingtasks()
    {
        if (!$this->aauth->premission(6)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $tasks = $this->tools->pending_tasks();

        $tlist = '';
        $tc = 0;
        foreach ($tasks as $row) {


            $tlist .= '<a href="javascript:void(0)" class="list-group-item">
                      <div class="media">
                        <div class="media-left valign-middle"><i class="icon-bullhorn2 icon-bg-circle bg-cyan"></i></div>
                        <div class="media-body">
                          <h6 class="media-heading">' . $row['name'] . '</h6>
                          <p class="notification-text font-small-2 text-muted">Due date is ' . dateformat($row['duedate']) . '.</p><small>
                            Start <time  class="media-meta text-muted">' . dateformat($row['start']) . '</time></small>
                        </div>
                      </div></a>';
            $tc++;
        }

        echo json_encode(array('tasks' => $tlist, 'tcount' => $tc));


    }


}