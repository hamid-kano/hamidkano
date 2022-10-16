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

class Settings extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->li_a = 'settings';

        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

        if ($this->aauth->get_user()->roleid < 5) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }

        $this->load->model('settings_model', 'settings');


    }

    public function company()
    {
        $this->li_a = 'company';
        if ($this->input->post()) {
            $name = $this->input->post('name', true);
            $phone = $this->input->post('phone', true);
            $email = $this->input->post('email', true);
            $address = $this->input->post('address', true);
            $city = $this->input->post('city', true);
            $region = $this->input->post('region', true);
            $country = $this->input->post('country', true);
            $postbox = $this->input->post('postbox', true);
            $taxid = $this->input->post('taxid', true);
            $data_share = $this->input->post('data_share', true);
             $foundation = datefordatabase($this->input->post('foundation', true));
            $this->settings->update_company(1, $name, $phone, $email, $address, $city, $region, $country, $postbox, $taxid, $data_share,$foundation);

        } else {

            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Company Settings';
            $data['company'] = $this->settings->company_details(1);

            $this->load->view('fixed/header', $head);
            $this->load->view('settings/company', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function currency()
    {
        $this->li_a = 'localisation';
        if ($this->input->post()) {
            $currency = $this->input->post('currency', true);
            $thous_sep = $this->input->post('thous_sep');
            $deci_sep = $this->input->post('deci_sep');
            $decimal = $this->input->post('decimal');
            $spost = $this->input->post('spos');
            $roundoff = $this->input->post('roundoff');
            $r_precision = $this->input->post('r_precision');

            $this->settings->update_currency(1, $currency, $thous_sep, $deci_sep, $decimal, $spost, $roundoff, $r_precision);

        } else {

            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Currency Settings';
            $data['currency'] = $this->settings->currency();

            $this->load->view('fixed/header', $head);
            $this->load->view('settings/currency', $data);
            $this->load->view('fixed/footer');
        }

    }


    public function dtformat()
    {
        $this->li_a = 'localisation';
        if ($this->input->post()) {
            $tzone = $this->input->post('tzone');
            $dateformat = $this->input->post('dateformat');
            $this->settings->update_dtformat(1, $tzone, $dateformat);

        } else {

            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Date Time Settings';
            $data['company'] = $this->settings->company_details(1);
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/timeformat', $data);
            $this->load->view('fixed/footer');
        }

    }


    public function companylogo()
    {
        $id = $this->input->get('id');
        $this->load->library("uploadhandler", array(
            'accept_file_types' => '/\.(gif|jpe?g|png)$/i', 'upload_dir' => FCPATH . 'userfiles/company/'
        ));
        $img = (string)$this->uploadhandler->filenaam();
        if ($img != '') {
            $this->settings->companylogo($id, $img);
        }
    }

    //tax


    public function email()
    {
        $this->li_a = 'misc_settings';
        if ($this->input->post()) {
            $host = $this->input->post('host');
            $port = $this->input->post('port');
            $auth = $this->input->post('auth');
            $auth_type = $this->input->post('auth_type');
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $sender = $this->input->post('sender');

            $this->load->library('ultimatemailer');

                $this->settings->update_smtp($host, $port, $auth, $auth_type, $username, $password, $sender);

        } else {

            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'SMTP Config';
            $data['email'] = $this->settings->email_smtp();
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/email', $data);
            $this->load->view('fixed/footer');
        }

    }


    public function billing_terms()
    {
        $this->li_a = 'billing';
        $data['terms'] = $this->settings->billingterms();
        $head['title'] = "Billing Terms";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('settings/terms', $data);
        $this->load->view('fixed/footer');
    }

    public function about()
    {
        $this->li_a = 'misc_settings';
        $head['title'] = "About";

        $this->load->view('fixed/header', $head);
        $this->load->view('settings/about');
        $this->load->view('fixed/footer');
    }

    public function add_term()
    {
        $this->li_a = 'billing';
        if ($this->input->post()) {
            $title = $this->input->post('title', true);
            $type = $this->input->post('type');
            $term = $this->input->post('terms');

            $this->settings->add_term($title, $type, $term);

        } else {
            $head['title'] = "Add Billing Term";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/add_terms');
            $this->load->view('fixed/footer');
        }
    }


    public function edit_term()
    {
        $this->li_a = 'billing';
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $title = $this->input->post('title', true);
            $type = $this->input->post('type');
            $term = $this->input->post('terms');


            $this->settings->edit_term($id, $title, $type, $term);

        } else {
            $id = $this->input->get('id');

            $data['term'] = $this->settings->get_terms($id);
            $head['title'] = "Edit Billing Term";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/edit_terms', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function delete_terms()
    {

        if ($this->input->post()) {
            $id = $this->input->post('deleteid');


            if ($this->settings->delete_terms($id)) {

                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }

        }
    }

    public function activate()
    {
        if ($this->input->post()) {
            $email = $this->input->post('email', true);
            $code = $this->input->post('code', true);
            $this->settings->update_atformat($email, $code);
        } else {
            $head['title'] = "Software Activation";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/active');
            $this->load->view('fixed/footer');
        }
    }

    public function theme()
    {
        $this->li_a = 'localisation';
        if ($this->input->post()) {
            $tdirection = $this->input->post('tdirection', true);
            $menu = $this->input->post('menu', true);
            $this->settings->theme($tdirection, $menu);
        } else {
            $head['title'] = "Theme Settings";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/theme');
            $this->load->view('fixed/footer');
        }
    }

    public function themelogo()
    {
        $this->load->library("uploadhandler", array(
            'accept_file_types' => '/\.(png)$/i', 'upload_dir' => FCPATH . 'userfiles/theme/', 'name' => 'logo-header.png'
        ));
    }

    public function tickets()
    {
        $this->load->model('plugins_model', 'plugins');
        if ($this->input->post()) {
            $service = $this->input->post('service', true);
            $email = $this->input->post('email', true);
            $support = $this->input->post('support', true);
            $sign = $this->input->post('signature');
            $this->plugins->update_api(3, $service, $email, 1, $support, $sign);
        } else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Support Ticket Settings';
            $data['support'] = $this->plugins->universal_api(3);
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/ticket', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function tax()
    {
        $this->li_a = 'tax';
        $this->load->library("Common");
        $data['taxlist'] = $this->common->taxsettings($this->config->item('tax'));
        if ($this->input->post()) {
            $taxid = $this->input->post('taxid');
            $taxstatus = $this->input->post('taxstatus');
            $gst_type = $this->input->post('gst_type');
            $this->settings->update_tax(1, $taxid, $taxstatus, $gst_type);
        } else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Tax Settings';
            $data['company'] = $this->settings->company_details(1);
            $data['prefix'] = $this->settings->prefix();
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/tax', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function prefix()
    {
        $this->li_a = 'billing';
        if ($this->input->post()) {
            $invoiceprefix = $this->input->post('invoiceprefix');

            $q_prefix = $this->input->post('q_prefix', true);
            $p_prefix = $this->input->post('p_prefix', true);
            $r_prefix = $this->input->post('r_prefix', true);
            $s_prefix = $this->input->post('s_prefix', true);
            $t_prefix = $this->input->post('t_prefix', true);
            $o_prefix = $this->input->post('o_prefix', true);
            $pos_prefix = $this->input->post('pos_prefix', true);
            $this->settings->update_prefix($invoiceprefix, $q_prefix, $p_prefix, $r_prefix, $s_prefix, $t_prefix, $o_prefix, $pos_prefix);

        } else {

            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Prefix Settings';
            $data['company'] = $this->settings->company_details(1);
            $data['prefix'] = $this->settings->prefix();
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/prefix', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function language()
    {
        $this->li_a = 'localisation';
        $this->load->library("Common");
        if ($this->input->post()) {

            $lang = $this->input->post('language', true);

            $this->settings->update_language(1, $lang);


        } else {

            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Billing & TAX Settings';
            $data['company'] = $this->settings->company_details(1);
            $data['prefix'] = $this->settings->prefix();
            $data['langs'] = $this->common->languages();
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/billing', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function automail()
    {
        $this->li_a = 'billing';
        if ($this->input->post()) {
            $email = $this->input->post('email');
            $sms = $this->input->post('sms');
            $this->settings->update_automail($email, $sms);

        } else {

            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Auto Email SMS Settings';
            $data['auto'] = $this->settings->automail();
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/automail', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function taxslabs()
    {
        $this->li_a = 'tax';
        $data['catlist'] = $this->settings->slabs();
        $head['title'] = "TAX Slabs";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('settings/slabs', $data);
        $this->load->view('fixed/footer');
    }

    public function taxslabs_new()
    {
        $this->li_a = 'tax';
        if ($this->input->post()) {
            $tname = $this->input->post('tname', true);
            $trate = $this->input->post('trate');
            $ttype = $this->input->post('ttype');
            $ttype2 = $this->input->post('ttype2');
            $this->settings->add_slab($tname, $trate, $ttype, $ttype2);

        } else {

            $data['catlist'] = $this->settings->slabs();
            $head['title'] = "TAX Slabs";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/tax_create', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function taxslabs_delete()
    {

        if ($this->input->post()) {
            $id = $this->input->post('deleteid');


            if ($this->settings->delete_slab($id)) {

                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }

        }

    }

    public function logdata()
    {
        $this->li_a = 'advance';
        $data['acts'] = $this->settings->logs();
        $head['title'] = "App Log";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('settings/logs', $data);
        $this->load->view('fixed/footer');
    }


    public function warehouse()
    {
        $this->li_a = 'billing';
        $this->load->model('plugins_model', 'plugins');
        if ($this->input->post()) {
            $wid = $this->input->post('wid');

            $this->plugins->update_api(60, $wid, '', 1, '', '');

        } else {

            $this->db->select('*');
            $this->db->from('geopos_warehouse');

            if ($this->aauth->get_user()->loc) {
                $this->db->where('loc', 0);
                $this->db->or_where('loc', $this->aauth->get_user()->loc);
            }


            $query = $this->db->get();
            $data['warehouses'] = $query->result_array();

            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Default WareHouse';
            $data['ware'] = $this->plugins->universal_api(60);
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/warehouse', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function discship()
    {
        $this->load->model('plugins_model', 'plugins');
        $this->li_a = 'billing';
        $this->load->library("Common");
        $data['discship'] = $this->plugins->universal_api(61);
        if ($this->input->post()) {
            $discstatus = $this->input->post('discstatus');
            $shiptax_type = $this->input->post('shiptax_type');
            $shiptax_rate = $this->input->post('shiptax_rate');
            switch ($discstatus) {


                case 'flat' :
                    $discstatus_name = $this->lang->line('Flat Discount') . ' ' . $this->lang->line('After TAX');
                    break;
                case 'b_p' :
                    $discstatus_name = $this->lang->line('% Discount') . ' ' . $this->lang->line('Before TAX');
                    break;
                case 'bflat' :
                    $discstatus_name = $this->lang->line('Flat Discount') . ' ' . $this->lang->line('Before TAX');
                    break;
                default :
                    $discstatus_name = $this->lang->line('% Discount') . ' ' . $this->lang->line('After TAX');
                    break;
            }
            $this->plugins->update_api(61, $discstatus, $shiptax_rate, 0, $shiptax_type, $discstatus_name);


        } else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Discount & Shipping Settings';
            $data['prefix'] = $this->settings->prefix();
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/discship', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function pos_style()
    {
        $this->li_a = 'billing';
        if ($this->input->post()) {
            $tdirection = $this->input->post('pstyle', true);
            $this->settings->posstyle($tdirection);
        } else {
            $head['title'] = "Pos Style Settings";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/posstyle');
            $this->load->view('fixed/footer');
        }
    }

        public function massage_order()
    {
        $this->li_a = 'billing';
        if ($this->input->post()) {
            $id = 1;
            $msg = $this->input->post('msg_down_order', true);
            $this->settings->update_massage_order($id,$msg);
        } else {
            $head['title'] = $this->lang->line('msg_down_order');
            $head['usernm'] = $this->aauth->get_user()->username;
            
        $data['massage_order'] = $this->settings->get_massage_order();
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/massage_down_order',$data);
            $this->load->view('fixed/footer');
        }
    }


    public function zero_stock()
    {
        $this->load->model('plugins_model', 'plugins');
        $this->li_a = 'billing';

        if ($this->input->post()) {
            $tdirection = $this->input->post('stock', true);
            $this->settings->zerostock($tdirection);
        } else {
            $data['current'] = $this->plugins->universal_api(63);
            $head['title'] = "Product As Service Settings";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/zerostock', $data);
            $this->load->view('fixed/footer');


        }
    }

    public function registration()
    {
        $this->load->model('plugins_model', 'plugins');
        $this->li_a = 'billing';

        if ($this->input->post()) {
            $register = $this->input->post('register', true);
            $email_confrim = $this->input->post('email_conf', true);
            $auto_mail = $this->input->post('automail', true);
            $this->plugins->m_update_api(64, $register, 0, $email_confrim, 0, $auto_mail);
        } else {
            $data['current'] = $this->plugins->universal_api(64);
            $head['title'] = "CRM Settings";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/selfregistration', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function custom_fields()
    {
        $this->li_a = 'advance';
        $data['customfields'] = $this->settings->custom_fields();
        $head['title'] = "Custom Form Fields Settings";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('settings/custom_field', $data);
        $this->load->view('fixed/footer');
    }

    public function add_custom_field()
    {
        $this->li_a = 'advance';
        if ($this->input->post()) {
            $f_name = $this->input->post('f_name', true);
            $f_type = $this->input->post('f_type', true);
            $f_module = $this->input->post('f_module', true);
            $f_view = $this->input->post('f_view', true);
            $f_required = $this->input->post('f_required', true);
            $f_placeholder = $this->input->post('f_placeholder', true);
            $f_description = $this->input->post('f_description', true);
            $this->settings->custom_field_add($f_name, $f_type, $f_module, $f_view, $f_required, $f_placeholder, $f_description);
        } else {
            $head['title'] = "Custom Form Fields Settings";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/field_add');
            $this->load->view('fixed/footer');
        }
    }

    public function edit_custom_field()
    {
        $this->li_a = 'advance';
        if ($this->input->post()) {
            $f_name = $this->input->post('f_name', true);
            $f_view = $this->input->post('f_view', true);
            $f_required = $this->input->post('f_required', true);
            $f_placeholder = $this->input->post('f_placeholder', true);
            $f_description = $this->input->post('f_description', true);
            $id = $this->input->post('fid');
            $this->settings->custom_field_edit($id, $f_name, $f_view, $f_required, $f_placeholder, $f_description);
        } else {
            $id = $this->input->get('id');
            $data['customfields'] = $this->settings->custom_fields($id);
            $head['title'] = "Custom Form Fields Settings";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/field_edit', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function delete_custom_field()
    {
        $id = $this->input->post('deleteid');

        if ($this->db->delete('geopos_custom_fields', array('id' => $id))) {
            $this->db->delete('geopos_custom_data', array('field_id' => $id));
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    public function print_invoice()
    {
        $this->li_a = 'templates';
        if ($this->input->post()) {
            $tdirection = $this->input->post('pstyle', true);
            $this->settings->printinvoice($tdirection);
        } else {
            $head['title'] = "Print Invoice Style Settings";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/printinvoice');
            $this->load->view('fixed/footer');
        }
    }

    public function dual_entry()
    {
        $this->load->model('accounts_model');
        $data['acclist'] = $this->accounts_model->accountslist($this->aauth->get_user()->loc);
        $this->load->model('plugins_model', 'plugins');
        $this->li_a = 'billing';
        $this->load->library("Common");
        $data['discship'] = $this->plugins->universal_api(65);
        if ($this->input->post()) {
            $dual = $this->input->post('dual');
            $dual_inv = $this->input->post('dual_inv');
            $dual_pur = $this->input->post('dual_pur');
            $this->plugins->m_update_api(65, $dual, $dual_inv, $dual_pur);
        } else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Dual Entry Settings';
            $data['prefix'] = $this->settings->prefix();
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/dual_entry', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function misc_automail()
    {
        $this->load->model('plugins_model', 'plugins');
        $this->li_a = 'billing';
        if ($this->input->post()) {
            $email = $this->input->post('email');
            $td_email = $this->input->post('td_email');
            $id_email = $this->input->post('id_email');
            $send_email = $this->input->post('send');
            $this->plugins->m_update_api(66, $email, $td_email, $send_email, $id_email);
        } else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Auto Email Settings';
            $data['auto'] = $this->plugins->universal_api(66);
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/misc_automail', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function allow_custom()
    {
        $enable = $this->input->post('enable');
        if ($enable != CUSTOM) {
            $config_file_path = APPPATH . "config/constants.php";
            $config_file = file_get_contents($config_file_path);
            $config_file = str_replace("('CUSTOM', '" . CUSTOM . "')", "('CUSTOM', '$enable')", $config_file);
            file_put_contents($config_file_path, $config_file);
        }
    }

    public function debug()
    {
        $this->li_a = 'billing';
        if ($this->input->post()) {
            $debug = $this->input->post('debug', true);
            $this->settings->debug($debug);
        } else {
            $head['title'] = "App Debug Settings";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/debug');
            $this->load->view('fixed/footer');
        }
    }

    public function server()
    {
        phpinfo();
    }

    public function db_error()
    {
        $query = $this->db->query("SELECT i.id, SUM(i.total) AS total,i.status,i.i_class,c.name,c.picture,i.csd
FROM geopos_invoices AS i LEFT JOIN geopos_customers AS c ON i.csd=c.id GROUP BY  i.csd ORDER BY  i.id  LIMIT 10");
        $error = $this->db->error();
        if (@$error['code']) {
            echo ' Critical Error: SQL Strict Mode Enabled! Please disable it to run app properly!';
            print_r($error);
        } else {
            echo ' Your SQL service is running well!';
        }
        $result = $query->result_array();
    }

    public function switch_location()
    {
        $id = $this->input->get('id', true);
        $data = array(
            'loc' => $id
        );
        $this->db->set($data);
        $this->db->where('id', $this->aauth->get_user()->id);
       $this->db->update('geopos_users');
       redirect(base_url('dashboard'));
    }
}