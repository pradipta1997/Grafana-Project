<?php

defined('BASEPATH') or exit('No direct script access allowed');

class SaldoRestocking extends MY_Controller
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
        $this->header('Saldo Restocking');
        $this->load->view('Layanan/list_saldoRestocking', $data);
        $this->footer();
    }

    public function listSaldoRestocking()
    {
        $list = $this->Serverside->_serverSide(
            'Div_Layanan.saldo_restocking',
            ['no', 'KANTOR_LAYANAN', 'BC', 'RETURN_50', 'RETURN_100', 'SALDO_AWAL_50', 'SALDO_AWAL_100', 'RPL_50', 'RPL_100', 'SALDO_AKHIR_50', 'SALDO_AKHIR_100', 'user', 'tanggal_update'],
            ['KANTOR_LAYANAN', 'BC', 'RETURN_50', 'RETURN_100', 'SALDO_AWAL_50', 'SALDO_AWAL_100', 'RPL_50', 'RPL_100', 'SALDO_AKHIR_50', 'SALDO_AKHIR_100', 'user', 'tanggal_update'],
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
            $row[] = $results->KANTOR_LAYANAN;
            $row[] = $results->BC;
            $row[] = rupiah($results->RETURN_50);
            $row[] = rupiah($results->RETURN_100);
            $row[] = rupiah($results->SALDO_AWAL_50);
            $row[] = rupiah($results->SALDO_AWAL_100);
            $row[] = rupiah($results->RPL_50);
            $row[] = rupiah($results->RPL_100);
            $row[] = rupiah($results->SALDO_AKHIR_50);
            $row[] = rupiah($results->SALDO_AKHIR_100);
            $row[] = $results->user;
            $row[] = $results->tanggal_update;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Serverside->_countAll('Div_Layanan.saldo_restocking'),
            "recordsFiltered" => $this->Serverside->_serverSide('Div_Layanan.saldo_restocking'),
            "data" => $data,
        );

        echo json_encode($output);
    }
}
