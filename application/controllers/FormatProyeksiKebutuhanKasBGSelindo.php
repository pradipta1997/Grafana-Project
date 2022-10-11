<?php

defined('BASEPATH') or exit('No direct script access allowed');

class FormatProyeksiKebutuhanKasBGSelindo extends MY_Controller
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
        $this->header('Format Proyeksi Kebutuhan Kas BG Selindo');
        $this->load->view('Layanan/list_FormatProyeksiKebutuhanKasBGSelindo', $data);
        $this->footer();
    }

    public function listFormatProyeksiKebutuhanKasBGSelindo()
    {
        $list = $this->Serverside->_serverSide(
            'Div_Layanan.format_proyeksi_kebutuhan_kas_bg_selindo',
            ['no', 'Kantor_Cabang', 'RPL_50', 'RPL_100', 'TK_50', 'TK_100', 'Grand_Total', 'Average_Kas_Per_ATM_50', 'Average_Kas_Per_ATM_100', 'user', 'tanggal_update'],
            ['Kantor_Cabang', 'RPL_50', 'RPL_100', 'TK_50', 'TK_100', 'Grand_Total', 'Average_Kas_Per_ATM_50', 'Average_Kas_Per_ATM_100', 'user', 'tanggal_update'],
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
            $row[] = nominal($results->RPL_50);
            $row[] = nominal($results->RPL_100);
            $row[] = rupiah($results->TK_50);
            $row[] = rupiah($results->TK_100);
            $row[] = rupiah($results->Grand_Total);
            $row[] = rupiah($results->Average_Kas_Per_ATM_50);
            $row[] = rupiah($results->Average_Kas_Per_ATM_100);
            $row[] = $results->user;
            $row[] = $results->tanggal_update;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Serverside->_countAll('Div_Layanan.format_proyeksi_kebutuhan_kas_bg_selindo'),
            "recordsFiltered" => $this->Serverside->_serverSide('Div_Layanan.format_proyeksi_kebutuhan_kas_bg_selindo'),
            "data" => $data,
        );

        echo json_encode($output);
    }
}
