<?php

class Common
{
    function __construct()
    {
        $this->PI = &get_instance();
        
    }

    function taxlist($id = 0)
    {
        $tax_list = '';
        switch ($id) {
            case -1:
                $tax_list .= '<option value="yes" data-tformat="yes" selected>&raquo;' . $this->PI->lang->line('On') . '</option>';
                break;
            case -2:
                $tax_list .= '<option value="inclusive"  data-tformat="incl" selected>&raquo;' . $this->PI->lang->line('Inclusive') . '</option>';
                break;
            case -3:
                $tax_list .= '<option value="' . GST_INCL . '" data-tformat="cgst" selected>&raquo;' . $this->PI->lang->line('GST1') . '</option>';
                break;
            case -4:
                $tax_list .= '<option value="' . GST_INCL . '"  data-tformat="igst" selected>&raquo;' . $this->PI->lang->line('IGST') . '</option>';
                break;
            case 0:
                $tax_list .= '<option value="off" selected>&raquo;' . $this->PI->lang->line('Off') . '</option>';
                break;
        }
        if ($id > 0) {
            $this->PI->db->where('id', $id);
            $this->PI->db->where('company_id', getCompanyId());
            $this->PI->db->where('type', 2);
            $this->PI->db->order_by('id', 'DESC');
            $query = $this->PI->db->get('geopos_config');
            $row1 = $query->row_array();
            $tax_list .= '<option value="' . $row1['val4'] . '" data-tformat="' . $row1['val3'] . '" data-trate="' . $row1['val2'] . '">' . $row1['val1'] . '</option> ';
        }
        $tax_list .= '<option value="yes" data-tformat="yes">' . $this->PI->lang->line('On') . '</option>
                                            <option value="inclusive"  data-tformat="incl">' . $this->PI->lang->line('Inclusive') . '</option>
                                            <option value="off" data-tformat="off">' . $this->PI->lang->line('Off') . '</option>
                                            <option value="' . GST_INCL . '" data-tformat="cgst">' . $this->PI->lang->line('GST1') . '</option>
                                            <option value="' . GST_INCL . '" data-tformat="igst">' . $this->PI->lang->line('IGST') . '</option> ';

        $this->PI->db->where('type', 2);
        $this->PI->db->where('company_id', getCompanyId());
        $this->PI->db->order_by('id', 'DESC');
        $query = $this->PI->db->get('geopos_config');
        $result = $query->result_array();
        foreach ($result as $row) {
            $tax_list .= '<option value="' . $row['val4'] . '" data-tformat="' . $row['val3'] . '" data-trate="' . $row['val2'] . '">' . $row['val1'] . '</option> ';
        }
        return $tax_list;
    }

    function disclist()
    {
        $this->PI->db->where('id', 61);
        $this->PI->db->where('company_id', getCompanyId());
        $query = $this->PI->db->get('univarsal_api');
        $row1 = $query->row_array();
        $disclist = '<option value="' . $row1['key1'] . '">--' . $row1['other'] . '--</option> ';
        $disclist .= '<option value="%">' . $this->PI->lang->line('% Discount') . ' ' . $this->PI->lang->line('After TAX') . '</option>
                                                <option value="flat">' . $this->PI->lang->line('Flat Discount') . ' ' . $this->PI->lang->line('After TAX') . '</option>
                                                  <option value="b_p">' . $this->PI->lang->line('% Discount') . ' ' . $this->PI->lang->line('Before TAX') . '</option>
                                                <option value="bflat">' . $this->PI->lang->line('Flat Discount') . ' ' . $this->PI->lang->line('Before TAX') . '</option> ';


        return $disclist;
    }

    function disc_status()
    {
        $this->PI->db->where('id', 61);
        $this->PI->db->where('company_id', getCompanyId());
        $query = $this->PI->db->get('univarsal_api');
        $row1 = $query->row_array();
        return array('disc_format' => $row1['key1'], 'ship_tax' => $row1['url'], 'ship_rate' => $row1['key2']);
    }

    function taxsettings($id = 0)
    {
        $tax_list = '';
        switch ($id) {
            case -1:
                $tax_list .= '<option value="-1" data-tformat="yes" selected>&raquo;' . $this->PI->lang->line('On') . '</option>';
                break;
            case -2:
                $tax_list .= '<option value="-2"  data-tformat="incl" selected>&raquo;' . $this->PI->lang->line('Inclusive') . '</option>';
                break;
            case -3:
                $tax_list .= '<option value="-3" data-tformat="cgst" selected>&raquo;' . $this->PI->lang->line('GST1') . '</option>';
                break;
            case -4:
                $tax_list .= '<option value="-4"  data-tformat="igst" selected>&raquo;' . $this->PI->lang->line('IGST') . '</option>';
                break;
            case 0:
                $tax_list .= '<option value="0" selected>&raquo;' . $this->PI->lang->line('Off') . '</option>';
                break;
        }
        if ($id > 0) {
            $this->PI->db->where('id', $id);
            $this->PI->db->where('company_id', getCompanyId());
            $this->PI->db->where('type', 2);
            $this->PI->db->order_by('id', 'DESC');
            $query = $this->PI->db->get('geopos_config');
            $row1 = $query->row_array();
            $tax_list .= '<option value="' . $row1['id'] . '" data-tformat="' . $row1['val3'] . '" data-trate="' . $row1['val2'] . '">' . $row1['val1'] . '</option> ';
        }
        $tax_list .= '<option value="-1" data-tformat="yes">' . $this->PI->lang->line('On') . '</option>
                                            <option value="-2"  data-tformat="incl">' . $this->PI->lang->line('Inclusive') . '</option>
                                            <option value="0" data-tformat="off">' . $this->PI->lang->line('Off') . '</option>
                                            <option value="-3" data-tformat="cgst">' . $this->PI->lang->line('GST1') . '</option>
                                            <option value="-4" data-tformat="igst">' . $this->PI->lang->line('IGST') . '</option> ';

        $this->PI->db->where('type', 2);
        $this->PI->db->where('company_id', getCompanyId());
        $this->PI->db->order_by('id', 'DESC');
        $query = $this->PI->db->get('geopos_config');
        $result = $query->result_array();
        foreach ($result as $row) {
            $tax_list .= '<option value="' . $row['id'] . '" data-tformat="' . $row['val3'] . '" data-trate="' . $row['val2'] . '">' . $row['val1'] . '</option> ';
        }
        return $tax_list;
    }

    function taxlist_edit($id = 0)
    {
        $tax_list = '';
        switch ($id) {
            case 'yes':
                $tax_list .= '<option value="yes"  data-tformat="yes" selected>&raquo;' . $this->PI->lang->line('On') . '</option>';
                break;
            case 'incl':
                $tax_list .= '<option value="inclusive"  data-tformat="incl" selected>&raquo;' . $this->PI->lang->line('Inclusive') . '</option>';
                break;
            case 'cgst':
                $tax_list .= '<option value="' . GST_INCL . '" data-tformat="cgst" selected>&raquo;' . $this->PI->lang->line('GST1') . '</option>';
                break;
            case 'igst':
                $tax_list .= '<option value="' . GST_INCL . '"  data-tformat="igst" selected>&raquo;' . $this->PI->lang->line('IGST') . '</option>';
                break;
            case 'no':
                $tax_list .= '<option value="off" selected>&raquo;' . $this->PI->lang->line('Off') . '</option>';
                break;
        }
        $tax_list .= '<option value="yes" data-tformat="yes">' . $this->PI->lang->line('On') . '</option>
                                            <option value="inclusive"  data-tformat="incl">' . $this->PI->lang->line('Inclusive') . '</option>
                                            <option value="off" data-tformat="off">' . $this->PI->lang->line('Off') . '</option>
                                            <option value="' . GST_INCL . '" data-tformat="cgst">' . $this->PI->lang->line('GST1') . '</option>
                                            <option value="' . GST_INCL . '" data-tformat="igst">' . $this->PI->lang->line('IGST') . '</option> ';

        $this->PI->db->where('type', 2);
        $this->PI->db->where('company_id', getCompanyId());
        $this->PI->db->order_by('id', 'DESC');
        $query = $this->PI->db->get('geopos_config');
        $result = $query->result_array();
        foreach ($result as $row) {
            $tax_list .= '<option value="' . $row['val4'] . '" data-tformat="' . $row['val3'] . '" data-trate="' . $row['val2'] . '">' . $row['val1'] . '</option> ';
        }
        return $tax_list;
    }

    function taxdetail()
    {
        $tax_name = '';
        switch ($this->PI->config->item('tax')) {
            case -1:
                $tax_f = 'yes';
                $tax_name = '%';
                break;
            case -2:
                $tax_f = 'incl';
                $tax_name = 'incl';
                break;
            case -3:
                $tax_f = 'cgst';
                $tax_name = '%';
                if (GST_INCL == 'inclusive') $tax_name = 'incl';
                break;
            case -4:
                $tax_f = 'igst';
                $tax_name = '%';
                if (GST_INCL == 'inclusive') $tax_name = 'incl';
                break;
            case 0:
                $tax_f = 'no';
                $tax_name = 'off';
                break;
        }
        if ($this->PI->config->item('tax') > 0) {
            $this->PI->db->where('id', $this->PI->config->item('tax'));
            $this->PI->db->where('company_id', getCompanyId());
            $this->PI->db->where('type', 2);
            $this->PI->db->order_by('id', 'DESC');
            $query = $this->PI->db->get('geopos_config');
            $row1 = $query->row_array();
            $tax_f = $row1['val3'];
            $tax_name = '%';
            if ($row1['val4'] == 'inclusive') {
                $tax_name = 'incl';
            }
            $tax_f = $row1['val3'];
        }
        if ($tax_f == 'inclusive') {
            $tax_f = 'incl';
        }

        return array('format' => $tax_f, 'handle' => $tax_name);
    }

    function taxhandle_edit($ty = '')
    {
        switch ($ty) {
            case 'yes':
                $tax_name = '%';
                break;
            case 'incl':
                $tax_name = 'incl';
                break;
            case 'cgst':
                $tax_name = '%';
                if (GST_INCL == 'inclusive') $tax_name = 'incl';
                break;
            case 'igst':
                $tax_name = '%';
                if (GST_INCL == 'inclusive') $tax_name = 'incl';
                break;
            case 'no':
                $tax_name = 'off';
                break;
            default:
                $tax_name = '%';
                break;
        }
        return $tax_name;
    }
    function languages($id = 0)
    {
        if ($id) {
            $this->PI->db->select('lang');
            $this->PI->db->from('geopos_locations');
            $this->PI->db->where('id', $id);
            $this->PI->db->where('company_id', getCompanyId());
            $query = $this->PI->db->get();
            $out = $query->row_array();
        } else {
            $this->PI->db->select('*');
            $this->PI->db->from('geopos_system');
            $this->PI->db->where('id', getCompanyId());
            $query = $this->PI->db->get();
            $out = $query->row_array();
        }
        $lang = '<option value="' . $out['lang'] . '">--' . $out['lang'] . '--</option><option value="english">English</option> <option value="arabic">Arabic</option><option value="bengali">Bengali</option>
                       <option value="czech">Czech</option><option value="chinese-simplified">Chinese-simplified</option> <option value="chinese-traditional">Chinese-traditional</option> <option value="dutch">Dutch</option><option value="french">French</option><option value="german">German</option><option value="greek">Greek</option><option value="hindi">Hindi</option><option value="indonesian">Indonesian</option>  <option value="italian">Italian</option><option value="japanese">Japanese</option><option value="korean">Korean</option><option value="latin">Latin</option> <option value="polish">Polish</option><option value="portuguese">Portuguese</option> <option value="russian">Russian</option> <option value="swedish">Swedish</option><option value="spanish">Spanish</option><option value="turkish">Turkish</option><option value="urdu">Urdu</option>';
        return $lang;
    }

    function current_language($lang = '')
    {
        $lang = '<option value="' . $lang . '">--' . $lang . '--</option><option value="english">English</option> <option value="arabic">Arabic</option><option value="bengali">Bengali</option>
                       <option value="czech">Czech</option><option value="chinese-simplified">Chinese-simplified</option> <option value="chinese-traditional">Chinese-traditional</option> <option value="dutch">Dutch</option><option value="french">French</option><option value="german">German</option><option value="greek">Greek</option><option value="hindi">Hindi</option><option value="indonesian">Indonesian</option>  <option value="italian">Italian</option><option value="japanese">Japanese</option><option value="korean">Korean</option><option value="latin">Latin</option> <option value="polish">Polish</option><option value="portuguese">Portuguese</option> <option value="russian">Russian</option> <option value="swedish">Swedish</option><option value="spanish">Spanish</option><option value="turkish">Turkish</option><option value="urdu">Urdu</option>';
        return $lang;

    }

    public function default_warehouse()
    {
        if ($this->PI->aauth->get_user()->loc) {
            $wr = '<option value="0">*' . $this->PI->lang->line('All') . '</option>';
            $this->PI->db->select('geopos_locations.ware,geopos_warehouse.title');
            $this->PI->db->from('geopos_locations');
            $this->PI->db->join('geopos_warehouse', 'geopos_locations.ware=geopos_warehouse.id', 'left');
            $this->PI->db->where('geopos_locations.company_id', getCompanyId());
            $this->PI->db->where('geopos_locations.id', $this->PI->aauth->get_user()->loc);
            $query = $this->PI->db->get();
            $result = $query->row_array();
            if ($result['ware']) $wr = '<option value="' . $result['ware'] . '">' . $result['title'] . '</option>';
            return $wr;
        } else {
            $wr = '<option value="0">*' . $this->PI->lang->line('All') . '</option>';
            $this->PI->db->select('univarsal_api.key1,geopos_warehouse.title');
            $this->PI->db->from('univarsal_api');
            $this->PI->db->where('univarsal_api.company_id', getCompanyId());
            $this->PI->db->join('geopos_warehouse', 'univarsal_api.key1=geopos_warehouse.id', 'left');
            $this->PI->db->where('univarsal_api.id', 60);
            $query = $this->PI->db->get();
            $result = $query->row_array();
            if ($result['title']) $wr = '<option value="' . $result['key1'] . '">' . $result['title'] . '</option>';
            return $wr;
        }
    }
    function zero_stock()
    {
        $this->PI->db->where('id', 63);
        $this->PI->db->where('univarsal_api.company_id', getCompanyId());
        $query = $this->PI->db->get('univarsal_api');
        $row1 = $query->row_array();
        return $row1['key1'];
    }

}