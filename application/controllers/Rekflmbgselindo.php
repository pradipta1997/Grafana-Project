<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Rekflmbgselindo extends MY_Controller
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
        $this->header('Rekap FLM BG Selindo');
        $this->load->view('Layanan/list_Rekflmbgselindo', $data);
        $this->footer();
    }

    public function listRekflmbgselindo()
    {
        $list = $this->Serverside->_serverSide(
            'Div_Layanan.rekap_flm_bg_selindo',
            ['no', 'KANTOR_LAYANAN', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli','Agustus', 'September', 'Oktober', 'November', 'Desember', 'Average_ALL', 'user', 'tanggal_update'],
            ['KANTOR_LAYANAN', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli','Agustus', 'September', 'Oktober', 'November', 'Desember', 'Average_ALL', 'user', 'tanggal_update'],
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
            $row[] = nominal($results->Januari);
            $row[] = nominal($results->Februari);
            $row[] = nominal($results->Maret);
            $row[] = nominal($results->April);
            $row[] = nominal($results->Mei);
            $row[] = nominal($results->Juni);
            $row[] = nominal($results->Juli);
            $row[] = nominal($results->Agustus);
            $row[] = nominal($results->September);
            $row[] = nominal($results->Oktober);
            $row[] = nominal($results->November);
            $row[] = nominal($results->Desember);
            $row[] = nominal($results->Average_ALL);
            $row[] = $results->user;
            $row[] = $results->tanggal_update;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Serverside->_countAll('Div_Layanan.rekap_flm_bg_selindo'),
            "recordsFiltered" => $this->Serverside->_serverSide('Div_Layanan.rekap_flm_bg_selindo'),
            "data" => $data,
        );

        echo json_encode($output);
    }
}
