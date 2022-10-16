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


function dateformat($input)
{
    $ci =& get_instance();
    $date = new DateTime($input);
    $date = $date->format($ci->config->item('dformat'));
    return $date;
}

function assets_url($input = '')
{
    return base_url($input);
}

function dateformat_time($input)
{
    $ci =& get_instance();
    $date = new DateTime($input);
    $date = $date->format($ci->config->item('dformat') . ' H:i:s');
    return $date;
}

function datefordatabase($input)
{
    $date = new DateTime($input);
    $date = $date->format('Y-m-d H:i:s');
    return $date;
}

function timefordatabase($input)
{
    $time = new DateTime($input);
    $time = $time->format('H:i:s');
    return $time;
}

function user_role($id = 5)
{
    $ci =& get_instance();
    switch ($id) {
        case 5:
            return $ci->lang->line('Business Owner');
            break;
        case 4:
            return $ci->lang->line('Business Manager');
            break;
        case 3:
            return $ci->lang->line('Sales Manager');
            break;
        case 2:
            return $ci->lang->line('Sales Person');
            break;
        case 1:
            return $ci->lang->line('Inventory Manager');
            break;
        case -1:
            return $ci->lang->line('Project Manager');
            break;
    }
}

function amountFormat($number)
{
    $ci =& get_instance();
    $query = $ci->db->query("SELECT currency FROM geopos_system WHERE id=".$ci->session->userdata('company_id')." LIMIT 1");
    $row = $query->row_array();
    $currency = $row['currency'];
    //get data from database
    $query2 = $ci->db->query("SELECT * FROM univarsal_api WHERE id=4 and company_id=".$ci->session->userdata('company_id')." LIMIT 1");
    $row = $query2->row_array();
    //Format money as per country
    if ($row['method'] == 'l') {
        return $currency . ' ' . @number_format($number, $row['url'], $row['key1'], $row['key2']);
    } else {
        return @number_format($number, $row['url'], $row['key1'], $row['key2']) . ' ' . $currency;
    }

}

function prefix($number)
{
    $ci =& get_instance();
    $query2 = $ci->db->query("SELECT * FROM univarsal_api WHERE id=51 and company_id=".$ci->session->userdata('company_id')." LIMIT 1");
    $row = $query2->row_array();
    //Format money as per country
    switch ($number) {
        case 1:
            return $row['name'];
            break;
        case 2:
            return $row['key1'];
            break;
        case 3:
            return $row['key2'];
            break;
        case 4:
            return $row['url'];
            break;
        case 5:
            return $row['method'];
            break;
        case 6:
            return $row['other'];
            break;
        case 7:
            $query2 = $ci->db->query("SELECT other FROM univarsal_api WHERE id=52 and company_id=".$ci->session->userdata('company_id')." LIMIT 1");
            $row = $query2->row_array();
            return $row['other'];
            break;
    }
}

function user_premission($input1, $input2)
{
    if (hash_equals($input1, $input2)) {
        return true;
    } else {
        return false;
    }
}


function amountFormat_s($number)
{
    $ci =& get_instance();
    $ci->load->database();
    //get data from database
    $query2 = $ci->db->query("SELECT * FROM univarsal_api WHERE id=4 and company_id=".$ci->session->userdata('company_id')." LIMIT 1");
    $row = $query2->row_array();
    //Format money as per country

    return @number_format($number, $row['url'], $row['key1'], $row['key2']);

}

function amountFormat_general($number)
{
    $ci =& get_instance();
    $ci->load->database();
    //get data from database
    $query2 = $ci->db->query("SELECT * FROM univarsal_api WHERE id=4 and company_id=".$ci->session->userdata('company_id')." LIMIT 1");
    $row = $query2->row_array();
    //Format money as per country
    $number = @number_format($number, $row['url'], $row['key1'], '');
    return $number;
}

function numberClean($number)
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM univarsal_api WHERE id=4 and company_id=".$ci->session->userdata('company_id')." LIMIT 1");
    $row = $query2->row_array();
    $number = str_replace($row['key2'], "", $number);
    $number = str_replace($row['key1'], ".", $number);
    return $number;
}


function amountExchange($number, $id = 0, $loc = 0)
{
    $ci =& get_instance();
    $ci->load->database();
    if ($loc > 0 && $id == 0) {
        $query = $ci->db->query("SELECT cur FROM geopos_locations WHERE id='$loc' and company_id=".$ci->session->userdata('company_id')." LIMIT 1");
        $row = $query->row_array();
        $id = $row['cur'];
    }
    if ($id > 0) {
        $query = $ci->db->query("SELECT * FROM geopos_currencies WHERE id='$id' and company_id=".$ci->session->userdata('company_id')." LIMIT 1");
        $row = $query->row_array();
        $currency = $row['symbol'];
        $rate = $row['rate'];
        $thosand = $row['thous'];
        $dec_point = $row['dpoint'];
        $decimal_after = $row['decim'];
        $totalamount = $rate * $number;
        //get data from database
        //Format money as per country
        if ($row['cpos'] == 0) {
            return $currency . ' ' . @number_format($totalamount, $decimal_after, $dec_point, $thosand);
        } else {
            return @number_format($totalamount, $decimal_after, $dec_point, $thosand) . ' ' . $currency;
        }
    } else {

        $query = $ci->db->query("SELECT currency FROM geopos_system WHERE id=".$ci->session->userdata('company_id')." LIMIT 1");
        $row = $query->row_array();
        $currency = $row['currency'];

        //get data from database
        $query2 = $ci->db->query("SELECT * FROM univarsal_api WHERE id=4 and company_id=".$ci->session->userdata('company_id')." LIMIT 1");
        $row = $query2->row_array();
        //Format money as per country
        if ($row['method'] == 'l') {
            return $currency . ' ' . @number_format($number, $row['url'], $row['key1'], $row['key2']);
        } else {
            return @number_format($number, $row['url'], $row['key1'], $row['key2']) . ' ' . $currency;
        }
    }

}

function amountExchange_s($number, $id = 0, $loc = 0)
{
    $ci =& get_instance();
    $ci->load->database();
    if ($loc > 0 && $id == 0) {
        $query = $ci->db->query("SELECT cur FROM geopos_locations WHERE id='$loc' and company_id=".$ci->session->userdata('company_id')." LIMIT 1");
        $row = $query->row_array();
        $id = $row['cur'];
    }
    if ($id > 0) {
        $query = $ci->db->query("SELECT * FROM geopos_currencies WHERE id='$id' and company_id=".$ci->session->userdata('company_id')." LIMIT 1");
        $row = $query->row_array();
        $rate = $row['rate'];
        $dec_point = $row['decim'];
        $totalamount = $rate * $number;
        $totalamount = number_format($totalamount, $dec_point, $dec_point, '');
        return $totalamount;
    } else {
        $query = $ci->db->query("SELECT currency FROM geopos_system WHERE id=".$ci->session->userdata('company_id')." LIMIT 1");
        $row = $query->row_array();
        $currency = $row['currency'];
        //get data from database
        $query2 = $ci->db->query("SELECT * FROM univarsal_api WHERE id=4 and company_id=".$ci->session->userdata('company_id')." LIMIT 1");
        $row = $query2->row_array();
        $number = number_format($number, $row['url'], $row['key1'], '');
        return $number;
    }

}

function edit_amountExchange_s($number, $id = 0, $loc = 0)
{
    $ci =& get_instance();
    $ci->load->database();
    if ($loc > 0) {
        $query = $ci->db->query("SELECT cur FROM geopos_locations WHERE id='$loc' and company_id=".$ci->session->userdata('company_id')." LIMIT 1");
        $row = $query->row_array();
        $id = $row['cur'];
    }
    if ($id > 0) {
        $query = $ci->db->query("SELECT * FROM geopos_currencies WHERE id='$id' and company_id=".$ci->session->userdata('company_id')." LIMIT 1");
        $row = $query->row_array();
        $rate = $row['rate'];
        $decimal_after = $row['decim'];
        $dec_point = $row['dpoint'];
        $number = str_replace($decimal_after, "", $number);
        $number = str_replace($dec_point, ".", $number);
        $totalamount = $rate * $number;
        $totalamount = number_format($totalamount, $decimal_after, $dec_point, '');
        return $totalamount;
    } else {
        $query = $ci->db->query("SELECT currency FROM geopos_system WHERE id=".$ci->session->userdata('company_id')." LIMIT 1");
        $row = $query->row_array();
        $currency = $row['currency'];
        //get data from database
        $query2 = $ci->db->query("SELECT * FROM univarsal_api WHERE id=4 and company_id=".$ci->session->userdata('company_id')." LIMIT 1");
        $row = $query2->row_array();
       // $number = str_replace($row['key2'], "", $number);
        //$number = str_replace($row['key1'], ".", $number);
        $number = number_format($number, $row['url'], $row['key1'], '');
        return $number;
    }

}

function rev_amountExchange_s($number, $id = 0, $loc = 0)
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT other FROM univarsal_api WHERE id=5  and company_id=".$ci->session->userdata('company_id')." LIMIT 1");
    $row = $query2->row_array();
    $revers = $row['other'];
    if ($loc) {
        $query = $ci->db->query("SELECT cur FROM geopos_locations WHERE id='$loc' and company_id=".$ci->session->userdata('company_id')." LIMIT 1");
        $row = $query->row_array();
        $lcid = $row['cur'];
        if ($lcid > 0) {
            $query = $ci->db->query("SELECT * FROM geopos_currencies WHERE id='$lcid' and company_id=".$ci->session->userdata('company_id')." LIMIT 1");
            $row = $query->row_array();
            if($row['id']){
            $rate = $row['rate'];
            $number = str_replace($row['thous'], "", $number);
            $number = str_replace($row['dpoint'], ".", $number);
            $number = $number / $rate;
            }
            else {
        $query2 = $ci->db->query("SELECT * FROM univarsal_api WHERE id=4 and company_id=".$ci->session->userdata('company_id')." LIMIT 1");
        $row = $query2->row_array();
        $number = str_replace($row['key2'], "", $number);
        $number = str_replace($row['key1'], ".", $number);

    }
        } elseif ($id) {
            $query = $ci->db->query("SELECT * FROM geopos_currencies WHERE id='$id' and company_id=".$ci->session->userdata('company_id')." LIMIT 1");
            $row = $query->row_array();
            $rate = $row['rate'];
            $number = str_replace($row['thous'], "", $number);
            $number = str_replace($row['dpoint'], ".", $number);
            $number = $number / $rate;
        }
        else {
        $query2 = $ci->db->query("SELECT * FROM univarsal_api WHERE id=4 and company_id=".$ci->session->userdata('company_id')." LIMIT 1");
        $row = $query2->row_array();
        $number = str_replace($row['key2'], "", $number);
        $number = str_replace($row['key1'], ".", $number);

    }
    } elseif ($id) {
        $query = $ci->db->query("SELECT * FROM geopos_currencies WHERE id='$id' and company_id=".$ci->session->userdata('company_id')." LIMIT 1");
        $row = $query->row_array();
        $rate = $row['rate'];
        $number = str_replace($row['thous'], "", $number);
        $number = str_replace($row['dpoint'], ".", $number);
        if ($revers) {

            $number = $number / $rate;
        }
    } else {
        $query2 = $ci->db->query("SELECT * FROM univarsal_api WHERE id=4 and company_id=".$ci->session->userdata('company_id')." LIMIT 1");
        $row = $query2->row_array();
        $number = str_replace($row['key2'], "", $number);
        $number = str_replace($row['key1'], ".", $number);

    }

    return $number;
}

function rev_amountExchange($number, $id = 0)
{
    $ci =& get_instance();
    $query = $ci->db->query("SELECT other FROM univarsal_api WHERE id='5' and company_id=".$ci->session->userdata('company_id')." LIMIT 1");
    $row = $query->row_array();
    $reverse = $row['other'];
    if ($reverse && $id > 0) {
        $query = $ci->db->query("SELECT rate FROM geopos_currencies WHERE id='$id' and company_id=".$ci->session->userdata('company_id')." LIMIT 1");
        $row = $query->row_array();
        $rate = $row['rate'];
        $totalamount = $number / $rate;
        return $totalamount;
    } else {
        return $number;
    }
}

function array_compare()
{
    $criteriaNames = func_get_args();
    $compare = function ($first, $second) use ($criteriaNames) {
        while (!empty($criteriaNames)) {
            $criterion = array_shift($criteriaNames);
            $sortOrder = 1;
            if (is_array($criterion)) {
                $sortOrder = $criterion[1] == SORT_DESC ? -1 : 1;
                $criterion = $criterion[0];
            }
            if ($first[$criterion] < $second[$criterion]) {
                return -1 * $sortOrder;
            } else if ($first[$criterion] > $second[$criterion]) {
                return 1 * $sortOrder;
            }
        }
        return 0;
    };

    return $compare;
}

function locations()
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM geopos_locations where company_id=".$ci->session->userdata('company_id')."");
    return $query2->result_array();
}

function location($number = 0)
{
    $ci =& get_instance();
    $ci->load->database();
    if ($number > 0) {
        $query2 = $ci->db->query("SELECT * FROM geopos_locations WHERE id=$number and company_id=".$ci->session->userdata('company_id')." ");
        return $query2->row_array();
    } else {
        $query2 = $ci->db->query("SELECT cname,address,city,region,country,postbox,phone,email,taxid,logo,foundation FROM geopos_system WHERE id=".$ci->session->userdata('company_id')." LIMIT 1");
        return $query2->row_array();
    }
}

function active($input1)
{

    $t_file = APPPATH . 'config' . DIRECTORY_SEPARATOR . 'lic.php';
    if (is_writeable($t_file)) {
        file_put_contents($t_file, $input1);
        $lc = file_get_contents($t_file);
        if (empty($lc)) {
            echo json_encode(array('status' => 'WError', 'message' => 'Server write permissions denied'));
        } else {
            if ($input1 == 2) {
                echo json_encode(array('status' => 'Error', 'message' => 'License error!'));
            } else {
                echo json_encode(array('status' => 'Success', 'message' => 'License updated!'));
            }
        }
    } else {
        echo json_encode(array('status' => 'WError', 'message' => 'Server write permissions denied!'));
    }

}

function currency($loc = 0, $id = 0)
{
    $ci =& get_instance();
    $ci->load->database();
    if ($loc > 0 && $id == 0) {
        $query = $ci->db->query("SELECT cur FROM geopos_locations WHERE id='$loc' and company_id=".$ci->session->userdata('company_id')." LIMIT 1");
        $row = $query->row_array();
        if(!isset($row['cur'])){
            $row['cur'] = 0;
        }
        $id = $row['cur'];
    }
    if ($id > 0) {
        $query = $ci->db->query("SELECT * FROM geopos_currencies WHERE id='$id' and company_id=".$ci->session->userdata('company_id')." LIMIT 1");
        $row = $query->row_array();
        $currency = $row['symbol'];
    } else {
        $query = $ci->db->query("SELECT currency FROM geopos_system WHERE id=".$ci->session->userdata('company_id')." LIMIT 1");
        $row = $query->row_array();
        $currency = $row['currency'];
    }
    return $currency;
}

function plugins_checker()
{
    $path = FCPATH . 'application/plugins';
    $plugins = array_diff(scandir($path), array('.', '..'));
    foreach ($plugins as $row) {
        $url = file_get_contents($path . '/' . $row);
        $plug = json_decode($url, true);
        echo '    <li><a class="dropdown-item"
                                                           href="' . base_url() . $plug['path'] . '"><i
                                                                    class="ft-chevron-right"></i> ' . $plug['name'] . '
                                                        </a></li>';
    }
}

function custom_plugins_checker($name='sms')
{
    $path = FCPATH . 'application'.DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.$name;
      if(file_exists($path)) {


          $plugins = array_diff(scandir($path), array('.', '..'));
          foreach ($plugins as $row) {
              $url = file_get_contents($path . '/' . $row);
              $plug = json_decode($url, true);
              echo '    <li><a class="dropdown-item"
                                                           href="' . base_url() . $plug['path'] . '"><i
                                                                    class="ft-chevron-right"></i> ' . $plug['name'] . '
                                                        </a></li>';
          }
      }
}

function datatable_lang()
{
    $ci =& get_instance();
    $result='';
   $lang= $ci->config->item('mylang');
   $dfile=FCPATH . 'application/language/'.$lang.'/datatable.php';
   if(file_exists($dfile)) $result=include_once($dfile);
    echo $result;
}

function accounting($loc = 0)
{
    $ci =& get_instance();
    $ci->load->database();
    if ($loc > 0) {
        $query = $ci->db->query("SELECT cur FROM geopos_locations WHERE id='$loc' and company_id=".$ci->session->userdata('company_id')." LIMIT 1");
        $row = $query->row_array();
        $id = $row['cur'];
        if ($id > 0) {
            $query = $ci->db->query("SELECT * FROM geopos_currencies WHERE id='$id' and company_id=".$ci->session->userdata('company_id')." LIMIT 1");
            $row = $query->row_array();

            $thosand = $row['thous'];
            $dec_point = $row['dpoint'];
            $decimal_after = $row['decim'];
        }
    } else {
        $query2 = $ci->db->query("SELECT * FROM univarsal_api WHERE id=4 and company_id=".$ci->session->userdata('company_id')." LIMIT 1");
        $row = $query2->row_array();

        $thosand = $row['key2'];
        $dec_point = $row['key1'];
        $decimal_after = $row['url'];
    }

    echo " <script type='text/javascript'>accounting.settings = {number: {precision :$decimal_after,thousand: '$thosand',decimal : '$dec_point'}};
var two_fixed=$decimal_after; </script>";

}