<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/***************************************************************************************/
function getHashCode(){
  $hash_code = randomString(12).time().randomString(3).randomNumber(3).randomString(10).randomNumber(11).randomNumber(5).randomString(7).randomNumber(7).(time()*2).randomString(7);
   return $hash_code;
}

/***************************************************************************************/
function getCompanyId(){
  $CI = get_instance();
  /* Checks If current Request is from API or not If not then go to authentication data and grab the company id from there */
  $api_key_variable = $CI->config->item('rest_key_name');
  if ($api_key_variable){
      $key_name = 'HTTP_' . strtoupper(str_replace('-', '_', $api_key_variable));
      if($key = $CI->input->server($key_name)) {
          $query = $CI->db->query("SELECT * FROM ".$CI->config->item('rest_keys_table')." WHERE ".$CI->config->item('rest_keys_table').".".$CI->config->item('rest_key_column'). " = '{$key}' ");
          $api_key_row = $query->row_array();
          return $api_key_row['company_id']; // early return
      }
  }

   return  $CI->aauth->get_user()->company_id ?? 1 ;

}
/**********************************************************************************************************************/
function getHashUser(){
  $CI = get_instance();
  return $CI->aauth->get_user()->hash_code;
}
/**********************************************************************************************************************/
function randomString($length = 6, $type = 0)
{
  $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
  $str = "";
  $size = strlen($chars);
  for ($i = 0; $i < $length; $i++) {
    $str .= $chars[rand(0, $size - 1)];
  }//end for loop
  if ($type == 1) {
    return md5($str);
  }
  return $str;
}

/**********************************************************************************************************************/
function randomNumber($length, $type = 0)
{
  $chars = "0123456789";
  $str = "";
  $size = strlen($chars);
  for ($i = 0; $i < $length; $i++) {
    $str .= $chars[rand(0, $size - 1)];
  }//end for loop
  if ($type == 1) {
    return md5($str);
  }
  return $str;
}
