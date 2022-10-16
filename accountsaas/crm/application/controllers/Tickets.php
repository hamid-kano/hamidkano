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

class Tickets Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ticket_model', 'ticket');
        if (!is_login()) {
            redirect(base_url() . 'user/profile', 'refresh');
        }
        $this->load->model('general_model', 'general');
        $this->captcha = $this->general->public_key()->captcha;
        $this->user_id = isset($this->session->get_userdata()['user_details'][0]->id) ? $this->session->get_userdata()['user_details'][0]->users_id : '1';

    }


    //documents


    public function index()
    {

        $head['usernm'] = '';
        $head['title'] = 'Support Tickets';
        $this->load->view('includes/header', $head);
        if ($this->ticket->ticket()->key1) {
            $this->load->view('support/tickets');
        } else {
            $this->load->view('support/general');
        }
        $this->load->view('includes/footer');


    }

    public function tickets_load_list()
    {
        if (!$this->ticket->ticket()->key1) {
            exit();
        }
        $list = $this->ticket->ticket_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $ticket) {
            $row = array();
            $no++;
            $row[] = $no;
            $row[] = $ticket->subject;
            $row[] = $ticket->created;
            $row[] = '<span class="st-' . $ticket->status . '">' . $this->lang->line($ticket->status) . '</span>';

            $row[] = '<a href="' . base_url('tickets/thread/?id=' . $ticket->id) . '" class="btn btn-success btn-xs"><i class="icon-file-text"></i> '.$this->lang->line('View').'</a>';


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->ticket->ticket_count_all(),
            "recordsFiltered" => $this->ticket->ticket_count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }


    public function thread()
    {
        if (!$this->ticket->ticket()->key1) {
            exit();
        }
        $flag = true;
        $data['captcha_on'] = $this->captcha;
        $data['captcha'] = $this->general->public_key()->recaptcha_p;

        $this->load->helper(array('form'));
        $this->load->model('projects_model', 'projects');
        $thread_id = $this->input->get('id');

        $data['response'] = 3;
        $head['usernm'] = '';
        $head['title'] = 'Add Support Reply';

        $this->load->view('includes/header', $head);

        if ($this->input->post('content')) {

            if ($this->captcha) {
                $this->load->helper('recaptchalib_helper');
                $reCaptcha = new ReCaptcha($this->general->public_key()->recaptcha_s);
                $resp = $reCaptcha->verifyResponse($this->input->server("REMOTE_ADDR"),
                    $this->input->post("g-recaptcha-response"));

                if (!$resp->success) {
                    $flag = false;

                }
            }

            if ($flag) {

                $message = $this->input->post('content');
                $attachments = $this->input->post('uploadedFiles');
                if ($attachments) {
                    $data['response'] = 1;
                    $data['responsetext'] = 'Reply Added Successfully.';
                    $filenames = json_encode($attachments);
                    $this->ticket->addreply($thread_id, $message, $filenames);
                } else {
                    $this->ticket->addreply($thread_id, $message, '');
                    $data['response'] = 1;
                    $data['responsetext'] = 'Reply Added Successfully.';
                }


            } else {

                $data['response'] = 0;
                $data['responsetext'] = 'Captcha Error!';

            }
            $data['thread_info'] = $this->ticket->thread_info($thread_id);
            $data['thread_list'] = $this->ticket->thread_list($thread_id);

            $this->load->view('support/thread', $data);
        } else {

            $data['thread_info'] = $this->ticket->thread_info($thread_id);
            $data['thread_list'] = $this->ticket->thread_list($thread_id);
                
            if( $data['thread_info']['project_id'] ) {
            $project = $this->projects->details($data['thread_info']['project_id']);
            $data['project'] = $project;
            }
            
            $this->load->view('support/thread', $data);


        }
        $this->load->view('includes/footer');


    }

    public function addticket()
    {
        if (!$this->ticket->ticket()->key1) {
            exit();
        }
        $flag = true;
        $data['captcha_on'] = $this->captcha;
        $data['captcha'] = $this->general->public_key()->recaptcha_p;

        $this->load->helper(array('form'));
        $this->load->model('projects_model', 'projects');
        $data['response'] = 3;
        $data['projects'] = $this->projects->get_client_projects();
        $head['usernm'] = '';
        $head['title'] = 'Add Support Ticket';

        $this->load->view('includes/header', $head);

        if ($this->input->post('submit')) {
            if ($this->captcha) {
                $this->load->helper('recaptchalib_helper');
                $reCaptcha = new ReCaptcha($this->general->public_key()->recaptcha_s);
                $resp = $reCaptcha->verifyResponse($this->input->server("REMOTE_ADDR"),
                    $this->input->post("g-recaptcha-response"));

                if (!$resp->success) {
                    $flag = false;

                }
            }

            if ($flag) {

                $title = $this->input->post('title');
                $project_id = $this->input->post('project_id');
                $message = $this->input->post('content');
                $attachments = $this->input->post('uploadedFiles');
                if(!$title || !$project_id || !$message) {
                    $data['response'] = 0;
                    $data['responsetext'] = 'من فضلك املأ البيانات';
                    $this->load->view('support/addticket', $data);
                    return;
                }
                if ($attachments) {
                    $filenames = json_encode($attachments);
                    if(!$this->ticket->addticket($title, $message, $filenames,$project_id)) {
                        $data['response'] = 0;
                        $data['responsetext'] = 'حدث خطأ حاول لاحقاً';
                    } else {
                    $data['response'] = 1;
                    $data['responsetext'] = ' تم إستلام طلبك, قد يستغرق الرد عليك مابين 1-5 ايام كحد أقصى ';
                    }

                } else {
                    if(!$this->ticket->addticket($title, $message, '',$project_id)) {
                            $data['response'] = 0;
                            $data['responsetext'] = 'حدث خطأ حاول لاحقاً';
                        } else {
                        $data['response'] = 1;
                        $data['responsetext'] = ' تم إستلام طلبك, قد يستغرق الرد عليك مابين 1-5 ايام كحد أقصى ';
                    }
                }
            } else {

                $data['response'] = 0;
                $data['responsetext'] = 'Captcha Error!.';

            }
            $this->load->view('support/addticket', $data);

        } else {

            $this->load->view('support/addticket', $data);


        }
        $this->load->view('includes/footer');


    }
    
    public function file_handling() {
        $this->load->library("Uploadhandler_generic", array(
            'accept_file_types' => '/\.(gif|jpe?g|png|docx|docs|txt|pdf|xls|xlsx|apk|zip|rar|ai)$/i', 'upload_dir' => FCPATH . '../userfiles/support/', 'upload_url' => substr_replace(base_url(), '', -4) . 'userfiles/support/'
        ,'max_file_size'=>128000));
        $files = (string)$this->uploadhandler_generic->filenaam();
    }


}