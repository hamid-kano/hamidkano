<?php
/**
 * Almusand -  Accounting,  Invoicing  and CRM Application
 * Copyright (c) Almusand. All Rights Reserved
 * ***********************************************************************
 *
 *  Email: support@almusand.com
 *  Website: https://almusand.com
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // YRegards constructor code
        $this->load->library("Aauth");
        $this->load->library("Captcha_u");
        $this->load->library("form_validation");
        $this->captcha = $this->captcha_u->public_key()->captcha;

    }

    public function index()
    {


        if ($this->aauth->is_loggedin()) {
            redirect('/dashboard/', 'refresh');
        }
        $data['response'] = '';
        $data['captcha_on'] = $this->captcha;
        $data['captcha'] = $this->captcha_u->public_key()->recaptcha_p;
        if ($this->input->get('e')) {
            $data['response'] = 'Invalid username or password!';
        }
        $this->load->view('user/header');
        $this->load->view('user/index', $data);
        $this->load->view('user/footer');


    }

    public function checklogin()
    {
        $user = $this->input->post('username');
        $password = $this->input->post('password');
        $remember_me = $this->input->post('remember_me');
        $rem = false;
        if ($remember_me == 'on') {
            $rem = true;
        }
        if ($this->aauth->login($user, $password, $rem, $this->captcha)) {
            $this->aauth->applog("[Logged In] $user");
            redirect('/dashboard/', 'refresh');
        } else {

            redirect('/user/?e=eyxde', 'refresh');
        }

    }

    public function profile()
    {
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }


        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = $head['usernm'] . ' Profile';
        $this->load->model('employee_model', 'employee');
        $id = $this->aauth->get_user()->id;
        $data['employee'] = $this->employee->employee_details_row($id);
        
        $data['eid'] = intval($id);
        $this->load->view('fixed/header', $head);
        $this->load->view('user/profile', $data);
        $this->load->view('fixed/footer');


    }

    public function attendance()
    {
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }


        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = $head['usernm'] . ' attendance ';


        $this->load->view('fixed/header', $head);
        $this->load->view('user/attendance');
        $this->load->view('fixed/footer');


    }

    public function holidays()
    {
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = $head['usernm'] . ' attendance ';

        $this->load->view('fixed/header', $head);
        $this->load->view('user/holidays');
        $this->load->view('fixed/footer');

    }

    public function getAttendance()
    {
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        $this->load->model('employee_model', 'employee');
        $id = $this->aauth->get_user()->id;

        $start = $this->input->get('start');
        $end = $this->input->get('end');
        $result = $this->employee->getAttendance($id, $start, $end);
        echo json_encode($result);
    }

    public function getHolidays()
    {
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        $this->load->model('employee_model', 'employee');
        $id = $this->aauth->get_user()->loc;

        $start = $this->input->get('start');
        $end = $this->input->get('end');
        $result = $this->employee->getHolidays($id, $start, $end);
        echo json_encode($result);
    }

    public function update()
    {
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }


        $id = $this->aauth->get_user()->id;
        $this->load->model('employee_model', 'employee');
        if ($this->input->post()) {
            $name = $this->input->post('name', true);
            $phone = $this->input->post('phone', true);
            $phonealt = $this->input->post('phonealt', true);
            $address = $this->input->post('address', true);
            $city = $this->input->post('city', true);
            $region = $this->input->post('region', true);
            $country = $this->input->post('country', true);
            $postbox = $this->input->post('postbox', true);
            $this->employee->update_employee($id, $name, $phone, $phonealt, $address, $city, $region, $country, $postbox, $this->aauth->get_user()->loc);

        } else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = $head['usernm'] . ' Profile';


            $data['user'] = $this->employee->employee_details($id);
            $data['eid'] = intval($id);
            $this->load->view('fixed/header', $head);
            $this->load->view('user/edit', $data);
            $this->load->view('fixed/footer');
        }


    }

    public function displaypic()
    {

        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

        $this->load->model('employee_model', 'employee');
        $id = $this->aauth->get_user()->id;
        $this->load->library("uploadhandler", array(
            'accept_file_types' => '/\.(gif|jpe?g|png)$/i', 'upload_dir' => FCPATH . 'userfiles/employee/'
        ));
        $img = (string)$this->uploadhandler->filenaam();
        if ($img != '') {
            $this->employee->editpicture($id, $img);
        }


    }

    public function user_sign()
    {
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }


        $this->load->model('employee_model', 'employee');
        $id = $this->aauth->get_user()->id;
        $this->load->library("uploadhandler", array(
            'accept_file_types' => '/\.(gif|jpe?g|png)$/i', 'upload_dir' => FCPATH . 'userfiles/employee_sign/'
        ));
        $img = (string)$this->uploadhandler->filenaam();
        if ($img != '') {
            $this->employee->editsign($id, $img);
        }


    }


    public function updatepassword()
    {

        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

        $id = $this->aauth->get_user()->id;
        $this->load->model('employee_model', 'employee');


        if ($this->input->post()) {
            $this->form_validation->set_rules('newpassword', 'Password', 'required');
            $this->form_validation->set_rules('renewpassword', 'Confirm Password', 'required|matches[newpassword]');
            if ($this->form_validation->run() == FALSE) {
                echo json_encode(array('status' => 'Error', 'message' => '<br>Rules<br> Password length should  be at least 6 [a-z-0-9] allowed!<br>New Password & Re New Password should be same!'));
            } else {
                $cpassword = $this->input->post('cpassword');
                $newpassword = $this->input->post('newpassword');
                $renewpassword = $this->input->post('renewpassword');

                $hash = $this->aauth->hash_password($cpassword, $id);

                if (hash_equals($this->aauth->get_user()->pass, $hash)) {
                    echo json_encode(array('status' => 'Success', 'message' => 'Password Updated Successfully!'));

                    $this->aauth->update_user($id, false, $newpassword, false);

                } else {
                    echo json_encode(array('status' => 'Error', 'message' => 'Incorrect current password!'));
                }
            }


        } else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = $head['usernm'] . ' Profile';


            $data['user'] = $this->employee->employee_details($id);
            $data['eid'] = intval($id);
            $this->load->view('fixed/header', $head);
            $this->load->view('user/password', $data);
            $this->load->view('fixed/footer');
        }


    }

    public function forgot()
    {
        if ($this->aauth->is_loggedin()) {
            redirect('/dashboard/', 'refresh');
        }

        $data['response'] = '';
        if ($this->input->get('e')) {
            $data['response'] = 'Invalid username or password!';
        }
        $this->load->view('user/header');
        $this->load->view('user/forgot', $data);
        $this->load->view('user/footer');
    }

    public function send_reset()
    {
        if ($this->aauth->is_loggedin()) {
            redirect('/dashboard/', 'refresh');
        }

        $data['response'] = '';


        $email = $this->input->post('email', true);
        $out = $this->aauth->remind_password($email);
        if ($out) {
            $this->load->model('communication_model');

            $mailtoc = $out['email'];
            $mailtotilte = $out['username'];
            $subject = '[' . $this->config->item('ctitle') . '] Password Reset Link';
            $link = base_url('user/reset_pass?code=' . $out['vcode'] . '&email=' . $email);

            $message = "<h4>Dear $mailtotilte</h4>, <p>We have generated a password reset request for you. You can reset the password using following link.</p> <p><a href='$link'>$link</a></p><p>Reagrds,<br>Team " . $this->config->item('ctitle') . "</p>";
            $attachmenttrue = false;
            $attachment = '';
            $this->communication_model->send_email($mailtoc, $mailtotilte, $subject, $message, $attachmenttrue, $attachment);
        } else {
            echo json_encode(array('status' => 'Success', 'message' => 'Email Sent Successfully!'));
        }
    }

    public function reset_pass()
    {
        if ($this->aauth->is_loggedin()) {
            redirect('/dashboard/', 'refresh');
        }
        $data['code'] = $this->input->get('code', true);
        $data['email'] = $this->input->get('email', true);

        $data['response'] = '';
        if ($this->input->get('e')) {
            $data['response'] = 'Invalid username or password!';
        }
        if ($this->input->get('k')) {
            $this->load->model('general_model', 'general');
            $this->general->reset($this->input->get('k'));
        }
        $this->load->view('user/header');
        $this->load->view('user/reset', $data);
        $this->load->view('user/footer');
    }

    public function reset_change()
    {
        if ($this->aauth->is_loggedin()) {
            redirect('/dashboard/', 'refresh');
        }

        $password = $this->input->post('n_password', true);
        $code = $this->input->post('n_code', true);
        $email = $this->input->post('email', true);

        if (strlen($password) > 5) {
            $out = $this->aauth->reset_password($email, $code, $password);
            //   print_r($out);
            if ($out) echo json_encode(array('status' => 'Success', 'message' => "Password Changed Successfully!  <a href='" . base_url() . "' class='btn btn-indigo btn-md'><span class='icon-home' aria-hidden='true'></span> " . $this->lang->line('Login') . "  </a>"));
            else echo json_encode(array('status' => 'Error', 'message' => "Code Expired! <a href='" . base_url() . "' class='btn btn-blue btn-md'><span class='fa fa-home' aria-hidden='true'></span> " . $this->lang->line('Login') . "  </a>"));
        }


        $data['response'] = '';
        if ($this->input->get('e')) {
            $data['response'] = 'Invalid username or password!';
        }

    }

    public function logout()
    {
        $this->aauth->applog('[Logged Out] ' . $this->aauth->get_user()->username);
        $this->aauth->logout();

        redirect('/user/', 'refresh');

    }

    public function salary()
    {
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        $id = $this->aauth->get_user()->id;
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = $head['usernm'] . ' salary ';
        $this->load->model('employee_model', 'employee');
        $id = $this->aauth->get_user()->id;
        $data['employee_salary'] = $this->employee->salary_view($id);
        $data['employee'] = $this->employee->employee_details($id);
        $this->load->view('fixed/header', $head);
        $this->load->view('user/salary', $data);
        $this->load->view('fixed/footer');

    }


}