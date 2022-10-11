<?php

defined('BASEPATH') or exit('No direct script access allowed');

class RekapPenggunaaSparepart extends MY_Controller
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
        $this->header('Rekap Penggunaa Sparepart');
        $this->load->view('Layanan/list_rekapPenggunaaSparepart', $data);
        $this->footer();
    }

    public function listRekapPenggunaaSparepart()
    {
        $list = $this->Serverside->_serverSide(
            'Div_Layanan.rekap_penggunaan_sparepart',
            ['no', 'TANGGAL', 'TID', 'Kantor_Layanan', 'LOKASI', 'MERK', 'TEKNISI', 'PART', 'BC', 'user', 'tanggal_update'],
            ['TANGGAL', 'TID', 'Kantor_Layanan', 'LOKASI', 'MERK', 'TEKNISI', 'PART', 'BC', 'user', 'tanggal_update'],
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
            $row[] = $results->TANGGAL;
            $row[] = $results->TID;
            $row[] = $results->Kantor_Layanan;
            $row[] = $results->LOKASI;
            $row[] = $results->MERK;
            $row[] = $results->TEKNISI;
            $row[] = $results->PART;
            $row[] = $results->BC;
            $row[] = $results->user;
            $row[] = $results->tanggal_update;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Serverside->_countAll('Div_Layanan.rekap_penggunaan_sparepart'),
            "recordsFiltered" => $this->Serverside->_serverSide('Div_Layanan.rekap_penggunaan_sparepart'),
            "data" => $data,
        );

        echo json_encode($output);
    }
}
