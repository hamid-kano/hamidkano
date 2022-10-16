<?php
/**
 * Geo POS -  Accounting,  Invoicing  and CRM Application
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

class Captcha_u
{

    /**
     * The CodeIgniter object variable
     * @access public
     * @var object
     */
    public $CI;

    /**
     * Variable for loading the config array into
     * @access public
     * @var array
     */
    public $config_vars;

    /**
     * Array to store error messages
     * @access public
     * @var array
     */
    public $errors = array();

    /**
     * Array to store info messages
     * @access public
     * @var array
     */
    public $infos = array();

    /**
     * Local temporary storage for current flash errors
     *
     * Used to update current flash data list since flash data is only available on the next page refresh
     * @access public
     * var array
     */
    public $flash_errors = array();

    /**
     * Local temporary storage for current flash infos
     *
     * Used to update current flash data list since flash data is only available on the next page refresh
     * @access public
     * var array
     */
    public $flash_infos = array();

    /**
     * The CodeIgniter object variable
     * @access public
     * @var object
     */
    public $aauth_db;

    ########################
    # Base Functions
    ########################

    /**
     * Constructor
     */
    public function __construct()
    {

        // get main CI object
        $this->CI = &get_instance();

        // Dependancies
        if (CI_VERSION >= 2.2) {
            $this->CI->load->library('driver');
        }
        $this->CI->load->library('session');
        $this->CI->lang->load('aauth');

        // config/aauth.php
        $this->CI->config->load('aauth');
        $this->config_vars = $this->CI->config->item('aauth');

        $this->aauth_db = $this->CI->load->database($this->config_vars['db_profile'], TRUE);

        // load error and info messages from flashdata (but don't store back in flashdata)
        $this->errors = $this->CI->session->flashdata('errors') ?: array();
        $this->infos = $this->CI->session->flashdata('infos') ?: array();
        // db load and get main CI object
        if (!@$this->CI->_query) {
            exit();
        }


    }


    public function public_key()
    {
        $this->aauth_db->select('key1 AS recaptcha_p,key2 AS captcha,url AS recaptcha_s');
        $this->aauth_db->from('univarsal_api');
        $this->aauth_db->where('id', 53);
        //$this->aauth_db->where('company_id', getCompanyId());
        $query = $this->aauth_db->get();
        return $query->row();
    }


}