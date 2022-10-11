<?php

defined('BASEPATH') or exit('No direct script access allowed');

class RekapLaporanPosisiKasUTLE extends MY_Controller
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
        $this->header('Rekap Laporan Posisi Kas UTLE BG');
        $this->load->view('Layanan/list_rekapLaporanPosisiKasUTLE', $data);
        $this->footer();
    }

    public function listRekapLaporanPosisiKasUTLE()
    {
        // $list = $this->General->fetch_CoustomQuery("SELECT * FROM db_layanan.gps_kendaraan ORDER BY gps_kendaraan.TAHUN ASC");
        // cetak_die($list);
        $list = $this->Serverside->_serverSide(
            'Div_Layanan.rekap_laporan_posisi_kas_utle_bg',
            ['no', 'BC', 'KANTOR_CABANG', 'POSISI_UTLE_DI_BRANKAS_100000', 'POSISI_UTLE_DI_BRANKAS_50000', 'POSISI_UTLE_DI_BRANKAS_TOTAL', 'Posisi_Tanggal', 'POSISI_UTLE_DI_BRANKAS_100000_2', 'POSISI_UTLE_DI_BRANKAS_50000_2', 'POSISI_UTLE_DI_BRANKAS_TOTAL_2', 'Keterangan', 'Posisi_Tanggal_2', 'user', 'tanggal_update'],
            ['BC', 'KANTOR_CABANG', 'POSISI_UTLE_DI_BRANKAS_100000', 'POSISI_UTLE_DI_BRANKAS_50000', 'POSISI_UTLE_DI_BRANKAS_TOTAL', 'Posisi_Tanggal', 'POSISI_UTLE_DI_BRANKAS_100000_2', 'POSISI_UTLE_DI_BRANKAS_50000_2', 'POSISI_UTLE_DI_BRANKAS_TOTAL_2', 'Keterangan', 'Posisi_Tanggal_2', 'user', 'tanggal_update'],
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
            $row[] = $results->BC;
            $row[] = $results->KANTOR_CABANG;
            $row[] = rupiah($results->POSISI_UTLE_DI_BRANKAS_100000);
            $row[] = rupiah($results->POSISI_UTLE_DI_BRANKAS_50000);
            $row[] = rupiah($results->POSISI_UTLE_DI_BRANKAS_TOTAL);
            $row[] = $results->Posisi_Tanggal;
            $row[] = rupiah($results->POSISI_UTLE_DI_BRANKAS_100000_2);
            $row[] = rupiah($results->POSISI_UTLE_DI_BRANKAS_50000_2);
            $row[] = rupiah($results->POSISI_UTLE_DI_BRANKAS_TOTAL_2);
            $row[] = $results->Posisi_Tanggal_2;
            $row[] = rupiah($results->Keterangan);
            $row[] = $results->user;
            $row[] = $results->tanggal_update;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Serverside->_countAll('Div_Layanan.rekap_laporan_posisi_kas_utle_bg'),
            "recordsFiltered" => $this->Serverside->_serverSide('Div_Layanan.rekap_laporan_posisi_kas_utle_bg'),
            "data" => $data,
        );

        echo json_encode($output);
    }
}
