<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ProyeksiNilaiSanggahan extends MY_Controller
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
        $this->header('Proyeksi Nilai Sanggahan');
        $this->load->view('Layanan/list_proyeksiNilaiSanggahan', $data);
        $this->footer();
    }

    public function listProyeksiNilaiSanggahan()
    {
        // $list = $this->General->fetch_CoustomQuery("SELECT * FROM db_layanan.gps_kendaraan ORDER BY gps_kendaraan.TAHUN ASC");
        // cetak_die($list);

        $list = $this->Serverside->_serverSide(
            'Div_Layanan.proyeksi_nilai_sanggahan',
            ['no', 'cpc', 'reability_avg', 'Tier_Invoice_before', 'Total_Qty_ATM', 'Proyeksi_Pendapatan_Sebelum_Sanggahan', 'Reliability', 'delta', 'Tier_Invoice_after', 'V3_G', 'V3_NG', 'V4_G', 'V4_NG', 'Total_ATM', 'Proyeksi_Pendapatan', 'Selisih_Pendapatan_Dgn_Sebelum_Sanggahan', 'user', 'tanggal_update'],
            ['cpc', 'reability_avg', 'Tier_Invoice_before', 'Total_Qty_ATM', 'Proyeksi_Pendapatan_Sebelum_Sanggahan', 'Reliability', 'delta', 'Tier_Invoice_after', 'V3_G', 'V3_NG', 'V4_G', 'V4_NG', 'Total_ATM', 'Proyeksi_Pendapatan', 'Selisih_Pendapatan_Dgn_Sebelum_Sanggahan', 'user', 'tanggal_update'],
            ['user' => 'ASC '],
            null,
            'data'
        );
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $results) {

            $row = array();
            $no++;
            $row[] = $no;
            $row[] = $results->cpc;
            $row[] = $results->reability_avg;
            $row[] = $results->Tier_Invoice_before;
            $row[] = nominal2($results->Total_Qty_ATM);
            $row[] = $results->Proyeksi_Pendapatan_Sebelum_Sanggahan;
            $row[] = nominal2($results->Reliability);
            $row[] = nominal2($results->delta);
            $row[] = $results->Tier_Invoice_after;
            $row[] = $results->V3_G;
            $row[] = $results->V3_NG;
            $row[] = $results->V4_G;
            $row[] = $results->V4_NG;
            $row[] = $results->Total_ATM;
            $row[] = rupiah($results->Proyeksi_Pendapatan);
            $row[] = $results->Selisih_Pendapatan_Dgn_Sebelum_Sanggahan;
            $row[] = $results->user;
            $row[] = $results->tanggal_update;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Serverside->_countAll('Div_Layanan.proyeksi_nilai_sanggahan'),
            "recordsFiltered" => $this->Serverside->_serverSide('Div_Layanan.proyeksi_nilai_sanggahan'),
            "data" => $data,
        );

        echo json_encode($output);
    }
}
