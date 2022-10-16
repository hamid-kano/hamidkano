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
require_once APPPATH . 'third_party/vendor/autoload.php';
require_once APPPATH . 'third_party/qrcode/vendor/autoload.php';
require_once APPPATH . 'libraries/WebClientPrints/WebClientPrint.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\DummyPrintConnector;
use Mike42\Escpos\EscposImage;

use Omnipay\Omnipay;
use Endroid\QrCode\QrCode;


class C_QrCode Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('Invoices_model','invocies');
        $this->load->model('Settings_model','settings');
        $this->load->library("Custom");
    }


    public function check_qr($tid,$hash_code)
    {
    	
       if(intval($tid) > 0 and !empty($hash_code)){
        $tex_report = 1;

			        $data['id'] = $tid;
			        $data['title'] = "Invoice $tid";
			        $data['invoice'] = $this->invocies->invoice_details_check_qr($tid, $hash_code);
		if(!$data['invoice']['eid']){
			echo "الرقم غير صحيح، يرجى إعادة مسج الصورة مرة أخرى.";exit;
		}
			        $data['round_off'] = $this->custom->api_config(4);
			        $query = $this->db->query("SELECT * FROM geopos_system WHERE id=".getCompanyId()." LIMIT 1");
			        $addressResult = $query->row_array();
			        $data['address'] =$addressResult['country'].','.$addressResult['region'].','.$addressResult['city'].','.$addressResult['address'] ;
			            /* if ($this->aauth->get_user()->loc!=0) {
			                 $loc=$this->aauth->get_user()->loc;
			                   $query = $this->db->query('SELECT * FROM geopos_locations WHERE ware='.$loc.' LIMIT 1');
			                   
			        $addressResult = $query->row_array();
			    //   $addressResult['country'].','.$addressResult['region'].','.
			        $data['address'] =$addressResult['city'].','.$addressResult['address'] ;
			               
			            }*/
			        
			        if ($data['invoice']) $data['products'] = $this->invocies->invoice_products($tid);
			        if ($data['invoice']) $data['employee'] = $this->invocies->employee($data['invoice']['eid']);
			        $this->load->model('billing_model', 'billing');
			        //$online_pay = $this->billing->online_pay_settings();
			        //if ($online_pay['enable'] == 1) {
			            $token = hash_hmac('ripemd160', $tid, $this->config->item('encryption_key'));
			            $data['qrc'] = 'pos_' . date('Y_m_d_H_i_s') . '_.png';
			             $qrCode = new QrCode(base_url('C_QrCode/check_qr/' . $tid . '/' . $hash_code));
			//header('Content-Type: '.$qrCode->getContentType());
			//echo $qrCode->writeString();
			            $qrCode->writeFile(FCPATH . 'userfiles/pos_temp/' . $data['qrc']);
			        //}
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

			        $report_version = 'pos_pdf_compact_check';

			        if ($tex_report == 2){
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
    }


}