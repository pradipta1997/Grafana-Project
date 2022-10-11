<?php

defined('BASEPATH') or exit('No direct script access allowed');

class UpdateCROCRM extends MY_Controller
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
        $this->header('Update CRO CRM');
        $this->load->view('Layanan/list_updateCROCRM', $data);
        $this->footer();
    }

    public function listUpdateCROCRM()
    {
        // $list = $this->General->fetch_CoustomQuery("SELECT * FROM db_layanan.gps_kendaraan ORDER BY gps_kendaraan.TAHUN ASC");
        // cetak_die($list);

        $list = $this->Serverside->_serverSide(
            'Div_Layanan.update_cro_crm',
            ['no', 'kantor_cabang', 'total_crm', 'capt_00', 'capt_03', 'capt_06', 'capt_09', 'capt_12', 'capt_15', 'capt_18', 'capt_21', 'avg', 'user', 'tanggal_update'],
            ['kantor_cabang', 'total_crm', 'capt_00', 'capt_03', 'capt_06', 'capt_09', 'capt_12', 'capt_15', 'capt_18', 'capt_21', 'avg', 'user', 'tanggal_update'],
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
            $row[] = $results->kantor_cabang;
            $row[] = $results->total_crm;
            $row[] = $results->capt_00;
            $row[] = $results->capt_03;
            $row[] = $results->capt_06;
            $row[] = $results->capt_09;
            $row[] = $results->capt_12;
            $row[] = $results->capt_15;
            $row[] = $results->capt_18;
            $row[] = $results->capt_21;
            $row[] = $results->avg;
            $row[] = $results->user;
            $row[] = $results->tanggal_update;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Serverside->_countAll('Div_Layanan.update_cro_crm'),
            "recordsFiltered" => $this->Serverside->_serverSide('Div_Layanan.update_cro_crm'),
            "data" => $data,
        );

        echo json_encode($output);
    }
}
