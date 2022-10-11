<?php

defined('BASEPATH') or exit('No direct script access allowed');

class DataVaksinGlobal extends MY_Controller
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
        $this->header('Data Vaksin Global');
        $this->load->view('Audit/list_DataVaksinGlobal', $data);
        $this->footer();
    }

    public function listDataVaksinGlobal()
    {
        $list = $this->Serverside->_serverSide(
            'Div_Audit_Internal.vaksin_global',
            ['no', 'Indonesia_Status_Covid_19','Indonesia_Penambahan', 'Indonesia_Total', 'Indonesia_Persentase', 'Jakarta_Penambahan', 'Jakarta_Total', 'Jakarta_Persentase', 'BG_Status_Covid_19', 'BG_Penambahan', 'BG_Total', 'BG_Persentase', 'user','tanggal_update'],
            ['Indonesia_Status_Covid_19','Indonesia_Penambahan', 'Indonesia_Total', 'Indonesia_Persentase', 'Jakarta_Penambahan', 'Jakarta_Total', 'Jakarta_Persentase', 'BG_Status_Covid_19', 'BG_Penambahan', 'BG_Total', 'BG_Persentase', 'user','tanggal_update'],
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
            $row[] = $results->Indonesia_Status_Covid_19;
            $row[] = $results->Indonesia_Penambahan;
            $row[] = nominal($results->Indonesia_Total);
            $row[] = $results->Indonesia_Persentase;
            $row[] = $results->Jakarta_Penambahan;
            $row[] = nominal($results->Jakarta_Total);
            $row[] = $results->Jakarta_Persentase;
            $row[] = $results->BG_Status_Covid_19;
            $row[] = $results->BG_Penambahan;
            $row[] = nominal($results->BG_Total);
            $row[] = $results->BG_Persentase;
            $row[] = $results->user;
            $row[] = $results->tanggal_update;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Serverside->_countAll('Div_Audit_Internal.vaksin_global'),
            "recordsFiltered" => $this->Serverside->_serverSide('Div_Audit_Internal.vaksin_global'),
            "data" => $data,
        );

        echo json_encode($output);
    }
}
