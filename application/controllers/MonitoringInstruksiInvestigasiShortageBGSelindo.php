<?php

defined('BASEPATH') or exit('No direct script access allowed');

class MonitoringInstruksiInvestigasiShortageBGSelindo extends MY_Controller
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
        $this->header('Monitoring Instruksi Investigasi Shortage BG Selindo');
        $this->load->view('Layanan/list_monitoringInstruksiInvestigasiShortageBGSelindo', $data);
        $this->footer();
    }

    public function listMonitoringInstruksiInvestigasiShortageBGSelindo()
    {
        // $list = $this->General->fetch_CoustomQuery("SELECT * FROM db_layanan.gps_kendaraan ORDER BY gps_kendaraan.TAHUN ASC");
        // cetak_die($list);


        $list = $this->Serverside->_serverSide(
            'Div_Layanan.Monitoring_Instruksi_Investigasi_Shortage_BG_Selindo',
            ['no', 'Kantor_Cabang', 'Frekuensi', 'Nominal', 'Frekuensi_Kasus_New', 'Frekuensi_Kasus_Open', 'Frekuensi_Kasus_Close', 'Frekuensi_Kasus', 'Closed_Case_Done', 'Closed_Case_Progress', 'Pending', 'Periode', 'user', 'tanggal_update'],
            ['Kantor_Cabang', 'Frekuensi', 'Nominal', 'Frekuensi_Kasus_New', 'Frekuensi_Kasus_Open', 'Frekuensi_Kasus_Close', 'Frekuensi_Kasus', 'Closed_Case_Done', 'Closed_Case_Progress', 'Pending', 'Periode', 'user', 'tanggal_update'],
            ['tanggal_update' => 'DESC'],
            null,
            'data'
        );
        // lastq();
        $data = array();
        $no = $_POST['start'];

        // cetak_die($list);
        foreach ($list as $results) {

            $row = array();
            $no++;
            $row[] = $no;
            $row[] = $results->Kantor_Cabang;
            $row[] = $results->Frekuensi;
            $row[] = rupiah($results->Nominal);
            $row[] = $results->Frekuensi_Kasus_New;
            $row[] = $results->Frekuensi_Kasus_Open;
            $row[] = $results->Frekuensi_Kasus_Close;
            $row[] = $results->Frekuensi_Kasus;
            $row[] = rupiah($results->Closed_Case_Done);
            $row[] = rupiah($results->Closed_Case_Progress);
            $row[] = $results->Pending;
            $row[] = $results->Periode;
            $row[] = $results->user;
            $row[] = $results->tanggal_update;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Serverside->_countAll('Div_Layanan.Monitoring_Instruksi_Investigasi_Shortage_BG_Selindo'),
            "recordsFiltered" => $this->Serverside->_serverSide('Div_Layanan.Monitoring_Instruksi_Investigasi_Shortage_BG_Selindo'),
            "data" => $data,
        );

        echo json_encode($output);
    }
}
