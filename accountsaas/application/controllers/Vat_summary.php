<?php

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


class Vat_summary extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library("Aauth");

        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(1)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
    }

    function show()
    {
        $head['title'] = "VAT Summary";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('reports/vat_summary_page');
        $this->load->view('fixed/footer');
    }
     function print()
    {
        $data['open_date'] = $date = datefordatabase($this->input->get('open_date'));
        $data['open_t_date'] = $date2 = datefordatabase($this->input->get('open_t_date'));

        $this->load->model('pos_invoices_model', 'invocies');
         $data['invoices'] = $this->invocies->invoices_by_date($date,$date2);

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
        $html = $this->load->view('print_files/vat_summary', $data, true);
        $h = 160 + $this->pheight;

        $pdf->WriteHTML($html);
        // render the view into HTML
        // write the HTML into the PDF
        $file_name = preg_replace('/[^A-Za-z0-9]+/', '-', 'vat_summery' . $date);
        if ($this->input->get('d')) {
            $pdf->Output($file_name . '.pdf', 'D');
        } else {
            $pdf->Output($file_name . '.pdf', 'I');
        }
        unlink('userfiles/pos_temp/' . $data['qrc']);
    }
    
}

?>