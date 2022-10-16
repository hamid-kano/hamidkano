<?php
/**
 * Geo POS -  Accounting,  Invoicing  and CRM Application
 * Copyright (c) Rajesh Dukiya. All Rights Reserved
 * ***********************************************************************
 *
 *  Email: support@ultimatekode.com
 *  Website: https://www.ultimatekode.com
 *
 *  ************************************************************************
 *  * This software is furnished under a license and may be used and copied
 *  * only  in  accordance  with  the  terms  of such  license and with the
 *  * inclusion of the above copyright notice.
 *  * If you Purchased from Codecanyon, Please read the full License from
 *  * here- http://codecanyon.net/licenses/standard/
 * ***********************************************************************
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_model extends CI_Model
{

    public function list_employee()
    {
        $this->db->select('geopos_employees.*,geopos_users.banned,geopos_users.roleid,geopos_users.loc');
        $this->db->from('geopos_employees');
        $this->db->join('geopos_users', 'geopos_employees.id = geopos_users.emp_id', 'left');
        $this->db->where('geopos_employees.company_id', getCompanyId());
        $this->db->order_by('geopos_users.roleid', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_project_employee($id)
    {
        $this->db->select('geopos_employees.*');
        $this->db->from('geopos_project_meta');
        $this->db->where('geopos_project_meta.pid', $id);
        $this->db->where('geopos_project_meta.meta_key', 19);
        $this->db->join('geopos_employees', 'geopos_employees.id = geopos_project_meta.meta_data', 'left');
        $this->db->join('geopos_users', 'geopos_employees.id = geopos_users.emp_id', 'left');
        $this->db->where('geopos_project_meta.company_id', getCompanyId());
        $this->db->order_by('geopos_users.roleid', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function employee_details($id,$hash_code)
    {
        $this->db->select('geopos_employees.*,geopos_users.email,geopos_users.loc,geopos_users.roleid,');
        $this->db->from('geopos_employees');
        $this->db->where('geopos_employees.id', $id);
        $this->db->where('geopos_employees.company_id', getCompanyId());
        $this->db->where('geopos_employees.hash_code', $hash_code);
        $this->db->join('geopos_users', 'geopos_employees.id = geopos_users.emp_id', 'left');
        $query = $this->db->get();
        return $query->row_array();
    }
    
    
        public function employee_details_row($id)
    {
        $this->db->select('geopos_employees.*,geopos_users.email,geopos_users.loc,geopos_users.roleid,');
        $this->db->from('geopos_employees');
        $this->db->where('geopos_users.id', $id);
        $this->db->where('geopos_employees.company_id', getCompanyId());
        $this->db->join('geopos_users', 'geopos_employees.id = geopos_users.emp_id', 'left');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function salary_history($id)
    {
        $this->db->select('*');
        $this->db->from('geopos_hrm');
        $this->db->where('typ', 1);
        $this->db->where('geopos_hrm.company_id', getCompanyId());;
        $this->db->where('rid', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function update_employee($id, $name, $phone, $phonealt, $address, $city, $region, $country, $postbox, $location, $salary = 0, $department = -1,$commission=0,$roleid=false,$hash_code)
    {
        $this->db->select('salary');
        $this->db->from('geopos_employees');
        $this->db->where('id', $id);
        $this->db->where('company_id', getCompanyId());
        $this->db->where('hash_code',$hash_code);
        $query = $this->db->get();
        $sal = $query->row_array();
         $this->db->select('roleid');
        $this->db->from('geopos_users');
        $this->db->where('id', $id);
        $this->db->where('company_id', getCompanyId());
        // $this->db->where('hash_code',$hash_code);
        $query = $this->db->get();
        $role = $query->row_array();


        $data = array(
            'name' => $name,
            'phone' => $phone,
            'phonealt' => $phonealt,
            'address' => $address,
            'city' => $city,
            'region' => $region,
            'country' => $country,
            'postbox' => $postbox,
            'salary' => $salary,
             'c_rate' => $commission
        );
        if ($department > -1) {
            $data = array(
                'name' => $name,
                'phone' => $phone,
                'phonealt' => $phonealt,
                'address' => $address,
                'city' => $city,
                'region' => $region,
                'country' => $country,
                'postbox' => $postbox,
                'salary' => $salary,
                'dept' => $department,
                 'c_rate' => $commission
            );
        }


        $this->db->set($data);
        $this->db->where('geopos_employees.company_id', getCompanyId());;
        $this->db->where('id', $id);
        $this->db->where('hash_code',$hash_code);


        if ($this->db->update('geopos_employees')) {

            if($roleid && $role['roleid']!=5){
                 $this->db->set('loc', $location);
                 $this->db->set('roleid', $roleid);
                $this->db->where('id', $id);
                $this->db->where('geopos_users.company_id', getCompanyId());;
               $this->db->update('geopos_users');
            }
            if (($salary != $sal['salary']) AND ($salary > 0.00)) {
                $data1 = array(
                    'typ' => 1,
                    'rid' => $id,
                    'val1' => $salary,
                    'val2' => $sal['salary'],
                    'val3' => date('Y-m-d H:i:s'),
                    'company_id'=>getCompanyId(),
                    'hash_code'=>getHashCode() 
                );

                $this->db->insert('geopos_hrm', $data1);
            }

            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function update_password($id, $cpassword, $newpassword, $renewpassword)
    {


    }

    public function editpicture($id, $pic)
    {
        $this->db->select('picture');
        $this->db->from('geopos_employees');
        $this->db->where('company_id', getCompanyId());
        $this->db->where('id', $id);

        $query = $this->db->get();
        $result = $query->row_array();


        $data = array(
            'picture' => $pic
        );


        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('geopos_employees')) {
            $this->db->set($data);
            $this->db->where('id', $id);
            $this->db->where('company_id', getCompanyId());
            $this->db->update('geopos_users');
            unlink(FCPATH . 'userfiles/employee/' . $result['picture']);
            unlink(FCPATH . 'userfiles/employee/thumbnail/' . $result['picture']);
        }


    }


    public function editsign($id, $pic)
    {
        $this->db->select('sign');
        $this->db->from('geopos_employees');
        $this->db->where('company_id', getCompanyId());
        $this->db->where('id', $id);

        $query = $this->db->get();
        $result = $query->row_array();


        $data = array(
            'sign' => $pic
        );


        $this->db->set($data);
        $this->db->where('id', $id);
        $this->db->where('company_id', getCompanyId());
        if ($this->db->update('geopos_employees')) {

            unlink(FCPATH . 'userfiles/employee_sign/' . $result['sign']);
            unlink(FCPATH . 'userfiles/employee_sign/thumbnail/' . $result['sign']);
        }


    }


    var $table = 'geopos_invoices';
    var $column_order = array(null, 'geopos_invoices.tid', 'geopos_invoices.invoicedate', 'geopos_invoices.total', 'geopos_invoices.status');
    var $column_search = array('geopos_invoices.tid', 'geopos_invoices.invoicedate', 'geopos_invoices.total', 'geopos_invoices.status');
    var $order = array('geopos_invoices.tid' => 'asc');


    private function _invoice_datatables_query($id)
    {
        $this->db->select('geopos_invoices.*,geopos_customers.name,geopos_invoices.hash_code hash_code_inv');
        $this->db->from('geopos_invoices');
        $this->db->where('geopos_invoices.eid', $id);
        $this->db->where('geopos_invoices.company_id', getCompanyId());
        $this->db->join('geopos_customers', 'geopos_invoices.csd=geopos_customers.id', 'left');

        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            $search = $this->input->post('search');
            $value = $search['value'];
            if ($value) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
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
        if ($search) // here order processing
        {
            $this->db->order_by($this->column_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function invoice_datatables($id)
    {
        $this->_invoice_datatables_query($id);
        $this->db->where('geopos_invoices.company_id', getCompanyId());
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    function invoicecount_filtered($id)
    {
        $this->_invoice_datatables_query($id);
        $this->db->where('geopos_invoices.company_id', getCompanyId());
        $query = $this->db->get();
        if ($id != '') {
            $this->db->where('geopos_invoices.eid', $id);
        }
        return $query->num_rows($id);
    }

    public function invoicecount_all($id)
    {
        $this->_invoice_datatables_query($id);
        $this->db->where('geopos_invoices.company_id', getCompanyId());
        $query = $this->db->get();
        if ($id != '') {
            $this->db->where('geopos_invoices.eid', $id);
        }
        return $query->num_rows($id = '');
    }

    //transaction


    var $tcolumn_order = array(null, 'account', 'type', 'cat', 'amount', 'stat');
    var $tcolumn_search = array('id', 'account');
    var $torder = array('id' => 'asc');
    var $eid = '';

    private function _get_datatables_query()
    {

        $this->db->from('geopos_transactions');
        $this->db->where('geopos_transactions.company_id', getCompanyId());
        $this->db->where('eid', $this->eid);


        $i = 0;

        foreach ($this->tcolumn_search as $item) // loop column
        {
            if ($this->input->post('search')['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $this->input->post('search')['value']);
                } else {
                    $this->db->or_like($item, $this->input->post('search')['value']);
                }

                if (count($this->tcolumn_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->tcolumn_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->torder)) {
            $order = $this->torder;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($eid)
    {
        $this->eid = $eid;
        $this->_get_datatables_query();
        $this->db->where('geopos_transactions.company_id', getCompanyId());
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->db->from('geopos_transactions');
        $this->db->where('geopos_transactions.company_id', getCompanyId());
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from('geopos_transactions');
        $this->db->where('geopos_transactions.company_id', getCompanyId());
        $this->db->where('eid', $this->eid);
        return $this->db->count_all_results();
    }


    public function add_employee($id, $username, $name, $roleid, $phone, $address, $city, $region, $country, $postbox, $location,$salary = 0,$commission = 0,$department=0)
    {
        $data = array(
            'id' => $id,
            'username' => $username,
            'name' => $name,
            'address' => $address,
            'city' => $city,
            'region' => $region,
            'country' => $country,
            'postbox' => $postbox,
            'phone' => $phone,
              'dept' => $department,
              'salary' => $salary,
            'c_rate' => $commission,
            'company_id'=>getCompanyId(),
            'hash_code'=>getHashCode() 
        );


        if ($this->db->insert('geopos_employees', $data)) {
            $data1 = array(
                'roleid' => $roleid,
                'loc' => $location
            );

            $this->db->set($data1);
            $this->db->where('id', $id);
            $this->db->where('company_id', getCompanyId());

            $this->db->update('geopos_users');
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function employee_validate($email)
    {
        $this->db->select('*');
        $this->db->from('geopos_users');
        $this->db->where('company_id', getCompanyId());
        $this->db->where('email', $email);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function money_details($eid)
    {
        $this->db->select('SUM(debit) AS debit,SUM(credit) AS credit');
        $this->db->from('geopos_transactions');
        $this->db->where('eid', $eid);
        $this->db->where('company_id', getCompanyId());
        $query = $this->db->get();
        return $query->row_array();
    }

    public function sales_details($eid)
    {
        $this->db->select('SUM(pamnt) AS total');
        $this->db->from('geopos_invoices');
        $this->db->where('eid', $eid);
        $this->db->where('company_id', getCompanyId());
        $query = $this->db->get();
        return $query->row_array();
    }

    public function employee_permissions()
    {
        $this->db->select('*');
        $this->db->from('geopos_premissions');
        $this->db->where('company_id', getCompanyId());
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    //documents list

    var $doccolumn_order = array(null, 'val1', 'val2', null);
    var $doccolumn_search = array('val1', 'val2');


    function addholidays($loc, $hday, $hdayto, $note)
    {
        $data = array('typ' => 2, 'rid' => $loc, 'val1' => $hday, 'val2' => $hdayto, 'val3' => $note,'company_id'=>getCompanyId(),'hash_code'=>getHashCode() );
        return $this->db->insert('geopos_hrm', $data);

    }

    function deleteholidays($id)
    {

        if ($this->db->delete('geopos_hrm', array('id' => $id, 'typ' => 2,'company_id'=>getCompanyId()))) {


            return true;
        } else {
            return false;
        }

    }


    function holidays_datatables()
    {
        $this->holidays_datatables_query();
         $this->db->where('geopos_hrm.company_id', getCompanyId());
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    private function holidays_datatables_query()
    {

        $this->db->from('geopos_hrm');
        $this->db->where('typ', 2);
        $this->db->where('company_id', getCompanyId());
        if ($this->aauth->get_user()->loc) {
            $this->db->where('rid', $this->aauth->get_user()->loc);
        }
        $i = 0;

        foreach ($this->doccolumn_search as $item) // loop column
        {
            $search = $this->input->post('search');
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
            $order = $this->doccolumn_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function holidays_count_filtered()
    {
        $this->holidays_datatables_query();
        $this->db->where('geopos_hrm.company_id', getCompanyId());
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function holidays_count_all()
    {
        $this->holidays_datatables_query();
        $this->db->where('geopos_hrm.company_id', getCompanyId());
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function hday_view($id, $loc)
    {
        $this->db->select('*');
        $this->db->from('geopos_hrm');
        $this->db->where('id', $id);
        $this->db->where('company_id', getCompanyId());
        $this->db->where('typ', 2);
        if ($this->aauth->get_user()->loc) {
            $this->db->where('rid', $loc);
        }

        $query = $this->db->get();
        return $query->row_array();
    }

    public function edithday($id, $loc, $from, $todate, $note)
    {

        $data = array('typ' => 2, 'val1' => $from, 'val2' => $todate, 'val3' => $note);


        $this->db->set($data);
        $this->db->where('id', $id);
        $this->db->where('company_id', getCompanyId());
        if ($this->aauth->get_user()->loc) {
            $this->db->where('rid', $loc);
        }


        $this->db->update('geopos_hrm');
        return true;

    }

    public function department_list($id, $rid = 0)
    {
        $this->db->select('*');
        $this->db->from('geopos_hrm');
        $this->db->where('typ', 3);
        $this->db->where('company_id', getCompanyId());
        if ($this->aauth->get_user()->loc) {
            $this->db->where('rid', $id);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function department_elist($id)
    {
        $this->db->select('*');
        $this->db->from('geopos_employees');
        $this->db->where('company_id', getCompanyId());
        $this->db->where('dept', $id);
        $query = $this->db->get();
        return $query->result_array();
    }


    public function department_view($id, $loc)
    {
        $this->db->select('*');
        $this->db->from('geopos_hrm');
        $this->db->where('company_id', getCompanyId());
        $this->db->where('id', $id);
        $this->db->where('typ', 3);
        if ($this->aauth->get_user()->loc) {
            $this->db->where('rid', $loc);
        }


        $query = $this->db->get();
        return $query->row_array();
    }

    function adddepartment($loc, $name)
    {
        $data = array('typ' => 3, 'rid' => $loc, 'val1' => $name,'company_id'=>getCompanyId(),'hash_code'=>getHashCode() );
        return $this->db->insert('geopos_hrm', $data);

    }

    function deletedepartment($id)
    {

        if ($this->db->delete('geopos_hrm', array('id' => $id, 'typ' => 3,'company_id'=>getCompanyId()))) {


            return true;
        } else {
            return false;
        }

    }

    public function editdepartment($id, $loc, $name)
    {

        $data = array(
            'val1' => $name
        );


        $this->db->set($data);
        $this->db->where('id', $id);
        $this->db->where('company_id', getCompanyId());
        if ($this->aauth->get_user()->loc) {
            $this->db->where('rid', $loc);
        }


        $this->db->update('geopos_hrm');
        return true;

    }

    //payroll

    private function _pay_get_datatables_query($eid)
    {

        $this->db->from('geopos_transactions');
        $this->db->where('company_id', getCompanyId());
        if ($this->aauth->get_user()->loc) {
            $this->db->where('loc', $this->aauth->get_user()->loc);
        }
        $this->db->where('ext', 4);
        if ($eid) {
            $this->db->where('payerid', $eid);
        }


        $i = 0;

        foreach ($this->tcolumn_search as $item) // loop column
        {
            if ($this->input->post('search')['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $this->input->post('search')['value']);
                } else {
                    $this->db->or_like($item, $this->input->post('search')['value']);
                }

                if (count($this->tcolumn_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->tcolumn_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->torder)) {
            $order = $this->torder;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function pay_get_datatables($eid)
    {

        $this->_pay_get_datatables_query($eid);
        $this->db->where('geopos_transactions.company_id', getCompanyId());
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function pay_count_filtered($eid)
    {
        $this->db->from('geopos_transactions');
        $this->db->where('company_id', getCompanyId());
        $this->db->where('ext', 4);
        if ($eid) {
            $this->db->where('payerid', $eid);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function pay_count_all($eid)
    {
        $this->db->from('geopos_transactions');
        $this->db->where('company_id', getCompanyId());
        $this->db->where('ext', 4);
        if ($eid) {
            $this->db->where('payerid', $eid);
        }
        return $this->db->count_all_results();
    }


    function addattendance($emp, $adate, $tfrom, $tto, $note)
    {

        foreach ($emp as $row) {

            $this->db->where('emp', $row);
            $this->db->where('company_id', getCompanyId());
            $this->db->where('DATE(adate)', $adate);
            $num = $this->db->count_all_results('geopos_attendance');

            if (!$num) {
                $data = array('emp' => $row, 'created' => date('Y-m-d H:i:s'), 'adate' => $adate, 'tfrom' => $tfrom, 'tto' => $tto, 'note' => $note,'company_id'=>getCompanyId(),'hash_code'=>getHashCode() 
);
                $this->db->insert('geopos_attendance', $data);
            }

        }

        return true;

    }

    function deleteattendance($id)
    {

        if ($this->db->delete('geopos_attendance', array('id' => $id,'company_id'=>getCompanyId() 
))) {
            return true;
        } else {
            return false;
        }

    }

    var $acolumn_order = array(null, 'geopos_attendance.emp', 'geopos_attendance.adate', null, null);
    var $acolumn_search = array('geopos_employees.name', 'geopos_attendance.adate');

    function attendance_datatables($cid)
    {
        $this->attendance_datatables_query($cid);
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    private function attendance_datatables_query($cid = 0)
    {
        $this->db->select('geopos_attendance.*,geopos_employees.name');
        $this->db->from('geopos_attendance');
        $this->db->join('geopos_employees', 'geopos_employees.id=geopos_attendance.emp', 'left');
        $this->db->where('geopos_attendance.company_id', getCompanyId());
        if ($this->aauth->get_user()->loc) {
            $this->db->join('geopos_users', 'geopos_users.id=geopos_attendance.emp', 'left');
            $this->db->where('geopos_users.loc', $this->aauth->get_user()->loc);

        }
        if ($cid) $this->db->where('geopos_attendance.emp', $cid);
        $i = 0;

        foreach ($this->acolumn_search as $item) // loop column
        {
            $search = $this->input->post('search');
            $value = $search['value'];
            if ($value) {

                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $value);
                } else {
                    $this->db->or_like($item, $value);
                }

                if (count($this->acolumn_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $search = $this->input->post('order');
        if ($search) {
            $this->db->order_by($this->acolumn_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->acolumn_order)) {
            $order = $this->acolumn_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function attendance_count_filtered($cid)
    {
        $this->attendance_datatables_query($cid);
        $this->db->where('geopos_attendance.company_id', getCompanyId());
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function attendance_count_all($cid)
    {
        $this->attendance_datatables_query($cid);
        $this->db->where('geopos_attendance.company_id', getCompanyId());
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getAttendance($emp, $start, $end)
    {

        $sql = "SELECT  CONCAT(tfrom, ' - ', tto) AS title,DATE(adate) as start ,DATE(adate) as end FROM geopos_attendance WHERE company_id=".getCompanyId()." and  (emp='$emp') AND (DATE(adate) BETWEEN ? AND ? ) ORDER BY DATE(adate) ASC";
        return $this->db->query($sql, array($start, $end))->result();

    }

    public function getHolidays($loc, $start, $end)
    {

        $sql = "SELECT  CONCAT(DATE(val1), ' - ', DATE(val2),' - ',val3) AS title,DATE(val1) as start ,DATE(val2) as end FROM geopos_hrm WHERE company_id=".getCompanyId()." and  (typ='2') AND  (rid='$loc') AND (DATE(val1) BETWEEN ? AND ? ) ORDER BY DATE(val1) ASC";
        return $this->db->query($sql, array($start, $end))->result();

    }


    public function salary_view($eid)
    {
        $this->db->from('geopos_transactions');
        $this->db->where('ext', 4);
        $this->db->where('payerid', $eid);
        $this->db->where('company_id', getCompanyId());
        $query = $this->db->get();
        return $query->result_array();
    }

    public function autoattend($opt)
    {
        $this->db->set('key1', $opt);
        $this->db->where('company_id', getCompanyId());
        $this->db->where('id', 62);

        $this->db->update('univarsal_api');
        return true;
    }


}