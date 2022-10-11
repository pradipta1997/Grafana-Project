<?php

defined('BASEPATH') or exit('No direct script access allowed');

class MonitoringProyek extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('excel', 'session'));
        if (!$this->session->userdata("user_login")) {
            redirect('Auth');
        }
    }

    public function index()
    {
        $data = array(

            // 'inserttable' => $this->General->fetch_CoustomQuery("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='db_chm'"),
        );

        // cekPergroup();
        $this->header('Monitoring Proyek');
        $this->load->view('Keuangan/list_monitoringProyek', $data);
        $this->footer();
    }

    public function listMonitoringProyek()
    {
        $list = $this->Serverside->_serverSide(
            'Div_Keuangan.monitoring_proyek',
            ['no', 'NAMA_PROYEK', 'JANUARI_2021', 'FEBRUARI_2021', 'MARET_2021', 'APRIL_2021', 'MEI_2021', 'JUNI_2021', 'JULI_2021', 'AGUSTUS_2021', 'SEPTEMBER_2021','OKTOBER_2021','NOVEMBER_2021','DESEMBER_2021','JANUARI_2022', 'FEBRUARI_2022', 'MARET_2022', 'APRIL_2022', 'MEI_2022', 'JUNI_2022', 'JULI_2022', 'AGUSTUS_2022', 'SEPTEMBER_2022', 'OKTOBER_2022', 'NOVEMBER_2022', 'DESEMBER_2022', 'KETERANGAN', 'user', 'tanggal_update'],
            ['NAMA_PROYEK', 'JANUARI_2021', 'FEBRUARI_2021', 'MARET_2021', 'APRIL_2021', 'MEI_2021', 'JUNI_2021', 'JULI_2021', 'AGUSTUS_2021', 'SEPTEMBER_2021','OKTOBER_2021','NOVEMBER_2021','DESEMBER_2021','JANUARI_2022', 'FEBRUARI_2022', 'MARET_2022', 'APRIL_2022', 'MEI_2022', 'JUNI_2022', 'JULI_2022', 'AGUSTUS_2022', 'SEPTEMBER_2022', 'OKTOBER_2022', 'NOVEMBER_2022', 'DESEMBER_2022', 'KETERANGAN', 'user', 'tanggal_update'],
            ['tanggal_update' => 'ASC'],
            null,
            'data'
        );
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $results) {

            $row = array();
            $no++;
            $row[] = $no;
            $row[] = $results->NAMA_PROYEK;
            $row[] = $results->JANUARI_2021;
            $row[] = $results->FEBRUARI_2021;
            $row[] = $results->MARET_2021;
            $row[] = $results->APRIL_2021;
            $row[] = $results->MEI_2021;
            $row[] = $results->JUNI_2021;
            $row[] = $results->JULI_2021;
            $row[] = $results->AGUSTUS_2021;
            $row[] = $results->SEPTEMBER_2021;
            $row[] = $results->OKTOBER_2021;
            $row[] = $results->NOVEMBER_2021;
            $row[] = $results->DESEMBER_2021;
            $row[] = $results->JANUARI_2022;
            $row[] = $results->FEBRUARI_2022;
            $row[] = $results->MARET_2022;
            $row[] = $results->APRIL_2022;
            $row[] = $results->MEI_2022;
            $row[] = $results->JUNI_2022;
            $row[] = $results->JULI_2022;
            $row[] = $results->AGUSTUS_2022;
            $row[] = $results->SEPTEMBER_2022;
            $row[] = $results->OKTOBER_2022;
            $row[] = $results->NOVEMBER_2022;
            $row[] = $results->DESEMBER_2022;
            $row[] = $results->KETERANGAN;
            $row[] = $results->user;
            $row[] = $results->tanggal_update;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Serverside->_countAll('Div_Keuangan.monitoring_proyek'),
            "recordsFiltered" => $this->Serverside->_serverSide('Div_Keuangan.monitoring_proyek'),
            "data" => $data,
        );

        echo json_encode($output);
    }
}
