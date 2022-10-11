<?php

defined('BASEPATH') or exit('No direct script access allowed');

class RekapDataPM extends MY_Controller
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
        $this->header('Rekap Data PM');
        $this->load->view('Layanan/list_rekapDataPM', $data);
        $this->footer();
    }

    public function listRekapDataPM()
    {
        // $list = $this->General->fetch_CoustomQuery("SELECT * FROM db_layanan.gps_kendaraan ORDER BY gps_kendaraan.TAHUN ASC");
        // cetak_die($list);

        $list = $this->Serverside->_serverSide(
            'Div_Layanan.rekap_data_pm',
            ['no', 'KANTOR_LAYANAN', 'JUMLAH_ATM', 'ON_PROGRES_PM_4', 'DONE_PM_4', 'PRESENTASE_PM_4', 'user', 'tanggal_update'],
            ['KANTOR_LAYANAN', 'JUMLAH_ATM', 'ON_PROGRES_PM_4', 'DONE_PM_4', 'PRESENTASE_PM_4', 'user', 'tanggal_update'],
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
            $row[] = nominal($results->ON_PROGRES_PM_4);
            $row[] = nominal($results->DONE_PM_4);
            $row[] = $results->PRESENTASE_PM_4;
            $row[] = $results->user;
            $row[] = $results->tanggal_update;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Serverside->_countAll('Div_Layanan.rekap_data_pm'),
            "recordsFiltered" => $this->Serverside->_serverSide('Div_Layanan.rekap_data_pm'),
            "data" => $data,
        );

        echo json_encode($output);
    }
}
