<?php

defined('BASEPATH') or exit('No direct script access allowed');

class DataVaksinAudit extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->audit = $this->load->database('db5', TRUE);
        $this->load->library(array('excel', 'session'));
        if (!$this->session->userdata("user_login")) {
            redirect('Auth');
        }
    }

    public function index()
    {

        $data = array(
            // 'inserttable' => $this->General->fetch_CoustomQuery("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='db_layanan'"),
        );

        // cekPergroup();
        $this->header('Data Vaksin Audit');
        $this->load->view('Audit/list_DataVaksin', $data);
        $this->footer();
    }

    public function listDataVaksinAudit()
    {
        $list = $this->Serverside->_serverSide(
            'Div_Audit_Internal.vaksin',
            ['no', 'ID_Personal','Nama', 'Jabatan', 'Unit_Kerja', 'Vaksin_I', 'Vaksin_II', 'Keterangan', 'user','tanggal_update'],
            ['ID_Personal','Nama', 'Jabatan', 'Unit_Kerja', 'Vaksin_I', 'Vaksin_II', 'Keterangan', 'user','tanggal_update'],
            ['tanggal_update' => 'DESC'],
            null,
            'data'
        );
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $results) {

            $row = array();
            $no++;
            $row[] = $no;
            $row[] = $results->ID_Personal;
            $row[] = $results->Nama;
            $row[] = $results->Jabatan;
            $row[] = $results->Unit_Kerja;
            $row[] = $results->Vaksin_I;
            $row[] = $results->Vaksin_II;
            $row[] = $results->Keterangan;
            $row[] = $results->user;
            $row[] = $results->tanggal_update;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Serverside->_countAll('Div_Audit_Internal.vaksin'),
            "recordsFiltered" => $this->Serverside->_serverSide('Div_Audit_Internal.vaksin'),
            "data" => $data,
        );

        echo json_encode($output);
    }
}
