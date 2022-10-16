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

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'third_party/vendor/autoload.php';
require_once APPPATH . 'third_party/qrcode/vendor/autoload.php';
require_once APPPATH . 'libraries/WebClientPrints/WebClientPrint.php';
require_once APPPATH . 'libraries/salla/vendor/autoload.php';
require __DIR__.'/../models/AccountingModel.php';   
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\DummyPrintConnector;
use Mike42\Escpos\EscposImage;

use Salla\ZATCA\GenerateQrCode;
use Salla\ZATCA\Tags\InvoiceDate;
use Salla\ZATCA\Tags\InvoiceTaxAmount;
use Salla\ZATCA\Tags\InvoiceTotalAmount;
use Salla\ZATCA\Tags\Seller;
use Salla\ZATCA\Tags\TaxNumber;

use Omnipay\Omnipay;
use Endroid\QrCode\QrCode;
use Twilio\Rest\Client; 

class Pos_invoices extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('pos_invoices_model', 'invocies');
        $this->load->library("Aauth");
        $this->load->library("Registerlog");
        // $this->load->library("WebClientPrint");
        $this->load->library("Common");
        $this->load->model('register_model', 'register');
        $this->load->model('Settings_model', 'settings');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(1)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        if ($this->aauth->get_user()->roleid == 2) {
            $this->limited = $this->aauth->get_user()->id;
        } else {
            $this->limited = '';
        }
        $this->load->library("Custom");
        $this->li_a = 'sales';
    }

    //create invoice
    public function create()
    {

        if (!$this->registerlog->check($this->aauth->get_user()->id)) {
            redirect('register/create');
        }
        $this->load->model('customers_model', 'customers');
        $this->load->model('categories_model');
        $this->load->model('plugins_model', 'plugins');
        $this->load->library("Common");
        $data['taxlist'] = $this->common->taxlist($this->config->item('tax'));
        $data['gateway'] = $this->invocies->gateway_list('Yes');
        $data['exchange'] = $this->plugins->universal_api(5);
        $data['enable_card'] = $this->plugins->universal_api(54);
        $data['customergrouplist'] = $this->customers->group_list();
        $data['lastinvoice'] = $this->invocies->lastinvoice();
        $data['draft_list'] = $this->invocies->drafts();
        $data['warehouse'] = $this->invocies->warehouses();
        $data['terms'] = $this->invocies->billingterms();
        $data['currency'] = $this->invocies->currencies();
        $head['title'] = "New Invoice";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['cat'] = $this->categories_model->category_list();
        $data['taxdetails'] = $this->common->taxdetail();
        $data['acc_list'] = $this->invocies->accountslist();

            
        if ($this->input->get('v2')) {  
            $head['s_mode'] = false;    
            $this->load->view('fixed/header-pos', $head);   
            $this->load->view('pos/newinvoice_v2_mobile', $data);   
        }elseif(POSV == 2) {
            $head['s_mode'] = false;
            $this->load->view('fixed/header-pos', $head);
            $this->load->view('pos/newinvoice_v2', $data);
        } else {
            $head['s_mode'] = true;
            $this->load->view('fixed/header-pos', $head);
            $this->load->view('pos/newinvoice', $data);
        }
        $this->load->view('fixed/footer-pos');
    }


    public function draft()
    {
        $this->load->model('categories_model');
        $data['gateway'] = $this->invocies->gateway_list('Yes');
        $tid = $this->input->get('id');
        $data['id'] = $tid;
        $data['title'] = "New Invoice";
        $this->load->model('customers_model', 'customers');
        $data['customergrouplist'] = $this->customers->group_list();
        $data['terms'] = $this->invocies->billingterms();
        $data['currency'] = $this->invocies->currencies();
        $data['invoice'] = $this->invocies->draft_details($tid, $this->limited);
        if ($data['invoice']['id']) $data['products'] = $this->invocies->draft_products($tid);
        $head['title'] = "Edit Invoice #$tid";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['warehouse'] = $this->invocies->warehouses();
        $this->load->model('plugins_model', 'plugins');
        $data['exchange'] = $this->plugins->universal_api(5);
        $data['cat'] = $this->categories_model->category_list();
        $data['lastinvoice'] = $this->invocies->lastinvoice();
        $data['taxdetails'] = $this->common->taxdetail();
        $data['taxlist'] = $this->common->taxlist($this->config->item('tax'));

        if ($this->input->get('v2') OR POSV == 2) {
            $head['s_mode'] = false;
            $this->load->view('fixed/header-pos', $head);
            if ($data['invoice']['id']) $this->load->view('pos/draft', $data);
        } else {
            $head['s_mode'] = false;
            $this->load->view('fixed/header-pos', $head);
            if ($data['invoice']['id']) $this->load->view('pos/draft', $data);
        }
        $this->load->view('fixed/footer-pos');
    }


    //edit invoice
    public function edit()
    {
        if (!$this->registerlog->check($this->aauth->get_user()->id)) {
            redirect('register/create');
        }
        $head['s_mode'] = false;
        $this->load->model('categories_model');
        $data['gateway'] = $this->invocies->gateway_list('Yes');
        $tid = $this->input->get('id');
        $hash_code = $this->input->get('ref');
        $data['id'] = $tid;
        $data['ref'] = $hash_code;

        $this->load->model('customers_model', 'customers');
        $data['customergrouplist'] = $this->customers->group_list();
        $data['terms'] = $this->invocies->billingterms();
        $data['currency'] = $this->invocies->currencies();
        $data['invoice'] = $this->invocies->invoice_details($tid, $this->limited,$hash_code);
        if ($data['invoice']['id']) $data['products'] = $this->invocies->invoice_products($tid);
        $head['title'] = "Edit Invoice #$tid";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['warehouse'] = $this->invocies->warehouses();
        $this->load->model('plugins_model', 'plugins');
        $data['exchange'] = $this->plugins->universal_api(5);
        $data['cat'] = $this->categories_model->category_list();
        $this->load->library("Common");
        $data['taxlist'] = $this->common->taxlist_edit($data['invoice']['taxstatus']);
        $this->load->view('fixed/header-pos', $head);
        if ($data['invoice']['id']) $this->load->view('pos/edit', $data);
        $this->load->view('fixed/footer-pos');

    }

    //invoices list
    public function index()
    {
        $head['title'] = "Manage Invoices";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('pos/invoices');
        $this->load->view('fixed/footer');
    }


    //action
    public function action()
    {

        $ptype = $this->input->post('type');
        $coupon = $this->input->post('coupon');
        $notes = $this->input->post('notes', true);
        $coupon_amount = 0;
        $coupon_n = '';
        $customer_id = $this->input->post('customer_id');
        $invocieno = $this->input->post('invocieno');
        $invoicedate = $this->input->post('invoicedate');
        $invocieduedate = $this->input->post('invocieduedate');
        $tax = $this->input->post('tax_handle');
        $total_tax = 0;
       $currency = $this->input->post('mcurrency'); 
        $amount_card=rev_amountExchange_s($this->input->post('amount_card'), $currency, $this->aauth->get_user()->loc); 
        $amount_cash=rev_amountExchange_s($this->input->post('amount_cash'), $currency, $this->aauth->get_user()->loc);

        $hash_code = getHashCode();
        $discountFormat = $this->input->post('discountFormat');
        $pterms = $this->input->post('pterms');
        $currency = $this->input->post('mcurrency');
        $total_discount = rev_amountExchange_s($this->input->post('after_disc'), $currency, $this->aauth->get_user()->loc);
        $disc_val = numberClean($this->input->post('disc_val'));
        $ship_taxtype = $this->input->post('ship_taxtype');
        $subtotal = rev_amountExchange_s($this->input->post('subtotal'), $currency, $this->aauth->get_user()->loc);
        $shipping = rev_amountExchange_s($this->input->post('shipping'), $currency, $this->aauth->get_user()->loc);
        $shipping_tax = rev_amountExchange_s($this->input->post('ship_tax'), $currency, $this->aauth->get_user()->loc);
        if ($ship_taxtype == 'incl') @$shipping = $shipping - $shipping_tax;
        $refer = $this->input->post('refer', true);
        $total = rev_amountExchange_s($this->input->post('total'), $currency, $this->aauth->get_user()->loc);
        $st_c = 0;
        $print_now = $this->input->post('printnow');
        $status = $this->registerlog->check($this->aauth->get_user()->id);
        $register_id=$status['id'];
        if ($ptype == 4) {
            $p_amount = rev_amountExchange_s($this->input->post('p_amount'), $currency, $this->aauth->get_user()->loc);
            $pmethod = $this->input->post('p_method');

            $c_amt = $p_amount - $total;
            if ($c_amt == 0.00) {
                $status = 'Paid';
                $pamnt = $total;
            } elseif ($c_amt < 0.00) {
                $status = 'Partial';
                if ($p_amount == 0.00) $status = 'Due';
                $pamnt = $p_amount;
                $c_amt = 0;
            } else {
                $status = 'Paid';
                $pamnt = $total;
                $roundoff = $this->custom->api_config(4);
                if ($roundoff['other']) $pamnt = round($total, $roundoff['active'], constant($roundoff['other']));
            }
            $i = 0;
            if ($discountFormat == '0') {
                $discstatus = 0;
            } else {
                $discstatus = 1;
            }
            if ($customer_id == 0) {
                echo json_encode(array('status' => 'Error', 'message' =>
                    $this->lang->line('Please add a new client')));
                exit;
            }
            $this->db->trans_start();
            //products
            $transok = true;
            $this->load->library("Common");
            //Invoice Data
            $bill_date = datefordatabase($invoicedate);
            $this->load->helper('date');
             $this->load->helper('my');  
            $format = "%h:%i %A";
            $time= mdate($format);
            
            $bill_due_date = datefordatabase($invocieduedate);
            $promo_flag = false;
            if ($coupon) {
                $this->db->select('*');
                $this->db->from('geopos_promo');
                $this->db->where('code', $coupon);
                $query = $this->db->get();
                $result_c = $query->row_array();
                if ($result_c['active'] == 0 && $result_c['available'] > 0) {
                    $promo_flag = true;
                    $amount = $result_c['amount'];
                    $notes .= '-' . $this->input->post('i_coupon');
                    $total_discount += $amount;
                }
            }
            $data = array('tid' => $invocieno, 'invoicedate' => $bill_date,'register_id'=>$register_id,'invoicetime'=>$time, 'invoiceduedate' => $bill_due_date, 'subtotal' => $subtotal ,'amount_card' => $amount_card, 'amount_cash' => $amount_cash, 'shipping' => $shipping, 'ship_tax' => $shipping_tax, 'ship_tax_type' => $ship_taxtype, 'discount_rate' => $disc_val, 'total' => $total, 'pmethod' => $pmethod, 'notes' => $notes, 'status' => $status, 'csd' => $customer_id, 'eid' => $this->aauth->get_user()->id, 'pamnt' => 0, 'taxstatus' => $tax, 'discstatus' => $discstatus, 'format_discount' => $discountFormat, 'refer' => $refer, 'term' => $pterms, 'multi' => $currency, 'i_class' => 1, 'loc' => $this->aauth->get_user()->loc, 'hash_code' => $hash_code,'company_id'=>getCompanyId());
          //$err =   $this->db->insert('geopos_invoices', $data);
         

            if ($this->db->insert('geopos_invoices', $data)) {
                $invocieno = $this->db->insert_id();
                $invocieno_n = $invocieno;
                $invocieno2 = $invocieno;
                
                $pid = $this->input->post('pid');
                $productlist = array();
                $prodindex = 0;
                $itc = 0;
                $product_id = $this->input->post('pid');
                $product_name1 = $this->input->post('product_name', true);
                $product_qty = $this->input->post('product_qty');
                $product_price = $this->input->post('product_price');
                $product_tax = $this->input->post('product_tax');
                $product_discount = $this->input->post('product_discount');
                $product_subtotal = $this->input->post('product_subtotal');
                $ptotal_tax = $this->input->post('taxa');
                $ptotal_disc = $this->input->post('disca');
                $product_des = $this->input->post('product_description', true);
                $product_unit = $this->input->post('unit');
                $product_hsn = $this->input->post('hsn', true);
                $product_alert = $this->input->post('alert');

                foreach ($pid as $key => $value) {


                    $total_discount += numberClean(@$ptotal_disc[$key]);
                    $total_tax += numberClean($ptotal_tax[$key]);
                    if(!isset($product_des[$key])){
                        $product_des[$key] = 0;
                    }
                    $data = array(
                        'tid' => $invocieno,
                        'pid' => $product_id[$key],
                        'product' => $product_name1[$key],
                        'code' => $product_hsn[$key],
                        'qty' => numberClean($product_qty[$key]),
                        'price' => rev_amountExchange_s($product_price[$key], $currency, $this->aauth->get_user()->loc),
                        'tax' => numberClean($product_tax[$key]),
                        'discount' => numberClean($product_discount[$key]),
                        'subtotal' => rev_amountExchange_s($product_subtotal[$key], $currency, $this->aauth->get_user()->loc),
                        'totaltax' => rev_amountExchange_s($ptotal_tax[$key], $currency, $this->aauth->get_user()->loc),
                        'totaldiscount' => rev_amountExchange_s($ptotal_disc[$key], $currency, $this->aauth->get_user()->loc),
                        'product_des' => '',
                        'i_class' => 1,
                        'unit' => $product_unit[$key],
                        'company_id'=>getCompanyId(),'hash_code'=>getHashCode() 
                    );

                    $flag = true;
                    $productlist[$prodindex] = $data;
                    $i++;
                    $prodindex++;

                    $amt = numberClean($product_qty[$key]);
                    if ($product_id[$key] > 0) {
                        $this->db->set('qty', "qty-$amt", FALSE);
                        $this->db->where('pid', $product_id[$key]);
                        $this->db->where('company_id', getCompanyId());
                        $this->db->update('geopos_products');
                        /*if ((numberClean($product_alert[$key]) - $amt) < 0 AND $st_c == 0 AND $this->common->zero_stock()) {
                            echo json_encode(array('status' => 'Error', 'message' => 'Product - <strong>' . $product_name1[$key] . "</strong> - Low quantity. Available stock is  " . $product_alert[$key]));
                            $transok = false;
                            $st_c = 1;
                        }*/

                        $this->db->select('*');
                        $this->db->from('geopos_products');
                        $this->db->where('pid', $product_id[$key]);
                        $query = $this->db->get();
                        $product = $query->row_array();
                        if ($product['qty'] < 0){
                            $this->db->set('qty', "0", FALSE);
                            $this->db->where('pid', $product_id[$key]);
                            $this->db->update('geopos_products');
                        }

                    }
                    $itc += $amt;


                }

                if ($prodindex > 0) {
                   $this->db->insert_batch('geopos_invoice_items', $productlist);
                   
                    $this->db->set(array('discount' => rev_amountExchange_s(amountFormat_general($total_discount), $currency, $this->aauth->get_user()->loc), 'tax' => rev_amountExchange_s(amountFormat_general($total_tax), $currency, $this->aauth->get_user()->loc), 'items' => $itc));
                    //,'hash_code' => getHashCode()
                    $this->db->where('id', $invocieno);
                    $this->db->where('company_id', getCompanyId());
                    $this->db->update('geopos_invoices');

                } else {
                    echo json_encode(array('status' => 'Error', 'message' =>
                        "Please choose product from product list. Go to Item manager section if you have not added the products."));
                    $transok = false;
                }

                $validtoken = hash_hmac('ripemd160', $invocieno, $this->config->item('encryption_key'));
                $link = base_url('billing/view?id=' . $invocieno . '&token=' . $validtoken.'&ref='.$hash_code);
                if ($transok) {
                    $this->load->library("Printer");
                    $printer = $this->printer->check($this->aauth->get_user()->loc);
                    $p_tid = 'thermal_p';
                    if ($printer['val2'] == 'server') $p_tid = 'thermal_server';
                    if (!$print_now) {
                    echo json_encode(array('status' => 'Success' , 'message' =>
                        $this->lang->line('Invoice Success') . " <a target='_blank' href='thermal_pdf?id=$invocieno&ref=".$hash_code."' class='btn btn-blue btn-lg'><span class='fa fa-ticket' aria-hidden='true'></span> PDF  </a> &nbsp; &nbsp;   <a id='$p_tid' data-ptref='".$hash_code."'  data-ptid='$invocieno' data-url='" . $printer['val3'] . "'  class='btn btn-info btn-lg white'><span class='fa fa-ticket' aria-hidden='true'></span> " . $this->lang->line('Thermal Printer') . "  </a> &nbsp; &nbsp; <a target='_blank' href='printinvoice?id=$invocieno&ref=".$hash_code."' class='btn btn-blue btn-lg'><span class='fa fa-print' aria-hidden='true'></span> A4  </a> &nbsp; &nbsp; <a href='view?id=$invocieno&ref=".$hash_code."' class='btn btn-purple btn-lg'><span class='fa fa-eye' aria-hidden='true'></span> " . $this->lang->line('View') . "  </a> &nbsp; &nbsp; <a href='$link' class='btn btn-blue-grey btn-lg'><span class='fa fa-globe' aria-hidden='true'></span> " . $this->lang->line('Public View') . " </a> &nbsp;<a href='create' class='btn btn-flickr btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span> " . $this->lang->line('Create') . "  </a>",'ref'=>$hash_code));
                    }

                    }
                $this->load->model('billing_model', 'billing');
                $tnote = '#' . $invocieno_n . '-' . $pmethod;
                switch ($pmethod) {
                    case 'Cash' :
                        $r_amt1 = $pamnt;
                        $r_amt2 = 0;
                        $r_amt3 = 0;
                        $r_amt4 = 0;
                        break;
                    case 'Card Swipe' :
                        $r_amt1 = 0;
                        $r_amt2 = $pamnt;
                        $r_amt3 = 0;
                        $r_amt4 = 0;
                        break;
                    case 'Bank' :
                        $r_amt1 = 0;
                        $r_amt2 = 0;
                        $r_amt3 = $pamnt;
                        $r_amt4 = 0;
                        break;
                         case 'Cash Card' :
                        $r_amt1 = $amount_cash;    
                        $r_amt2 = $amount_card; 
                        $r_amt3 = 0;    
                        $r_amt4 = 0;
                        break;
                }
              /*  if ($pamnt > 0) $this->billing->paynow($invocieno, $pamnt, $tnote, $pmethod, $this->aauth->get_user()->loc, $bill_date);
                $this->registerlog->update($this->aauth->get_user()->id, $r_amt1, $r_amt2, $r_amt3,$r_amt4, 0, $c_amt);
                if ($promo_flag) {
                    $cqty = $result_c['available'] - 1;
                    if ($cqty > 0) {
                        $data = array('available' => $cqty);
                    } else {
                        $data = array('active' => 1, 'available' => $cqty);
                    }
                    $amount = $result_c['amount'];
                    $this->db->set($data);
                    $this->db->where('id', $result_c['id']);
                    $this->db->where('company_id', getCompanyId());
                    $this->db->update('geopos_promo');
                }
            } else {
                
                echo json_encode(array('status' => 'Error', 'message' =>
                    "Invalid Entry!"));
                $transok = false;
            }*/

                    $paynow = false;
                if ($pamnt > 0) {
                    ###########
                    $accounting = new AccountingModel();
                    $setting = $accounting->setting();
                    if($setting['sales_credit_to']){
                        $accounting->TransactionFire($setting['sales_credit_to'],'accounts',0,$total);
                        if($setting['sales_vat_to'])
                            $accounting->TransactionFire($setting['sales_vat_to'],'accounts',0,$total/100*15);
                        $accounting->updateAccountBalance($setting['sales_credit_to']);
                    }
                    if ($pmethod == "Cash"){
                        if($setting['cash_payment_to']){
                            $accounting->TransactionFire($setting['cash_payment_to'],'accounts',$total,0,'payment for invoice',$invocieno);
                            $accounting->updateAccountBalance($setting['cash_payment_to']);
                        }
                    }else{
                        if($setting['bank_payment_to']){
                            $accounting->TransactionFire($setting['bank_payment_to'],'accounts',$total,0,'payment for invoice',$invocieno);
                            $accounting->updateAccountBalance($setting['bank_payment_to']);
                        }
                    }

//                    $paynow = $this->billing->paynow($invocieno, $pamnt, $tnote, $pmethod, $this->aauth->get_user()->loc, $bill_date);
                }


                     $this->registerlog->update($this->aauth->get_user()->id, $r_amt1, $r_amt2, $r_amt3,$r_amt4, 0, $c_amt);
                if ($promo_flag) {
                    $cqty = $result_c['available'] - 1;
                    if ($cqty > 0) {
                        $data = array('available' => $cqty);
                    } else {
                        $data = array('active' => 1, 'available' => $cqty);
                    }
                    $amount = $result_c['amount'];
                    $this->db->set($data);
                    $this->db->where('id', $result_c['id']);
                    $this->db->update('geopos_promo');
                }
            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    "Invalid Entry!"));
                $transok = false;
            }


            if ($transok) {
                $this->db->trans_complete();
            } else {
                
                $this->db->trans_rollback();
            }

        } elseif ($ptype == 2) {

            ///card section
            $discountFormat = $this->input->post('discountFormat');
            $pterms = $this->input->post('pterms');
            $currency = $this->input->post('mcurrency');
            $i = 0;
            if ($discountFormat == '0') {
                $discstatus = 0;
            } else {
                $discstatus = 1;
            }
            if ($customer_id == 0) {
                echo json_encode(array('status' => 'Error', 'message' =>
                    $this->lang->line('Please add a new client')));
                exit;
            }
            $this->db->trans_start();
            //products
            $transok = true;
            //Invoice Data
            $bill_date = datefordatabase($invoicedate);
            $bill_due_date = datefordatabase($invocieduedate);
            $promo_flag = false;
            if ($coupon) {
                $this->db->select('*');
                $this->db->from('geopos_promo');
                $this->db->where('code', $coupon);
                $this->db->where('company_id', getCompanyId());
                $query = $this->db->get();
                $result_c = $query->row_array();
                if ($result_c['active'] == 0 && $result_c['available'] > 0) {
                    $promo_flag = true;
                    $amount = $result_c['amount'];
                    $notes .= '-' . $this->input->post('i_coupon');
                    $total_discount += $amount;
                }
            }
            $data = array('tid' => $invocieno, 'invoicedate' => $bill_date, 'invoiceduedate' => $bill_due_date, 'subtotal' => $subtotal, 'shipping' => $shipping, 'total' => $total, 'notes' => $notes, 'csd' => $customer_id, 'eid' => $this->aauth->get_user()->id, 'taxstatus' => $tax, 'discstatus' => $discstatus, 'format_discount' => $discountFormat, 'refer' => $refer, 'term' => $pterms, 'multi' => $currency, 'i_class' => 1, 'loc' => $this->aauth->get_user()->loc, 'hash_code' => $hash_code,'company_id'=>getCompanyId());
            $invoice_true = false;
            if ($this->db->insert('geopos_invoices', $data)) {
                $invoice_true = true;
                $tid = $invocieno;
                $invocieno2 = $invocieno;
                $invocieno = $this->db->insert_id();
                $pid = $this->input->post('pid');
                $productlist = array();
                $prodindex = 0;
                $itc = 0;
                $product_id = $this->input->post('pid');
                $product_name1 = $this->input->post('product_name', true);
                $product_qty = $this->input->post('product_qty');
                $product_price = $this->input->post('product_price');
                $product_tax = $this->input->post('product_tax');
                $product_discount = $this->input->post('product_discount');
                $product_subtotal = $this->input->post('product_subtotal');
                $ptotal_tax = $this->input->post('taxa');
                $ptotal_disc = $this->input->post('disca');
                $product_des = $this->input->post('product_description', true);
                $product_unit = $this->input->post('unit');
                $product_hsn = $this->input->post('hsn');
                $product_alert = $this->input->post('alert');
                foreach ($pid as $key => $value) {
                    $total_discount += numberClean(@$ptotal_disc[$key]);
                    $total_tax += numberClean($ptotal_tax[$key]);
                    $data = array(
                        'tid' => $invocieno,
                        'pid' => $product_id[$key],
                        'product' => $product_name1[$key],
                        'code' => $product_hsn[$key],
                        'qty' => numberClean($product_qty[$key]),
                        'price' => rev_amountExchange_s($product_price[$key], $currency, $this->aauth->get_user()->loc),
                        'tax' => numberClean($product_tax[$key]),
                        'discount' => numberClean($product_discount[$key]),
                        'subtotal' => rev_amountExchange_s($product_subtotal[$key], $currency, $this->aauth->get_user()->loc),
                        'totaltax' => rev_amountExchange_s($ptotal_tax[$key], $currency, $this->aauth->get_user()->loc),
                        'totaldiscount' => rev_amountExchange_s($ptotal_disc[$key], $currency, $this->aauth->get_user()->loc),
                        'product_des' => $product_des[$key],
                        'i_class' => 1,
                        'unit' => $product_unit[$key],
                        'company_id'=>getCompanyId(),
                        'hash_code'=>getHashCode() 
                    );
                    $productlist[$prodindex] = $data;
                    $i++;
                    $prodindex++;
                    $amt = numberClean($product_qty[$key]);
                    if ($product_id[$key] > 0) {
                        $this->db->set('qty', "qty-$amt", FALSE);
                        $this->db->where('company_id', getCompanyId());
                        $this->db->where('pid', $product_id[$key]);
                        $this->db->update('geopos_products');
                       /* if ((numberClean($product_alert[$key]) - $amt) < 0 AND $st_c == 0 AND $this->common->zero_stock()) {
                            echo json_encode(array('status' => 'Error', 'message' => 'Product - <strong>' . $product_name1[$key] . "</strong> - Low quantity. Available stock is  " . $product_alert[$key]));
                            $transok = false;
                            $st_c = 1;
                        }*/

                                $this->db->select('*');
                        $this->db->from('geopos_products');
                        $this->db->where('pid', $product_id[$key]);
                        $query = $this->db->get();
                        $product = $query->row_array();
                        if ($product['qty'] < 0){
                            $this->db->set('qty', "0", FALSE);
                            $this->db->where('pid', $product_id[$key]);
                            $this->db->update('geopos_products');
                            
                    }
                    $itc += $amt;
                }
                if ($prodindex > 0) {
                    $this->db->insert_batch('geopos_invoice_items', $productlist);
                } else {
                    echo json_encode(array('status' => 'Error', 'message' =>
                        "Please choose product from product list. Go to Item manager section if you have not added the products."));
                    $transok = false;
                }
                $validtoken = hash_hmac('ripemd160', $invocieno, $this->config->item('encryption_key'));
                $link = base_url('billing/view?id=' . $invocieno . '&token=' . $validtoken.'&ref='.$hash_code);
                if ($promo_flag) {
                    $cqty = $result_c['available'] - 1;
                    if ($cqty > 0) {
                        $data = array('available' => $cqty);
                    } else {
                        $data = array('active' => 1, 'available' => $cqty);
                    }

                    $this->db->set($data);
                    $this->db->where('id', $result_c['id']);
                    $this->db->where('company_id', getCompanyId());
                    $this->db->update('geopos_promo');

                    if ($result_c['reflect'] > 0) {
                        $data = array(
                            'payerid' => 0,
                            'payer' => $this->lang->line('Coupon') . '-' . $result_c['code'],
                            'acid' => $result_c['reflect'],
                            'account' => 'Promo',
                            'date' => date('Y-m-d'),
                            'debit' => 0,
                            'credit' => $amount,
                            'type' => 'Income',
                            'cat' => $this->lang->line('Coupon'),
                            'method' => 'Transfer',
                            'eid' => $this->aauth->get_user()->id,
                            'note' => $this->lang->line('Coupon') . ' ' . $this->lang->line('Delete') . ' ' . $this->lang->line('Qty') . '-' . $result_c['available'],
                            'loc' => $this->aauth->get_user()->loc,'company_id'=>getCompanyId(),'hash_code'=>getHashCode() 
                        );
                        $this->db->set('lastbal', "lastbal+$amount", FALSE);
                        $this->db->where('id', $result_c['reflect']);
                        $this->db->where('company_id', getCompanyId());
                        $this->db->update('geopos_accounts');
                        $this->db->insert('geopos_transactions', $data);
                    }
                }

            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    "Invalid Entry!"));
                $transok = false;
            }


            //card process
            //card process

            if ($invoice_true) {
                $gateway = $this->input->post('gateway', true);
                setcookie("pos_set", base_url('pos_invoices/view?id=' . $invocieno.'&ref='.$hash_code), time() + 30 * 24 * 60 * 60, '/');
                $validtoken = hash_hmac('ripemd160', $invocieno, $this->config->item('encryption_key'));
                $quckpay = base_url() . "billing/card?id=$invocieno&itype=inv&token=$validtoken&gid=$gateway&ref=".$hash_code;

                if ($transok) echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Invoice Success') . " <script type='text/javascript' >window.location.replace('$quckpay');</script><a target='_blank' href='$quckpay' class='btn btn-blue btn-lg'><span class='icon-printer' aria-hidden='true'></span> " . $this->lang->line('Pay') . "  </a> &nbsp; &nbsp;    <a target='_blank' href='thermal_pdf?id=$invocieno&ref='".$hash_code."' class='btn btn-blue btn-lg'><span class='icon-printer' aria-hidden='true'></span> " . $this->lang->line('Print') . "  </a> &nbsp; &nbsp;    &nbsp; &nbsp; <a href='view?id=$invocieno&ref=".$hash_code."' class='btn btn-purple btn-lg'><span class='icon-file-text2' aria-hidden='true'></span> " . $this->lang->line('View') . "  </a> &nbsp; &nbsp; <a href='$link' class='btn btn-blue-grey btn-lg'><span class='icon-earth' aria-hidden='true'></span> " . $this->lang->line('Public View') . " </a> <a href='create' class='btn btn-amber btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span> " . $this->lang->line('Create') . "  </a>"));
            }

            if ($transok) {
                $this->db->trans_complete();
            } else {
                $this->db->trans_rollback();
            }
            //var_dump("expresddsion");
        } else {
           //  var_dump("expresddsissson");
//draft
            $p_amount = 0;
            $pmethod = $this->input->post('p_method', true);

            $c_amt = @$p_amount - $total;
            if ($c_amt == 0.00) {
                $status = 'Paid';
                $pamnt = $total;
            } elseif ($c_amt < 0.00) {
                $status = 'Partial';
                $pamnt = $p_amount;


            } else {
                $status = 'Paid';
                $pamnt = $total;
            }


            $i = 0;
            if ($discountFormat == '0') {
                $discstatus = 0;
            } else {
                $discstatus = 1;
            }

            if ($customer_id == 0) {
                echo json_encode(array('status' => 'Error', 'message' =>
                    $this->lang->line('Please add a new client')));
                exit;
            }
            $this->db->trans_start();
            //products
            $transok = true;
            //Invoice Data
            $bill_date = datefordatabase($invoicedate);
            $bill_due_date = datefordatabase($invocieduedate);
            $promo_flag = false;
            $data = array('tid' => $invocieno, 'invoicedate' => $bill_date, 'invoiceduedate' => $bill_due_date, 'subtotal' => $subtotal, 'shipping' => $shipping, 'ship_tax' => $shipping_tax, 'ship_tax_type' => $ship_taxtype, 'total' => $total, 'pmethod' => $pmethod, 'notes' => $notes, 'status' => $status, 'csd' => $customer_id, 'eid' => $this->aauth->get_user()->id, 'pamnt' => 0, 'taxstatus' => $tax, 'discstatus' => $discstatus, 'format_discount' => $discountFormat, 'refer' => $refer, 'term' => $pterms, 'multi' => $currency, 'i_class' => 1, 'loc' => $this->aauth->get_user()->loc,'company_id'=>getCompanyId(),'hash_code'=>$hash_code);
            if ($this->db->insert('geopos_draft', $data)) {
                $invocieno2 = $invocieno;
                $invocieno = $this->db->insert_id();
                $pid = $this->input->post('pid');
                $productlist = array();
                $prodindex = 0;
                $itc = 0;

                $product_id = $this->input->post('pid');
                $product_name1 = $this->input->post('product_name', true);
                $product_qty = $this->input->post('product_qty');
                $product_price = $this->input->post('product_price');
                $product_tax = $this->input->post('product_tax');
                $product_discount = $this->input->post('product_discount');
                $product_subtotal = $this->input->post('product_subtotal');
                $ptotal_tax = $this->input->post('taxa');
                $ptotal_disc = $this->input->post('disca');
                $product_des = $this->input->post('product_description', true);
                $product_unit = $this->input->post('unit');
                $product_hsn = $this->input->post('hsn');


                foreach ($pid as $key => $value) {


                    $total_discount += numberClean(@$ptotal_disc[$key]);
                    $total_tax += numberClean($ptotal_tax[$key]);

                    $data = array(
                        'tid' => $invocieno,
                        'pid' => $product_id[$key],
                        'product' => $product_name1[$key],
                        'code' => $product_hsn[$key],
                        'qty' => numberClean($product_qty[$key]),
                        'price' => rev_amountExchange_s($product_price[$key], $currency, $this->aauth->get_user()->loc),
                        'tax' => numberClean($product_tax[$key]),
                        'discount' => numberClean($product_discount[$key]),
                        'subtotal' => rev_amountExchange_s($product_subtotal[$key], $currency, $this->aauth->get_user()->loc),
                        'totaltax' => rev_amountExchange_s($ptotal_tax[$key], $currency, $this->aauth->get_user()->loc),
                        'totaldiscount' => rev_amountExchange_s($ptotal_disc[$key], $currency, $this->aauth->get_user()->loc),
                        'product_des' => $product_des[$key],
                        'i_class' => 1,
                        'unit' => $product_unit[$key],'company_id'=>getCompanyId(),'hash_code'=>getHashCode() 
                    );

                    $flag = true;
                    $productlist[$prodindex] = $data;
                    $i++;
                    $prodindex++;
                    $amt = numberClean($product_qty[$key]);
                    $itc += $amt;
                }

                if ($prodindex > 0) {
                    $this->db->insert_batch('geopos_draft_items', $productlist);
                    $this->db->set(array('discount' => rev_amountExchange_s(amountFormat_general($total_discount), $currency, $this->aauth->get_user()->loc), 'tax' => rev_amountExchange_s(amountFormat_general($total_tax), $currency, $this->aauth->get_user()->loc), 'items' => $itc));
                    $this->db->where('id', $invocieno);
                    $this->db->where('company_id', getCompanyId());
                    $this->db->update('geopos_draft');

                } else {
                    echo json_encode(array('status' => 'Error', 'message' =>
                        "Please choose product from product list. Go to Item manager section if you have not added the products."));
                    $transok = false;
                }

                $validtoken = hash_hmac('ripemd160', $invocieno, $this->config->item('encryption_key'));
                $link = base_url('billing/view?id=' . $invocieno . '&token=' . $validtoken.'&ref='.$hash_code);
                if ($transok) echo json_encode(array('status' => 'Success', 'message' =>
                    $this->lang->line('Draft Success') . " <a href='create' class='btn btn-info btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span> " . $this->lang->line('New') . "  </a>"));

            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    "Invalid Entry!"));
                $transok = false;
            }
            if ($transok) {
                $this->db->trans_complete();
            } else {
                $this->db->trans_rollback();
            }
        }
        if ($transok) {
            $this->db->from('univarsal_api');
            $this->db->where('univarsal_api.id', 56);
            $this->db->where('company_id', getCompanyId());
            $query = $this->db->get();
            $auto = $query->row_array();
            if ($auto['key1'] == 1) {
                $this->db->select('name,email');
                $this->db->from('geopos_customers');
                $this->db->where('id', $customer_id);
                $this->db->where('company_id', getCompanyId());
                $query = $this->db->get();
                $customer = $query->row_array();

                $this->load->model('communication_model');
                $invoice_mail = $this->send_invoice_auto($invocieno, $invocieno2, $bill_date, $total, $currency);
                $attachmenttrue = false;
                $attachment = '';

            }

            if ($auto['key2'] == 1) {
                $this->db->select('name,phone');
                $this->db->from('geopos_customers');
                $this->db->where('company_id', getCompanyId());
                $this->db->where('id', $customer_id);
                $query = $this->db->get();
                $customer = $query->row_array();

                $this->load->model('plugins_model', 'plugins');
                $invoice_sms = $this->send_sms_auto($invocieno, $invocieno2, $bill_date, $total, $currency);

                $mobile = $customer['phone'];
                $text_message = $invoice_sms['message'];

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


            }
        }
        //profit calculation
        $t_profit = 0;
        $this->db->select('geopos_invoice_items.pid, geopos_invoice_items.price, geopos_invoice_items.qty, geopos_products.fproduct_price');
        $this->db->from('geopos_invoice_items');
        $this->db->join('geopos_products', 'geopos_products.pid = geopos_invoice_items.pid', 'left');
        $this->db->where('geopos_invoice_items.tid', $invocieno);
        $this->db->where('geopos_invoice_items.company_id', getCompanyId());
        $query = $this->db->get();
        $pids = $query->result_array();
        foreach ($pids as $profit) {
            $t_cost = $profit['fproduct_price'] * $profit['qty'];
            $s_cost = $profit['price'] * $profit['qty'];

            $t_profit += $s_cost - $t_cost;
        }
        $data = array('type' => 9, 'rid' => $invocieno, 'col1' => $t_profit, 'd_date' => $bill_date,'company_id'=>getCompanyId(),'hash_code'=>getHashCode() );

        $this->db->insert('geopos_metadata', $data);
        //var_dump($print_now);exit;
        if ($print_now) {
            $this->db->trans_complete();
            echo json_encode(['status'=>'Success','invoice_id'=>$invocieno,'ref'=>$hash_code]);
        }
    }


    public function ajax_list()
    {

        $list = $this->invocies->get_datatables($this->limited);

        $data = array();

        $no = $this->input->post('start');

        foreach ($list as $invoices) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<a href="' . base_url("pos_invoices/view?id=$invoices->id&ref=".$invoices->hash_code_main."") . '">&nbsp; ' . $invoices->tid . '</a>';
            $row[] = $invoices->name;
            $row[] = dateformat($invoices->invoicedate);
            $row[] = $invoices->invoicetime;
            $row[] = amountExchange($invoices->total, 0, $this->aauth->get_user()->loc);
            $row[] = '<span class="st-' . $invoices->status . '">' . $this->lang->line(ucwords($invoices->status)) . '</span>';
            // $row[] = '<a href="' . base_url("pos_invoices/view?id=$invoices->id") . '" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i></a>&nbsp;<a href="' . base_url("pos_invoices/thermal_pdf?id=$invoices->id") . '&d=1" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a>&nbsp;<a href="#" data-object-id="' . $invoices->id . '" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a>';
            $row[] = '<a href="' . base_url("pos_invoices/view?id=$invoices->id&ref=".$invoices->hash_code_main."") . '" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i></a>&nbsp;<a href="' . base_url("pos_invoices/thermal_pdf?id=$invoices->id&ref=".$invoices->hash_code_main."") . '&d=1" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a>';
            $data[] = $row;
        }


        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->invocies->count_all($this->limited),
            "recordsFiltered" => $this->invocies->count_filtered($this->limited),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);

    }

    public function view()
    {
        $this->load->model('accounts_model');
        $data['acclist'] = $this->accounts_model->accountslist((integer)$this->aauth->get_user()->loc);
        $tid = $this->input->get('id');
        $hash_code = $this->input->get('ref');
        $data['id'] = $tid;
        $data['ref'] = $hash_code;


        $data['invoice'] = $this->invocies->invoice_details($tid, $this->limited,$hash_code);

        $data['attach'] = $this->invocies->attach($tid);
        if ($data['invoice']['id']) $data['products'] = $this->invocies->invoice_products($tid);
        if ($data['invoice']['id']) $data['activity'] = $this->invocies->invoice_transactions($tid);
        $data['c_custom_fields'] = $this->custom->view_fields_data($data['invoice']['cid'], 1);

        $this->load->library("Printer");
        $data['printer'] = $this->printer->check($data['invoice']['loc']);

        $data['employee'] = $this->invocies->employee($data['invoice']['eid']);
        $head['title'] = "Invoice " . $data['invoice']['tid'];
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        if ($data['invoice']['id']) $this->load->view('pos/view', $data);
        $this->load->view('fixed/footer');

    }


    public function printinvoice()
    {
        $tid = $this->input->get('id');
        $hash_code = $this->input->get('ref');
        $data['id'] = $tid;
        $data['ref'] = $hash_code;
        $data['round_off'] = $this->custom->api_config(4);
        $data['invoice'] = $this->invocies->invoice_details($tid, $this->limited,$hash_code);
        if ($data['invoice']['id']) $data['products'] = $this->invocies->invoice_products($tid);
        if ($data['invoice']['id']) $data['employee'] = $this->invocies->employee($data['invoice']['eid']);
        if (CUSTOM) $data['c_custom_fields'] = $this->custom->view_fields_data($data['invoice']['cid'], 1, 1);
        if ($data['invoice']['i_class'] == 1) {
            $pref = prefix(7);
        } else {
            $pref = $this->config->item('prefix');
        }
        $data['general'] = array('title' => $this->lang->line('Invoice'), 'person' => $this->lang->line('Customer'), 'prefix' => $pref, 't_type' => 0);
        ini_set('memory_limit', '640M');
        if ($data['invoice']['taxstatus'] == 'cgst' || $data['invoice']['taxstatus'] == 'igst') {
            $html = $this->load->view('print_files/invoice-a4-gst_v' . INVV, $data, true);
        } else {
            $html = $this->load->view('print_files/invoice-a4_v' . INVV, $data, true);
        }
        //PDF Rendering
        $this->load->library('pdf');
        if (INVV == 1) {
            $header = $this->load->view('print_files/invoice-header_v' . INVV, $data, true);
            $pdf = $this->pdf->load_split(array('margin_top' => 40));
            $pdf->SetHTMLHeader($header);
        }
        if (INVV == 2) {
            $pdf = $this->pdf->load_split(array('margin_top' => 5));
        }
        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #' . $data['invoice']['tid'] . '</div>');
        $pdf->WriteHTML($html);
        if ($this->input->get('d')) {
            $pdf->Output('Invoice_pos' . $data['invoice']['tid'] . '.pdf', 'D');
        } else {
            $pdf->Output('Invoice_pos' . $data['invoice']['tid'] . '.pdf', 'I');
        }
    }

    public function delete_i()
    {
        $id = $this->input->post('deleteid');
        if ($this->aauth->premission(11)) {
            if ($this->invocies->invoice_delete($id, $this->limited)) {
                echo json_encode(array('status' => 'Success', 'message' =>
                    $this->lang->line('DELETED')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    $this->lang->line('ERROR')));
            }
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }

    public function editaction()
    {
        $ptype = $this->input->post('type');
        $coupon = $this->input->post('coupon');
        $notes = $this->input->post('notes', true);
        $coupon_amount = 0;
        $coupon_n = '';
        $account = $this->input->post('account', true);
        $customer_id = $this->input->post('customer_id');
        $invocieno_n = $this->input->post('invoiceno');
        $invocieno = $this->input->post('iid');
        $hash_code = $this->input->post('ref');
        $invoicedate = $this->input->post('invoicedate');
        $invocieduedate = $this->input->post('invocieduedate');
        $currency = $this->input->post('mcurrency');
        if ($ptype == 4) {
            $p_amount = rev_amountExchange_s($this->input->post('p_amount'), $currency, $this->aauth->get_user()->loc);
            $pmethod = $this->input->post('p_method');
            $notes = $this->input->post('notes');
            $tax = $this->input->post('tax_handle');
            $subtotal = rev_amountExchange_s($this->input->post('subtotal'), $currency, $this->aauth->get_user()->loc);
            $ship_taxtype = $this->input->post('ship_taxtype');
            $shipping = rev_amountExchange_s($this->input->post('shipping'), $currency, $this->aauth->get_user()->loc);
            $shipping_tax = rev_amountExchange_s($this->input->post('ship_tax'), $currency, $this->aauth->get_user()->loc);
            if ($ship_taxtype == 'incl') $shipping = $shipping - $shipping_tax;
            $refer = $this->input->post('refer');
            $total = rev_amountExchange_s($this->input->post('total'), $currency, $this->aauth->get_user()->loc);
            $old_total = rev_amountExchange_s($this->input->post('old_total'), $currency, $this->aauth->get_user()->loc);
            $total_tax = 0;
            $total_discount = 0;
            $discountFormat = $this->input->post('discountFormat');
            $pterms = $this->input->post('pterms');
            //edit
            $diff = $total - $old_total;
            $c_amt = $p_amount - $diff;
            if ($c_amt < 0) {
                $c_amt = 0;
            }
            $i = 0;
            if ($this->limited) {
                $employee = $this->invocies->invoice_details($invocieno, $this->limited,$hash_code);
                if ($this->aauth->get_user()->id != $employee['eid']) exit();
            }
            if ($discountFormat == '0') {
                $discstatus = 0;
            } else {
                $discstatus = 1;
            }
            if ($customer_id == 0) {
                echo json_encode(array('status' => 'Error', 'message' =>
                    $this->lang->line('Please add a new client')));
                exit;
            }
            $this->db->trans_start();
            $transok = true;
            $bill_date = datefordatabase($invoicedate);
            $bill_due_date = datefordatabase($invocieduedate);
            $promo_flag = false;
            if ($coupon) {
                $this->db->select('*');
                $this->db->from('geopos_promo');
                $this->db->where('company_id', getCompanyId());
                $this->db->where('code', $coupon);
                $query = $this->db->get();
                $result_c = $query->row_array();
                if ($result_c['active'] == 0 && $result_c['available'] > 0) {
                    $promo_flag = true;
                    $amount = $result_c['amount'];
                    $notes .= '-' . $this->input->post('i_coupon');
                    $total_discount += $amount;
                }
            }
            $data = array('invoicedate' => $bill_date, 'invoiceduedate' => $bill_due_date, 'subtotal' => $subtotal, 'shipping' => $shipping, 'ship_tax' => $shipping_tax, 'ship_tax_type' => $ship_taxtype, 'total' => $total, 'notes' => $notes, 'csd' => $customer_id, 'taxstatus' => $tax, 'discstatus' => $discstatus, 'format_discount' => $discountFormat, 'refer' => $refer, 'term' => $pterms, 'multi' => $currency);
            $this->db->set($data);
            $this->db->where('id', $invocieno);
            $this->db->where('hash_code', $hash_code);
            $this->db->where('company_id', getCompanyId());

            if ($this->db->update('geopos_invoices', $data)) {
                //Product Data
                $pid = $this->input->post('pid');
                $productlist = array();
                $prodindex = 0;
                $itc = 0;

               $this->db->delete('geopos_invoice_items', array('tid' => $invocieno,'company_id'=>getCompanyId()));

                $product_id = $this->input->post('pid');
                $product_name1 = $this->input->post('product_name', true);
                $product_qty = $this->input->post('product_qty');
                $old_product_qty = $this->input->post('old_product_qty');
                $product_price = $this->input->post('product_price');
                $product_tax = $this->input->post('product_tax');
                $product_discount = $this->input->post('product_discount');
                $product_subtotal = $this->input->post('product_subtotal');
                $ptotal_tax = $this->input->post('taxa');
                $ptotal_disc = $this->input->post('disca');
                $product_des = $this->input->post('product_description', true);
                $product_unit = $this->input->post('unit');
                $product_hsn = $this->input->post('hsn');
                foreach ($pid as $key => $value) {

                    $total_discount += numberClean(@$ptotal_disc[$key]);
                    $total_tax += numberClean($ptotal_tax[$key]);
                    $data = array(
                        'tid' => $invocieno,
                        'pid' => $product_id[$key],
                        'product' => $product_name1[$key],
                        'code' => $product_hsn[$key],
                        'qty' => numberClean($product_qty[$key]),
                        'price' => rev_amountExchange_s($product_price[$key], $currency, $this->aauth->get_user()->loc),
                        'tax' => numberClean($product_tax[$key]),
                        'discount' => numberClean($product_discount[$key]),
                        'subtotal' => rev_amountExchange_s($product_subtotal[$key], $currency, $this->aauth->get_user()->loc),
                        'totaltax' => rev_amountExchange_s($ptotal_tax[$key], $currency, $this->aauth->get_user()->loc),
                        'totaldiscount' => rev_amountExchange_s($ptotal_disc[$key], $currency, $this->aauth->get_user()->loc),
                        'product_des' => $product_des[$key],
                        'i_class' => 1,
                        'unit' => $product_unit[$key],
                        'company_id'=>getCompanyId(),
                        'hash_code'=>getHashCode() 
                    );

                    $productlist[$prodindex] = $data;
                    $i++;
                    $prodindex++;
                    $amt = numberClean($product_qty[$key]) - @numberClean($old_product_qty[$key]);

                    if ($product_id[$key] > 0) {
                        $this->db->set('qty', "qty-$amt", FALSE);
                        $this->db->where('pid', $product_id[$key]);
                        $this->db->where('company_id', getCompanyId());
                        $this->db->update('geopos_products');

                    }
                    $itc += $amt;
                }
                if ($prodindex > 0) {
                $this->db->insert_batch('geopos_invoice_items', $productlist);

                    $this->db->set(array('discount' => rev_amountExchange_s(amountFormat_general($total_discount), $currency, $this->aauth->get_user()->loc), 'tax' => rev_amountExchange_s(amountFormat_general($total_tax), $currency, $this->aauth->get_user()->loc), 'items' => $itc));
                    $this->db->where('id', $invocieno);
                    $this->db->where('company_id', getCompanyId());
                  $dd =   $this->db->update('geopos_invoices');
                  
                } else {
                    echo json_encode(array('status' => 'Error', 'message' =>
                        "Please add at least one product in invoice"));
                    $transok = false;
                }
                

                $this->load->model('billing_model', 'billing');
                $tnote = '#' . $invocieno_n . '-' . $pmethod;
                switch ($pmethod) {
                    case 'Cash' :
                        $r_amt1 = $diff;
                        $r_amt2 = 0;
                        $r_amt3 = 0;
                         $r_amt4 = 0;
                        break;
                    case 'Card Swipe' :
                        $r_amt1 = 0;
                        $r_amt2 = $diff;
                        $r_amt3 = 0;
                         $r_amt4 = 0;
                        break;
                    case 'Bank' :
                        $r_amt1 = 0;
                        $r_amt2 = 0;
                        $r_amt3 = $diff;
                         $r_amt4 = 0;
                        break;
                 case 'Cash Card' :
                        $r_amt1 = 0;
                        $r_amt2 = 0;
                        $r_amt3 = 0;
                         $r_amt4 = $diff;
                        break;
                }
                $this->billing->paynow($invocieno, $diff, $tnote, $pmethod, $this->aauth->get_user()->loc, 0, $account);
                $this->registerlog->update($this->aauth->get_user()->id, $r_amt1, $r_amt2, $r_amt3, $r_amt4,0, $c_amt);
                if ($promo_flag) {
                    $cqty = $result_c['available'] - 1;
                    if ($cqty > 0) {
                        $data = array('available' => $cqty);
                    } else {
                        $data = array('active' => 1, 'available' => $cqty);
                    }
                    $amount = $result_c['amount'];
                    $this->db->set($data);
                    $this->db->where('id', $result_c['id']);
                    $this->db->where('company_id', getCompanyId());
                    $this->db->update('geopos_promo');

                    if ($result_c['reflect'] > 0) {
                        $data = array(
                            'payerid' => 0,
                            'payer' => $this->lang->line('Coupon') . '-' . $result_c['code'],
                            'acid' => $result_c['reflect'],
                            'account' => 'Promo',
                            'date' => date('Y-m-d'),
                            'debit' => 0,
                            'credit' => $amount,
                            'type' => 'Income',
                            'cat' => $this->lang->line('Coupon'),
                            'method' => 'Transfer',
                            'eid' => $this->aauth->get_user()->id,
                            'note' => $this->lang->line('Coupon') . ' ' . $this->lang->line('Delete') . ' ' . $this->lang->line('Qty') . '-' . $result_c['available'],
                            'loc' => $this->aauth->get_user()->loc,
                            'company_id'=>getCompanyId(),
                            'hash_code'=>getHashCode() 
                        );
                        $this->db->set('lastbal', "lastbal+$amount", FALSE);
                        $this->db->where('id', $result_c['reflect']);
                        $this->db->where('company_id', getCompanyId());
                        $this->db->update('geopos_accounts');
                        $this->db->insert('geopos_transactions', $data);
                    }
                }
            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    $this->lang->line('ERROR')));
                $transok = false;
            }

            if ($this->input->post('restock')) {
                foreach ($this->input->post('restock') as $key => $value) {

                    $myArray = explode('-', $value);
                    $prid = $myArray[0];
                    $dqty = numberClean($myArray[1]);
                    if ($prid > 0) {
                        $this->db->set('qty', "qty+$dqty", FALSE);
                        $this->db->where('pid', $prid);
                        $this->db->where('company_id', getCompanyId());
                        $this->db->update('geopos_products');
                    }
                }
            }

                    //profit calculation
        $t_profit = 0;
        $this->db->select('geopos_invoice_items.pid, geopos_invoice_items.price, geopos_invoice_items.qty, geopos_products.fproduct_price');
        $this->db->from('geopos_invoice_items');
        $this->db->join('geopos_products', 'geopos_products.pid = geopos_invoice_items.pid', 'left');
        $this->db->where('geopos_invoice_items.tid', $invocieno);
        $this->db->where('geopos_invoice_items.company_id', getCompanyId());
        $query = $this->db->get();
        $pids = $query->result_array();
        foreach ($pids as $profit) {
            $t_cost = $profit['fproduct_price'] * $profit['qty'];
            $s_cost = $profit['price'] * $profit['qty'];

            $t_profit += $s_cost - $t_cost;
        }
        $this->db->set('col1', $t_profit);
        $this->db->where('type', 9);
        $this->db->where('company_id', getCompanyId());
        $this->db->where('rid', $invocieno);
        $this->db->update('geopos_metadata');

           $this->db->trans_complete();     
            if ($transok) {
                $this->db->trans_complete();
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Invoice has  been updated') . " <a href='view?id=$invocieno&ref=".$hash_code."' class='btn btn-info btn-lg'><span class='icon-file-text2' aria-hidden='true'></span> " . $this->lang->line('View') . " </a> "));
            } else {
                $this->db->trans_rollback();
            }

        }



    }

    public function update_status()
    {
        $tid = $this->input->post('tid');
        $status = $this->input->post('status');
        $this->db->set('status', $status);
        $this->db->where('id', $tid);
        $this->db->where('company_id', getCompanyId());
        $this->db->update('geopos_invoices');
        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('UPDATED'), 'pstatus' => $status));
    }


    public function addcustomer()
    {
        $name = $this->input->post('name', true);
        $company = $this->input->post('company', true);
        $phone = $this->input->post('phone', true);
        $email = $this->input->post('email', true);
        $address = $this->input->post('address', true);
        $city = $this->input->post('city', true);
        $region = $this->input->post('region', true);
        $country = $this->input->post('country', true);
        $postbox = $this->input->post('postbox', true);
        $taxid = $this->input->post('taxid', true);
        $customergroup = $this->input->post('customergroup', true);
        $name_s = $this->input->post('name_s', true);
        $phone_s = $this->input->post('phone_s', true);
        $email_s = $this->input->post('email_s', true);
        $address_s = $this->input->post('address_s', true);
        $city_s = $this->input->post('city_s', true);
        $region_s = $this->input->post('region_s', true);
        $country_s = $this->input->post('country_s', true);
        $postbox_s = $this->input->post('postbox_s', true);
        $this->load->model('customers_model', 'customers');
        $this->customers->add($name, $company, $phone, $email, $address, $city, $region, $country, $postbox, $customergroup, $taxid, $name_s, $phone_s, $email_s, $address_s, $city_s, $region_s, $country_s, $postbox_s);

    }

    public function file_handling()
    {
        if ($this->input->get('op')) {
            $name = $this->input->get('name');
            $invoice = $this->input->get('invoice');
            if ($this->invocies->meta_delete($invoice, 1, $name)) {
                echo json_encode(array('status' => 'Success'));
            }
        } else {
            $id = $this->input->get('id');
            $this->load->library("Uploadhandler_generic", array(
                'accept_file_types' => '/\.(gif|jpe?g|png|docx|docs|txt|pdf|xls)$/i', 'upload_dir' => FCPATH . 'userfiles/attach/', 'upload_url' => base_url() . 'userfiles/attach/'
            ));
            $files = (string)$this->uploadhandler_generic->filenaam();
            if ($files != '') {

                $this->invocies->meta_insert($id, 1, $files);
            }
        }


    }


    function thermal_print($id = 0, $mode = true, $d = true)
    {
        //dual mode -basic for standard users and advanced mode

        $basic_mode = false;

        $tid = $this->input->get('id');
        $hash_code = $this->input->get('ref');
        if (!$tid > 0) $tid = $id;
        $data['id'] = $tid;
        $data['title'] = "Invoice $tid";
        $data['invoice'] = $this->invocies->invoice_details($tid, $this->limited,$hash_code);
        if ($data['invoice']['id']) $data['products'] = $this->invocies->invoice_products($tid);
        if ($data['invoice']['id']) $data['employee'] = $this->invocies->employee($data['invoice']['eid']);

        $this->load->library("Printer");
        $printer_data = $this->printer->check($data['invoice']['loc']);

        if ($printer_data) {

            if ($printer_data['val2'] != 'server') {
                if ($d) echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('your thermal printer')));

                //based on  https://github.com/mike42/escpos-php
                switch ($printer_data['val2']) {
                    case 'file' :
                        $connector = new FilePrintConnector($printer_data['val3']);
                        break;
                    case 'network' :
                        $address = parse_url($printer_data['val3']);
                        $connector = new NetworkPrintConnector($address['host'], $address['port']);
                        break;
                    case 'windows' :
                        $connector = new WindowsPrintConnector($printer_data['val3']);
                        break;

                    case 'test' :
                        $connector = new DummyPrintConnector();
                        break;

                }

                $items = array();
                $sub_t = 0;
                foreach ($data['products'] as $row) {
                    $items[] = $this->toString($row['product'], $row['subtotal']);
                    $sub_t += $row['price'] * $row['qty'];
                }
                $subtotal = $this->toString($this->lang->line('Subtotal'), $sub_t);
                $tax = $this->toString($this->lang->line('Tax'), $data['invoice']['tax']);
                $total = $this->toString($this->lang->line('Total'), $data['invoice']['total'], true);
                $round_off = $this->custom->api_config(4);
                if ($round_off['other']) {
                    $final_amount = round($data['invoice']['total'], $round_off['active'], constant($round_off['other']));
                    $total_round = $this->toString($this->lang->line('Round Off'), $final_amount, true);
                }


                //Date is kept the same for testing
                // $date = date('l jS \of F Y h:i:s A');
                $date = dateformat($data['invoice']['invoicedate']) . ' ' . date('h:i:s A');


//simple and fast printing
                if (!$printer_data['other']) {

                    // Start the printer
                    //$logo = EscposImage::load(FCPATH . "userfiles/company/logo.png", false);
                    $printer = new Printer($connector);

                    // Print top logo
                    $printer->setJustification(Printer::JUSTIFY_CENTER);
                    //$printer->graphics($logo);

                    //Name of shop
                    $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
                    $printer->text($this->config->item('ctitle') . "\n");
                    $printer->selectPrintMode();
                    $printer->text($this->config->item('address') . "\n");
                    $printer->feed();

                    //Title of receipt
                    $printer->setEmphasis(true);
                    $printer->text($this->lang->line('Invoice') . ' ' . $data['invoice']['tid'] . "\n");
                    $printer->setEmphasis(false);

                    //Items
                    $printer->setJustification(Printer::JUSTIFY_LEFT);
                    $printer->setEmphasis(true);
                    $printer->text($this->toString('', $this->config->item('currency')));
                    $printer->setEmphasis(false);
                    foreach ($items as $item) {
                        $printer->text($item);
                    }
                    $printer->setEmphasis(true);
                    $printer->text($subtotal);
                    $printer->setEmphasis(false);
                    $printer->feed();

                    // Tax and total
                    $printer->text($tax);
                    $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
                    $printer->text($total);
                    if ($round_off['other']) {
                        $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
                        $printer->text($total_round);
                    }
                    $printer->selectPrintMode();

                    // Footer
                    $printer->feed(2);
                    $printer->setJustification(Printer::JUSTIFY_CENTER);
                    $printer->text($this->lang->line('Thank you') . "\n");
                    $printer->text("\n");
                    $printer->feed(2);
                    $printer->text($date . "\n");

                    // Cut the receipt and open the cash drawer
                    $printer->cut();
                    //   $printer->pulse();
                    if ($printer_data['val2'] == 'test') {
                        $data = $connector->getData();

                        header('Content-type: application/octet-stream');
                        header('Content-Length: ' . strlen($data));

                        $file = FCPATH . "pos_test_receipt_" . date('Y-m-d_H_i_s') . ".bin";
                        file_put_contents($file, $data);
                    }


                    $printer->close();
                } else {
                    //thermal pdf printing
                    $printer = new Printer($connector);
                    $this->pheight = 0;
                    $data['id'] = $tid;
                    $data['title'] = "Invoice $tid";
                    $data['invoice'] = $this->invocies->invoice_details($tid, $this->limited,$hash_code);
                    if ($data['invoice']) $data['products'] = $this->invocies->invoice_products($tid);
                    if ($data['invoice']) $data['employee'] = $this->invocies->employee($data['invoice']['eid']);

                    $this->load->model('billing_model', 'billing');
                    $online_pay = $this->billing->online_pay_settings();
                    if ($online_pay['enable'] == 1) {
                        $token = hash_hmac('ripemd160', $tid, $this->config->item('encryption_key'));
                        $data['qrc'] = 'pos_' . date('Y_m_d_H_i_s') . '_.png';
                        $static_q = $data['qrc'];

                        $qrCode = new QrCode(base_url('billing/card?id=' . $tid . '&itype=inv&token=' . $token));

//header('Content-Type: '.$qrCode->getContentType());
//echo $qrCode->writeString();
                        $qrCode->writeFile(FCPATH . 'userfiles/pos_temp/' . $data['qrc']);
                    }

                    // boost the memory limit if it's low ;)
                    ini_set('memory_limit', '640M');
                    // load library
                    $this->load->library('pdf');
                    $pdf = $this->pdf->load_thermal();
                    // retrieve data from model or just static date
                    $data['title'] = "items";
                    $pdf->allow_charset_conversion = true;  // Set by default to TRUE
                    $pdf->charset_in = 'UTF-8';
                    //   $pdf->SetDirectionality('rtl'); // Set lang direction for rtl lang
                    $pdf->autoLangToFont = true;
                    $html = $this->load->view('pos/pdfposthermal', $data, true);
                    // render the view into HTML

                    $h = 160 + $this->pheight;
                    $pdf->_setPageSize(array(70, $h), $pdf->DefOrientation);
                    $pdf->WriteHTML($html);
                    $file_name = preg_replace('/[^A-Za-z0-9]+/', '-', 'PosInvoice_' . $data['invoice']['name'] . '_' . $data['invoice']['tid']);

                    $pdf->Output('userfiles/pos_temp/' . $file_name . '.pdf', 'F');


                    if (!extension_loaded('imagick')) {
                        echo 'imagick not installed';
                    }
                    $im = new Imagick();


                    $im->setResolution(300, 300);
                    $im->readimage(FCPATH . 'userfiles' . DIRECTORY_SEPARATOR . 'pos_temp' . DIRECTORY_SEPARATOR . $file_name . '.pdf');
                    $im->setImageType(imagick::IMGTYPE_TRUECOLOR);
                    $im->setImageFormat('png');
                    //$im->transparentPaintImage(      'white', 0, 100, false    );
                    $im->writeImage(FCPATH . 'userfiles' . DIRECTORY_SEPARATOR . 'pos_temp' . DIRECTORY_SEPARATOR . $file_name . '.png');
                    $im->clear();
                    $im->destroy();
                    $printer->graphics(EscposImage::load(FCPATH . 'userfiles' . DIRECTORY_SEPARATOR . 'pos_temp' . DIRECTORY_SEPARATOR . $file_name . '.png'));
                    $printer->cut();
                    if ($printer_data['val2'] == 'test') {
                        $data = $connector->getData();

                        header('Content-type: application/octet-stream');
                        header('Content-Length: ' . strlen($data));

                        $file = FCPATH . "advanced_pos_test_receipt_" . date('Y-m-d_H_i_s') . ".bin";
                        file_put_contents($file, $data);
                    }
                    $printer->close();
                    unlink(FCPATH . 'userfiles' . DIRECTORY_SEPARATOR . 'pos_temp' . DIRECTORY_SEPARATOR . $static_q);
                    unlink(FCPATH . 'userfiles' . DIRECTORY_SEPARATOR . 'pos_temp' . DIRECTORY_SEPARATOR . $file_name . '.pdf');
                    unlink(FCPATH . 'userfiles' . DIRECTORY_SEPARATOR . 'pos_temp' . DIRECTORY_SEPARATOR . $file_name . '.png');

                }


            } elseif ($printer_data['val2'] == 'server') {

                $ch = curl_init();
                // Set cURL options

                curl_setopt($ch, CURLOPT_URL, $printer_data['val3'] . "pos_printer/adv.php?id=$tid");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.66 Safari/537.36");
                // Decode returned JSON
                $output = json_decode(curl_exec($ch), true);
                // Close Channel
                curl_close($ch);
            }
        } else {
            if ($mode) echo json_encode(array('status' => 'Error', 'message' => 'Please setup a thermal printer in printer section.'));
        }

    }

    public function toString($name = '', $price = '', $dollarSign = false)
    {
        $rightCols = 10;
        $leftCols = 38;
        if ($dollarSign) {
            $leftCols = $leftCols / 2 - $rightCols / 2;
        }
        $left = str_pad($name, $leftCols);

        $sign = $this->config->item('currency');
        $right = str_pad($sign . $price, $rightCols, ' ', STR_PAD_LEFT);
        return "$left$right\n";

    }


    function thermal_pdf()
    {
        $tid = $this->input->get('id');
        $hash_code = $this->input->get('ref');
        $tex_report = $this->input->get('report');



        $data['id'] = $tid;
        $data['title'] = "Invoice $tid";
        $data['invoice'] = $this->invocies->invoice_details($tid, $this->limited,$hash_code);
        if ($data['invoice']) $hash_code = $data['invoice']["hash_code"];
        $data['round_off'] = $this->custom->api_config(4);
        $query = $this->db->query("SELECT * FROM geopos_system WHERE id=".getCompanyId()." LIMIT 1");
        $addressResult = $query->row_array();
        $data['address'] =$addressResult['country'].','.$addressResult['region'].','.$addressResult['city'].','.$addressResult['address'] ;
             if ($this->aauth->get_user()->loc!=0) {
                 $loc=$this->aauth->get_user()->loc;
                   $query = $this->db->query('SELECT * FROM geopos_locations WHERE ware='.$loc.' and company_id='.getCompanyId().' LIMIT 1');
                   
        $addressResult = $query->row_array();
    //   $addressResult['country'].','.$addressResult['region'].','.
        $data['address'] =$addressResult['city'].','.$addressResult['address'] ;
               
            }

    
                $displayQRCodeAsBase64 = GenerateQrCode::fromArray([
            new Seller($addressResult['cname']), // seller name        
            new TaxNumber($addressResult['taxid']), // seller tax number
            new InvoiceDate(dateformat($data['invoice']['invoicedate']).' '.$data['invoice']['invoicetime']),
            new InvoiceTotalAmount($data['invoice']['total']), // invoice total amount
            new InvoiceTaxAmount($data['invoice']['tax']) // invoice tax amount
        ])->render();
         $data['qr_code_image'] = $displayQRCodeAsBase64;

        // var_dump($data['qr_code_image']);exit;


        
        if ($data['invoice']) $data['products'] = $this->invocies->invoice_products($tid);
        if ($data['invoice']) $data['employee'] = $this->invocies->employee($data['invoice']['eid']);
        $this->load->model('billing_model', 'billing');
        $online_pay = $this->billing->online_pay_settings();
       // var_dump($online_pay);exit;
        if (isset($online_pay['enable']) and $online_pay['enable'] == 1) {
            $token = hash_hmac('ripemd160', $tid, $this->config->item('encryption_key'));
            $data['qrc'] = 'pos_' . date('Y_m_d_H_i_s') . '_.png';

           // $qrCode = new QrCode(base_url('C_QrCode/check_qr/' . $tid . '/' . $hash_code));
//header('Content-Type: '.$qrCode->getContentType());
//echo $qrCode->writeString();
          //  echo "<img src='".$data['qr_code_image']."' alt='QR Code' />";
            //$qrCode->writeFile(FCPATH . 'userfiles/pos_temp/' . $data['qrc']);

        }
         $data['massage_order'] = $this->settings->get_massage_order();
        // boost the memory limit if it's low ;)
        ini_set('memory_limit', '640M');
        // load library
        $this->load->library('pdf');
        $this->pheight = 0;
        $this->load->library('pdf');
        $pdf = $this->pdf->load_thermal();
        // retrieve data from model or just static date
        $data['title'] = "items";
        $pdf->allow_charset_conversion = true;  // Set by default to TRUE
        $pdf->charset_in = 'UTF-8';
        //   $pdf->SetDirectionality('rtl'); // Set lang direction for rtl lang
        $pdf->autoLangToFont = true;

        $report_version = 'pos_pdf_compact';
        if ($tex_report == 1){
           // var_dump("expression");exit;
            $report_version .= '_v3';
        }
        //var_dump($report_version);exit;
        $html = $this->load->view('print_files/' . $report_version, $data, true);
        $h = 160 + $this->pheight;
        //  $pdf->_setPageSize(array(70, $h), $this->orientation);
        $pdf->_setPageSize(array(70, $h), $pdf->DefOrientation);
        $pdf->WriteHTML($html);
        // render the view into HTML
        // write the HTML into the PDF
        $file_name = preg_replace('/[^A-Za-z0-9]+/', '-', 'PosInvoice_' . $data['invoice']['name'] . '_' . $data['invoice']['tid']);
        if ($this->input->get('d')) {
            $pdf->Output($file_name . '.pdf', 'D');
        } else {
            $pdf->Output($file_name . '.pdf', 'I');
        }

        unlink('userfiles/pos_temp/' . $data['qrc']);
    }
    function register_print()
    {
         $status = $this->registerlog->check($this->aauth->get_user()->id);

        if ($status) {

        }
        $status['cashInvoices']=$this->invocies->active_register_cashInvoice($status['id']);
        $status['cardInvoices']=$this->invocies->active_register_cardInvoice($status['id']);
        $status['onAccountInvoices']=$this->invocies->active_register_onAccountInvoice($status['id']);
    //   var_dump($status);
    //   var_dump($status['cashInvoices'][0]['total']);
        // boost the memory limit if it's low ;)
        ini_set('memory_limit', '640M');
        // load library
        $this->load->library('pdf');
        $this->pheight = 0;
        $this->load->library('pdf');
        $pdf = $this->pdf->load_thermal();
        // retrieve data from model or just static date

        $pdf->allow_charset_conversion = true;  // Set by default to TRUE
        $pdf->charset_in = 'UTF-8';
        //   $pdf->SetDirectionality('rtl'); // Set lang direction for rtl lang
        $pdf->autoLangToFont = true;
        $html = $this->load->view('print_files/pos_pdf_register', $status, true);
        $h = 160 + $this->pheight;
        //  $pdf->_setPageSize(array(70, $h), $this->orientation);
        $pdf->_setPageSize(array(70, $h), $pdf->DefOrientation);
        $pdf->WriteHTML($html);
        // render the view into HTML
        // write the HTML into the PDF
        $file_name = preg_replace('/[^A-Za-z0-9]+/', '-', 'payment_summery' . $status['o_date'] );
        if ($this->input->get('d')) {
            $pdf->SetJS('this.print();');
            $pdf->Output($file_name . '.pdf', 'D');
        } else {
            $pdf->SetJS('this.print();');
            $pdf->Output($file_name . '.pdf', 'I');
        }
        unlink('userfiles/pos_temp/' . $data['qrc']);
    }


    function register_summary_view()
    {
        $head = '';
        $this->load->view('fixed/header', $head);
        $this->load->view('pos/register_summary_view');
        $this->load->view('fixed/footer');
    }

    function register_summary_print()
    {
        $data['open_date'] = $date = datefordatabase($this->input->get('open_date'));
        $data['open_t_date'] = $date2 = datefordatabase($this->input->get('open_t_date'));
        $data['open_time'] = $time = $this->input->get('open_time');
        $data['open_t_time'] = $time2 = $this->input->get('open_t_time');
        $open_time=date("G:i", strtotime($time));
        $open_t_time=date("G:i", strtotime($time2));

        $data['register_s'] = $register_s = $this->registerlog->lists(0,$date,$date2,$open_time,$open_t_time);
       
        $i=0;
        foreach($data['register_s'] as $register)
        {
         $data['register_s'][$i]['cashInvoices']=$this->invocies->active_register_cashInvoice($register['id']);
        //  var_dump($data['register_s'][$i]['cashInvoices']);
        $data['register_s'][$i]['cardInvoices']=$this->invocies->active_register_cardInvoice($register['id']);
        $data['register_s'][$i]['onAccountInvoices']=$this->invocies->active_register_onAccountInvoice($register['id']);
        $i++;
        }
    //   var_dump($data['register_s'][0]['cashInvoices']['cashTotal']);
        // boost the memory limit if it's low ;)
        ini_set('memory_limit', '640M');
        // load library
        $this->load->library('pdf');
        $this->pheight = 0;
        $this->load->library('pdf');
        $pdf = $this->pdf->load_thermal();
        // retrieve data from model or just static date

        $pdf->allow_charset_conversion = true;  // Set by default to TRUE
        $pdf->charset_in = 'UTF-8';
        //   $pdf->SetDirectionality('rtl'); // Set lang direction for rtl lang
        $pdf->autoLangToFont = true;
        $html = $this->load->view('print_files/pos_pdf_summary_register', $data, true);
        $h = 160 + $this->pheight;
        //  $pdf->_setPageSize(array(70, $h), $this->orientation);
        // $pdf->_setPageSize(array(70, $h), $pdf->DefOrientation);
        $pdf->WriteHTML($html);
        // render the view into HTML
        // write the HTML into the PDF
        $file_name = preg_replace('/[^A-Za-z0-9]+/', '-', 'payment_summery' . $date);
        if ($this->input->get('d')) {
            $pdf->Output($file_name . '.pdf', 'D');
        } else {
            $pdf->Output($file_name . '.pdf', 'I');
        }
        unlink('userfiles/pos_temp/' . $data['qrc']);
    }

     function invoice_summary_view()
    {
        $head = '';
        $this->load->view('fixed/header', $head);
        $this->load->view('pos/invoice_summary_view');
        $this->load->view('fixed/footer');
    }
     function invoice_summary_print()
    {
        $data['open_date'] = $date = datefordatabase($this->input->get('open_date'));
        $data['open_t_date'] = $date2 = datefordatabase($this->input->get('open_t_date'));
        $data['open_time'] = $time = $this->input->get('open_time');

        $data['open_t_time'] = $time2 = $this->input->get('open_t_time');
         $newTime = date('h:i A', strtotime($time));
           $newTime2 = date('h:i A', strtotime($time2));
        // $open_time=date("G:i", strtotime($time));
        // $open_t_time=date("G:i", strtotime($time2));
    // var_dump($time);
         $data['cashInvoices']=$this->invocies->active_cashInvoice($date,$date2, $newTime,$newTime2);
        //   var_dump($data['cashInvoices']);
        //  var_dump($data['register_s'][$i]['cashInvoices']);
        // $data['cardInvoices']=$this->invocies->active_cardInvoice($date,$date2, $data['open_time'],$data['open_t_time']);
        // $data['onAccountInvoices']=$this->invocies->active_onAccountInvoice($date,$date2, $data['open_time'],$data['open_t_time']);

    //   var_dump($data['register_s'][0]['cashInvoices']['cashTotal']);
        // boost the memory limit if it's low ;)
        ini_set('memory_limit', '640M');
        // load library
        $this->load->library('pdf');
        $this->pheight = 0;
        $this->load->library('pdf');
        $pdf = $this->pdf->load_thermal();
        // retrieve data from model or just static date

        $pdf->allow_charset_conversion = true;  // Set by default to TRUE
        $pdf->charset_in = 'UTF-8';
        //   $pdf->SetDirectionality('rtl'); // Set lang direction for rtl lang
        $pdf->autoLangToFont = true;
        $html = $this->load->view('print_files/pos_pdf_summary_invoice', $data, true);
        $h = 160 + $this->pheight;

        $pdf->WriteHTML($html);
        // render the view into HTML
        // write the HTML into the PDF
        $file_name = preg_replace('/[^A-Za-z0-9]+/', '-', 'payment_summery' . $date);
        if ($this->input->get('d')) {
            $pdf->Output($file_name . '.pdf', 'D');
        } else {
            $pdf->Output($file_name . '.pdf', 'I');
        }
        unlink('userfiles/pos_temp/' . $data['qrc']);
    }

    public function set_coupon()
    {
        $id = $this->input->post('coupon');
        if ($id) {
            $this->db->select('*');
            $this->db->from('geopos_promo');
            $this->db->where('code', $id);
            $query = $this->db->get();
            $promo = $query->row_array();
            if (($promo['active'] == 0) && ($promo['available'] > 0) && (strtotime($promo['valid']) >= strtotime(date('Y-m-d')))) {
                echo json_encode(array('status' => 'Success', 'message' => $promo['code'] . ' ' . $this->lang->line('Coupon Applied') . ' ' . $this->lang->line('Amount') . ' ' . amountFormat_general($promo['amount']), 'amount' => amountFormat_general($promo['amount'])));
            } elseif (($promo['active'] == 0) && ($promo['available'] > 0) && (strtotime($promo['valid']) < strtotime(date('Y-m-d')))) {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('Coupon Expired'), 'amount' => 0));
            } elseif ($promo['active'] > 0) {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('Usages Exceed'), 'amount' => 0));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('Invalid Coupon'), 'amount' => 0));
            }
        } else {
            echo json_encode(array('status' => 'Error', 'message' => '', 'amount' => 0));
        }


    }

    public function send_invoice_auto($invocieno, $invocieno2, $idate, $total, $multi)
    {
        $this->load->library('parser');
        $this->load->model('templates_model', 'templates');
        $template = $this->templates->template_info(6);

        $data = array(
            'Company' => $this->config->item('ctitle'),
            'BillNumber' => $invocieno2
        );
        $subject = $this->parser->parse_string($template['key1'], $data, TRUE);
        $validtoken = hash_hmac('ripemd160', $invocieno, $this->config->item('encryption_key'));
        $link = base_url('billing/view?id=' . $invocieno . '&token=' . $validtoken);


        $data = array(
            'Company' => $this->config->item('ctitle'),
            'BillNumber' => $invocieno2,
            'URL' => "<a href='$link'>$link</a>",
            'CompanyDetails' => '<h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
<address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
             ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email'),
            'DueDate' => dateformat($idate),
            'Amount' => amountExchange($total, $multi)
        );
        $message = $this->parser->parse_string($template['other'], $data, TRUE);


        return array('subject' => $subject, 'message' => $message);
    }

    public function send_sms_auto($invocieno, $invocieno2, $idate, $total, $multi)
    {
        $this->load->library('parser');
        $this->load->model('templates_model', 'templates');
        $template = $this->templates->template_info(30);
        $validtoken = hash_hmac('ripemd160', $invocieno, $this->config->item('encryption_key'));
        $link = base_url('billing/view?id=' . $invocieno . '&token=' . $validtoken);
        $this->load->model('plugins_model', 'plugins');
        $sms_service = $this->plugins->universal_api(1);
        if ($sms_service['active']) {
            $this->load->library("Shortenurl");
            $this->shortenurl->setkey($sms_service['key1']);
            $link = $this->shortenurl->shorten($link);
        }
        $data = array(
            'BillNumber' => $invocieno2,
            'URL' => $link,
            'DueDate' => dateformat($idate),
            'Amount' => amountExchange($total, $multi)
        );
        $message = $this->parser->parse_string($template['other'], $data, TRUE);
        return array('message' => $message);
    }


    public function invoicepdf()
    {
        $run = false;
        $id = $this->input->get('id');
        $hash_code = $this->input->get('ref');
        $key = $this->input->get('key');
        $this->db->select('key');
        $this->db->from('geopos_restkeys');
        $this->db->limit(1);
        $this->db->where('key', $key);
        $query_r = $this->db->get();
        if ($query_r->num_rows() > 0) {
            $run = true;
        }

        if (!$run) {
            exit('eer');
        }

        // Get the user from the array, using the id as key for retrieval.
        // Usually a model is to be used for this.

        $tid = $id;
        $data['qrc'] = 'pos_' . date('Y_m_d_H_i_s') . '_.png';
        $data['id'] = $tid;
        $data['title'] = "Invoice $tid";
        $data['invoice'] = $this->invocies->invoice_details($tid,'',$hash_code);

        if ($data['invoice']) $data['products'] = $this->invocies->invoice_products($tid);
        if ($data['invoice']) $data['employee'] = $this->invocies->employee($data['invoice']['eid']);

       


        $this->load->model('billing_model', 'billing');
        $online_pay = $this->billing->online_pay_settings();
        if ($online_pay['enable'] == 1) {
            $token = hash_hmac('ripemd160', $tid, $this->config->item('encryption_key'));
            $data['qrc'] = 'pos_' . date('Y_m_d_H_i_s') . '_.png';

            $qrCode = new QrCode(base_url('billing/card?id=' . $tid . '&itype=inv&token=' . $token));

//header('Content-Type: '.$qrCode->getContentType());
//echo $qrCode->writeString();
            $qrCode->writeFile(FCPATH . 'userfiles/pos_temp/' . $data['qrc']);
        }

        $this->pheight = 0;
        $this->load->library('pdf');
        $pdf = $this->pdf->load_thermal();
        // retrieve data from model or just static date
        $data['title'] = "items";
        $pdf->allow_charset_conversion = true;  // Set by default to TRUE
        $pdf->charset_in = 'UTF-8';
        //   $pdf->SetDirectionality('rtl'); // Set lang direction for rtl lang
        $pdf->autoLangToFont = true;
        $data['round_off'] = $this->custom->api_config(4);


        $html = $this->load->view('print_files/pos_pdf_compact_v3', $data, true);
        // render the view into HTML

        $h = 160 + $this->pheight;
        $pdf->_setPageSize(array(70, $h), $pdf->DefOrientation);
        $pdf->WriteHTML($html);
        $file_name = substr($key, 0, 6) . $id;
        $pdf->Output('userfiles/pos_temp/' . $file_name . '.pdf', 'F');
        if (!extension_loaded('imagick')) {
            echo 'imagick not installed';
        }
        $im = new Imagick();
        $im->setResolution(300, 300);
        $im->readimage(FCPATH . 'userfiles/pos_temp/' . $file_name . '.pdf');
        $im->setImageType(imagick::IMGTYPE_TRUECOLOR);
        $im->setImageFormat('png');
        //$im->transparentPaintImage(      'white', 0, 100, false    );
        $im->writeImage(FCPATH . 'userfiles/pos_temp/rest-' . $file_name . '.png');
        $im->clear();
        $im->destroy();
        unlink('userfiles/pos_temp/' . $data['qrc']);
        unlink(FCPATH . 'userfiles/pos_temp/' . $file_name . '.pdf');


    }

    public function invoiceclean()
    {
        $file_name = substr($this->input->get('key'), 0, 6) . $this->input->get('id');
        unlink(FCPATH . 'userfiles/pos_temp/' . $file_name . '.png');

    }

    public function view_payslip()
    {
        $id = $this->input->get('id');
        $hash_code = $this->input->get('ref');
        $inv = $this->input->get('inv');
        $data['invoice'] = $this->invocies->invoice_details($inv, $this->limited,$hash_code);
        if (!$data['invoice']['id']) exit('Limited Permissions!');

        $this->load->model('transactions_model', 'transactions');
        $head['title'] = "View Transaction";
        $head['usernm'] = $this->aauth->get_user()->username;

        $data['trans'] = $this->transactions->view($id);

        if ($data['trans']['payerid'] > 0) {
            $data['cdata'] = $this->transactions->cview($data['trans']['payerid'], $data['trans']['ext']);
        } else {
            $data['cdata'] = array('address' => 'Not Registered', 'city' => '', 'phone' => '', 'email' => '');
        }
        ini_set('memory_limit', '640M');

        $html = $this->load->view('transactions/view-print-customer', $data, true);

        //PDF Rendering
        $this->load->library('pdf');

        $pdf = $this->pdf->load_en();

        $pdf->SetHTMLFooter('<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;"><tr><td width="33%"></td><td width="33%" align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td><td width="33%" style="text-align: right; ">#' . $id . '</td></tr></table>');

        $pdf->WriteHTML($html);

        if ($this->input->get('d')) {

            $pdf->Output('Trans_#' . $id . '.pdf', 'D');
        } else {
            $pdf->Output('Trans_#' . $id . '.pdf', 'I');
        }


    }
    
    public function download_offline_pos(){

        /*  api key generation */
            $this->load->model('restapi_model', 'restapi');
            $api_keys = $this->restapi->keylist();
            if(!count($api_keys)) {
                $api_key = $this->restapi->addnew($return_key = true);
            } else {
                $api_key = $api_keys[0]['key'];
            }
        /*  api key generation */

        $url = base_url('rest');
        redirect('https://almusand.co/offline_app/download.php?url='.$url.'&api_key='.$api_key, 'refresh');
    }


}
