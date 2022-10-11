<?php

defined('BASEPATH') or exit('No direct script access allowed');

class DataVandalismeRelokasi extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->layanan = $this->load->database('db2', TRUE);
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
        $this->header('Data Vandalisme & Relokasi');
        $this->load->view('Layanan/list_dataVandalismeRelokasi', $data);
        $this->footer();
    }

    public function listDataVandalismeRelokasi()
    {
        $list = $this->Serverside->_serverSide(
            'Div_Layanan.data_vandalisme_relokasi',
            ['no', 'Kantor_Cabang', 'Total_ATM', 'Vandalisme', 'Location', 'Total', 'Presentase', 'user', 'tanggal_update'],
            ['Kantor_Cabang', 'Total_ATM', 'Vandalisme', 'Location', 'Total', 'Presentase', 'user', 'tanggal_update'],
            ['tanggal_update' => 'DESC '],
            null,
            'data'
        );
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $results) {

            $row = array();
            $no++;
            $row[] = $no;
            $row[] = $results->Kantor_Cabang;
            $row[] = nominal($results->Total_ATM);
            $row[] = $results->Vandalisme;
            $row[] = $results->Location;
            $row[] = $results->Total;
            $row[] = $results->Presentase;
            $row[] = $results->user;
            $row[] = $results->tanggal_update;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Serverside->_countAll('Div_Layanan.data_vandalisme_relokasi'),
            "recordsFiltered" => $this->Serverside->_serverSide('Div_Layanan.data_vandalisme_relokasi'),
            "data" => $data,
        );

        echo json_encode($output);
    }
}
