<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


function sitezconfig($input)
{
    //get main CodeIgniter object
    $ci =& get_instance();
    $ci->load->database();

    //get data from database
    $query = $ci->db->query("SELECT * FROM geopos_system WHERE id=1 LIMIT 1");
    $row = $query->row_array();
    if (@$row["$input"]) {
        return $row["$input"];
    } else {
        return NULL;
    }
}

function assets_url($input='')
{
    return base_url($input);
}

function dateformat($input)
{
    $ci =& get_instance();
    $date = new DateTime($input);
    $date = $date->format($ci->config->item('dformat'));
    return $date;
}

function datefordatabase($input)
{
    $ci =& get_instance();
    $date = new DateTime($input);
    $date = $date->format('Y-m-d H:i:s');
    return $date;
}

function user_role($id = 5)
{ $ci =& get_instance();
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
    $ci->load->database();

    $query = $ci->db->query("SELECT currency FROM geopos_system WHERE id=1 LIMIT 1");
    $row = $query->row_array();
    $currency = $row['currency'];

    //get data from database
    $query2 = $ci->db->query("SELECT * FROM univarsal_api WHERE id=4 LIMIT 1");
    $row = $query2->row_array();
    //Format money as per country

    if ($row['method'] == 'l') {
        return $currency . ' ' . @number_format($number, $row['url'], $row['key1'], $row['key2']);
    } else {
        return @number_format($number, $row['url'], $row['key1'], $row['key2']) . ' ' . $currency;
    }

}

function appset()
{
    $ci =& get_instance();
    $ci->load->database();
    $query = $ci->db->query("SELECT * FROM geopos_system WHERE id=1 LIMIT 1");
    $row = $query->row_array();
    $this->config->set_item('ctitle', $row["cname"]);
    $this->config->set_item('address', $row["address"]);
    $this->config->set_item('city', $row["city"]);
    $this->config->set_item('region', $row["region"]);
    $this->config->set_item('country', $row["country"]);
    $this->config->set_item('phone', $row["phone"]);
    $this->config->set_item('email', $row["email"]);
    $this->config->set_item('tax', $row["tax"]);
    $this->config->set_item('taxno', $row["taxid"]);
    $this->config->set_item('currency', $row["currency"]);
    $this->config->set_item('format_curr', $row["currency_format"]);
    $this->config->set_item('prefix', $row["prefix"]);
    // $this->config->set_item('date_f',$row["dfomat"]);
    $this->config->set_item('tzone', $row["zone"]);
    $this->config->set_item('logo', $row["logo"]);


    switch ($row['dformat']) {
        case 1:
            $this->config->set_item('date', date("d-m-Y"));
            $this->config->set_item('dformat', "d-m-Y");
            $this->config->set_item('dformat2', "dd-mm-yy");
            break;
        case 2:
            $this->config->set_item('date', date("Y-m-d"));
            $this->config->set_item('dformat', "Y-m-d");
            $this->config->set_item('dformat2', "yy-mm-dd");
            break;
        case 3:
            $this->config->set_item('date', date("Y-m-d"));
            $this->config->set_item('dformat', "Y-m-d");
            $this->config->set_item('dformat2', "yy-mm-dd");
            break;
    }


}

function amountFormat_s($number)
{
    $ci =& get_instance();
    $ci->load->database();

    //get data from database
    $query2 = $ci->db->query("SELECT * FROM univarsal_api WHERE id=4 LIMIT 1");
    $row = $query2->row_array();
    //Format money as per country

    if ($row['method'] == 'l') {
        return @number_format($number, $row['url'], $row['key1'], $row['key2']);
    } else {
        return @number_format($number, $row['url'], $row['key1'], $row['key2']);
    }

}
function amountExchange($number, $id = 0)
{
    $ci =& get_instance();
    $ci->load->database();
    if ($id > 0) {
        $query = $ci->db->query("SELECT * FROM geopos_currencies WHERE id='$id' LIMIT 1");
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

        $query = $ci->db->query("SELECT currency FROM geopos_system WHERE id=1 LIMIT 1");
        $row = $query->row_array();
        $currency = $row['currency'];

        //get data from database
        $query2 = $ci->db->query("SELECT * FROM univarsal_api WHERE id=4 LIMIT 1");
        $row = $query2->row_array();
        //Format money as per country

        if ($row['method'] == 'l') {
            return $currency . ' ' . @number_format($number, $row['url'], $row['key1'], $row['key2']);
        } else {
            return @number_format($number, $row['url'], $row['key1'], $row['key2']) . ' ' . $currency;
        }
    }

}

function location($number=0)
{
    $ci =& get_instance();
    $ci->load->database();

        if ($number > 0) {
            $query2 = $ci->db->query("SELECT * FROM geopos_locations WHERE id=$number");
            return $query2->row_array();
        } else {
            $query2 = $ci->db->query("SELECT cname,address,city,region,country,postbox,phone,email,taxid,logo FROM geopos_system WHERE id=1 LIMIT 1");
            return $query2->row_array();
        }

}



