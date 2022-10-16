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

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Common
{

  function __construct()
    {
        $this->PI = &get_instance();
        if(isset($this->PI->session->userdata('user_details')[0]->users_id)>0){
               $this->PI->db->select('lang');
        $this->PI->db->from('users');
        $this->PI->db->where('users_id', $this->PI->session->userdata('user_details')[0]->users_id);
        $query = $this->PI->db->get();
        $out= $query->row_array();
        if($out['lang']) {
            $this->PI->lang->load($out['lang'],$out['lang']);
        }
        else{
             $this->PI->lang->load('english','english');
        }
        }
        else{
            $this->PI->db->select('lang');
            $this->PI->db->from('geopos_system');
            $this->PI->db->where('id', 1);
            $query = $this->PI->db->get();
            $out = $query->row_array();
             $this->PI->lang->load($out['lang'],$out['lang']);
        }

    }


    function load($host, $port, $auth,$auth_type, $username, $password, $mailfrom, $mailfromtilte, $mailto, $mailtotilte, $subject, $message, $attachmenttrue, $attachment)
    {
        include_once APPPATH . '/libraries/PHPMailer/vendor/autoload.php';
        //Create a new PHPMailer instance
        $mail = new PHPMailer;
        $mail->CharSet = "UTF-8";

        $mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
        $mail->SMTPDebug = 0;
//Ask for HTML-friendly debug output
        $mail->Debugoutput = 'html';

        $mail->Host = $host;

        $mail->Port = $port;

        $mail->SMTPAuth = $auth;

        if($auth_type!='none') { $mail->SMTPSecure = $auth_type; }

        $mail->Username = $username;
//Password to use for SMTP authentication
        $mail->Password = $password;
//Set who the message is to be sent from
        $mail->setFrom($mailfrom, $mailfromtilte);
//Set an alternative reply-to address
//$mail->addReplyTo('replyto@example.com', 'First Last');
//Set who the message is to be sent to
        $mail->addAddress($mailto, $mailtotilte);
//Set the subject line
        $mail->Subject = $subject;
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
        $mail->msgHTML($message);
//Replace the plain text body with one created manually
        $mail->AltBody = 'This is a html email';
//Attach an image file
        if ($attachmenttrue == true) {
            $mail->addAttachment($attachment);
        }

//send the message, check for errors
        if (!$mail->send()) {
            echo json_encode(array('status' => 'Error', 'message' => $mail->ErrorInfo));
        } else {
            echo json_encode(array('status' => 'Success', 'message' => 'Email Sent Successfully!'));
        }


    }

    function corn_mail($host, $port, $auth,$auth_type, $username, $password, $mailfrom, $mailfromtilte, $mailto, $mailtotilte, $subject, $message, $attachmenttrue, $attachment)
    {
        include_once APPPATH . '/libraries/PHPMailer/vendor/autoload.php';
        //Create a new PHPMailer instance
        $mail = new PHPMailer;
        $mail->CharSet = "UTF-8";

        $mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
        $mail->SMTPDebug = 0;
//Ask for HTML-friendly debug output
        $mail->Debugoutput = 'html';

        $mail->Host = $host;

        $mail->Port = $port;

        $mail->SMTPAuth = $auth;
        if($auth_type!='none') { $mail->SMTPSecure = $auth_type; }

        $mail->Username = $username;
//Password to use for SMTP authentication
        $mail->Password = $password;
//Set who the message is to be sent from
        $mail->setFrom($mailfrom, $mailfromtilte);
//Set an alternative reply-to address
//$mail->addReplyTo('replyto@example.com', 'First Last');
//Set who the message is to be sent to
        $mail->addAddress($mailto, $mailtotilte);
//Set the subject line
        $mail->Subject = $subject;
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
        $mail->msgHTML($message);
//Replace the plain text body with one created manually
        $mail->AltBody = 'This is a html email';
//Attach an image file
        if ($attachmenttrue == true) {
            $mail->addAttachment($attachment);
        }

//send the message, check for errors
        if (!$mail->send()) {
            return false;
        } else {
            return true;
        }


    }

    function group_load($host, $port, $auth,$auth_type, $username, $password, $mailfrom, $mailfromtilte, $recipients, $subject, $message, $attachmenttrue, $attachment)
    {
        include_once APPPATH . '/libraries/PHPMailer/vendor/autoload.php';

        $mail = new PHPMailer;
        $mail->CharSet = "UTF-8";

        $mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
        $mail->SMTPDebug = 0;

        $mail->Debugoutput = 'html';

        $mail->Host = $host;

        $mail->Port = $port;

        $mail->SMTPAuth = $auth;
        if($auth_type!='none') { $mail->SMTPSecure = $auth_type; }

        $mail->Username = $username;

        $mail->Password = $password;

        $mail->setFrom($mailfrom, $mailfromtilte);
        $mail->addAddress($mailfrom, $mailfromtilte);

        foreach ($recipients as $row) {

            $mail->AddCC($row['email'], $row['name']);
        }

        $mail->Subject = $subject;

        $mail->msgHTML($message);

        $mail->AltBody = 'This is a html email';

        if ($attachmenttrue == true) {
            $mail->addAttachment($attachment);
        }


        if (!$mail->send()) {
            echo json_encode(array('status' => 'Error', 'message' => $mail->ErrorInfo));
        } else {
            echo json_encode(array('status' => 'Success', 'message' => 'Email Sent Successfully!'));
        }


    }

    function bin_send($host, $port, $auth,$auth_type, $username, $password, $mailfrom, $mailfromtilte, $mailto, $mailtotilte, $subject, $message, $attachmenttrue, $attachment)
    {
        include_once APPPATH . '/libraries/PHPMailer/vendor/autoload.php';
        //Create a new PHPMailer instance
        $mail = new PHPMailer;

//Tell PHPMailer to use SMTP
        $mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
        $mail->SMTPDebug = 0;
//Ask for HTML-friendly debug output
        $mail->Debugoutput = 'html';
//Set the hostname of the mail server
        $mail->Host = $host;
//Set the SMTP port number - likely to be 25, 465 or 587
        $mail->Port = $port;
//Whether to use SMTP authentication
        $mail->SMTPAuth = $auth;

//Username to use for SMTP authentication
        if($auth_type!='none') { $mail->SMTPSecure = $auth_type; }
        $mail->Username = $username;
//Password to use for SMTP authentication
        $mail->Password = $password;
//Set who the message is to be sent from
        $mail->setFrom($mailfrom, $mailfromtilte);
//Set an alternative reply-to address
//$mail->addReplyTo('replyto@example.com', 'First Last');
//Set who the message is to be sent to
        $mail->addAddress($mailto, $mailtotilte);
//Set the subject line
        $mail->Subject = $subject;
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
        $mail->msgHTML($message);
//Replace the plain text body with one created manually
        $mail->AltBody = 'This is a html email';
//Attach an image file
        if ($attachmenttrue == true) {
            $mail->addAttachment($attachment);
        }

//send the message, check for errors
        if (!$mail->send()) {
            return 0;
        } else {
            return 1;
        }


    }

        function languages($id = 0)
    {

        if ($id) {
            $this->PI->db->select('lang');
            $this->PI->db->from('geopos_locations');
            $this->PI->db->where('id', $id);
            $query = $this->PI->db->get();
            $out = $query->row_array();
        } else {
            $this->PI->db->select('lang');
            $this->PI->db->from('geopos_system');
            $this->PI->db->where('id', 1);
            $query = $this->PI->db->get();
            $out = $query->row_array();
        }


        $lang = '<option value="' . $out['lang'] . '">--' . $out['lang'] . '--</option><option value="english">English</option> <option value="arabic">Arabic</option><option value="bengali">Bengali</option>
                       <option value="czech">Czech</option><option value="chinese-simplified">Chinese-simplified</option> <option value="chinese-traditional">Chinese-traditional</option> <option value="dutch">Dutch</option><option value="french">French</option><option value="german">German</option><option value="greek">Greek</option><option value="hindi">Hindi</option><option value="indonesian">Indonesian</option>  <option value="italian">Italian</option><option value="japanese">Japanese</option><option value="korean">Korean</option><option value="latin">Latin</option> <option value="polish">Polish</option><option value="portuguese">Portuguese</option> <option value="russian">Russian</option> <option value="swedish">Swedish</option><option value="spanish">Spanish</option><option value="turkish">Turkish</option><option value="urdu">Urdu</option>';
        return $lang;

    }

      function front_end()
      {


          $this->PI->db->select('key1 AS register,key2 AS orders,url AS email_confirm,method AS products');
          $this->PI->db->from('univarsal_api');
          $this->PI->db->where('id', 64);
          $query = $this->PI->db->get();
          return $query->row();

      }



}