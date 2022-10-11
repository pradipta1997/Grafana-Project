<?php

defined('BASEPATH') or exit('No direct script access allowed');

class UpdateDataCctvKolaborasi extends MY_Controller
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
        $this->header('Update Data CCTV Kolaborasi');
        $this->load->view('Layanan/list_updateDataCctvKolaborasi', $data);
        $this->footer();
    }

    public function listUpdateDataCctvKolaborasi()
    {
        // $list = $this->General->fetch_CoustomQuery("SELECT * FROM db_layanan.gps_kendaraan ORDER BY gps_kendaraan.TAHUN ASC");
        // cetak_die($list);

        $list = $this->Serverside->_serverSide(
            'Div_Layanan.update_data_cctv_kolaborasi',
            ['no', 'jumlah', 'update_data_cctv_kolaborasi', 'user', 'tanggal_update'],
            ['jumlah', 'update_data_cctv_kolaborasi', 'user', 'tanggal_update'],
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
            $row[] = $results->jumlah;
            $row[] = $results->update_data_cctv_kolaborasi;
            $row[] = $results->user;
            $row[] = $results->tanggal_update;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Serverside->_countAll('Div_Layanan.update_data_cctv_kolaborasi'),
            "recordsFiltered" => $this->Serverside->_serverSide('Div_Layanan.update_data_cctv_kolaborasi'),
            "data" => $data,
        );

        echo json_encode($output);
    }
}
