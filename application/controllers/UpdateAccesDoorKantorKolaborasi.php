<?php

defined('BASEPATH') or exit('No direct script access allowed');

class UpdateAccesDoorKantorKolaborasi extends MY_Controller
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
        $this->header('Update Acces Door Kantor Kolaborasi');
        $this->load->view('Layanan/list_UpdateAccesDoorKantorKolaborasi', $data);
        $this->footer();
    }

    public function listUpdateAccesDoorKantorKolaborasi()
    {
        // $list = $this->General->fetch_CoustomQuery("SELECT * FROM db_layanan.gps_kendaraan ORDER BY gps_kendaraan.TAHUN ASC");
        // cetak_die($list);

        $list = $this->Serverside->_serverSide(
            'Div_Layanan.update_acces_door_kantor_kolaborasi',
            ['no', 'Update_Data_Access_Door_Kantor_Kolaborasi', 'user', 'tanggal_update'],
            ['Update_Data_Access_Door_Kantor_Kolaborasi', 'user', 'tanggal_update'],
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
            $row[] = $results->Update_Data_Access_Door_Kantor_Kolaborasi;
            $row[] = $results->user;
            $row[] = $results->tanggal_update;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Serverside->_countAll('Div_Layanan.update_acces_door_kantor_kolaborasi'),
            "recordsFiltered" => $this->Serverside->_serverSide('Div_Layanan.update_acces_door_kantor_kolaborasi'),
            "data" => $data,
        );

        echo json_encode($output);
    }
}
