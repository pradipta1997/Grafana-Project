<?php

defined('BASEPATH') or exit('No direct script access allowed');

class RekapMonitoringPelanggaranSOPkcSelindo extends MY_Controller
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
        $this->header('Rekap Monitoring Pelanggaran SOP KC Selindo');
        $this->load->view('Layanan/list_rekapMonitoringPelanggaranSOPkcSelindo', $data);
        $this->footer();
    }

    public function listRekapMonitoringPelanggaranSOPkcSelindo()
    {
        // $list = $this->General->fetch_CoustomQuery("SELECT * FROM db_layanan.gps_kendaraan ORDER BY gps_kendaraan.TAHUN ASC");
        // cetak_die($list);

        $list = $this->Serverside->_serverSide(
            'Div_Layanan.rekap_monitoring_pelanggaran_sop_kc_selindo',
            ['no', 'unit_kerja', 'tgl_1', 'tgl_2', 'tgl_3', 'tgl_4', 'tgl_5', 'tgl_6', 'tgl_7', 'tgl_8', 'tgl_9', 'tgl_10', 'tgl_11', 'tgl_12', 'tgl_13', 'tgl_14', 'tgl_15', 'tgl_16', 'tgl_17', 'tgl_18', 'tgl_19', 'tgl_20', 'tgl_21', 'tgl_22', 'tgl_23', 'tgl_24', 'tgl_25', 'tgl_26', 'tgl_27', 'tgl_28', 'tgl_29', 'tgl_30', 'grand_total', 'user', 'tanggal_update'],
            ['unit_kerja', 'tgl_1', 'tgl_2', 'tgl_3', 'tgl_4', 'tgl_5', 'tgl_6', 'tgl_7', 'tgl_8', 'tgl_9', 'tgl_10', 'tgl_11', 'tgl_12', 'tgl_13', 'tgl_14', 'tgl_15', 'tgl_16', 'tgl_17', 'tgl_18', 'tgl_19', 'tgl_20', 'tgl_21', 'tgl_22', 'tgl_23', 'tgl_24', 'tgl_25', 'tgl_26', 'tgl_27', 'tgl_28', 'tgl_29', 'tgl_30', 'grand_total', 'user', 'tanggal_update'],
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
            $row[] = $results->unit_kerja;
            $row[] = $results->tgl_1;
            $row[] = $results->tgl_2;
            $row[] = $results->tgl_3;
            $row[] = $results->tgl_4;
            $row[] = $results->tgl_5;
            $row[] = $results->tgl_6;
            $row[] = $results->tgl_7;
            $row[] = $results->tgl_8;
            $row[] = $results->tgl_9;
            $row[] = $results->tgl_10;

            $row[] = $results->tgl_11;
            $row[] = $results->tgl_12;
            $row[] = $results->tgl_13;
            $row[] = $results->tgl_14;
            $row[] = $results->tgl_15;
            $row[] = $results->tgl_16;
            $row[] = $results->tgl_17;
            $row[] = $results->tgl_18;
            $row[] = $results->tgl_19;
            $row[] = $results->tgl_20;

            $row[] = $results->tgl_21;
            $row[] = $results->tgl_22;
            $row[] = $results->tgl_23;
            $row[] = $results->tgl_24;
            $row[] = $results->tgl_25;
            $row[] = $results->tgl_26;
            $row[] = $results->tgl_27;
            $row[] = $results->tgl_28;
            $row[] = $results->tgl_29;
            $row[] = $results->tgl_30;
            $row[] = $results->grand_total;

           
            $row[] = $results->user;
            $row[] = $results->tanggal_update;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Serverside->_countAll('Div_Layanan.rekap_monitoring_pelanggaran_sop_kc_selindo'),
            "recordsFiltered" => $this->Serverside->_serverSide('Div_Layanan.rekap_monitoring_pelanggaran_sop_kc_selindo'),
            "data" => $data,
        );

        echo json_encode($output);
    }
}
