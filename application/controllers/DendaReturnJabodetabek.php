<?php

defined('BASEPATH') or exit('No direct script access allowed');

class DendaReturnJabodetabek extends MY_Controller
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
        $this->header('Denda Return JABODETABEK');
        $this->load->view('Layanan/list_dendaReturnJabodetabek', $data);
        $this->footer();
    }

    public function listDendaReturnJabodetabek()
    {
        // $list = $this->General->fetch_CoustomQuery("SELECT * FROM db_layanan.gps_kendaraan ORDER BY gps_kendaraan.TAHUN ASC");
        // cetak_die($list);

        $list = $this->Serverside->_serverSide(
            'Div_Layanan.denda_return_jabodetabek',
            ['no', 'Kantor_Cabang', 'no_9822', 'no_9825', 'no_9850', 'no_9921', 'user', 'tanggal_update'],
            ['Kantor_Cabang', 'no_9822', 'no_9825', 'no_9850', 'no_9921', 'user', 'tanggal_update'],
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
            $row[] = $results->Kantor_Cabang;
            $row[] = rupiah($results->no_9822);
            $row[] = rupiah($results->no_9825);
            $row[] = rupiah($results->no_9850);
            $row[] = rupiah($results->no_9921);
            $row[] = $results->user;
            $row[] = $results->tanggal_update;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Serverside->_countAll('Div_Layanan.denda_return_jabodetabek'),
            "recordsFiltered" => $this->Serverside->_serverSide('Div_Layanan.denda_return_jabodetabek'),
            "data" => $data,
        );

        echo json_encode($output);
    }
}
