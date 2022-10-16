<?php
/**
 * Almusand -  Accounting,  Invoicing  and CRM Application
 * Copyright (c) Almusand. All Rights Reserved
 * ***********************************************************************
 *
 *  Email: support@almusand.com
 *  Website: https://almusand.com
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pdf
{
   var $temppath;
    function __construct()
    {
        $this->temppath= FCPATH . 'userfiles/temp/pdf';
    }

    function load($param = NULL)
    {
        require_once APPPATH . 'third_party/vendor/autoload.php';
        $mpdf = new \Mpdf\Mpdf(['tempDir' => $this->temppath,'mode' => 'utf-8', 'format' => 'A4', 'margin_left' => 5, 'margin_right' => 5, 'margin_top' => 5, 'margin_bottom' => 4]);
        //$mpdf->SetDirectionality('RTL');
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        return $mpdf;
    }

	function load_en($param = NULL)
    {


        require_once APPPATH . 'third_party/vendor/autoload.php';

        $mpdf = new \Mpdf\Mpdf(['tempDir' => $this->temppath]);

        //$mpdf->SetDirectionality('RTL');
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        return $mpdf;


    }


    function load_split($param = array('margin_top'=>40))
    {


        require_once APPPATH . 'third_party/vendor/autoload.php';

        $mpdf = new \Mpdf\Mpdf(['tempDir' => $this->temppath,'mode' => 'utf-8', 'format' => 'A4', 'margin_left' => 5, 'margin_right' => 5, 'margin_top' =>$param['margin_top'], 'margin_bottom' => 12]);

        //$mpdf->SetDirectionality('RTL');
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $mpdf->use_kwt = true;

        return $mpdf;


    }

        function load_thermal($param = NULL)
    {


        require_once APPPATH . 'third_party/vendor/autoload.php';

        $mpdf = new \Mpdf\Mpdf(['tempDir' => $this->temppath,'mode' => 'utf-8',  'margin_left' => 1, 'margin_right' => 1, 'margin_top' =>1, 'margin_bottom' => 1]);


        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $mpdf->use_kwt = true;


        return $mpdf;


    }
}