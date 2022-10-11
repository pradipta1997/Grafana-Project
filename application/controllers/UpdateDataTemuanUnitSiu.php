<?php

defined('BASEPATH') or exit('No direct script access allowed');

class UpdateDataTemuanUnitSiu extends MY_Controller
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
        $this->header('Update Data Temuan Unit SIU');
        $this->load->view('Layanan/list_updateDataTemuanUnitSiu', $data);
        $this->footer();
    }

    public function listUpdateDataTemuanUnitSiu()
    {
        // $list = $this->General->fetch_CoustomQuery("SELECT * FROM db_layanan.gps_kendaraan ORDER BY gps_kendaraan.TAHUN ASC");
        // cetak_die($list);

        $list = $this->Serverside->_serverSide(
            'Div_Layanan.update_data_temuan_unit_siu',
            ['no', 'Cabang', 'Kriteria_Pelanggaran_Admin', 'Kriteria_Pelanggaran_CPC', 'Kriteria_Pelanggaran_Gerbang_Utama', 'Kriteria_Pelanggaran_Kunci', 'Kriteria_Pelanggaran_Khasanah', 'Kriteria_Pelanggaran_Loading', 'Kriteria_Pelanggaran_Passthru', 'Kriteria_Pelanggaran_Maintrap', 'Kriteria_Pelanggaran_Rutang', 'Kriteria_Pelanggaran_Steril', 'Kriteria_Pelanggaran_Kendaraan', 'Total_Jumlah_Pelanggaran', 'user', 'tanggal_update'],
            ['Cabang', 'Kriteria_Pelanggaran_Admin', 'Kriteria_Pelanggaran_CPC', 'Kriteria_Pelanggaran_Gerbang_Utama', 'Kriteria_Pelanggaran_Kunci', 'Kriteria_Pelanggaran_Khasanah', 'Kriteria_Pelanggaran_Loading', 'Kriteria_Pelanggaran_Passthru', 'Kriteria_Pelanggaran_Maintrap', 'Kriteria_Pelanggaran_Rutang', 'Kriteria_Pelanggaran_Steril', 'Kriteria_Pelanggaran_Kendaraan', 'Total_Jumlah_Pelanggaran', 'user', 'tanggal_update'],
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
            $row[] = $results->Cabang;
            $row[] = $results->Kriteria_Pelanggaran_Admin;

            $row[] = $results->Kriteria_Pelanggaran_CPC;
            $row[] = $results->Kriteria_Pelanggaran_Gerbang_Utama;
            $row[] = $results->Kriteria_Pelanggaran_Kunci;
            $row[] = $results->Kriteria_Pelanggaran_Khasanah;
            $row[] = $results->Kriteria_Pelanggaran_Loading;
            $row[] = $results->Kriteria_Pelanggaran_Passthru;

            $row[] = $results->Kriteria_Pelanggaran_Maintrap;
            $row[] = $results->Kriteria_Pelanggaran_Rutang;
            $row[] = $results->Kriteria_Pelanggaran_Steril;
            $row[] = $results->Kriteria_Pelanggaran_Kendaraan;
            $row[] = $results->Total_Jumlah_Pelanggaran;
            $row[] = $results->user;
            $row[] = $results->tanggal_update;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Serverside->_countAll('Div_Layanan.update_data_temuan_unit_siu'),
            "recordsFiltered" => $this->Serverside->_serverSide('Div_Layanan.update_data_temuan_unit_siu'),
            "data" => $data,
        );

        echo json_encode($output);
    }
}
