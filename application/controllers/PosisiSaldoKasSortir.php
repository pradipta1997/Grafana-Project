<?php

defined('BASEPATH') or exit('No direct script access allowed');

class PosisiSaldoKasSortir extends MY_Controller
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
        $this->header('Posisi Saldo Kas Sortir');
        $this->load->view('Layanan/list_posisiSaldoKasSortir', $data);
        $this->footer();
    }

    public function listPosisiSaldoKasSortir()
    {
        // $list = $this->General->fetch_CoustomQuery("SELECT * FROM db_layanan.gps_kendaraan ORDER BY gps_kendaraan.TAHUN ASC");
        // cetak_die($list);
        $list = $this->Serverside->_serverSide(
            'Div_Layanan.posisi_saldo_kas_sortir',
            ['no', 'KANTOR_LAYANAN', 'KANCAKO', 'SALDO_AWAL_31_OKTOBER_2021', 'TAMBAHAN_KAS_31_OKTOBER_2021', 'SORTIR_SETOR_31_OKTOBER_2021', 'SALDO_AKHIR_31_OKTOBER_2021', 'KETERANGAN', 'user', 'tanggal_update'],
            ['KANTOR_LAYANAN', 'KANCAKO', 'SALDO_AWAL_31_OKTOBER_2021', 'TAMBAHAN_KAS_31_OKTOBER_2021', 'SORTIR_SETOR_31_OKTOBER_2021', 'SALDO_AKHIR_31_OKTOBER_2021', 'KETERANGAN', 'user', 'tanggal_update'],
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
            $row[] = $results->KANCAKO;
            $row[] = rupiah($results->SALDO_AWAL_31_OKTOBER_2021);
            $row[] = rupiah($results->TAMBAHAN_KAS_31_OKTOBER_2021);
            $row[] = rupiah($results->SORTIR_SETOR_31_OKTOBER_2021);
            $row[] = rupiah($results->SALDO_AKHIR_31_OKTOBER_2021);
            $row[] = $results->KETERANGAN;
            $row[] = $results->user;
            $row[] = $results->tanggal_update;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Serverside->_countAll('Div_Layanan.posisi_saldo_kas_sortir'),
            "recordsFiltered" => $this->Serverside->_serverSide('Div_Layanan.posisi_saldo_kas_sortir'),
            "data" => $data,
        );

        echo json_encode($output);
    }
}
