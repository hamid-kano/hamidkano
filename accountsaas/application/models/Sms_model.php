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

class Sms_model extends CI_Model
{


    public function send_sms($mobile, $text_message)
    {
        /*
         * Define The SMS Gateway - Default Gateway is Twilio which can be configured via user interface
         * Other providers like 'TextLocal' need a manual configuration
         *   $gateway_code = 1;
         *  1 for twilio
         *  2 for TextLocal
         *  3 for Clockwork
         * 4 For Any Generic
         */
        #################################
        ########### SWITCH HERE###########
        $gateway_code = $this->config->item('gateway_code');
        ################################


        switch ($gateway_code) {
            case 1:
                $this->twilio($mobile, $text_message);
                break;
            case 2:
                $this->textlocal($mobile, $text_message);
                break;
            case 3:
                $this->clockwork($mobile, $text_message);
                break;
            case 4:
                $this->generic($mobile, $text_message);
                break;
            case 5:
                $this->msg91($mobile, $text_message);
                break;
            case 6:
                $this->bulk_sms($mobile, $text_message);
                break;
            case 7:
                $this->nexmo($mobile, $text_message);
                break;
            case 8:
            $this->ymamah($mobile, $text_message);
            break;
        }
    }


    private function twilio($mobile, $text_message)
    {
        require APPPATH . 'third_party/twilio-php-master/Twilio/autoload.php';

        $sms_service = $this->plugins->universal_api(2);


// Your Account SID and Auth Token from twilio.com/console
        $sid = $sms_service['key1'];
        $token = $sms_service['key2'];
        $client = new \Twilio\Rest\Client($sid, $token);


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


    private function textlocal($mobile, $text_message)
    {

        $apiKey = urlencode($this->config->item('textlocal_api_key'));
        // Message details
        $numbers = array($mobile);
        $sender = urlencode($this->config->item('textlocal_sender_id'));
        $text_message = rawurlencode($text_message);
        $numbers = implode(',', $numbers);
        // Prepare data for POST request
        $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $text_message);
        // Send the POST request with cURL
        $ch = curl_init('https://api.textlocal.in/send/');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        // Process your response here
        $result = json_decode($response, true);

        if ($result['status'] == 'success') {
            echo json_encode(array('status' => 'Success', 'message' => 'Message sending successful. Current Message Status is ' . $result['status']));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'SMS Service Error'));
        }

    }

    private function clockwork($mobile, $text_message)
    {
        $apiKey = urlencode($this->config->item('clockwork_api_key'));
        // Message details

        $sender = urlencode($this->config->item('clockwork_sender_id'));
        $text_message = rawurlencode($text_message);

        // Prepare data for POST request
        $data = array('key' => $apiKey, 'to' => $mobile, "sender" => $sender, "content" => $text_message);
        // Send the POST request with cURL
        $ch = curl_init('https://api.clockworksms.com/http/send.aspx');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        // Process your response here
        //$result= json_decode($response,true);

        if ($response) {
            echo json_encode(array('status' => 'Success', 'message' => 'Message sending successful. Current Message Status is ' . $response));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'SMS Service Error'));
        }
    }


    private function generic($mobile, $text_message)
    {

        $apiKey = urlencode($this->config->item('generic_api_key'));
        $sender = urlencode($this->config->item('generic_sender_id'));
        $text_message = rawurlencode($text_message);


        //FOR POST
        //Please enter correct parameter1,parameter2,parameter3 - it can any as per your gateway variable
        $post_parameters = $this->config->item('generic_parameter_names');
        $data = array($post_parameters[0] => $apiKey, $post_parameters[1] => $mobile, $post_parameters[2] => $sender, $post_parameters[3] => $text_message);

        if ($this->config->item('generic_method_post')) $data[] = $this->config->item('generic_post_data');


        // Prepare data for POST request
        // Send the POST request with cURL
        $ch = curl_init($this->config->item('generic_gateway_url'));


        if ($this->config->item('generic_method_post')) curl_setopt($ch, CURLOPT_POST, true);
        if ($this->config->item('generic_method_post')) curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        // Process your response here
        $result = json_decode($response, true);

        if ($response) {
            echo json_encode(array('status' => 'Success', 'message' => 'Message sending successful. Current Message Status is ' . $result['status']));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'SMS Service Error'));
        }

    }

    private function nexmo($mobile, $text_message)
    {

    }

    private function msg91($mobile, $text_message)
    {
        $country = 91;
        $sender_id = $this->config->item('msg91_api_key');
        $route = '4';
        $authkey = $this->config->item('msg91_sender_id');


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://api.msg91.com/api/v2/sendsms?country=$country&sender=$sender_id&route=$route&mobiles=$mobile&authkey=$authkey&encrypt=&message=$text_message&flash=&unicode=&schtime=&afterminutes=&response=&campaign=",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{ \"sender\": \"SOCKET\", \"route\": \"4\", \"country\": \"SOCKET\", \"sms\": [ { \"message\": \"$text_message\", \"to\": [ \"$mobile\" ] } ] }",
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTPHEADER => array(
                "authkey: ",
                "content-type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
            echo json_encode(array('status' => 'Error', 'message' => 'Message sending Error. ' . $err));
        } else {
            $xml = simplexml_load_string($response);
            $json = json_encode($xml);
            $arr = json_decode($json, true);

            $temp = array();
            foreach ($arr as $k => $v) {
                foreach ($v as $k1 => $v1) {
                    $temp[$k][$k1] = $v1;
                }
            }
            echo json_encode(array('status' => 'Success', 'message' => 'Message sending successful. Current Message Status is ' . $response['TYPE']));

        }
    }

    public function bulk_sms($mobile, $text_message)
    {

        $username = "xxxxxxx";

//Enter your login password
        $password = "";

//Enter your Sender ID
        $sender = "";

//do not edit below
        $mobile_number = $mobile;
        $message = $text_message;

//Don't change below code use as it is
        $url = "https://www.bulksmsgateway.in/sendmessage.php?user=" . urlencode($username) . "&password=" . urlencode($password) . "&
mobile=" . urlencode($mobile_number) . "&message=" . urlencode($message) . "&sender=" . urlencode($sender) . "&type=" . urlencode('3');

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $curl_scraped_page = curl_exec($ch);

        curl_close($ch);

        echo json_encode(array('status' => 'Success', 'message' => 'Message sending successful.'));
    }

    private function ymamah($mobile, $text_message) {
        $curl = curl_init();
    
        $postFields = [
            "Username"=>"0534867942",
            "Password"=>"123123123",
            "Tagname"=>"ALMUSAND",
            "RecepientNumber"=>$mobile,
            "VariableList"=>"",
            "ReplacementList"=>"",
            "Message"=>$text_message,
            "SendDateTime"=>0,
            "EnableDR"=>false
        ];
        curl_setopt_array($curl, array(
          CURLOPT_URL => "http://api1.yamamah.com/SendSMS",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS =>json_encode($postFields),
          CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json"
          ),
        ));
        
        $response = curl_exec($curl);
        $decodedData = json_decode($response);
        curl_close($curl);
        if($decodedData->Status == "1") {
            echo json_encode(array('status' => 'Success', 'message' => 'Message sending successful.'));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Message sending Error. ' . $decodedData->StatusDescription));
        }
    }


}