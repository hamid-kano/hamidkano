<?php

defined('BASEPATH') OR exit('No direct script access allowed');

//$config['enable_sms'] = TRUE; No applicable - for future development purpose
//$config['enable_sms'] = TRUE;

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
$config['gateway_code'] =8;
################################


/*
 *  'TextLocal' SMS Gateway Credentials  manual configuration
 *   Your apiKey
 *  Sender Id
 */

$config['textlocal_api_key'] = 'Your apiKey';
$config['textlocal_sender_id'] = 'TXTLCL';

#####END #####

/*
 *  'clockwork' SMS Gateway Credentials  manual configuration
 *   Your apiKey
 *  Sender Id
 */
$config['clockwork_api_key'] = 'Your apiKey';
$config['clockwork_sender_id'] = 'SenderID';

#####END #####

/*
 *  'msg91' SMS Gateway Credentials  manual configuration
 *   Your apiKey
 *  Sender Id
 */
$config['msg91_api_key'] = 'Your msg91 authkey';
$config['msg91_sender_id'] = 'SenderID';

#####END #####
/*
 *  'bulksmsgateway.in' SMS Gateway Credentials  manual configuration
 *   Your apiKey
 *  Sender Id
 */
$config['bulk_sms_username'] = 'Your username';
$config['bulk_sms_password'] = 'Password';
$config['bulk_sms_sender_id'] = 'sender_id';

#####END #####
/*
 *  'Generic'   SMS Gateway Credentials  manual configuration
 *   Your apiKey
 *  Sender Id
 */
$config['generic_gateway_url'] = 'https://your-sms-api-url.com';
$config['generic_api_key'] = 'Your generic authkey';
$config['generic_sender_id'] = 'sender_id';

//Applicable only for Generic POST
//-----------------------------------------------------------------------------
$config['generic_method_post'] = false;

// generic_parameter_names change as per your documentation

$config['generic_parameter_names'] = array(0=>'api_parameter',1=>'number_parameter',2=>'sender_id_parameter',3=>'message_parameter');

//Pass Extra Parameters
$config['generic_post_data'] =array('parameter1' => 'Test');
#####END #####


/*
 *  'Test'   SMS Gateway Credentials  manual configuration
 *   Your apiKey
 *  Sender Id
 */
$config['test_gateway_url'] = 'https://your-sms-api-url.com';
$config['test_api_key'] = 'Your test authkey';
#####END #####