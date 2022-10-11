<?php

defined('BASEPATH') or exit('No direct script access allowed');

class UpdateKirimBAHOBJB extends MY_Controller
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
        $this->header('Update Kirim BA HO BJB');
        $this->load->view('Layanan/list_updateKirimBAHOBJB', $data);
        $this->footer();
    }

    public function listUpdateKirimBAHOBJB()
    {
        // $list = $this->General->fetch_CoustomQuery("SELECT * FROM db_layanan.gps_kendaraan ORDER BY gps_kendaraan.TAHUN ASC");
        // cetak_die($list);

        $list = $this->Serverside->_serverSide(
            'Div_Layanan.update_kirim_ba_ho_bjb',
            ['no', 'KANCA_BG', 'TOTAL_ATM_IN', 'TOTAL_ATM_OUT', 'TOTAL_ATM_DONE_HO', 'TOTAL_BA', 'KEKURANGAN_BA', 'STATUS_KIRIM', 'KETERANGAN', 'user', 'tanggal_update'],
            ['KANCA_BG', 'TOTAL_ATM_IN', 'TOTAL_ATM_OUT', 'TOTAL_ATM_DONE_HO', 'TOTAL_BA', 'KEKURANGAN_BA', 'STATUS_KIRIM', 'KETERANGAN', 'user', 'tanggal_update'],
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
            $row[] = $results->KANCA_BG;
            $row[] = nominal($results->TOTAL_ATM_IN);
            $row[] = nominal($results->TOTAL_ATM_OUT);
            $row[] = nominal($results->TOTAL_ATM_DONE_HO);
            $row[] = nominal($results->TOTAL_BA);
            $row[] = nominal($results->KEKURANGAN_BA);
            $row[] = $results->STATUS_KIRIM;
            $row[] = $results->KETERANGAN;
            $row[] = $results->user;
            $row[] = $results->tanggal_update;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Serverside->_countAll('Div_Layanan.update_kirim_ba_ho_bjb'),
            "recordsFiltered" => $this->Serverside->_serverSide('Div_Layanan.update_kirim_ba_ho_bjb'),
            "data" => $data,
        );

        echo json_encode($output);
    }
}
