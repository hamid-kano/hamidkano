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

class Cronjob extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();

        $this->load->model('cronjob_model', 'cronjob');
        $this->load->library("Aauth");
        $this->li_a = 'advance';
    }


    public function index()
    {
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < 5) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $data['message'] = false;
        $data['corn'] = $this->cronjob->config();
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Cron Job Panel';
        $this->load->view('fixed/header', $head);
        $this->load->view('cronjob/info', $data);
        $this->load->view('fixed/footer');
    }


    public function generate()
    {
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
            if ($this->aauth->get_user()->roleid < 5) {

                exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

            }
        }


        if ($this->cronjob->generate()) {

            $data['message'] = true;


            $data['corn'] = $this->cronjob->config();
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Generate New Key';
            $this->load->view('fixed/header', $head);
            $this->load->view('cronjob/info', $data);
            $this->load->view('fixed/footer');
        }


    }


    function due_invoices_email()
    {

        $corn = $this->cronjob->config();
        $this->load->library('parser');

        $cornkey = $corn['cornkey'];


        echo "---------------Cron job for due invoices-------\n";


        if ($cornkey == $this->input->get('token')) {
            $i = 1;

            $emails = $this->cronjob->due_mail();
            $this->load->model('templates_model', 'templates');
            $template = $this->templates->template_info(7);

            $this->load->model('communication_model', 'communication');

            foreach ($emails as $invoice) {


                $validtoken = hash_hmac('ripemd160', $invoice['id'], $this->config->item('encryption_key'));

                $link = base_url('billing/view?id=' . $invoice['id'] . '&token=' . $validtoken);

                $loc = location($invoice['loc']);

                $data = array(
                    'Company' => $loc['cname'],
                    'BillNumber' => $invoice['tid']
                );
                $subject = $this->parser->parse_string($template['key1'], $data, TRUE);


                $data = array(
                    'Company' => $loc['cname'],
                    'BillNumber' => $invoice['tid'],
                    'URL' => "<a href='$link'>$link</a>",
                    'CompanyDetails' => '<h6><strong>' . $loc['cname'] . ',</strong></h6>
<address>' . $loc['address'] . '<br>' . $loc['city'] . ', ' . $loc['country'] . '</address>
            Phone: ' . $loc['phone'] . '<br> Email: ' . $loc['email'],
                    'DueDate' => dateformat($invoice['invoiceduedate']),
                    'Amount' => amountExchange($invoice['total'], $invoice['multi'])
                );
                $message = $this->parser->parse_string($template['other'], $data, TRUE);

                if ($this->communication->send_corn_email($invoice['email'], $invoice['name'], $subject, $message)) {
                    echo "---------------$i. Email Sent! -------------------------\n";
                } else {

                    echo "---------------$i. Error! -------------------------\n";
                }


                $i++;

            }


        } else {

            echo "---------------Error! Invalid Token! -------------------------\n";
        }
    }


    function reports()
    {

        $corn = $this->cronjob->config();

        $cornkey = $corn['cornkey'];


        echo "---------------Updating Reports-------\n";


        if ($cornkey == $this->input->get('token')) {


            echo "---------------Cron started-------\n";

            $this->cronjob->reports();

            echo "---------------Task Done-------\n";

        }


    }


    public function update_exchange_rate()
    {

        $corn = $this->cronjob->config();

        $cornkey = $corn['cornkey'];

        echo "---------------Updating Exchange Rates-------\n";
        if ($cornkey == $this->input->get('token')) {

            echo "---------------Cron started-------\n";
            $this->load->model('plugins_model', 'plugins');
            $exchange = $this->plugins->universal_api(5);
            if ($exchange['active']) {
                $endpoint = $exchange['key2'];
                $access_key = $exchange['key1'];
                $base = $exchange['url'];


                $ch = curl_init('http://apilayer.net/api/' . $endpoint . '?access_key=' . $access_key . '');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


                $json = curl_exec($ch);
                curl_close($ch);


                $exchangeRates = json_decode($json, true);


                $this->cronjob->exchange_rate($base, $exchangeRates['quotes']);
                echo "---------------Task Done-------\n";
            }
        }


    }

    public function subscription()
    {
        $corn = $this->cronjob->config();

        $cornkey = $corn['cornkey'];


        echo "---------------Cron job for subscription-------\n";


        if ($cornkey == $this->input->get('token')) {

            echo "---------------Process Started -------------------------\n";

            if ($this->cronjob->subs()) {

                echo "---------------Success! Process Done! -------------------------\n";
            } else {
                echo "---------------Error! Process Halted! -------------------------\n";
            }


        } else {

            echo "---------------Error! Invalid Token! -------------------------\n";
        }


    }


    public function cleandrafts()
    {
        $corn = $this->cronjob->config();

        $cornkey = $corn['cornkey'];


        echo "---------------Cron job for clean drafts-------\n";


        if ($cornkey == $this->input->get('token')) {

            echo "---------------Process Started -------------------------\n";

            // $ndate = date("Y-m-d", strtotime(date('Y-m-d') . " -7 days"));
            $this->db->where('tid>', 1);
            $this->db->delete('geopos_draft');
            $this->db->where('tid>', 1);
            $this->db->delete('geopos_draft_items');

            echo "---------------Success! Process Done! -------------------------\n";


        } else {

            echo "---------------Error! Invalid Token! -------------------------\n";
        }


    }

    public function promo()
    {
        $corn = $this->cronjob->config();

        $cornkey = $corn['cornkey'];


        echo "---------------Cron job for promo update-------\n";


        if ($cornkey == $this->input->get('token')) {

            echo "---------------Process Started -------------------------\n";


            $data = array(
                ' active' => 2

            );
            $this->db->set($data);
            $this->db->where('valid<', date('Y-m-d'));


            $this->db->update('geopos_promo');


            echo "---------------Success! Process Done! -------------------------\n";


        } else {

            echo "---------------Error! Invalid Token! -------------------------\n";
        }


    }

    public function stock_alert()
    {
        $corn = $this->cronjob->config();
        $this->load->model('communication_model', 'communication');

        $cornkey = $corn['cornkey'];


        echo "---------------Cron job for product stock alert-------\n";


        if ($cornkey == $this->input->get('token')) {

            echo "---------------Process Started -------------------------\n";
            $subject = 'Stock Alert ' . date('Y-m-d H:i:s');

            if ($this->communication->send_corn_email($this->config->item('email'), $this->config->item('cname'), $subject, $this->cronjob->stock())) {
                echo "-------------- Email Sent! -------------------------\n";
            } else {

                echo "---------------. Error! -------------------------\n";
            }


        } else {

            echo "---------------Error! Invalid Token! -------------------------\n";
        }


    }

    public function dbbackup()
    {
        $corn = $this->cronjob->config();
        //  $this->load->model('communication_model', 'communication');

        $cornkey = $corn['cornkey'];


        echo "---------------Cron job for database backup-------\n";


        if ($cornkey == $this->input->get('token')) {

            echo "---------------Process Started -------------------------\n";
            $bdate = 'backup_' . date('Y_m_d_H_i_s');
            $this->load->dbutil();
            $backup = $this->dbutil->backup();
            $this->load->helper('file');
            write_file(FCPATH . 'userfiles/' . $bdate . '-' . rand(99, 999) . '.gz', $backup);


        } else {

            echo "---------------Error! Invalid Token! -------------------------\n";
        }


    }

    public function cleanlog()
    {
        $corn = $this->cronjob->config();

        $cornkey = $corn['cornkey'];


        echo "---------------Cron job to clean 7days old log-------\n";


        if ($cornkey == $this->input->get('token')) {

            echo "---------------Process Started -------------------------\n";

            // $ndate = date("Y-m-d", strtotime(date('Y-m-d') . " -7 days"));
            $this->db->where('DATE(created)<', date('Y-m-d', strtotime(date('Y-m-d') . " -7 days")));
            $this->db->delete('geopos_log');

            echo "---------------Success! Process Done! -------------------------\n";


        } else {

            echo "---------------Error! Invalid Token! -------------------------\n";
        }


    }

    public function expiry_alert()
    {
        $corn = $this->cronjob->config();
        $this->load->model('communication_model', 'communication');

        $cornkey = $corn['cornkey'];


        echo "---------------Cron job for product expiry alert-------\n";


        if ($cornkey == $this->input->get('token')) {

            echo "---------------Process Started -------------------------\n";
            $subject = 'Expiry Alert ' . date('Y-m-d H:i:s');

            if ($this->communication->send_corn_email($this->config->item('email'), $this->config->item('cname'), $subject, $this->cronjob->expiry())) {
                echo "-------------- Email Sent! -------------------------\n";
            } else {

                echo "---------------. Error! -------------------------\n";
            }


        } else {

            echo "---------------Error! Invalid Token! -------------------------\n";
        }


    }


    function anniversary_mail()
    {
        $corn = $this->cronjob->config();
        $this->load->library('parser');
        $cornkey = $corn['cornkey'];

        echo "---------------Cron job for anniversary_mail-------\n";


        if ($cornkey == $this->input->get('token')) {
            $i = 1;

            $this->load->model('plugins_model', 'plugins');
            $anniversary_cron = $this->plugins->universal_api(67);

            $this->load->model('templates_model', 'templates');
            $template = $this->templates->template_info(17);
            $this->load->model('communication_model', 'communication');
            $loc = location(0);
            $data = array(
                'Company' => $loc['cname']
            );
            $subject = $this->parser->parse_string($template['key1'], $data, TRUE);
            $data = array(
                'Company' => $loc['cname'],
                'CompanyDetails' => '<h6><strong>' . $loc['cname'] . ',</strong></h6>
<address>' . $loc['address'] . '<br>' . $loc['city'] . ', ' . $loc['country'] . '</address>
            Phone: ' . $loc['phone'] . '<br> Email: ' . $loc['email']

            );
            $message = $this->parser->parse_string($template['other'], $data, TRUE);



             if (date('m-d', strtotime($loc['foundation'])) === date('m-d', strtotime(date('Y-m-d')))){


      $date1 = strtotime($anniversary_cron['other']);
      $date2 = strtotime(date('Y-m-d')); // Can use date/string just like strtotime.


      if (!$anniversary_cron['active']) {
          echo "---------------. Email Sent! block 0-------------------------\n";
          $emails = $this->cronjob->customer_mail($anniversary_cron['method']);

          $user = $this->communication->group_email($emails, $subject, $message, false, '', false);
          if ($user) {
              echo "---------------$user. Email Sent! -------------------------\n";
              $vv = $this->plugins->m_update_api(67, 0, $user, date('Y-m-d'), $anniversary_cron['method'], '', 1);
          } else {
              echo "---------------$i. Esrror! -------------------------\n";
          }

      } else if ($anniversary_cron['active'] == 1) {
          $emails = $this->cronjob->customer_mail($anniversary_cron['method'], $anniversary_cron['key2']);

          $user = $this->communication->group_email($emails, $subject, $message, false, '', false);
          if ($user > 1) {
              echo "---------------$user. Email Sent! block 1-------------------------\n";
              $vv = $this->plugins->m_update_api(67, 0, $user, date('Y-m-d'), $anniversary_cron['method'], null, 1);
          } else {
              $futureDate = date('Y-m-d', strtotime('+1 year'));
              $vv = $this->plugins->m_update_api(67, 0, $user, date('Y-m-d'), $anniversary_cron['method'], $futureDate, 2);

          }
      } else if ($anniversary_cron['active'] == 2 AND $date1 == $date2) {
          echo "---------------. Email Sent! block 1-------------------------\n";
          $emails = $this->cronjob->customer_mail($anniversary_cron['method'], $anniversary_cron['key2'] + 1);
          $user = $this->communication->group_email($emails, $subject, $message, false, '', false);
          if ($user) {
              echo "---------------$user. Email Sent! -------------------------\n";
              $this->plugins->m_update_api(67, 0, $user, date('Y-m-d'), $anniversary_cron['method'], null, 1);
          } else {
              $futureDate = date('Y-m-d', strtotime('+1 year'));
              $this->plugins->m_update_api(67, 0, 0, date('Y-m-d'), $anniversary_cron['method'], $futureDate, 2);

          }
      }
  }

        } else {

            echo "---------------Error! Invalid Token! -------------------------\n";
        }

    }


     function anniversary_sms()
    {
        $corn = $this->cronjob->config();
        $this->load->library('parser');
        $cornkey = $corn['cornkey'];

        echo "---------------Cron job for anniversary_mail-------\n";


        if ($cornkey == $this->input->get('token')) {
            $i = 1;

            $this->load->model('plugins_model', 'plugins');
            $anniversary_cron = $this->plugins->universal_api(68);

            $this->load->model('templates_model', 'templates');
            $template = $this->templates->template_info(37);
            $this->load->model('communication_model', 'communication');
            $loc = location(0);
            $data = array(
                'Company' => $loc['cname']
            );
            $subject = $this->parser->parse_string($template['key1'], $data, TRUE);
            $data = array(
                'Company' => $loc['cname'],
                'CompanyDetails' => '<h6><strong>' . $loc['cname'] . ',</strong></h6>
<address>' . $loc['address'] . '<br>' . $loc['city'] . ', ' . $loc['country'] . '</address>
            Phone: ' . $loc['phone'] . '<br> Email: ' . $loc['email']

            );
            $message = $this->parser->parse_string($template['other'], $data, TRUE);



             if (date('m-d', strtotime($loc['foundation'])) === date('m-d', strtotime(date('Y-m-d')))){


      $date1 = strtotime($anniversary_cron['other']);
      $date2 = strtotime(date('Y-m-d')); // Can use date/string just like strtotime.


      if (!$anniversary_cron['active']) {
          echo "---------------. Sms Sent! block 0-------------------------\n";
          $numbers = $this->cronjob->customer_mail($anniversary_cron['method']);

          foreach($numbers as $mob){
                     $this->twilio($mob['phone'], $message);
                     $user=$mob['id'];
          }

          if ($user) {
              echo "---------------$user. Sms Sent! -------------------------\n";
              $vv = $this->plugins->m_update_api(68, 0, $user, date('Y-m-d'), $anniversary_cron['method'], '', 1);
          } else {
              echo "---------------$i. Esrror! -------------------------\n";
          }

      } else if ($anniversary_cron['active'] == 1) {
          $numbers = $this->cronjob->customer_mail($anniversary_cron['method'], $anniversary_cron['key2']);

              foreach($numbers as $mob){
                     $this->twilio($mob['phone'], $message);
                     $user=$mob['id'];
          }
          if ($user > 1) {
              echo "---------------$user. Sms Sent! block 1-------------------------\n";
              $vv = $this->plugins->m_update_api(68, 0, $user, date('Y-m-d'), $anniversary_cron['method'], null, 1);
          } else {
              $futureDate = date('Y-m-d', strtotime('+1 year'));
              $vv = $this->plugins->m_update_api(68, 0, $user, date('Y-m-d'), $anniversary_cron['method'], $futureDate, 2);

          }
      } else if ($anniversary_cron['active'] == 2 AND $date1 == $date2) {
          echo "---------------. Sms Sent! block 1-------------------------\n";
          $numbers = $this->cronjob->customer_mail($anniversary_cron['method'], $anniversary_cron['key2'] + 1);
           foreach($numbers as $mob){
                     $this->twilio($mob['phone'], $message);
                     $user=$mob['id'];
          }
          if ($user) {
              echo "---------------$user. Sms Sent! -------------------------\n";
              $this->plugins->m_update_api(68, 0, $user, date('Y-m-d'), $anniversary_cron['method'], null, 1);
          } else {
              $futureDate = date('Y-m-d', strtotime('+1 year'));
              $this->plugins->m_update_api(68, 0, 0, date('Y-m-d'), $anniversary_cron['method'], $futureDate, 2);

          }
      }
  }

        } else {

            echo "---------------Error! Invalid Token! -------------------------\n";
        }

    }


     private function twilio($mobile, $text_message)
    {
         $this->load->model('plugins_model', 'plugins');
        require APPPATH . 'third_party/twilio-php-master/Twilio/autoload.php';

        $sms_service = $this->plugins->universal_api(2);


// Your Account SID and Auth Token from twilio.com/console
        $sid = $sms_service['key1'];
        $token = $sms_service['key2'];
        $client = new Client($sid, $token);


        $message = $client->messages->create(
        // the number you'd like to send the message to
            $mobile,
            array(
                // A Twilio phone number you purchased at twilio.com/console
                'from' => $sms_service['url'],
                // the body of the text message you'd like to send
                'body' => $text_message
            )
        );

        if ($message->sid) {
            echo json_encode(array('status' => 'Success', 'message' => 'Message sending successful. Current Message Status is ' . $message->status));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'SMS Service Error'));
        }
    }


}