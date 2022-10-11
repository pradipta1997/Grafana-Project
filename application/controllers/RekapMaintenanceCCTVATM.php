<?php

defined('BASEPATH') or exit('No direct script access allowed');

class RekapMaintenanceCCTVATM extends MY_Controller
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
        $this->header('Rekap Maintenance CCTV ATM');
        $this->load->view('Layanan/list_rekapMaintenanceCCTVATM', $data);
        $this->footer();
    }

    public function listRekapMaintenanceCCTVATM()
    {
        // $list = $this->General->fetch_CoustomQuery("SELECT * FROM db_layanan.gps_kendaraan ORDER BY gps_kendaraan.TAHUN ASC");
        // cetak_die($list);

        $list = $this->Serverside->_serverSide(
            'Div_Layanan.rekap_maintenance_cctv_atm',
            ['no', 'KANTOR_LAYANAN', 'JUMLAH_ATM', 'WEEK_1_ON_PROGRESS', 'WEEK_1_DONE', 'WEEK_2_ON_PROGRESS', 'WEEK_2_DONE', 'WEEK_3_ON_PROGRESS', 'WEEK_3_DONE', 'WEEK_4_ON_PROGRESS', 'WEEK_4_DONE', 'user', 'tanggal_update'],
            ['KANTOR_LAYANAN', 'JUMLAH_ATM', 'WEEK_1_ON_PROGRESS', 'WEEK_1_DONE', 'WEEK_2_ON_PROGRESS', 'WEEK_2_DONE', 'WEEK_3_ON_PROGRESS', 'WEEK_3 _DONE', 'WEEK_4_ON_PROGRESS', 'WEEK_4_DONE', 'user', 'tanggal_update'],
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
            $row[] = $results->JUMLAH_ATM;
            $row[] = $results->WEEK_1_ON_PROGRESS;
            $row[] = $results->WEEK_1_DONE;
            $row[] = $results->WEEK_2_ON_PROGRESS;
            $row[] = $results->WEEK_2_DONE;
            $row[] = $results->WEEK_3_ON_PROGRESS;
            $row[] = $results->WEEK_3_DONE;
            $row[] = $results->WEEK_4_ON_PROGRESS;
            $row[] = $results->WEEK_4_DONE;
            $row[] = $results->user;
            $row[] = $results->tanggal_update;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Serverside->_countAll('Div_Layanan.rekap_maintenance_cctv_atm'),
            "recordsFiltered" => $this->Serverside->_serverSide('Div_Layanan.rekap_maintenance_cctv_atm'),
            "data" => $data,
        );

        echo json_encode($output);
    }
}
