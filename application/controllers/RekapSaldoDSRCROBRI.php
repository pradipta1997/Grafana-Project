<?php

defined('BASEPATH') or exit('No direct script access allowed');

class RekapSaldoDSRCROBRI extends MY_Controller
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
        $this->header('Rekap Saldo DSR CRO BRI');
        $this->load->view('Layanan/list_rekapSaldoDSRCROBRI', $data);
        $this->footer();
    }

    public function listRekapSaldoDSRCROBRI()
    {
        $list = $this->Serverside->_serverSide(
            'Div_Layanan.rekap_saldo_dsr_cro_bri',
            ['no', 'BC', 'KANTOR_CABANG', 'SALDO_AWAL_CRO', 'RETURN_CRO', 'SALDO_AKHIR_CRO', 'SALDO_AWAL_DSR', 'RETURN_DSR', 'SALDO_AKHIR_DSR', 'KETERANGAN', 'NOMINAL', 'KETERANGAN1', 'NOMINAL1', 'KETERANGAN2', 'NOMINAL2', 'user', 'tanggal_update'],
            ['BC', 'KANTOR_CABANG', 'SALDO_AWAL_CRO', 'RETURN_CRO', 'SALDO_AKHIR_CRO', 'SALDO_AWAL_DSR', 'RETURN_DSR', 'SALDO_AKHIR_DSR', 'KETERANGAN', 'NOMINAL', 'KETERANGAN1', 'NOMINAL1', 'KETERANGAN2', 'NOMINAL2', 'user', 'tanggal_update'],
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
            $row[] = $results->BC;
            $row[] = $results->KANTOR_CABANG;
            $row[] = rupiah($results->SALDO_AWAL_CRO);
            $row[] = rupiah($results->RETURN_CRO);
            $row[] = rupiah($results->SALDO_AKHIR_CRO);
            $row[] = rupiah($results->SALDO_AWAL_DSR);
            $row[] = rupiah($results->RETURN_DSR);
            $row[] = rupiah($results->SALDO_AKHIR_DSR);
            $row[] = $results->KETERANGAN;
            $row[] = rupiah($results->NOMINAL);
            $row[] = $results->KETERANGAN1;
            $row[] = rupiah($results->NOMINAL1);
            $row[] = $results->KETERANGAN2;
            $row[] = rupiah($results->NOMINAL2);
            $row[] = $results->user;
            $row[] = $results->tanggal_update;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Serverside->_countAll('Div_Layanan.rekap_saldo_dsr_cro_bri'),
            "recordsFiltered" => $this->Serverside->_serverSide('Div_Layanan.rekap_saldo_dsr_cro_bri'),
            "data" => $data,
        );

        echo json_encode($output);
    }
}
