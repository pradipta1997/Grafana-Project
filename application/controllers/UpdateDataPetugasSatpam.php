<?php

defined('BASEPATH') or exit('No direct script access allowed');

class UpdateDataPetugasSatpam extends MY_Controller
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
        $this->header('Update Data Petugas Satpam');
        $this->load->view('Layanan/list_updateDataPetugasSatpam', $data);
        $this->footer();
    }

    public function listUpdateDataPetugasSatpam()
    {
        // $list = $this->General->fetch_CoustomQuery("SELECT * FROM db_layanan.gps_kendaraan ORDER BY gps_kendaraan.TAHUN ASC");
        // cetak_die($list);

        $list = $this->Serverside->_serverSide(
            'Div_Layanan.update_data_petugas_satpam',
            ['no', 'jumlah', 'update_data_petugas_satpam', 'user', 'tanggal_update'],
            ['jumlah', 'update_data_petugas_satpam', 'user', 'tanggal_update'],
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
            $row[] = $results->update_data_petugas_satpam;
            $row[] = $results->user;
            $row[] = $results->tanggal_update;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Serverside->_countAll('Div_Layanan.update_data_petugas_satpam'),
            "recordsFiltered" => $this->Serverside->_serverSide('Div_Layanan.update_data_petugas_satpam'),
            "data" => $data,
        );

        echo json_encode($output);
    }
}
