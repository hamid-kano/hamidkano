<?php
/**
 * Almusand -  Accounting,  Invoicing  and CRM Application
 * Copyright (c) Almusand. All Rights Reserved
 * ***********************************************************************
 *
 *  Email: support@almusand.com
 *  Website: https://almusand.com
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class Ultimatemailer
{

    public function __construct()
    {
        //$CI = &get_instance();
        //  log_message('Debug', 'mailer class is loaded.');

    }

    function load($host, $port, $auth,$auth_type, $username, $password, $mailfrom, $mailfromtilte, $mailto, $mailtotilte, $subject, $message, $attachmenttrue, $attachment)
    {
        include_once APPPATH . '/third_party/PHPMailer/vendor/autoload.php';
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
        return $mail->send();


    }

    function corn_mail($host, $port, $auth,$auth_type, $username, $password, $mailfrom, $mailfromtilte, $mailto, $mailtotilte, $subject, $message, $attachmenttrue, $attachment)
    {
        include_once APPPATH . '/third_party/PHPMailer/vendor/autoload.php';
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

    function group_load($host, $port, $auth,$auth_type, $username, $password, $mailfrom, $mailfromtilte, $recipients, $subject, $message, $attachmenttrue, $attachment,$flag=true)
    {
        include_once APPPATH . '/third_party/PHPMailer/vendor/autoload.php';

        $mail = new PHPMailer;
        $mail->CharSet = "UTF-8";
        $id=true;

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
            $id=$row['id'];

        }

        $mail->Subject = $subject;

        $mail->msgHTML($message);

        $mail->AltBody = 'This is a html email';

        if ($attachmenttrue == true) {
            $mail->addAttachment($attachment);
        }


        if (!$mail->send() AND $flag ) {
            echo json_encode(array('status' => 'Error', 'message' => $mail->ErrorInfo));
        } else if($flag) {
            echo json_encode(array('status' => 'Success', 'message' => 'Email Sent Successfully!'));
        } else {
           return $id;

        }


    }

    function bin_send($host, $port, $auth,$auth_type, $username, $password, $mailfrom, $mailfromtilte, $mailto, $mailtotilte, $subject, $message, $attachmenttrue, $attachment)
    {
        include_once APPPATH . '/third_party/PHPMailer/vendor/autoload.php';
        //Create a new PHPMailer instance
        $mail = new PHPMailer;
        $mail->CharSet = "UTF-8";

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
        return $mail->send();


    }
}