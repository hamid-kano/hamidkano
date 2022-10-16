<?php
defined('BASEPATH') OR exit('No direct script access allowed ');

class User extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('general_model', 'general');

        $this->captcha = $this->general->public_key()->captcha;
        $this->user_id = isset($this->session->get_userdata()['user_details'][0]->id) ? $this->session->get_userdata()['user_details'][0]->users_id : '1';
         $this->load->library("Common");
         $this->load->library("Custom");

    }

    /**
     * This function is redirect to users profile page
     * @return Void
     */
    public function index()
    {
        if (is_login()) {
            redirect(base_url() . 'invoices', 'refresh');
        }
    }

    /**
     * This function is used to load login view page
     * @return Void
     */
    public function login()
    {


        $data['captcha_on'] = $this->captcha;
        $data['captcha'] = $this->general->public_key()->recaptcha_p;




        if (isset($_SESSION['user_details'])) {
            redirect(base_url() . 'invoices', 'refresh');
        }
        $this->load->view('header');
        $this->load->view('login', $data);
        $this->load->view('footer');
    }

    /**
     * This function is used to logout user
     * @return Void
     */
    public function logout()
    {
        is_login();
        $this->session->unset_userdata('user_details');
        redirect(base_url() . 'user/login', 'refresh');
    }

    /**
     * This function is used to registr user
     * @return Void
     */
    public function registration()
    {
        if (isset($_SESSION['user_details'])) {
            redirect(base_url() . 'user/profile', 'refresh');
        }

        if ($this->common->front_end()->register) {
            //Check if admin allow to registration for user
            // if (setting_all('register_allowed') == 1) {
            if ($this->input->post()) {
                $this->add_edit();
                $this->session->set_flashdata('messagePr', 'Successfully Registered..');
            } else {
                $this->load->view('header');
                $this->load->view('register', array('langs' => $this->common->languages(),'custom_fields' => $this->custom->add_fields(1,1)));

            }
        } else {
            $this->session->set_flashdata('messagePr', 'Registration Not allowed..');
            redirect(base_url() . 'user/login', 'refresh');
        }

    }

    /**
     * This function is used for user authentication ( Working in login process )
     * @return Void
     */
    public function auth_user($page = '')
    {

        if ($this->captcha) {
            $this->load->helper('recaptchalib_helper');
            $reCaptcha = new ReCaptcha($this->general->public_key()->recaptcha_s);
            $resp = $reCaptcha->verifyResponse($this->input->server("REMOTE_ADDR"),
                $this->input->post("g-recaptcha-response"));

            if (!$resp->success) {
                $this->session->set_flashdata('messagePr', 'Invalid captcha');
                redirect(base_url() . 'user/login', 'refresh');
            }
        }


        $return = $this->User_model->auth_user();
        if (empty($return)) {
            $this->session->set_flashdata('messagePr', 'Invalid details');
            redirect(base_url() . 'user/login', 'refresh');
        } else {
            if ($return == 'not_varified') {
                $this->session->set_flashdata('messagePr', 'This accout is not varified. Please contact to your admin..');
                redirect(base_url() . 'user/login', 'refresh');
            } else {
                $this->session->set_userdata('user_details', $return);
            }
            redirect(base_url() . 'invoices', 'refresh');
        }
    }

    /**
     * This function is used send mail in forget password
     * @return Void
     */
    public function forgetpassword()
    {
        $page['title'] = 'Forgot Password';
        if ($this->input->post()) {
            $setting = settings();
            $res = $this->User_model->get_data_by('users', $this->input->post('email'), 'email', 1);
            if (isset($res[0]->users_id) && $res[0]->users_id != '') {
                $var_key = $this->getVarificationCode();
                $this->User_model->updateRow('users', 'users_id', $res[0]->users_id, array('var_key' => $var_key));
                $sub = "Reset password";
                $email = $this->input->post('email');
                $data = array(
                    'user_name' => $res[0]->name,
                    'action_url' => base_url(),
                    'sender_name' => $setting['company_name'],
                    'website_name' => $setting['website'],
                    'varification_link' => base_url() . 'user/mail_varify?code=' . $var_key,
                    'url_link' => base_url() . 'user/mail_varify?code=' . $var_key,
                );
                $body = $this->User_model->get_template('forgot_password');
                $body = $body->html;
                foreach ($data as $key => $value) {
                    $body = str_replace('{var_' . $key . '}', $value, $body);
                }
                if ($setting['mail_setting'] == 'php_mailer') {
                    $this->load->library("send_mail");
                    $emm = $this->send_mail->email($sub, $body, $email, $setting);
                } else {
                    // content-type is required when sending HTML email
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    $headers .= 'From: ' . $setting['EMAIL'] . "\r\n";
                    $emm = mail($email, $sub, $body, $headers);
                }
                if ($emm) {
                    $this->session->set_flashdata('messagePr', 'To reset your password, link has been sent to your email');
                    redirect(base_url() . 'user/login', 'refresh');
                }
            } else {
                $this->session->set_flashdata('forgotpassword', 'This account does not exist');//die;
                redirect(base_url() . "user/forgetpassword");
            }
        } else {
            $this->load->view('include/script');
            $this->load->view('forget_password');
        }
    }

    /**
     * This function is used to load view of reset password and varify user too
     * @return : void
     */
    public function mail_varify()
    {
        $return = $this->User_model->mail_varify();
        $this->load->view('include/script');
        if ($return) {
            $data['email'] = $return;
            $this->load->view('set_password', $data);
        } else {
            $data['email'] = 'allredyUsed';
            $this->load->view('set_password', $data);
        }
    }

    /**
     * This function is used to reset password in forget password process
     * @return : void
     */
    public function reset_password()
    {
        $return = $this->User_model->ResetPpassword();
        if ($return) {
            $this->session->set_flashdata('messagePr', 'Password Changed Successfully..');
            redirect(base_url() . 'user/login', 'refresh');
        } else {
            $this->session->set_flashdata('messagePr', 'Unable to update password');
            redirect(base_url() . 'user/login', 'refresh');
        }
    }

    /**
     * This function is generate hash code for random string
     * @return string
     */
    public function getVarificationCode()
    {
        $pw = $this->randomString();
        return $varificat_key = password_hash($pw, PASSWORD_DEFAULT);
    }


    /**
     * This function is used for show users list
     * @return Void
     */
    public function userTable()
    {
        is_login();
        if (CheckPermission("user", "own_read")) {
            $this->load->view('include/header');
            $this->load->view('user_table');
            $this->load->view('include/footer');
        } else {
            $this->session->set_flashdata('messagePr', 'You don\'t have permission to access.');
            redirect(base_url() . 'user/profile', 'refresh');
        }
    }

    /**
     * This function is used to create datatable in users list page
     * @return Void
     */
    public function dataTable()
    {
        is_login();
        $table = 'users';
        $primaryKey = 'users_id';
        $columns = array(
            array('db' => 'users_id', 'dt' => 0), array('db' => 'status', 'dt' => 1),
            array('db' => 'name', 'dt' => 2),
            array('db' => 'email', 'dt' => 3),
            array('db' => 'users_id', 'dt' => 4)
        );

        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $where = array("user_type != 'admin'");
        $output_arr = SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $where);
        foreach ($output_arr['data'] as $key => $value) {
            $id = $output_arr['data'][$key][count($output_arr['data'][$key]) - 1];
            $output_arr['data'][$key][count($output_arr['data'][$key]) - 1] = '';
            if (CheckPermission('user', "all_update")) {
                $output_arr['data'][$key][count($output_arr['data'][$key]) - 1] .= '<a id="btnEditRow" class="modalButtonUser mClass"  href="javascript:;" type="button" data-src="' . $id . '" title="Edit"><i class="fa fa-pencil" data-id=""></i></a>';
            } else if (CheckPermission('user', "own_update") && (CheckPermission('user', "all_update") != true)) {
                $user_id = getRowByTableColomId($table, $id, 'users_id', 'user_id');
                if ($user_id == $this->user_id) {
                    $output_arr['data'][$key][count($output_arr['data'][$key]) - 1] .= '<a id="btnEditRow" class="modalButtonUser mClass"  href="javascript:;" type="button" data-src="' . $id . '" title="Edit"><i class="fa fa-pencil" data-id=""></i></a>';
                }
            }

            if (CheckPermission('user', "all_delete")) {
                $output_arr['data'][$key][count($output_arr['data'][$key]) - 1] .= '<a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId(' . $id . ', \'user\')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>';
            } else if (CheckPermission('user', "own_delete") && (CheckPermission('user', "all_delete") != true)) {
                $user_id = getRowByTableColomId($table, $id, 'users_id', 'user_id');
                if ($user_id == $this->user_id) {
                    $output_arr['data'][$key][count($output_arr['data'][$key]) - 1] .= '<a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId(' . $id . ', \'user\')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>';
                }
            }
            $output_arr['data'][$key][0] = '<input type="checkbox" name="selData" value="' . $output_arr['data'][$key][0] . '">';
        }
        echo json_encode($output_arr);
    }

    /**
     * This function is Showing users profile
     * @return Void
     */
    public function profile($id = '')
    {
        is_login();
        if (!isset($id) || $id == '') {
            $id = $this->session->userdata('user_details')[0]->users_id;
        }
        $data['user_data'] = $this->User_model->get_users($id);
        $this->load->view('includes/header');
        $this->load->view('profile', $data);
        $this->load->view('includes/footer');
    }

    /**
     * This function is used to show popup of user to add and update
     * @return Void
     */
    public function get_modal()
    {
        is_login();
        if ($this->input->post('id')) {
            $data['userData'] = getDataByid('users', $this->input->post('id'), 'users_id');
            echo $this->load->view('add_user', $data, true);
        } else {
            echo $this->load->view('add_user', '', true);
        }
        exit;
    }


    /**
     * This function is used to upload file
     * @return Void
     */
    function upload()
    {
        foreach ($_FILES as $name => $fileInfo) {
            $filename = $_FILES[$name]['name'];
            $tmpname = $_FILES[$name]['tmp_name'];
            $exp = explode('.', $filename);
            $ext = end($exp);
            $newname = "cutsm_upl_" . time() . "." . $ext;
            $config['upload_path'] = '../userfiles/customers/';
            $config['upload_url'] = '../userfiles/customers/';
            $config['allowed_types'] = "gif|jpg|jpeg|png";
            $config['max_size'] = '2000000';
            $config['file_name'] = $newname;
            $this->load->library('upload', $config);
            move_uploaded_file($tmpname, "../userfiles/customers/" . $newname);
            return $newname;
        }
    }

    /**
     * This function is used to add and update users
     * @return Void
     */
    public function add_edit($id = '')
    {
        $data = $this->input->post();

        $profile_pic = 'user.png';
        $name = 'jj';
        if ($this->input->post('users_id')) {
            $id = $this->input->post('users_id');
        }
        if (isset($this->session->userdata('user_details')[0]->users_id)) {
            if ($this->input->post('users_id') == $this->session->userdata('user_details')[0]->users_id) {
                $redirect = 'profile';
            } else {
                $redirect = 'userTable';
            }
        } else {
            $redirect = 'login';
        }
        if ($this->input->post('fileOld')) {
            $newname = $this->input->post('fileOld');
            $profile_pic = $newname;
        } else {
            $data[$name] = '';
            $profile_pic = 'user.png';
        }
        foreach ($_FILES as $name => $fileInfo) {
            if (!empty($_FILES[$name]['name'])) {
                $newname = $this->upload();
                $data[$name] = $newname;
                $profile_pic = $newname;
            } else {
                if ($this->input->post('fileOld')) {
                    $newname = $this->input->post('fileOld');
                    $data[$name] = $newname;
                    $profile_pic = $newname;
                } else {
                    $data[$name] = '';
                    $profile_pic = 'user.png';
                }
            }
        }
        if ($id != '') {
            $data = $this->input->post();
            if ($this->input->post('status') != '') {
                $data['status'] = $this->input->post('status');
            }
            $data['user_type'] = 'Member';
            if ($this->input->post('password') != '') {
                if ($this->input->post('currentpassword') != '') {
                    $old_row = getDataByid('users', $this->input->post('users_id'), 'users_id');
                    if (password_verify($this->input->post('currentpassword'), $old_row->password)) {
                        if ($this->input->post('password') == $this->input->post('confirmPassword')) {
                            $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
                            $data['password'] = $password;
                        } else {
                            $this->session->set_flashdata('messagePr', 'Password and confirm password should be same...');
                            redirect(base_url() . 'user/' . $redirect, 'refresh');
                        }
                    } else {
                        $this->session->set_flashdata('messagePr', 'Enter Valid Current Password...');
                        redirect(base_url() . 'user/' . $redirect, 'refresh');
                    }
                } else {
                    $this->session->set_flashdata('messagePr', 'Current password is required');
                    redirect(base_url() . 'user/' . $redirect, 'refresh');
                }
            }
            $id = $this->input->post('users_id');
            unset($data['fileOld']);
            unset($data['currentpassword']);
            unset($data['confirmPassword']);
            unset($data['users_id']);
            unset($data['user_type']);
            if (isset($data['edit'])) {
                unset($data['edit']);
            }
            if ($data['password'] == '') {
                unset($data['password']);
            }
            $data['profile_pic'] = $profile_pic;
            $data2['picture'] = $profile_pic;
            $this->User_model->updateRow('users', 'users_id', $id, $data);
            $this->User_model->updateRow('geopos_customers', 'id', $this->session->userdata('user_details')[0]->cid, $data2);

            $this->session->set_flashdata('messagePr', 'Your data updated Successfully..');
            redirect(base_url() . 'user/' . $redirect, 'refresh');
        } else {
            if ($this->input->post('user_type') != 'admin') {
                $data = $this->input->post();
                $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
                $checkValue = $this->User_model->check_exists('users', 'email', $this->input->post('email'));
                if ($checkValue == false) {
                    $this->session->set_flashdata('messagePr', 'This Email Already Registered with us..');
                    redirect(base_url() . 'user/userTable', 'refresh');
                }
            //    $checkValue1 = $this->User_model->check_exists('users', 'name', $this->input->post('name'));
          //      if ($checkValue1 == false) {
         //           $this->session->set_flashdata('messagePr', 'Username Already Registered with us..');
           //         redirect(base_url() . 'user/registration', 'refresh');
           //     }


                if ($this->input->post('status') != '') {
                    $data['status'] = $this->input->post('status');
                }
                //$data['token'] = $this->generate_token();
                $data['user_id'] = $this->user_id;
                $data['password'] = $password;
                $data['profile_pic'] = $profile_pic;
                $data['is_deleted'] = 0;
                $data['status'] = 'active';
                $this->load->helper(array('form', 'url'));

                $this->load->library('form_validation');

                $this->form_validation->set_rules('city', 'region', 'required');
                $this->form_validation->set_rules('region', 'region', 'required');
                $this->form_validation->set_rules('country', 'country', 'required');
                $this->form_validation->set_rules('postbox', 'postbox', 'required');
                $this->form_validation->set_rules('address', 'address', 'required');
                $this->form_validation->set_rules('phone', 'phone', 'required');
                $this->form_validation->set_rules('email', 'email', 'required');
                $this->form_validation->set_rules('lang', 'lang', 'required');
                $this->form_validation->set_rules('password', 'Password', 'required');
                $this->form_validation->set_rules('password_confirmation', 'Password Confirmation', 'required|matches[password]');
                $zdata1['name'] = $data['name'];
                $zdata1['city'] = $this->input->post('city');
                $zdata1['region'] = $this->input->post('region');
                $zdata1['country'] = $this->input->post('country');
                $zdata1['postbox'] = $this->input->post('postbox');
                $zdata1['address'] = $this->input->post('address');
                $zdata1['phone'] = $this->input->post('phone');
                $zdata1['email'] = $data['email'];
                $zdata1['gid'] = 1;
                if (isset($data['password_confirmation'])) {
                    unset($data['password_confirmation']);
                }
                if (isset($data['call_from'])) {
                    unset($data['call_from']);
                }
                unset($data['submit']);


                if ($this->form_validation->run()) {

                    if ($this->common->front_end()->email_confirm) {

                        $this->load->library('parser');
                        $data['status'] = 'wait';
                        $udata['code'] = $this->generate_token();
                    }
                    //in customer
                    $cid = $this->User_model->insertRow('geopos_customers', $zdata1);

                    $udata['user_id'] = 1;

                    $udata['is_deleted'] = 0;
                    $udata['name'] = $data['name'];
                    $udata['password'] = $data['password'];
                    $udata['email'] = $data['email'];
                    $udata['user_type'] = 'Member';
                    $udata['cid'] = $cid;
                    $udata['lang'] = $data['lang'];
                    $udata['status'] = $data['status'];
                    $this->User_model->insertRow('users', $udata);
                    $this->custom->save_fields_data($cid,1);
                    if ($this->common->front_end()->email_confirm) {

                        $this->load->library('parser');

                        $template = $this->User_model->template_info(14);
                        $tdata = array(
                            'Company' => $this->config->item('ctitle'),
                            'NAME' => $data['name']
                        );
                        $subject = $this->parser->parse_string($template['key1'], $tdata, TRUE);
                        $reg_url = base_url() . 'user/confirm?token=' . $udata['code'];
                        $tdata = array(
                            'Company' => $this->config->item('ctitle'),
                            'NAME' => $data['name'],
                            'REG_URL' => $reg_url
                        );
                        $message = $this->parser->parse_string($template['other'], $tdata, TRUE);

                         $this->general->send_email($zdata1['email'],$data['name'], $subject, $message);
                    }


                    $this->session->set_flashdata('messagePr', 'Registered Successfully! ');
                       redirect(base_url() . 'user/' . $redirect, 'refresh');
                } else {
                    $this->session->set_flashdata('messagePr', 'Please! ReFill the all details ');
                    redirect(base_url() . 'user/registration', 'refresh');
                }


            } else {
                $this->session->set_flashdata('messagePr', 'You Don\'t have this authority ');
                redirect(base_url() . 'user/registration', 'refresh');
            }
        }

    }


    /**
     * This function is used to delete users
     * @return Void
     */
    public function delete($id)
    {
        is_login();
        $ids = explode('-', $id);
        foreach ($ids as $id) {
            $this->User_model->delete($id);
        }
        redirect(base_url() . 'user/userTable', 'refresh');
    }

    /**
     * This function is used to send invitation mail to users for registration
     * @return Void
     */
    public function InvitePeople()
    {
        is_login();
        if ($this->input->post('emails')) {
            $setting = settings();
            $var_key = $this->randomString();
            $emailArray = explode(',', $this->input->post('emails'));
            $emailArray = array_map('trim', $emailArray);
            $body = $this->User_model->get_template('invitation');
            $result['existCount'] = 0;
            $result['seccessCount'] = 0;
            $result['invalidEmailCount'] = 0;
            $result['noTemplate'] = 0;
            if (isset($body->html) && $body->html != '') {
                $body = $body->html;
                foreach ($emailArray as $mailKey => $mailValue) {
                    if (filter_var($mailValue, FILTER_VALIDATE_EMAIL)) {
                        $res = $this->User_model->get_data_by('users', $mailValue, 'email');
                        if (is_array($res) && empty($res)) {
                            $link = (string)'<a href="' . base_url() . 'user/registration?invited=' . $var_key . '">Click here</a>';
                            $data = array('var_user_email' => $mailValue, 'var_inviation_link' => $link);
                            foreach ($data as $key => $value) {
                                $body = str_replace('{' . $key . '}', $value, $body);
                            }
                            if ($setting['mail_setting'] == 'php_mailer') {
                                $this->load->library("send_mail");
                                $emm = $this->send_mail->email('Invitation for registration', $body, $mailValue, $setting);
                            } else {
                                // content-type is required when sending HTML email
                                $headers = "MIME-Version: 1.0" . "\r\n";
                                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                $headers .= 'From: ' . $setting['EMAIL'] . "\r\n";
                                $emm = mail($mailValue, 'Invitation for registration', $body, $headers);
                            }
                            if ($emm) {
                                $darr = array('email' => $mailValue, 'var_key' => $var_key);
                                $this->User_model->insertRow('users', $darr);
                                $result['seccessCount'] += 1;;
                            }
                        } else {
                            $result['existCount'] += 1;
                        }
                    } else {
                        $result['invalidEmailCount'] += 1;
                    }
                }
            } else {
                $result['noTemplate'] = 'No Email Template Availabale.';
            }
        }
        echo json_encode($result);
        exit;
    }

    /**
     * This function is used to Check invitation code for user registration
     * @return TRUE/FALSE
     */
    public function chekInvitation()
    {
        if ($this->input->post('code') && $this->input->post('code') != '') {
            $res = $this->User_model->get_data_by('users', $this->input->post('code'), 'var_key');
            $result = array();
            if (is_array($res) && !empty($res)) {
                $result['email'] = $res[0]->email;
                $result['users_id'] = $res[0]->users_id;
                $result['result'] = 'success';
            } else {
                $this->session->set_flashdata('messagePr', 'This code is not valid..');
                $result['result'] = 'error';
            }
        }
        echo json_encode($result);
        exit;
    }

    /**
     * This function is used to registr invited user
     * @return Void
     */
    public function register_invited($id)
    {
        $data = $this->input->post();
        $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        $data['password'] = $password;
        $data['var_key'] = NULL;
        $data['is_deleted'] = 0;
        $data['status'] = 'active';
        $data['user_id'] = 1;
        if (isset($data['password_confirmation'])) {
            unset($data['password_confirmation']);
        }
        if (isset($data['call_from'])) {
            unset($data['call_from']);
        }
        if (isset($data['submit'])) {
            unset($data['submit']);
        }
        $this->User_model->updateRow('users', 'users_id', $id, $data);
        $this->session->set_flashdata('messagePr', 'Successfully Registered..');
        redirect(base_url() . 'user/login', 'refresh');
    }

    /**
     * This function is used to check email is alredy exist or not
     * @return TRUE/FALSE
     */
    public function checEmailExist()
    {
        $result = 1;
        $res = $this->User_model->get_data_by('users', $this->input->post('email'), 'email');
        if (!empty($res)) {
            if ($res[0]->users_id != $this->input->post('uId')) {
                $result = 0;
            }
        }
        echo $result;
        exit;
    }

    /**
     * This function is used to Generate a token for varification
     * @return String
     */
    public function generate_token()
    {
        $alpha = "abcdefghijklmnopqrstuvwxyz";
        $alpha_upper = strtoupper($alpha);
        $numeric = "0123456789";
        $special = ".-+=_,!@$#*%<>[]{}";
        $chars = $alpha . $alpha_upper . $numeric;
        $token = '';
        $up_lp_char = $alpha . $alpha_upper . $special;
        $chars = str_shuffle($chars);
        $token = substr($chars, 10, 10) . strtotime("now") . substr($up_lp_char, 8, 8);
        return $token;
    }

    /**
     * This function is used to Generate a random string
     * @return String
     */
    public function randomString()
    {
        $alpha = "abcdefghijklmnopqrstuvwxyz";
        $alpha_upper = strtoupper($alpha);
        $numeric = "0123456789";
        $special = ".-+=_,!@$#*%<>[]{}";
        $chars = $alpha . $alpha_upper . $numeric;
        $pw = '';
        $chars = str_shuffle($chars);
        $pw = substr($chars, 8, 8);
        return $pw;
    }


    public function confirm()
    {


        if ($this->input->get('token', true) && $this->input->get('token', true) != '') {
            $res = $this->User_model->get_data_by_row('users', 'code', $this->input->get('token'));

            if ($res['code']) {


                $this->User_model->updateRow('users', 'code', $this->input->get('token'), array('status' => 'active', 'code' => null));
                $this->session->set_flashdata('messagePr', 'Activated.');
                $result['result'] = 'success';
            } else {
                $this->session->set_flashdata('messagePr', 'This code is not valid..');
                $result['result'] = 'error';
            }
        }


        redirect(base_url() . 'user/login', 'refresh');
    }

        public function reset()
    {

        if ($this->input->post('n_code', true) && $this->input->post('n_password', true) != ''  && $this->input->post('n_password', true) != '') {
            $return = $this->User_model->ResetPpassword();

             if ($return) {
                echo json_encode(array('status' => 'Success', 'message' => 'Successfully! Changed! <a href="'.base_url().'">Go to Home</a>' ));
      //      redirect(base_url() . 'user/login', 'refresh');
        } else {
            $this->session->set_flashdata('messagePr', 'Unable to update password');
           // redirect(base_url() . 'user/login', 'refresh');
        }

        }
             else if ($this->input->get('email', true) && $this->input->get('token', true) != ''){
            $data['code']=$this->input->get('token', true);
              $data['email']=$this->input->get('email', true);
             $this->load->view('header');
        $this->load->view('reset',$data);
        $this->load->view('footer');
        }



        if ($this->input->post('email', true) && $this->input->post('token', true) != '') {
            $res = $this->User_model->get_data_by_row('users', 'code', $this->input->get('token'));

            if ($res['code']) {


                $this->User_model->updateRow('users', 'code', $this->input->get('token'), array('status' => 'active', 'code' => null));
                $this->session->set_flashdata('messagePr', 'Activated.');
                $result['result'] = 'success';
            } else {
                $this->session->set_flashdata('messagePr', 'This code is not valid..');
                $result['result'] = 'error';
            }
            redirect(base_url() . 'user/login', 'refresh');
        }




    }



    public function forgot()
    {
        if ($this->input->post('email', true) && $this->input->post('email', true) != '') {
            $res = $this->User_model->get_data_by_row('users', 'email', $this->input->post('email'));

            if ($res['email']) {

                if ($this->common->front_end()->email_confirm) {
                      $res['code'] = $this->generate_token();
                         $this->User_model->updateRow('users', 'email', $res['email'], array('code' =>  $res['code']));
                    $this->load->library('parser');

                    $template = $this->User_model->template_info(15);
                    $tdata = array(
                        'Company' => $this->config->item('ctitle'),
                        'NAME' => $res['name']
                    );
                    $subject = $this->parser->parse_string($template['key1'], $tdata, TRUE);
                    $reg_url = base_url() . 'user/reset?token=' . $res['code'].'&email='. $res['email'];
                    $tdata = array(
                        'Company' => $this->config->item('ctitle'),
                        'NAME' => $res['name'],
                        'RESET_URL' => $reg_url
                    );
                    $message = $this->parser->parse_string($template['other'], $tdata, TRUE);

                $this->general->send_email($res['email'],$res['name'], $subject, $message);

                }
            }
                echo json_encode(array('status' => 'Success', 'message' => 'Email Sent Successfully!'));
        }
        else {
              $this->load->view('header');
        $this->load->view('forgot');
        $this->load->view('footer');
    }
        }


            public function address($id = '')
    {
        is_login();
        if (!isset($id) || $id == '') {
            $id = $this->session->userdata('user_details')[0]->users_id;
        }
        $data['customer'] = $this->User_model->get_users_full($id);
        $this->load->view('includes/header');
        $this->load->view('address', $data);
        $this->load->view('includes/footer');
    }


            public function update_address($id = '')
    {
           is_login();
            $id = $this->session->userdata('user_details')[0]->cid;

              $name = $this->input->post('name',true);
        $company = $this->input->post('company',true);
        $phone = $this->input->post('phone',true);

        $address = $this->input->post('address',true);
        $city = $this->input->post('city',true);
        $region = $this->input->post('region',true);
        $country = $this->input->post('country',true);
        $postbox = $this->input->post('postbox',true);
        $taxid = $this->input->post('taxid',true);
        $name_s = $this->input->post('name_s',true);
        $phone_s = $this->input->post('phone_s',true);
        $email_s = $this->input->post('email_s',true);
        $address_s = $this->input->post('address_s',true);
        $city_s = $this->input->post('city_s',true);
        $region_s = $this->input->post('region_s',true);
        $country_s = $this->input->post('country_s',true);
        $postbox_s = $this->input->post('postbox_s',true);
        $docid = $this->input->post('docid',true);
        $language = $this->input->post('language',true);

           $data = array(
            'name' => $name,
            'company' => $company,
            'phone' => $phone,
            'address' => $address,
            'city' => $city,
            'region' => $region,
            'country' => $country,
            'postbox' => $postbox,
            'taxid' => $taxid,
            'name_s' => $name_s,
            'phone_s' => $phone_s,
            'email_s' => $email_s,
            'address_s' => $address_s,
            'city_s' => $city_s,
            'region_s' => $region_s,
            'country_s' => $country_s,
            'postbox_s' => $postbox_s,
             'docid' => $docid

        );

              $this->User_model->updateRow('geopos_customers', 'id',$id,$data);

              $data2 = array(
                'name' => $name,
                 'lang' => $language
            );

               $this->User_model->updateRow('users', 'cid',$id,$data2);


            echo json_encode(array('status' => 'Success', 'message' => 'Updated!'));




    }


}