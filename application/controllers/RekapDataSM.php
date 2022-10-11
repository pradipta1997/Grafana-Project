<?php

defined('BASEPATH') or exit('No direct script access allowed');

class RekapDataSM extends MY_Controller
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
        $this->header('Rekap Data SM');
        $this->load->view('Layanan/list_rekapDataSM', $data);
        $this->footer();
    }

    public function listRekapDataSM()
    {
        // $list = $this->General->fetch_CoustomQuery("SELECT * FROM db_layanan.gps_kendaraan ORDER BY gps_kendaraan.TAHUN ASC");
        // cetak_die($list);

        $list = $this->Serverside->_serverSide(
            'Div_Layanan.rekap_data_sm',
            ['no', 'KANTOR_LAYANAN', 'JUMLAH_ATM', 'ON_PROGRES_SM', 'DONE_SM', 'PRESENTASE_SM', 'ESTIMASI_DENDA', 'user', 'tanggal_update'],
            ['KANTOR_LAYANAN', 'JUMLAH_ATM', 'ON_PROGRES_SM', 'DONE_SM', 'PRESENTASE_SM', 'ESTIMASI_DENDA', 'user', 'tanggal_update'],
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
            $row[] = nominal($results->JUMLAH_ATM);
            $row[] = nominal($results->ON_PROGRES_SM);
            $row[] = nominal($results->DONE_SM);
            $row[] = $results->PRESENTASE_SM;
            $row[] = rupiah($results->ESTIMASI_DENDA);
            $row[] = $results->user;
            $row[] = $results->tanggal_update;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Serverside->_countAll('Div_Layanan.rekap_data_sm'),
            "recordsFiltered" => $this->Serverside->_serverSide('Div_Layanan.rekap_data_sm'),
            "data" => $data,
        );

        echo json_encode($output);
    }
}
