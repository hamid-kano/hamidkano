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

class Events_model extends CI_Model
{


    /*Read the data from DB */
    public function getEvents($start, $end)
    {
        $e2=date('Y-m-d', strtotime($end. ' - 60 days'));
        $sql = "SELECT * FROM geopos_events WHERE company_id=".getCompanyId()."  and ((geopos_events.start BETWEEN ? AND ?) OR (geopos_events.end > ? )) ORDER BY geopos_events.start ASC";

        return $this->db->query($sql, array($start, $end,$e2))->result();
    }

    /*Create new events */

    public function addEvent($title, $start, $end, $description, $color)
    {

        $data = array(
            'title' => $title,
            'start' => $start,
            'end' => $end,

            'description' => $description,
            'color' => $color,'company_id'=>getCompanyId(),'hash_code'=>getHashCode() 
        );

        if ($this->db->insert('geopos_events', $data)) {
            return true;
        } else {
            return false;
        }
    }

    /*Update  event */

    public function updateEvent($id, $title, $description, $color)
    {

        $sql = "UPDATE geopos_events SET title = ?, description = ?, color = ? WHERE id = ? and company_id= ?";
        $this->db->query($sql, array($title, $description, $color, $id,getCompanyId()));
        return ($this->db->affected_rows() != 1) ? false : true;
    }


    /*Delete event */

    public function deleteEvent()
    {

        $sql = "DELETE FROM geopos_events WHERE id = ? and company_id= ?";
        $this->db->query($sql, array($_GET['id'],getCompanyId()));
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    /*Update  event */

    public function dragUpdateEvent()
    {

        $sql = "UPDATE geopos_events SET  geopos_events.start = ? ,geopos_events.end = ?  WHERE id = ? and company_id= ? ";
        $this->db->query($sql, array($_POST['start'], $_POST['end'], $_POST['id'],getCompanyId()));
        return ($this->db->affected_rows() != 1) ? false : true;


    }

}