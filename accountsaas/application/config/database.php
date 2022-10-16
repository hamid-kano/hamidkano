<?php
defined('BASEPATH') or exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;
/*$hostname ='localhost';
$username ='v2almusand';
$password ='&9qnZWM&u9Ke';
$database ='v2almusa_accounting';	*/

$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'accountsaas';
// get database name from api call same site
$curl = curl_init();
$url = $_SERVER['SERVER_NAME'] . '/dev-db';
// Optional Authentication:
curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($curl, CURLOPT_USERPWD, "username:password");

curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
// TODO :: null point pattern
$owner_db_name = curl_exec($curl);
curl_close($curl);
$db['default'] = array(
	'dsn'	=> '',
	'hostname' => $hostname,
	'username' => $username,
	'password' => $password,
	'database' => $owner_db_name ?? $database,
	'dbport' => '3306',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8mb4',
	'dbcollat' => 'utf8mb4_unicode_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
