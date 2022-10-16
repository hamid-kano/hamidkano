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

class Tickets Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ticket_model', 'ticket');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(3)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $this->li_a = 'crm';

    }


    //documents


    public function index()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Support Tickets';
        $data['totalt'] = $this->ticket->ticket_count_all('');
        $this->load->view('fixed/header', $head);
        $this->load->view('support/tickets', $data);
        $this->load->view('fixed/footer');


    }

    public function tickets_load_list()
    {
        $filt = $this->input->get('stat');
        $list = $this->ticket->ticket_datatables($filt);
        $data = array();
        $no = $this->input->post('start');

        foreach ($list as $ticket) {
            $row = array();
            $no++;
            $row[] = $no;
            $row[] = $ticket->subject;
            $row[] = dateformat_time($ticket->created);
            $row[] = $ticket->project;
            $row[] = $ticket->customer;
            $row[] = '<span class="st-' . $ticket->status . '">' . $this->lang->line($ticket->status) . '</span>';
            
            $row[] = '<a href="' . base_url('tickets/thread/?id=' . $ticket->id.'&ref='.$ticket->hash_code) . '" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> ' . $this->lang->line('View') . '</a> <a class="btn btn-danger btn-xs delete-object" href="#" data-object-ref="' . $ticket->hash_code . '" data-object-id="' . $ticket->id . '"> <i class="fa fa-trash "></i> </a>';


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->ticket->ticket_count_all($filt),
            "recordsFiltered" => $this->ticket->ticket_count_filtered($filt),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function ticket_stats()
    {

        $this->ticket->ticket_stats();


    }


    public function thread()
    {

        $this->load->helper(array('form'));
        $thread_id = $this->input->get('id');
        $hash_code = $this->input->get('ref');

        $data['response'] = 3;
        $this->load->model('projects_model', 'projects');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Add Support Reply';

        $this->load->view('fixed/header', $head);

        if ($this->input->post('content')) {

            $message = $this->input->post('content');
            $attachments = $this->input->post('uploadedFiles');
            if ($attachments) {
                    $data['response'] = 1;
                    $data['responsetext'] = 'Reply Added Successfully.';
                    $filenames = json_encode($attachments);
                    $this->ticket->addreply($thread_id, $message, $filenames,$hash_code);

            } else {
                $this->ticket->addreply($thread_id, $message, '',$hash_code);
                $data['response'] = 1;
                $data['responsetext'] = 'Reply Added Successfully.';
            }

            $data['thread_info'] = $this->ticket->thread_info($thread_id,$hash_code);
            $data['thread_list'] = $this->ticket->thread_list($thread_id,$hash_code);
            if( $data['thread_info']['project_id'] ) {
            $project = $this->projects->details($data['thread_info']['project_id']);
            $data['project'] = $project;
            }

            $this->load->view('support/thread', $data);
        } else {

            $data['thread_info'] = $this->ticket->thread_info($thread_id,$hash_code);
            $data['thread_list'] = $this->ticket->thread_list($thread_id,$hash_code);
            if( $data['thread_info']['project_id'] ) {
            $project = $this->projects->details($data['thread_info']['project_id']);
            $data['project'] = $project;
            }
            $this->load->view('support/thread', $data);


        }
        $this->load->view('fixed/footer');


    }
    
    public function create()
    {
        $flag = true;

        $this->load->helper(array('form'));
        $data['response'] = 3;
        $this->db->from('geopos_projects');
        $this->db->where('company_id', getCompanyId());
        $query = $this->db->get();
        $data['projects'] = $query->result_array();
        $head['usernm'] = '';
        $head['title'] = 'Add Support Ticket';

        $this->load->view('fixed/header', $head);

        if ($this->input->post('submit')) {


            if ($flag) {

                $title = $this->input->post('title');
                $project_id = $this->input->post('project_id');
                $message = $this->input->post('content');
                $attachments = $this->input->post('uploadedFiles');
                if(!$title || !$project_id || !$message) {
                    $data['response'] = 0;
                    $data['responsetext'] = 'من فضلك املأ البيانات';
                    $this->load->view('support/create', $data);
                    return;
                }
                if ($attachments) {
                    $filenames = json_encode($attachments);
                    if(!$this->ticket->addticket($title, $message, $filenames,$project_id)) {
                        $data['response'] = 0;
                        $data['responsetext'] = 'حدث خطأ حاول لاحقاً';
                    } else {
                    $data['response'] = 1;
                    $data['responsetext'] = 'تم إنشاء التذكرة بنجاح';
                    }

                } else {
                    if(!$this->ticket->addticket($title, $message, '',$project_id)) {
                            $data['response'] = 0;
                            $data['responsetext'] = 'حدث خطأ حاول لاحقاً';
                        } else {
                        $data['response'] = 1;
                        $data['responsetext'] = 'تم إنشاء التذكرة بنجاح';
                    }
                }
            } 
            $this->load->view('support/create', $data);

        } else {

            $this->load->view('support/create', $data);


        }
        $this->load->view('fixed/footer');


    }


    public function delete_ticket()
    {
        $id = $this->input->post('deleteid');
        $hash_code = $this->input->post('ref');

        if ($this->ticket->deleteticket($id,$hash_code)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    public function update_status()
    {
        $tid = $this->input->post('tid');
        $status = $this->input->post('status');


        $this->db->set('status', $status);
        $this->db->where('id', $tid);
        $this->db->update('geopos_tickets');

        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('UPDATED'), 'pstatus' => $status));
    }
    
    public function file_handling() {
        $this->load->library("Uploadhandler_generic", array(
            'accept_file_types' => '/\.(gif|jpe?g|png|docx|docs|txt|pdf|xls|xlsx|apk|zip|rar|ai)$/i', 'upload_dir' => FCPATH . '/userfiles/support/', 'upload_url' => base_url() . 'userfiles/support/'
        ,'max_file_size'=>128000));
        $files = (string)$this->uploadhandler_generic->filenaam();
    }


}