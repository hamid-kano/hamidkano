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

class Journals extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('journals_model','journals');
        $this->load->model('transactions_model', 'transactions');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        $this->load->library("Custom");
        $this->li_a = 'accounts';
    }

    public function index()
    {
        if (!$this->aauth->premission(5)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $head['title'] = "Journals";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('journals/index');
        $this->load->view('fixed/footer');

    }

    public function add()
    {
        if (!$this->aauth->premission(5)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $data['accounts'] = $this->transactions->acc_list();
        $head['title'] = "Add Manual Journal Entry";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('journals/create', $data);
        $this->load->view('fixed/footer');

    }

    public function translist()
    {
        if (!$this->aauth->premission(5)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $list = $this->journals->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $journal) {
            $no++;
            $row = array();
            $pid = $journal->id;
            $row[] = dateformat($journal->date);
            $row[] = $journal->note;
            $row[] = $journal->sum;
            $row[] = $journal->total_lines;
            $row[] = '<a href="' . base_url() . 'journals/view?id=' . $pid . '&ref='.$journal->hash_code.'" class="btn btn-primary btn-sm"><span class="fa fa-eye"></span>  ' . $this->lang->line('View') . '</a> <a href="' . base_url() . 'journals/print_t?id=' . $pid . '&ref='.$journal->hash_code.'" class="btn btn-info btn-sm"  title="Print"><span class="fa fa-print"></span></a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->journals->count_all(),
            "recordsFiltered" => $this->journals->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function save_trans()
    {
        if (!$this->aauth->premission(5)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
       // var_dump("expression");exit;
        $journal_date = $this->input->post('date', true);
        $payer_id = $this->input->post('payer_id', true);
        $payer_ty = $this->input->post('payer_type', true);
        $payer_name = $this->input->post('payer_name', true);
        $date = datefordatabase($journal_date);
        $lines = $this->input->post('line', true);
        if(!$lines) {
            echo json_encode(array('status' => 'Error', 'message' =>
                'Error!'));
            return;
        }
        $sum = 0;
        $files =$this->input->post('files', true);
    if(isset($files)){
       $files = implode(',',$this->input->post('files', true));
    }
        

        foreach ($lines as $_line) {
            $sum += $_line['debit'];
        }
        $journal_data = [
            'date'=>$date,
            'note'=>$this->input->post('note', true),
            'files'=>$files,
            'total_lines'=>count($this->input->post('line', true)),
            'sum'=>$sum,
            'company_id'=>getCompanyId(),
            'hash_code'=>getHashCode()
        ];

        $journal_id = $this->journals->store($journal_data);

        foreach ($lines as $line) {
            $credit = $line['credit'] ?? 0;
            $debit = $line['debit'] ?? 0;
            $pay_acc = $line['pay_acc'];
            $pay_cat = "غير محدد";
            $pay_type = ($credit > $debit) ? "Income" : "Expense";
            $paymethod = "غير محدد";
            $note = $journal_data['note'];
            if(!$this->transactions->addtrans($payer_id, $payer_name, $pay_acc, $date, $debit, $credit, $pay_type, $pay_cat, $paymethod, $note, $this->aauth->get_user()->id, $this->aauth->get_user()->loc, $payer_ty,  $journal_id)) {
                return json_encode(array('status' => 'Error', 'message' =>
                'Error!'));
            }
        }

        /*
    <span class='fa fa-plus-circle' aria-hidden='true'></span> " . $this->lang->line('New') . "  </a> <a href='" . base_url() . 'journals/view?id=' . $journal_id . "&ref' class='btn btn-primary btn-xs'><span class='fa fa-eye'></span>
        */
        echo json_encode(array('status' => 'Success', 'message' =>
                    $this->lang->line('Journal has been') . "  <a href='" . base_url() . "journals/add' class='btn btn-blue '>  " . $this->lang->line('View') . "</a> <a href='" . base_url() . "journals' class='btn btn-pink '><span class='fa fa-list-alt aria-hidden='true'></span></a>"));


    }

    public function view()
    {
        if (!$this->aauth->premission(5)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $head['title'] = "View Journal";
        $head['usernm'] = $this->aauth->get_user()->username;
        $id = $this->input->get('id');
        $hash_code = $this->input->get('ref');
        $data['journal'] = $this->journals->get_journal($id,$hash_code);
        //var_dump($data['journal']);exit;
        $data['transactions'] = $this->journals->get_transactions($id);
        $this->load->view('fixed/header', $head);
        if ($data['journal']['id']) $this->load->view('journals/view', $data);
        $this->load->view('fixed/footer');

    }

    public function print_t()
    {
        if (!$this->aauth->premission(5)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $head['title'] = "View Journal";
        $head['usernm'] = $this->aauth->get_user()->username;
        $id = $this->input->get('id');
        $hash_code = $this->input->get('ref');
        $data['journal'] = $this->journals->get_journal($id,$hash_code);
        $data['transactions'] = $this->journals->get_transactions($id);
        ini_set('memory_limit', '64M');

        $html = $this->load->view('journals/view-print', $data, true);

        //PDF Rendering
        $this->load->library('pdf');

        $pdf = $this->pdf->load_en();

        $pdf->SetHTMLFooter('<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;"><tr><td width="33%"></td><td width="33%" align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td><td width="33%" style="text-align: right; ">#' . $id . '</td></tr></table>');

        if ($data['journal']['id']) $pdf->WriteHTML($html);

        if ($this->input->get('d')) {

            $pdf->Output('Journal_#' . $id . '.pdf', 'D');
        } else {
            $pdf->Output('Journal_#' . $id . '.pdf', 'I');
        }
    }

    public function file_handling()
    {
        $id = $this->input->get('id', TRUE);
        $this->load->library("Uploadhandler_generic", array(
            'accept_file_types' => '/\.(gif|jpe?g|png|docx|docs|txt|pdf|xls)$/i', 'upload_dir' => FCPATH . 'userfiles/journal/', 
            'upload_url' => base_url() . 'userfiles/journal/',
        ));
        $files = (string)$this->uploadhandler_generic->filenaam();
        if ($files != '') {
            if($id) {
              $this->journals->addfile($id, $files);  
            }
        }


    }

    public function delete_file()
    {
        $fileid = $this->input->post('object_id');
        $journal_id = $this->input->post('journal_id');
        $this->journals->deletefile($journal_id, $fileid);
        echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));


    }

}