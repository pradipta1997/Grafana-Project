<?php

defined('BASEPATH') or exit('No direct script access allowed');

class RekapDataPerformanceClusterBulanan extends MY_Controller
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
        $this->header('Rekap Data Performance Cluster Bulanan');
        $this->load->view('Layanan/list_rekapDataPerformanceClusterBulanan', $data);
        $this->footer();
    }

    public function listRekapDataPerformanceClusterBulanan()
    {
        // $list = $this->General->fetch_CoustomQuery("SELECT * FROM db_layanan.gps_kendaraan ORDER BY gps_kendaraan.TAHUN ASC");
        // cetak_die($list);

        $list = $this->Serverside->_serverSide(
            'Div_Layanan.rekap_data_performance_cluster_bulanan',
            ['no', 'KANTOR_CABANG', 'Total_ATM', 'RELIABILITY', 'no_0_sd_10', 'no_11_sd_15', 'no_16_sd_20', 'no_21_sd_25', 'no_26_sd_30', 'Diatas_30', 'Total_RPL', 'RPL_per_HARI', 'RPL_ATM_BLN', 'CLUSTER', 'user', 'tanggal_update'],
            ['KANTOR_CABANG', 'Total_ATM', 'RELIABILITY', 'no_0_sd_10', 'no_11_sd_15', 'no_16_sd_20', 'no_21_sd_25', 'no_26_sd_30', 'Diatas_30', 'Total_RPL', 'RPL_per_HARI', 'RPL_ATM_BLN', 'CLUSTER', 'user', 'tanggal_update'],
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
            $row[] = $results->KANTOR_CABANG;
            $row[] = $results->Total_ATM;
            $row[] = $results->RELIABILITY;
            $row[] = nominal($results->no_0_sd_10);
            $row[] = nominal($results->no_11_sd_15);
            $row[] = nominal($results->no_16_sd_20);
            $row[] = nominal($results->no_21_sd_25);
            $row[] = nominal($results->no_26_sd_30);
            $row[] = nominal($results->Diatas_30);
            $row[] = nominal($results->Total_RPL);
            $row[] = nominal($results->RPL_per_HARI);
            $row[] = nominal($results->RPL_ATM_BLN);
            $row[] = nominal($results->CLUSTER);
            $row[] = $results->user;
            $row[] = $results->tanggal_update;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Serverside->_countAll('Div_Layanan.rekap_data_performance_cluster_bulanan'),
            "recordsFiltered" => $this->Serverside->_serverSide('Div_Layanan.rekap_data_performance_cluster_bulanan'),
            "data" => $data,
        );

        echo json_encode($output);
    }
}
