<?php

defined('BASEPATH') or exit('No direct script access allowed');

class UpdatedataAlatAlarmSystemDanAccesDoor extends MY_Controller
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
        $this->header('Update Data Alat Alarm System & Acces Door');
        $this->load->view('Layanan/list_updateDataAlatAlarmSystemAccesDoor', $data);
        $this->footer();
    }

    public function listUpdateDataAlatAlarmSystemAccesDoor()
    {
        // $list = $this->General->fetch_CoustomQuery("SELECT * FROM db_layanan.gps_kendaraan ORDER BY gps_kendaraan.TAHUN ASC");
        // cetak_die($list);

        $list = $this->Serverside->_serverSide(
            'Div_Layanan.update_data_alat_alarm_system_dan_acces_door',
            ['no', 'jumlah', 'update_data_alat_alarm_system_acces_door', 'user', 'tanggal_update'],
            ['jumlah', 'update_data_alat_alarm_system_acces_door', 'user', 'tanggal_update'],
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
            $row[] = $results->update_data_alat_alarm_system_acces_door;
            $row[] = $results->user;
            $row[] = $results->tanggal_update;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Serverside->_countAll('Div_Layanan.update_data_alat_alarm_system_dan_acces_door'),
            "recordsFiltered" => $this->Serverside->_serverSide('Div_Layanan.update_data_alat_alarm_system_dan_acces_door'),
            "data" => $data,
        );

        echo json_encode($output);
    }
}
