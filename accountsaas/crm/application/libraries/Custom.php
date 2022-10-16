<?php

class Custom
{
    function __construct()
    {
        $this->PI = &get_instance();
    }

    function add_fields($id = 0, $apply = 0)
    {
        $this->PI->db->where('f_module', $id);
        if($apply) $this->PI->db->where('f_view', $apply);
        $this->PI->db->order_by('id', 'DESC');
        $query = $this->PI->db->get('geopos_custom_fields');
        $result = $query->result_array();
        return $result;
    }


    function view_fields($id = 0, $apply = 0)
    {

        $this->PI->db->where('f_module', $id);
        if($apply)  $this->PI->db->where('f_view', $apply);
        $this->PI->db->order_by('id', 'DESC');
        $query = $this->PI->db->get('geopos_custom_fields');
        $result = $query->result_array();
        return $result;
    }

    function save_fields_data($rid = 0, $r_type = 0)
    {
        $custom = $this->PI->input->post('custom', true);
        $datalist = array();
        $dindex = 0;
        if(is_array($custom)) {
            foreach ($custom as $key => $value) {
                if ($value) {
                    $data = array(
                        'field_id' => $key,
                        'rid' => $rid,
                        'module' => $r_type,
                        'data' => $value
                    );
                    $datalist[$dindex] = $data;
                    $dindex++;
                }
            }
            $this->PI->db->insert_batch('geopos_custom_data', $datalist);
        }
    }

        function edit_save_fields_data($rid = 0, $r_type = 0)
    {
        $custom = $this->PI->input->post('custom', true);
         if(is_array($custom)) {
             $datalist = array();
             $dindex = 0;
             $this->PI->db->delete('geopos_custom_data', array('rid' => $rid, 'module' => $r_type));
             foreach ($custom as $key => $value) {
                 if ($value) {
                     $data = array(
                         'field_id' => $key,
                         'rid' => $rid,
                         'module' => $r_type,
                         'data' => $value
                     );
                     $datalist[$dindex] = $data;
                     $dindex++;
                 }
             }

             $this->PI->db->insert_batch('geopos_custom_data', $datalist);
         }
    }

    function view_fields_data($rid = 0,$r_type = 0,$view = 0)
    {


        $this->PI->db->select("geopos_custom_data.*,geopos_custom_fields.name ");
        $this->PI->db->from('geopos_custom_data');
        $this->PI->db->join('geopos_custom_fields', 'geopos_custom_data.field_id = geopos_custom_fields.id', 'left');


            $this->PI->db->where('geopos_custom_data.rid=', $rid);
             $this->PI->db->where('geopos_custom_data.module=', $r_type);
              $this->PI->db->where('geopos_custom_data.module=', $r_type);
              if($view)  $this->PI->db->where('geopos_custom_fields.f_view=', $view);
          $query = $this->PI->db->get();
        $result = $query->result_array();
        return $result;

    }

        function view_edit_fields($id = 0, $apply = 0)
    {


          $query = $this->PI->db->query("SELECT `geopos_custom_data`.`data`, `geopos_custom_fields`.* FROM `geopos_custom_fields` LEFT OUTER JOIN `geopos_custom_data` ON `geopos_custom_fields`.`id`=`geopos_custom_data`.`field_id` AND (`geopos_custom_data`.`rid` = '$id' OR `geopos_custom_data`.`rid` IS NULL) WHERE  `geopos_custom_fields`.`f_module` = $apply;");
        return $query->result_array();
    }





    function del_fields($rid,$r_type)
    {
        $this->PI->db->delete('geopos_custom_data', array('rid' => $rid,'module'=>$r_type));

    }


}