<?php

defined('BASEPATH') or exit('No direct script access allowed');

class SaldoRestockingTerpusat extends MY_Controller
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
        $this->header('Saldo Restocking Terpusat');
        $this->load->view('Layanan/list_saldoRestockingTerpusat', $data);
        $this->footer();
    }

    public function listSaldoRestockingTerpusat()
    {
        $list = $this->Serverside->_serverSide(
            'Div_Layanan.saldo_restocking_terpusat',
            ['no', 'KANTOR_LAYANAN', 'BC', 'RETURN_50', 'RETURN_100', 'JUMLAH', 'SALDO_AWAL_PAGI_50', 'SALDO_AWAL_PAGI_100', 'JUMLAH1', 'RPL_PAGI_50', 'RPL_PAGI_100', 'JUMLAH2', 'SALDO_RESTOCKING_PAGI_50', 'SALDO_RESTOCKING_PAGI_100', 'JUMLAH3', 'user', 'tanggal_update'],
            ['KANTOR_LAYANAN', 'BC', 'RETURN_50', 'RETURN_100', 'JUMLAH', 'SALDO_AWAL_PAGI_50', 'SALDO_AWAL_PAGI_100', 'JUMLAH1', 'RPL_PAGI_50', 'RPL_PAGI_100', 'JUMLAH2', 'SALDO_RESTOCKING_PAGI_50', 'SALDO_RESTOCKING_PAGI_100', 'JUMLAH3', 'user', 'tanggal_update'],
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
            $row[] = rupiah($results->JUMLAH);
            $row[] = rupiah($results->SALDO_AWAL_PAGI_50);
            $row[] = rupiah($results->SALDO_AWAL_PAGI_100);
            $row[] = rupiah($results->JUMLAH1);
            $row[] = rupiah($results->RPL_PAGI_50);
            $row[] = rupiah($results->RPL_PAGI_100);
            $row[] = rupiah($results->JUMLAH2);
            $row[] = rupiah($results->SALDO_RESTOCKING_PAGI_50);
            $row[] = rupiah($results->SALDO_RESTOCKING_PAGI_100);
            $row[] = rupiah($results->JUMLAH3);
            $row[] = $results->user;
            $row[] = $results->tanggal_update;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Serverside->_countAll('Div_Layanan.saldo_restocking_terpusat'),
            "recordsFiltered" => $this->Serverside->_serverSide('Div_Layanan.saldo_restocking_terpusat'),
            "data" => $data,
        );

        echo json_encode($output);
    }
}
