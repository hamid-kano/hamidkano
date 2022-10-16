<?php
ini_set('memory_limit', '-1');
/**
 * Almusand -  Accounting,  Invoicing  and CRM Application
 * Copyright (c) Almusand. All Rights Reserved
 * ***********************************************************************
 *
 *  Email: support@almusand.com
 *  Website: https://almusand.com
 */
require_once APPPATH . 'third_party/qrcode/vendor/autoload.php';

use Endroid\QrCode\QrCode;

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . 'libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Rest extends REST_Controller
{

    function __construct()
    {   
        // Construct the parent class
        parent::__construct();
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 500; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->load->library('session');
        $this->session->set_userdata('company_id',getCompanyId());
        $this->load->model('restservice_model', 'restservice');
    }

    public function general_data_get() {
        $query = $this->db->query("SELECT * FROM geopos_system WHERE id = ".getCompanyId()." LIMIT 1");
        $data = $query->row_array();
        $address = $data['country'].','.$data['region'].','.$data['city'].','.$data['address'];
        $logo = file_get_contents(FCPATH . 'userfiles/company/' . $data['logo']);
        $encodedLogo = base64_encode($logo);
        $this->load->model('settings_model', 'settings');
        $terms = $this->settings->billingterms();
        $this->response([
                    'status' => true,
                    'general_data'=>[
                        'tax_number'=>$data['taxid'],    
                        'company_name'=>$data['cname'],    
                        'address'=>$address,
                        'encoded_logo'=>$encodedLogo,
                        'invoice_terms'=>$terms,
                    ],
                ], REST_Controller::HTTP_OK);
    }
    
    public function auth_user_post() {
        $this->load->library("Aauth");
        $this->load->model("employee_model");
        $this->load->model('settings_model', 'settings');
        $email = $this->post('email');
        $password = $this->post('password');
        if($this->aauth->login($email, $password, false,null)){
            $this->aauth->applog("[Logged In] ". $email." via API");
            $employee = $this->employee_model->employee_details_row($this->aauth->get_user()->id);
            $employee['id'] = $this->aauth->get_user()->id;
            $location = location($this->aauth->get_user()->loc);
            $query = $this->db->query("SELECT * FROM geopos_system WHERE id= ".getCompanyId()." LIMIT 1");
            $addressResult = $query->row_array();
            $address = $addressResult['country'].','.$addressResult['region'].','.$addressResult['city'].','.$addressResult['address'];
            
            $logo = file_get_contents(FCPATH . 'userfiles/company/' . $location['logo']);
            $encodedLogo = base64_encode($logo);

            $terms = $this->settings->billingterms();
            
            $this->response([
                    'status' => true,
                    'employee' => $employee,
                    'general_data'=>[
                        'tax_number'=>$location['taxid'],    
                        'company_name'=>$location['cname'],    
                        'address'=>$address,
                        'encoded_logo'=>$encodedLogo,
                        'invoice_terms'=>$terms,
                    ],
                ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                    'status' => FALSE,
                    'message' => 'Authentication data is incorrect'
                ], REST_Controller::HTTP_OK);
        }
    }

    public function clients_get()
    {
        $id = $this->get('id');
        if ($id === NULL) {
            $list = $this->restservice->customers();
            if ($list) {
                // Set the response and exit
                $this->response($list, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No Client were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        // Find and return a single record for a particular user.
        $id = (int)$id;
        // Validate the id.
        if ($id <= 0) {
            // Invalid id, set the response and exit.
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }
        // Get the user from the array, using the id as key for retrieval.
        // Usually a model is to be used for this.
        $list = $this->restservice->customers($id);
        if (!empty($list)) {
            $this->set_response($list[0], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Client could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }
    
    public function test_get(){
        $this->load->library('session');
        $this->set_response(['data'=>$this->session->userdata('company_id')], REST_Controller::HTTP_OK);
    }

    public function clients_post()
    {
        $id = $this->post('id');
        if ($id === NULL) {
            $list = $this->restservice->customers();
            // Check if the users data store contains users (in case the database result returns NULL)
            if ($list) {
                // Set the response and exit
                $this->response($list, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No Client were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        // Find and return a single record for a particular user.
        $id = (int)$id;
        // Validate the id.
        if ($id <= 0) {
            // Invalid id, set the response and exit.
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }
        // Get the user from the array, using the id as key for retrieval.
        // Usually a model is to be used for this.
        $list = $this->restservice->customers($id);
        if (!empty($list)) {
            $this->set_response($list[0], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Client could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }
    
    public function create_client_post()
    {
        $name = $this->post('name');
        $email = $this->post('email');
        $phone = $this->post('phone');
        if ($name && $email && $phone) {
            $this->load->library("Aauth");
            $this->load->model('customers_model', 'customers');
            ob_start();
            $created = $this->customers->add($name, null, $phone, $email, null, null, null, null, null, 1, null, null, null, null, null, null, null, null, null, 'arabic', true, null, null, null, null);
            ob_end_clean();
            if($created) {
                $this->response([
                    'status' => 1,
                    'message' => 'Client Created Succesfully',
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => 3,
                    'message' => 'Email Already Exists',
                ], REST_Controller::HTTP_OK);
            }
        } else {
                // Set the response and exit
                $this->response([
                    'status' => 0,
                    'message' => 'sorry you have to complete request data',
                ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
        }

    }


    public function clients_delete()
    {
        $id = (int)$this->get('id');
        // Validate the id.
        if ($id <= 0) {
            // Set the response and exit
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        if ($this->restservice->delete_customers($id)) {
            $message = [
                'id' => $id,
                'message' => 'Deleted the resource'
            ];

            $this->set_response($message, REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
        }
    }
    
    public function products_get()
    {
        $id = $this->get('id');
        if ($id === NULL) {
            $list = $this->restservice->products();
            $newlist = [];
            foreach($list as $product) {
                $item = $product;
                $item['encoded_image'] = '';
                $newlist[] = $item;
            }
            // Check if the users data store contains users (in case the database result returns NULL)
            if ($newlist) {
                // Set the response and exit
                $this->response($newlist, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No Products were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        // Find and return a single record for a particular user.
        $id = (int)$id;
        // Validate the id.
        if ($id <= 0) {
            // Invalid id, set the response and exit.
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }
        // Get the user from the array, using the id as key for retrieval.
        // Usually a model is to be used for this.
        $list = $this->restservice->products($id);
        if (!empty($list)) {
            $this->set_response($list[0], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Products could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function products_categories_get()
    {
        $this->load->model('categories_model');
        $categories = $this->categories_model->category_list();
        $this->set_response([
                'status'=>true,
                'categories'=>$categories,
            ], REST_Controller::HTTP_OK);
    }

    public function invoice_get()
    {
        $id = $this->get('id');

        if ($id === NULL) {
            $list = $this->restservice->invoice($id);
            // Check if the users data store contains users (in case the database result returns NULL)
            if ($list) {
                // Set the response and exit
                $this->response($list, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No Products were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        // Find and return a single record for a particular user.
        $id = (int)$id;
        // Validate the id.
        if ($id <= 0) {
            // Invalid id, set the response and exit.
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }
        // Get the user from the array, using the id as key for retrieval.
        // Usually a model is to be used for this.
        $list = $this->restservice->invoice($id);
        if (!empty($list)) {
            $this->set_response($list[0], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Invoice could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }
    
    
     public function warehouses_get()
    {
        $this->load->model('pos_invoices_model', 'invocies');
        $this->load->library("Aauth");
        $warehouses = $this->invocies->warehouses();
        $this->set_response([
            'warehouses' => $warehouses,
            'message'=>'Date retrieved successfully',
        ], REST_Controller::HTTP_OK);
    }
    
    public function invoices_get()
    {

    
        // Get the user from the array, using the id as key for retrieval.
        // Usually a model is to be used for this.
        $list = $this->restservice->invoices();
        if (!empty($list)) {
            $this->set_response($list[0], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Invoices could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }
    
    public function invoice_post()
    {
        $this->load->model('pos_invoices_model', 'invocies');
        $this->load->library("Registerlog");
        $this->load->library("Aauth");
        $this->load->library("Common");
        $this->load->model('register_model', 'register');
        $this->load->model('Settings_model', 'settings');
        $this->load->library("Custom");
        $company_id = getCompanyId();
        $coupon = $this->post('coupon');
        $notes = $this->post('notes', true);
        $coupon_amount = 0;
        $coupon_n = '';
        $customer_id = $this->post('customer_id');
        $employee_id = $this->post('employee_id');
        $this->aauth->login_fast($employee_id);
        $loc = $this->aauth->get_user()->loc;
		if($this->post('loc')==null && !$loc){$loc=1;}
        $invocieno = $this->invocies->lastinvoice()+1;
        $invoicedate = $this->post('invoicedate');
        $tax = $this->post('tax_handle');
        $total_tax = 0;
        $amount_card= $this->post('amount_card');
        $amount_cash= $this->post('amount_cash');
        $pterms = 1;
        $discountFormat = $this->post('discountFormat');
        $currency = 0;
        $total_discount = rev_amountExchange_s($this->post('discount_value'), $currency, 0);
        $disc_val = numberClean($this->post('discount_rate'));
        $ship_taxtype = $this->post('ship_tax_type');
        $subtotal = rev_amountExchange_s($this->post('subtotal'), $currency, 0);
        $shipping = rev_amountExchange_s($this->post('shipping'), $currency, 0);
        $shipping_tax = rev_amountExchange_s($this->post('ship_tax'), $currency, 0);
        if ($ship_taxtype == 'incl') @$shipping = $shipping - $shipping_tax;
        $refer = null;
        $total = rev_amountExchange_s($this->post('total'), $currency, 0);
        $pmethod = $this->post('payment_method');
        $status = 'Paid';
        $pamnt = $total;
            if ($discountFormat == '0') {
                $discstatus = 0;
            } else {
                $discstatus = 1;
            }
            if ($customer_id == 0) {
                $this->response([
                    'status' => FALSE,
                    'message' => 'customer_id field is required'
                ], REST_Controller::HTTP_UNPROCESSABLE_ENTITY);
                exit;
            }
            $this->db->trans_start();
            //products
            $transok = true;
            $this->load->library("Common");
            //Invoice Data
            $bill_date = datefordatabase($invoicedate);
            $time= $this->post('invoicetime');
            $promo_flag = false;
            if ($coupon) {
                $this->db->select('*');
                $this->db->from('geopos_promo');
                $this->db->where('code', $coupon);
                $this->db->where('company_id', $company_id);
                $query = $this->db->get();
                $result_c = $query->row_array();
                if ($result_c['active'] == 0 && $result_c['available'] > 0) {
                    $promo_flag = true;
                    $amount = $result_c['amount'];
                    $notes .= '- Coupon Code' . $coupon;
                    $total_discount += $amount;
                }
            }
            $data = array('tid' => $invocieno, 'invoicedate' => $bill_date,'register_id'=>null,'invoicetime'=>$time, 'invoiceduedate' => $bill_date, 'subtotal' => $subtotal ,'amount_card' => $amount_card, 'amount_cash' => $amount_cash, 'shipping' => $shipping, 'ship_tax' => $shipping_tax, 'ship_tax_type' => $ship_taxtype, 'discount_rate' => $disc_val, 'total' => $total, 'pmethod' => $pmethod, 'notes' => $notes, 'status' => $status, 'csd' => $customer_id, 'eid' => $employee_id, 'pamnt' => $pamnt, 'taxstatus' => $tax, 'discstatus' => $discstatus, 'format_discount' => $discountFormat, 'refer' => $refer, 'term' => $pterms, 'multi' => $currency, 'i_class' => 1, 'loc' => $loc, 'hash_code' => getHashCode(),'company_id'=>$company_id);
            
            if ($this->db->insert('geopos_invoices', $data)) {

                $invocieno_n = $invocieno;
                $invocieno2 = $invocieno;
                $invocieno = $this->db->insert_id();
                $productlist = array();
                $invoice_total_items_count = 0;
                $invoice_items = $this->post('items');

                foreach ($invoice_items as $item) {


                    $total_discount += numberClean(@$item['product_total_discount']);
                    $total_tax += numberClean(@$item['product_total_tax']);

                    $data = array(
                        'tid' => $invocieno,
                        'pid' => $item['product_id'],
                        'product' => $item['product_name'],
                        'code' => $item['product_code'],
                        'qty' => numberClean($item['quantity']),
                        'price' => rev_amountExchange_s($item['product_price'], $currency, 0),
                        'tax' => numberClean($item['product_tax']),
                        'discount' => numberClean($item['product_discount']),
                        'subtotal' => rev_amountExchange_s($item['product_subtotal'], $currency, 0),
                        'totaltax' => rev_amountExchange_s($item['product_total_tax'], $currency, 0),
                        'totaldiscount' => rev_amountExchange_s($item['product_total_discount'], $currency, 0),
                        'product_des' => $item['product_description'],
                        'i_class' => 1,
                        'unit' => null,
                        'company_id'=>$company_id,
                        'hash_code' => getHashCode()
                    );

                    $productlist[] = $data;

                    $amt = numberClean($item['quantity']);
                    if ($item['product_id'] > 0) {
                        $this->db->set('qty', "qty-$amt", FALSE);
                        $this->db->where('pid', $item['product_id']);
                        $this->db->update('geopos_products');
                        
                    }
                    $invoice_total_items_count += $amt;


                }

                if (count($productlist)) {
                    $this->db->insert_batch('geopos_invoice_items', $productlist);
                    $this->db->set(array('discount' => rev_amountExchange_s(amountFormat_general($total_discount), $currency, 0), 'tax' => rev_amountExchange_s(amountFormat_general($total_tax), $currency, 0), 'items' => $invoice_total_items_count));
                    $this->db->where('id', $invocieno);
                    $this->db->update('geopos_invoices');

                } else {
                    $this->response([
                    'status' => FALSE,
                    'message' => 'Invalid Request Please Check all the required fields'
                ], REST_Controller::HTTP_UNPROCESSABLE_ENTITY);
                    $transok = false;
                }
                $this->load->model('billing_model', 'billing');
                $tnote = '#' . $invocieno_n . '-' . $pmethod;
                if ($pamnt > 0) $this->billing->paynow($invocieno, $pamnt, $tnote, $pmethod, 0, $bill_date, 0, $employee_id);
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
                $this->response([
                    'status' => FALSE,
                    'message' => 'Invalid Request Please Check all the required fields'
                ], REST_Controller::HTTP_UNPROCESSABLE_ENTITY);
                $transok = false;
            }
            if ($transok) {
                $this->db->trans_complete();
            } else {
                $this->db->trans_rollback();
            }
        //profit calculation
        $t_profit = 0;
        $this->db->select('geopos_invoice_items.pid, geopos_invoice_items.price, geopos_invoice_items.qty, geopos_products.fproduct_price');
        $this->db->from('geopos_invoice_items');
        $this->db->join('geopos_products', 'geopos_products.pid = geopos_invoice_items.pid', 'left');
        $this->db->where('geopos_invoice_items.tid', $invocieno);
        $this->db->where('geopos_invoice_items.company_id', $company_id);
        $query = $this->db->get();
        $pids = $query->result_array();
        foreach ($pids as $profit) {
            $t_cost = $profit['fproduct_price'] * $profit['qty'];
            $s_cost = $profit['price'] * $profit['qty'];

            $t_profit += $s_cost - $t_cost;
        }
        $data = array('type' => 9, 'rid' => $invocieno, 'col1' => $t_profit, 'd_date' => $bill_date,'company_id'=>$company_id);

        $this->db->insert('geopos_metadata', $data);

        $this->response([
                    'status' => true,
                    'message' => 'Invoice Was Created Successfull with number : '.$invocieno_n
                ], REST_Controller::HTTP_OK);

    }

    public function invoicepdf_get()
    {
        $run = false;
        $this->load->model('pos_invoices_model', 'invocies');
        $id = $this->get('id');
        $key = $this->get('key');
        $this->db->select('key');
        $this->db->from('geopos_restkeys');
        $this->db->limit(1);
        $this->db->where('key', $key);
        $query_r = $this->db->get();
        if ($query_r->num_rows() > 0) {
            $run = true;
        }


        if (!$run) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Invoice could not be found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }


        // Get the user from the array, using the id as key for retrieval.
        // Usually a model is to be used for this.
        $this->load->library('Aauth');
        $this->load->library('Custom');
        $tid = $id;
        $data['qrc'] = 'pos_' . date('Y_m_d_H_i_s') . '_.png';
        $data['id'] = $tid;
        $data['title'] = "Invoice $tid";
        $data['invoice'] = $this->invocies->invoice_details($tid);
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
        $html = $this->load->view('print_files/pos_pdf_compact', $data, true);
        // render the view into HTML

        $h = 160 + $this->pheight;
        $pdf->_setPageSize(array(70, $h), $pdf->DefOrientation);
        $pdf->WriteHTML($html);
        $file_name = substr($key, 0, 6) . $id;
        $pdf->Output('userfiles/pos_temp/' . $file_name . '.pdf', 'F');
        if (!extension_loaded('imagick')) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Imagick extension not installed!'
            ], REST_Controller::HTTP_OK);
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
        $this->set_response(array('w' => 1), REST_Controller::HTTP_OK);

    }
}
