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

class Tools_model extends CI_Model
{

    var $column_order = array('status', 'name', 'duedate', 'tdate', null, null);
    var $column_search = array('name', 'duedate', 'tdate');
    var $notecolumn_order = array(null, 'title', 'cdate', null);
    var $notecolumn_search = array('id', 'title', 'cdate');
    var $order = array('id' => 'asc');

    private function _task_datatables_query($cday = '')
    {

        $this->db->from('geopos_todolist');
        $this->db->where('geopos_todolist.company_id', getCompanyId());
        if ($cday) {
            $this->db->where('DATE(duedate)=', $cday);
        }


        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            $search = $this->input->post('search');
        if(!isset($search['value'])){
            $search['value'] = '';
        }
            $value = $search['value'];
            if ($value) {

                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $value);
                } else {
                    $this->db->or_like($item, $value);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $search = $this->input->post('order');
        if ($search) {
            $this->db->order_by($this->column_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function task_datatables($cday = '')
    {


        $this->_task_datatables_query($cday);

        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $this->db->where('geopos_todolist.company_id', getCompanyId());
        $query = $this->db->get();
        return $query->result();
    }

    function task_count_filtered($cday = '')
    {
        $this->_task_datatables_query($cday);
        $this->db->where('geopos_todolist.company_id', getCompanyId());
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function task_count_all($cday = '')
    {
        $this->_task_datatables_query($cday);
        $this->db->where('geopos_todolist.company_id', getCompanyId());
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function addtask($name, $status, $priority, $stdate, $tdate, $employee, $assign, $content)
    {

        $data = array('tdate' => date('Y-m-d H:i:s'), 'name' => $name, 'status' => $status, 'start' => $stdate, 'duedate' => $tdate, 'description' => $content, 'eid' => $employee, 'aid' => $assign, 'related' => 0, 'priority' => $priority, 'rid' => 0,'company_id'=> getCompanyId(),'hash_code'=> getHashCode());
        return $this->db->insert('geopos_todolist', $data);
    }

    public function edittask($id, $name, $status, $priority, $stdate, $tdate, $employee, $content,$hash_code)
    {

        $data = array('tdate' => date('Y-m-d H:i:s'), 'name' => $name, 'status' => $status, 'start' => $stdate, 'duedate' => $tdate, 'description' => $content, 'eid' => $employee, 'related' => 0, 'priority' => $priority, 'rid' => 0);
        $this->db->set($data);
        $this->db->where('id', $id);
        $this->db->where('hash_code', $hash_code);
        $this->db->where('company_id', getCompanyId());
        return $this->db->update('geopos_todolist');
        //return $this->db->insert('geopos_todolist', $data);
    }

    public function settask($id, $stat,$hash_code)
    {

        $data = array('status' => $stat);
        $this->db->set($data);
        $this->db->where('id', $id);
        $this->db->where('hash_code', $hash_code);
        $this->db->where('company_id', getCompanyId());
        return $this->db->update('geopos_todolist');
    }

    public function deletetask($id,$hash_code)
    {

        return $this->db->delete('geopos_todolist', array('id' => $id,'company_id'=> getCompanyId()));
    }

    public function viewtask($id,$hash_code)
    {

        $this->db->select('geopos_todolist.*,geopos_employees.name AS emp, assi.name AS assign');
        $this->db->from('geopos_todolist');
        $this->db->where('geopos_todolist.id', $id);
        $this->db->where('geopos_todolist.hash_code', $hash_code);
        $this->db->where('geopos_todolist.company_id', getCompanyId());
        $this->db->join('geopos_employees', 'geopos_employees.id = geopos_todolist.eid', 'left');
        $this->db->join('geopos_employees AS assi', 'assi.id = geopos_todolist.aid', 'left');
        $query = $this->db->get();
        return $query->row_array();
    }


    public function task_stats()
    {

        $query = $this->db->query("SELECT
				COUNT(IF( status = 'Due', id, NULL)) AS Due,
				COUNT(IF( status = 'Progress', id, NULL)) AS Progress,
				COUNT(IF( status = 'Done', id, NULL)) AS Done
				FROM geopos_todolist where company_id=".getCompanyId()." ");

        echo json_encode($query->result_array());

    }

    //goals

    public function goals($id)
    {

        $this->db->select('*');
        $this->db->from('geopos_goals');
        $this->db->where('id', $id);
        $this->db->where('geopos_goals.company_id', getCompanyId());
        $query = $this->db->get();
        return $query->row_array();
    }

    public function setgoals($income, $expense, $sales, $netincome)
    {


        $data = array('income' => $income, 'expense' => $expense, 'sales' => $sales, 'netincome' => $netincome);
        $this->db->set($data);
        $this->db->where('id', 1);
        $this->db->where('geopos_goals.company_id', getCompanyId());
        return $this->db->update('geopos_goals');
    }

    //notes

    private function _notes_datatables_query()
    {

        $this->db->from('geopos_notes');
        $this->db->where('ntype', 0);
        $this->db->where('geopos_notes.company_id', getCompanyId());
        $i = 0;

        foreach ($this->notecolumn_search as $item) // loop column
        {
            $search = $this->input->post('search');
        if(!isset($search['value'])){
            $search['value'] = '';
        }
            $value = $search['value'];
            if ($value) {

                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $value);
                } else {
                    $this->db->or_like($item, $value);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $search = $this->input->post('order');
        if ($search) {
            $this->db->order_by($this->notecolumn_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function notes_datatables()
    {
        $this->_notes_datatables_query();
        $this->db->where('geopos_notes.company_id', getCompanyId());
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    function notes_count_filtered()
    {
        $this->_notes_datatables_query();
        $this->db->where('geopos_notes.company_id', getCompanyId());
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function notes_count_all()
    {
        $this->_notes_datatables_query();
        $this->db->where('geopos_notes.company_id', getCompanyId());
        $query = $this->db->get();
        return $query->num_rows();
    }


    function addnote($title, $content)
    {
        $data = array('title' => $title, 'content' => $content, 'cdate' => date('Y-m-d'), 'last_edit' => date('Y-m-d H:i:s'), 'cid' => $this->aauth->get_user()->id, 'fid' => $this->aauth->get_user()->id, 'ntype' => 0,'company_id'=> getCompanyId(),'hash_code'=> getHashCode());
        return $this->db->insert('geopos_notes', $data);

    }

    public function note_v($id)
    {
        $this->db->select('*');
        $this->db->from('geopos_notes');
        $this->db->where('id', $id);
        $this->db->where('geopos_notes.company_id', getCompanyId());
        $query = $this->db->get();
        return $query->row_array();
    }

    function deletenote($id,$hash_code)
    {
        return $this->db->delete('geopos_notes', array('id' => $id,'company_id'=> getCompanyId()));

    }


    //documents list

    var $doccolumn_order = array(null, 'title', 'cdate', null);
    var $doccolumn_search = array('title', 'cdate');

    public function documentlist()
    {
        $this->db->select('*');
        $this->db->from('geopos_documents');
        $this->db->where('geopos_documents.company_id', getCompanyId());
        $query = $this->db->get();
        return $query->result_array();
    }

    function adddocument($title, $filename)
    {
        $data = array('title' => $title, 'filename' => $filename, 'cdate' => date('Y-m-d'),'company_id'=> getCompanyId(),'hash_code'=> getHashCode());
        return $this->db->insert('geopos_documents', $data);

    }

    function deletedocument($id,$hash_code)
    {
        $this->db->select('filename');
        $this->db->from('geopos_documents');
        $this->db->where('id', $id);
        $this->db->where('geopos_documents.company_id', getCompanyId());
         //$this->db->where('geopos_documents.hash_code', $hash_code);
        $query = $this->db->get();
        $result = $query->row_array();
        if ($this->db->delete('geopos_documents', array('id' => $id,'company_id'=> getCompanyId()))) {

            unlink(FCPATH . 'userfiles/documents/' . $result['filename']);
            return true;
        } else {
            return false;
        }

    }


    function document_datatables()
    {
        $this->document_datatables_query();
        $this->db->where('geopos_documents.company_id', getCompanyId());
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    private function document_datatables_query()
    {

        $this->db->from('geopos_documents');
        $this->db->where('geopos_documents.company_id', getCompanyId());
        $i = 0;

        foreach ($this->doccolumn_search as $item) // loop column
        {
            $search = $this->input->post('search');
        if(!isset($search['value'])){
            $search['value'] = '';
        }
            $value = $search['value'];
            if ($value) {

                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $value);
                } else {
                    $this->db->or_like($item, $value);
                }

                if (count($this->doccolumn_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $search = $this->input->post('order');
        if ($search) {
            $this->db->order_by($this->doccolumn_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function document_count_filtered()
    {
        $this->document_datatables_query();
        $this->db->where('geopos_documents.company_id', getCompanyId());
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function document_count_all()
    {
        $this->document_datatables_query();
        $this->db->where('geopos_documents.company_id', getCompanyId());
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function pending_tasks()
    {
        $this->db->select('*');
        $this->db->from('geopos_todolist');
        $this->db->where('status', 'Due');
        $this->db->where('geopos_todolist.company_id', getCompanyId());
        $this->db->order_by('DATE(duedate)', 'ASC');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function pending_tasks_user($id)
    {
        $this->db->select('*');
        $this->db->from('geopos_todolist');
        $this->db->where('status', 'Due');
        $this->db->where('eid', $id);
        $this->db->where('geopos_todolist.company_id', getCompanyId());
        $this->db->order_by('DATE(duedate)', 'ASC');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }


    public function editnote($id, $title, $content,$hash_code)
    {
        $data = array(
            'title' => $title,
            'content' => $content

        );

        $data = array('title' => $title, 'content' => $content, 'last_edit' => date('Y-m-d H:i:s'), 'fid' => $this->aauth->get_user()->id);


        $this->db->set($data);
        $this->db->where('id', $id);
        $this->db->where('geopos_notes.company_id', getCompanyId());

        if ($this->db->update('geopos_notes')) {
            return true;
        } else {
            return false;
        }

    }


}