<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Layanan extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('excel', 'session'));
        $this->layanan = $this->load->database('db2', TRUE);
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
        $this->header('Layanan');
        $this->load->view('Layanan/layanan', $data);
        $this->footer();
    }


    public function import_excel()
    {
        $layanan = input('layanan');
        // cetak_die($layanan);

        //Tabel GPS Kendaraan ------------------------------------------------------------------------------------------------------------
        if ($layanan == 'gps_kendaraan') {

            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $NO = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $CABANG = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $KODE = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $NO_POLISI = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $JENIS_KENDARAAN = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $UKER = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $TAHUN = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $NO_GSM = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $IMEI = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $STATUS_KENDARAAN = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $PEMBAYARAN_GSM = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                        $Keterangan = $worksheet->getCellByColumnAndRow(11, $row)->getValue();

                        $temp_data[] = array(
                            'NO'                    => $NO,
                            'CABANG'                => $CABANG,
                            'KODE'                  => $KODE,
                            'NO_POLISI'             => $NO_POLISI,
                            'JENIS_KENDARAAN'       => $JENIS_KENDARAAN,
                            'UKER'                  => $UKER,
                            'TAHUN'                 => $TAHUN,
                            'NO_GSM'                => $NO_GSM,
                            'IMEI'                  => $IMEI,
                            'STATUS_KENDARAAN'      => $STATUS_KENDARAAN,
                            'PEMBAYARAN_GSM'        => $PEMBAYARAN_GSM,
                            'Keterangan'            => $Keterangan,
                            'user'                  => $this->session->userdata("user_login")['username']

                        );
                        //delete data
                        $this->db->query("DELETE FROM Div_Layanan.gps_kendaraan IMEI = '".$IMEI."'"); 
                    }
                }
                // $this->load->model('ImportModel');
                //insert data
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('Gpskendaraan');
                    }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('Gpskendaraan');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }


    //Tabel Data Segel Tas ------------------------------------------------------------------------------------------------------------
        } else if ($layanan == 'data_segel_tas') {

            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $Tahun = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $Bulan = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $Kode = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $Kantor_Cabang = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $Nama_Barang = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $Awal = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $Masuk = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $Keluar = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $Sisa = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $Permintaan = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $Kode_Barang = $worksheet->getCellByColumnAndRow(10, $row)->getValue();


                        $temp_data[] = array(
                            'Tahun'    => $Tahun,
                            'Bulan'    => $Bulan,
                            'Kode'    => $Kode,
                            'Kantor_Cabang'    => $Kantor_Cabang,
                            'Nama_Barang'    => $Nama_Barang,
                            'Awal'    => $Awal,
                            'Masuk'    => $Masuk,
                            'Keluar'    => $Keluar,
                            'Sisa'    => $Sisa,
                            'Permintaan'    => $Permintaan,
                            'Kode_Barang'    => $Kode_Barang,
                            'user' => $this->session->userdata("user_login")['username']

                        );
                        //delete data
                        // $this->db->query("DELETE FROM Div_Layanan.data_segel_tas WHERE ");
                    }
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('Datasegeltas');
                    }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('Datasegeltas');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }

            //Tabel Kendaraan ------------------------------------------------------------------------------------------------------------
        } else if ($layanan == 'kendaraan') {

            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $Kode = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $Kanca = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $No = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $Kendaraan_TNBK = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $Tahun_Kend = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $Type_Kend = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $Rangka_Kend = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $Mesin_Kend = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $Status_Kend = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $Project = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $Uker = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                        $gsm = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                        $imei = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                        $Sataus_gps = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                        $Vendor = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                        $Awal_sewa = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
                        $Akhir_sewa = $worksheet->getCellByColumnAndRow(16, $row)->getValue();
                        $stnk_row = $worksheet->getCellByColumnAndRow(17, $row);
                        $stnk = $stnk_row->getValue();
                        if(PHPExcel_Shared_Date::isDateTime($stnk_row)) {
                             $stnk = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($stnk)); 
                        }
                        $tnbk_row = $worksheet->getCellByColumnAndRow(18, $row);
                        $tnbk = $tnbk_row->getValue();
                        if(PHPExcel_Shared_Date::isDateTime($tnbk_row)) {
                             $tnbk = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($tnbk)); 
                        }
                        $Masa_kir_row = $worksheet->getCellByColumnAndRow(19, $row);
                        $Masa_kir = $Masa_kir_row->getValue();
                        if(PHPExcel_Shared_Date::isDateTime($Masa_kir_row)) {
                             $Masa_kir = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($Masa_kir)); 
                        }
                        $safety_box = $worksheet->getCellByColumnAndRow(20, $row)->getValue();
                        $jenis_kend = $worksheet->getCellByColumnAndRow(21, $row)->getValue();
                        $keterangan = $worksheet->getCellByColumnAndRow(22, $row)->getValue();

                        $temp_data[] = array(
                            'Kode'    => $Kode,
                            'Kanca'    => $Kanca,
                            'No'    => $No,
                            'Kendaraan_TNBK'    => $Kendaraan_TNBK,
                            'Tahun_Kend'    => $Tahun_Kend,
                            'Type_Kend'    => $Type_Kend,
                            'Rangka_Kend'    => $Rangka_Kend,
                            'Mesin_Kend'    => $Mesin_Kend,
                            'Status_Kend'    => $Status_Kend,
                            'Project'    => $Project,
                            'Uker'    => $Uker,
                            'gsm'    => $gsm,
                            'imei'    => $imei,
                            'Sataus_gps'    => $Sataus_gps,
                            'Vendor'    => $Vendor,
                            'Awal_sewa'    => $Awal_sewa,
                            'Akhir_sewa'    => $Akhir_sewa,
                            'stnk'    => $stnk,
                            'tnbk'    => $tnbk,
                            'Masa_kir'    => $Masa_kir,
                            'safety_box'    => $safety_box,
                            'jenis_kend'    => $jenis_kend,
                            'keterangan'    => $keterangan,
                            'user' => $this->session->userdata("user_login")['username']

                        );
                        //delete data
                        $this->db->query("DELETE FROM Div_Layanan.kendaraan WHERE Kendaraan_TNBK = '".$Kendaraan_TNBK."'"); 
                    }
                }
                // $this->load->model('ImportModel');
                //insert data
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                if ($insert) {
                    if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('Kendaraan');
                    }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('Kendaraan');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }

    //Tabel Data Kas ------------------------------------------------------------------------------------------------------------
        } else if ($layanan == 'tbl_data_kas') {

            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $kantor_cabang = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $tk_replenish = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $return = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $atm_replenish = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $average_tk = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $average_return = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $average_rpl = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        

                        $temp_data[] = array(
                            'no'    => $no,
                            'kantor_cabang'    => $kantor_cabang,
                            'tk_replenish'    => $tk_replenish,
                            'return'    => $return,
                            'atm_replenish'    => $atm_replenish,
                            'average_tk'    => $average_tk,
                            'average_return'    => $average_return,
                            'average_rpl'    => $average_rpl,
                          'user' => $this->session->userdata("user_login")['username']

                        );
                        //delete data
                        $this->db->query("DELETE FROM Div_Layanan.tbl_data_kas WHERE kantor_cabang = '".$kantor_cabang."'");
                    }
                }
                // $this->load->model('ImportModel');
                //insert data
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('Datakas');
                    }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('Datakas');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }

    //Tabel Master Kas ------------------------------------------------------------------------------------------------------------
        } else if ($layanan == 'tbl_masterkas'){
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();

                        // $tanggal = $worksheet->getCellByColumnAndRow(1, $row)->getValue();

                        $tanggal = $worksheet->getCellByColumnAndRow(1, $row);
                        $tgl_kas = $tanggal->getValue();
                        if(PHPExcel_Shared_Date::isDateTime($tanggal)) {
                             $tgl_kas = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($tgl_kas)); 
                        }
                        
                        $codebranch = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $saldo_awal_bri = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $uang_layak = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $uang_meragukan = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $uang_tidak_layak = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $total_saldo_awal_penambahan = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $tambahan_kas = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $penukaran_uang_tidak_layak = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $kas_atm_return = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                        $sub_total = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                        $total_saldo_awal_pengurangan = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                        $shortage = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                        $atm_replenish = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                        $sub_total_pengurangan = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
                        $saldo_akhir = $worksheet->getCellByColumnAndRow(16, $row)->getValue();
                        $cabang = $worksheet->getCellByColumnAndRow(17, $row)->getValue();                        

                        $temp_data[] = array(
                            'no'    => $no,
                            'tanggal'    => $tgl_kas,
                            'codebranch'    => $codebranch,
                            'saldo_awal_bri'    => $saldo_awal_bri,
                            'uang_layak'    => $uang_layak,
                            'uang_meragukan'    => $uang_meragukan,
                            'uang_tidak_layak'    => $uang_tidak_layak,
                            'total_saldo_awal_penambahan'    => $total_saldo_awal_penambahan,
                            'tambahan_kas'    => $tambahan_kas,
                            'penukaran_uang_tidak_layak'    => $penukaran_uang_tidak_layak,
                            'kas_atm_return'    => $kas_atm_return,
                            'sub_total'    => $sub_total,
                            'total_saldo_awal_pengurangan'    => $total_saldo_awal_pengurangan,
                            'shortage'    => $shortage,
                            'atm_replenish'    => $atm_replenish,
                            'sub_total_pengurangan'    => $sub_total_pengurangan,
                            'saldo_akhir'    => $saldo_akhir,
                            'cabang'    => $cabang,
                            'user' => $this->session->userdata("user_login")['username']

                        );
                        // delete data
                        // $this->db->  query("DELETE FROM Div_Layanan.tbl_masterkas WHERE no = '" . $no . "'");
                    }
                }
                // $this->load->model('ImportModel');
                //insert data
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                if ($insert) {
                    if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('Masterkas');
                    }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('Masterkas');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }
        

        //Tabel MHU & MSU ------------------------------------------------------------------------------------------------------------
        }else if ($layanan == 'tbl_mhu_dan_msu'){
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $kode = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $kanca = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $project = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $type_mesin = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $serial_number = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $versi_software = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $tahun_produksi = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $tahun_pengadaan = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $jumlah_pocket = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $jenis_mesin = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $aktivitas_mesin = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                        $kepemilikan = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                        $kondisi = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                        $keterangan = $worksheet->getCellByColumnAndRow(13, $row)->getValue();                        

                        $temp_data[] = array(
                            'kode'    => $kode,
                            'kanca'    => $kanca,
                            'project'    => $project,
                            'type_mesin'    => $type_mesin,
                            'serial_number'    => $serial_number,
                            'versi_software'    => $versi_software,
                            'tahun_produksi'    => $tahun_produksi,
                            'tahun_pengadaan'    => $tahun_pengadaan,
                            'jumlah_pocket'    => $jumlah_pocket,
                            'jenis_mesin'    => $jenis_mesin,
                            'aktivitas_mesin'    => $aktivitas_mesin,
                            'kepemilikan'    => $kepemilikan,
                            'kondisi'    => $kondisi,
                            'keterangan'    => $keterangan,
                            'user' => $this->session->userdata("user_login")['username']

                        );
                        //delete data
                        $this->db->query("DELETE FROM Div_Layanan.tbl_mhu_dan_msu WHERE serial_number = '".$serial_number."'"); 
                    }
                }
                // $this->load->model('ImportModel');
                //insert data
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                if ($insert) {
                    if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('Mhumsu');
                    }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('Mhumsu');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }


        //Tabel Rekap Shortage ------------------------------------------------------------------------------------------------------------
        }else if ($layanan == 'tbl_rekap_shortage'){
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $No = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $Tgl_Selisih_raw = $worksheet->getCellByColumnAndRow(1, $row);
                        $tgl_selisih_final = $Tgl_Selisih_raw->getValue();
                        if(PHPExcel_Shared_Date::isDateTime($Tgl_Selisih_raw)) {
                             $tgl_selisih_final = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($tgl_selisih_final)); 
                        }
                        $Kantor_Cabang = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $TID = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $BC = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $Lokasi = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $Mesin = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $Denom = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $Supervisi = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $Shortage = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $tgl_intruksi_row = $worksheet->getCellByColumnAndRow(10, $row);
                        $tgl_intruksi = $tgl_intruksi_row->getValue();
                        if(PHPExcel_Shared_Date::isDateTime($tgl_intruksi_row)) {
                             $tgl_intruksi = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($tgl_intruksi)); 
                        }
                        $Surat_Investigasi = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                        $PIC_Investigasi = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                        $Keterangan_H3 = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                        $reminder_row = $worksheet->getCellByColumnAndRow(14, $row);
                        $Reminder_H3 = $reminder_row->getValue();
                        if(PHPExcel_Shared_Date::isDateTime($reminder_row)) {
                             $Reminder_H3 = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($Reminder_H3)); 
                        }
                        $Tindak_lanjut = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
                        $Kesimpulan = $worksheet->getCellByColumnAndRow(16, $row)->getValue();
                        $New = $worksheet->getCellByColumnAndRow(17, $row)->getValue();
                        $Open = $worksheet->getCellByColumnAndRow(19, $row)->getValue();
                        $Close = $worksheet->getCellByColumnAndRow(20, $row)->getValue();
                        $Case_ID = $worksheet->getCellByColumnAndRow(21, $row)->getValue();

                        $temp_data[] = array(
                            'No'    => $No,
                            'Tgl_Selisih'    => $tgl_selisih_final,
                            'Kantor_Cabang'    => $Kantor_Cabang,
                            'TID'    => $TID,
                            'BC'    => $BC,
                            'Lokasi'    => $Lokasi,
                            'Mesin'    => $Mesin,
                            'Denom'    => $Denom,
                            'Supervisi'    => $Supervisi,
                            'Shortage'    => $Shortage,
                            'Tgl_Instruksi'    => $tgl_intruksi,
                            'Surat_Investigasi'    => $Surat_Investigasi,
                            'PIC_Investigasi'    => $PIC_Investigasi,
                            'Keterangan_H3'    => $Keterangan_H3,
                            'Reminder_H3'    => $Reminder_H3,
                            'Tindak_lanjut'    => $Tindak_lanjut,
                            'Kesimpulan'    => $Kesimpulan,
                            'New'    => $New,
                            'Open'    => $Open,
                            'Close'    => $Close,
                            'Case_ID'    => $Case_ID,
                            'user' => $this->session->userdata("user_login")['username']

                        );
                        // delete data
                        $this->db->query("DELETE FROM Div_Layanan.tbl_rekap_shortage WHERE TID = '".$TID."'");
                    }
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('Rekapshortage');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('Rekapshortage');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }

        //Tabel Rekap Bank BJB ------------------------------------------------------------------------------------------------------------
        } else if ($layanan == 'rekap_bank_bjb'){
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $No = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $cabang = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $id_atm = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $lokasi_atm = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $tanggal_efektif = $worksheet->getCellByColumnAndRow(4, $row);
                        $tgl_efektif_final = $tanggal_efektif->getValue();
                        if(PHPExcel_Shared_Date::isDateTime($tanggal_efektif)) {
                             $tgl_efektif_final = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($tgl_efektif_final)); 
                        }
                        $jam_pengisian = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $denom = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $nominal_pengisian = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $vendor = $worksheet->getCellByColumnAndRow(8, $row)->getValue();  

                        $temp_data[] = array(
                            'No'               => $No,
                            'cabang'           => $cabang,
                            'id_atm'           => $id_atm,
                            'lokasi_atm'       => $lokasi_atm,
                            'tanggal_efektif'  => $tgl_efektif_final,
                            'jam_pengisian'    => $jam_pengisian,
                            'denom'            => $denom,
                            'nominal_pengisian' => $nominal_pengisian,
                            'vendor'            => $vendor,
                            'user'              => $this->session->userdata("user_login")['username']

                        );
                        //delete data
                        // $this->db->query("DELETE FROM Div_Layanan.rekap_bank_bjb WHERE "); 
                    }
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('Rekapbankbjb');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('Rekapbankbjb');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }


            //Tabel Rekap CR Bank BJB ------------------------------------------------------------------------------------------------------------
        } else if ($layanan == 'rekap_cr_bank_bjb'){
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $NO = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        
                        //untuk convert tanggal excel to db
                        $Tgl_Rep = $worksheet->getCellByColumnAndRow(1, $row);
                        $tgl_Rep_final = $Tgl_Rep->getValue();
                        if(PHPExcel_Shared_Date::isDateTime($Tgl_Rep)) {
                             $tgl_Rep_final = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($tgl_Rep_final)); 
                        }

                        $ID_ATM = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $BG = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $Lokasi = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $Time = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $Denom = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $Tot_Replenish = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                    

                        $temp_data[] = array(
                            'NO'            => $NO,
                            'Tgl_Rep'       => $tgl_Rep_final,
                            'ID_ATM'        => $ID_ATM,
                            'BG'            => $BG,
                            'Lokasi'        => $Lokasi,
                            'Time'          => $Time,
                            'Denom'         => $Denom,
                            'Tot_Replenish' => $Tot_Replenish,
                            'user'          => $this->session->userdata("user_login")['username']

                        );

                        $this->db->query("DELETE FROM Div_Layanan.rekap_cr_bank_bjb WHERE ID_ATM = '" . $ID_ATM . "'");
                        // lastq();
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('Rekapcrbankbjb');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('Rekapcrbankbjb');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }


            //Tabel Rekap FLM Bank BJB ------------------------------------------------------------------------------------------------------------
        } else if ($layanan == 'rekap_flm_bank_bjb'){
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $No = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        // $Tanggal = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $Tanggal = $worksheet->getCellByColumnAndRow(1, $row);
                        $tgl_final = $Tanggal->getValue();
                        if(PHPExcel_Shared_Date::isDateTime($Tanggal)) {
                             $tgl_final = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($tgl_final)); 
                        }
                        $Kantor_Cabang = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $ID_ATM = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $Nama_ATM = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $Problem = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $No_Tiket_Catatan_BG = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                    

                        $temp_data[] = array(
                            'No'                  => $No,
                            'Tanggal'             => $tgl_final,
                            'Kantor_Cabang'       => $Kantor_Cabang,
                            'ID_ATM'              => $ID_ATM,
                            'Nama_ATM'            => $Nama_ATM,
                            'Problem'             => $Problem,
                            'No_Tiket_Catatan_BG' => $No_Tiket_Catatan_BG,
                            'user'                => $this->session->userdata("user_login")['username']

                        );

                        $this->db->query("DELETE FROM Div_Layanan.rekap_flm_bank_bjb WHERE ID_ATM = '" . $ID_ATM . "'");
                        // lastq();

                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('Rekapflmbankbjb');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('Rekapflmbankbjb');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }


            //Tabel Rekap Biaya CR FLM Bank BJB ------------------------------------------------------------------------------------------------------------
        } else if ($layanan == 'rekap_biaya_cr_flm_bank_bjb'){
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $NO = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $ID = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        // $TANGGAL_PERDANA_PENGISIAN_ATM = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $tgl_perdana_pengisianatm = $worksheet->getCellByColumnAndRow(2, $row);
                        $TANGGAL_PERDANA_PENGISIAN_ATM = $tgl_perdana_pengisianatm->getValue();
                        if(PHPExcel_Shared_Date::isDateTime($tgl_perdana_pengisianatm)) {
                             $TANGGAL_PERDANA_PENGISIAN_ATM = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($TANGGAL_PERDANA_PENGISIAN_ATM)); 
                        }
                        $HARI = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $CABANG = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $ATM = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $BG = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $BIAYA_CR_DAN_FLM = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $PPN = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $VERSI_BJB_CR = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $VERSI_BJB_FLM = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                        $VERSI_BJB_CR_DAN_FLM = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                        $VERSI_BJB_CR_DAN_FLM1 = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                        $VERSI_BG_FLM = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                        $VERSI_BG_CR_DAN_FLM = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                        $BIAYA = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
                        $KETERANGAN = $worksheet->getCellByColumnAndRow(16, $row)->getValue();
                        $TOTAL_BIAYA = $worksheet->getCellByColumnAndRow(17, $row)->getValue();
                        $TRUE_FALSE = $worksheet->getCellByColumnAndRow(18, $row)->getValue();
                    

                        $temp_data[] = array(
                            'NO'                              => $NO,
                            'ID'                              => $ID,
                            'TANGGAL_PERDANA_PENGISIAN_ATM'   => $TANGGAL_PERDANA_PENGISIAN_ATM,
                            'HARI'                  => $HARI,
                            'CABANG'                => $CABANG,
                            'ATM'                   => $ATM,
                            'BG'                    => $BG,
                            'BIAYA_CR_DAN_FLM'      => $BIAYA_CR_DAN_FLM,
                            'PPN'                   => $PPN,
                            'VERSI_BJB_CR'          => $VERSI_BJB_CR,
                            'VERSI_BJB_FLM'         => $VERSI_BJB_FLM,
                            'VERSI_BJB_CR_DAN_FLM'  => $VERSI_BJB_CR_DAN_FLM,
                            'VERSI_BJB_CR_DAN_FLM1' => $VERSI_BJB_CR_DAN_FLM1,
                            'VERSI_BG_FLM'          => $VERSI_BG_FLM,
                            'VERSI_BG_CR_DAN_FLM'   => $VERSI_BG_CR_DAN_FLM,
                            'BIAYA'                 => $BIAYA,
                            'KETERANGAN'            => $KETERANGAN,
                            'TOTAL_BIAYA'           => $TOTAL_BIAYA,
                            'TRUE_FALSE'            => $TRUE_FALSE,
                            'user'                  => $this->session->userdata("user_login")['username']

                        );

                        $this->db->query("DELETE FROM Div_Layanan.rekap_biaya_cr_flm_bank_bjb WHERE ID = '" . $ID . "'");
                        // lastq();
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('Rekapbiayacrflmbjb');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('Rekapbiayacrflmbjb');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }

//Tabel Harga Kegiatan Bank BJB ------------------------------------------------------------------------------------------------------------
        } else if ($layanan == 'harga_kegiatan_bank_bjb'){
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $NO = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $wilayah = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $kantor_cabang = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $total_atm = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $kegiatan_cr = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $kegiatan_flm = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $total_biaya = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        
                        $temp_data[] = array(
                            'NO'                         => $NO,
                            'wilayah'                    => $wilayah,
                            'kantor_cabang'              => $kantor_cabang,
                            'total_atm'                  => $total_atm,
                            'kegiatan_cr'                => $kegiatan_cr,
                            'kegiatan_flm'               => $kegiatan_flm,
                            'total_biaya'                => $total_biaya,
                            'user'                       => $this->session->userdata("user_login")['username']

                        );

                        // $this->db->query("DELETE FROM Div_Layanan.harga_kegiatan_bank_bjb WHERE );
                        // lastq();
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('Hargakegiatanbankbjb');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('Hargakegiatanbankbjb');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }

//Tabel Rekap analisa kc non cro cit ------------------------------------------------------------------------------------------------------------
        }else if ($layanan == 'rekap_analisa_kc_non_cro_cit'){
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $Laba_Rugi = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $Status_Pencapaian_VS_RKA_Pendapatan = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $Status_Pencapaian_VS_RKA_Biaya = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $Status_Pencapaian_VS_RKA_Laba_Rugi = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $Nama_Kanca = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $Nama_Pembina = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $RKA_Pendapatan = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $RKA_Biaya = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $RKA_Laba_Rugi = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $Pencapaian_VS_RKA_Pendapatan = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $Pencapaian_VS_RKA_Biaya = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                        $Pencapaian_VS_RKA_Laba_Rugi = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                        $Total_Pencapaian_Pendapatan = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                        $Total_Pencapaian_Biaya = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                        $Total_Pencapaian_Laba_Rugi = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                        $Total_Pencapaian_BOPO = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
                        $Prognosa_sd_Desember_Pendapatan = $worksheet->getCellByColumnAndRow(16, $row)->getValue();
                        $Prognosa_sd_Desember_Biaya = $worksheet->getCellByColumnAndRow(17, $row)->getValue();
                        $Prognosa_sd_Desember_Laba_Rugi = $worksheet->getCellByColumnAndRow(18, $row)->getValue();
                                                
                        $temp_data[] = array(
                            'Laba_Rugi'                     => $Laba_Rugi,
                            'Status_Pencapaian_VS_RKA_Pendapatan'                => $Status_Pencapaian_VS_RKA_Pendapatan,
                            'Status_Pencapaian_VS_RKA_Biaya'          => $Status_Pencapaian_VS_RKA_Biaya,
                            'Status_Pencapaian_VS_RKA_Laba_Rugi'              => $Status_Pencapaian_VS_RKA_Laba_Rugi,
                            'Nama_Kanca'            => $Nama_Kanca,
                            'Nama_Pembina'           => $Nama_Pembina,
                            'RKA_Pendapatan'            => $RKA_Pendapatan,
                            'RKA_Biaya'            => $RKA_Biaya,
                            'RKA_Laba_Rugi'            => $RKA_Laba_Rugi,
                            'Pencapaian_VS_RKA_Pendapatan'            => $Pencapaian_VS_RKA_Pendapatan,
                            'Pencapaian_VS_RKA_Biaya'            => $Pencapaian_VS_RKA_Biaya,
                            'Pencapaian_VS_RKA_Laba_Rugi'            => $Pencapaian_VS_RKA_Laba_Rugi,
                            'Total_Pencapaian_Pendapatan'            => $Total_Pencapaian_Pendapatan,
                            'Total_Pencapaian_Biaya'            => $Total_Pencapaian_Biaya,
                            'Total_Pencapaian_Laba_Rugi'            => $Total_Pencapaian_Laba_Rugi,
                            'Total_Pencapaian_BOPO'            => $Total_Pencapaian_BOPO,
                            'Prognosa_sd_Desember_Pendapatan'            => $Prognosa_sd_Desember_Pendapatan,
                            'Prognosa_sd_Desember_Biaya'            => $Prognosa_sd_Desember_Biaya,
                            'Prognosa_sd_Desember_Laba_Rugi'            => $Prognosa_sd_Desember_Laba_Rugi,
                            'user'                   => $this->session->userdata("user_login")['username']

                        );

                        $this->db->query("DELETE FROM Div_Layanan.rekap_analisa_kc_non_cro_cit WHERE Nama_Kanca = '" . $Nama_Kanca . "'");
                        // lastq();
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('Rekanalisakcnoncrocit');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('Rekanalisakcnoncrocit');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }

//Tabel Rekap Analisa KC Total ------------------------------------------------------------------------------------------------------------
        }else if ($layanan == 'rekap_analisa_kc_total'){
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $Laba_Rugi = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $Status_Pencapaian_VS_RKA_Pendapatan = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $Status_Pencapaian_VS_RKA_Biaya = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $Status_Pencapaian_VS_RKA_Laba_Rugi = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $Nama_Kanca = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $Nama_Pembina = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $RKA_Pendapatan = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $RKA_Biaya = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $RKA_Laba_Rugi = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $Pencapaian_VS_RKA_Pendapatan = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $Pencapaian_VS_RKA_Biaya = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                        $Pencapaian_VS_RKA_Laba_Rugi = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                        $Total_Pencapaian_Pendapatan = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                        $Total_Pencapaian_Biaya = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                        $Total_Pencapaian_Laba_Rugi = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                        $Total_Pencapaian_BOPO = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
                        $Prognosa_sd_Desember_Pendapatan = $worksheet->getCellByColumnAndRow(16, $row)->getValue();
                        $Prognosa_sd_Desember_Biaya = $worksheet->getCellByColumnAndRow(17, $row)->getValue();
                        $Prognosa_sd_Desember_Laba_Rugi = $worksheet->getCellByColumnAndRow(18, $row)->getValue();
                                                
                        $temp_data[] = array(
                            'Laba_Rugi'                     => $Laba_Rugi,
                            'Status_Pencapaian_VS_RKA_Pendapatan'                => $Status_Pencapaian_VS_RKA_Pendapatan,
                            'Status_Pencapaian_VS_RKA_Biaya'          => $Status_Pencapaian_VS_RKA_Biaya,
                            'Status_Pencapaian_VS_RKA_Laba_Rugi'              => $Status_Pencapaian_VS_RKA_Laba_Rugi,
                            'Nama_Kanca'            => $Nama_Kanca,
                            'Nama_Pembina'           => $Nama_Pembina,
                            'RKA_Pendapatan'            => $RKA_Pendapatan,
                            'RKA_Biaya'            => $RKA_Biaya,
                            'RKA_Laba_Rugi'            => $RKA_Laba_Rugi,
                            'Pencapaian_VS_RKA_Pendapatan'            => $Pencapaian_VS_RKA_Pendapatan,
                            'Pencapaian_VS_RKA_Biaya'            => $Pencapaian_VS_RKA_Biaya,
                            'Pencapaian_VS_RKA_Laba_Rugi'            => $Pencapaian_VS_RKA_Laba_Rugi,
                            'Total_Pencapaian_Pendapatan'            => $Total_Pencapaian_Pendapatan,
                            'Total_Pencapaian_Biaya'            => $Total_Pencapaian_Biaya,
                            'Total_Pencapaian_Laba_Rugi'            => $Total_Pencapaian_Laba_Rugi,
                            'Total_Pencapaian_BOPO'            => $Total_Pencapaian_BOPO,
                            'Prognosa_sd_Desember_Pendapatan'            => $Prognosa_sd_Desember_Pendapatan,
                            'Prognosa_sd_Desember_Biaya'            => $Prognosa_sd_Desember_Biaya,
                            'Prognosa_sd_Desember_Laba_Rugi'            => $Prognosa_sd_Desember_Laba_Rugi,
                            'user'                   => $this->session->userdata("user_login")['username']

                        );

                        $this->db->query("DELETE FROM Div_Layanan.rekap_analisa_kc_total WHERE Nama_Kanca = '" . $Nama_Kanca . "'");
                        // lastq();
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('Rekapanalisakctotal');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('Rekapanalisakctotal');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }

//Tabel Rekap Analisa problem kc selindo ------------------------------------------------------------------------------------------------------------
        }else if ($layanan == 'rekap_analisa_problem_kc_selindo'){
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $NO = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $KANTOR_CABANG = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $RATAS_ATM = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $AVG_RELIABILITY = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $OFF_OUT_FLM = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $CO_OUT_FLM = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $CODF_OUT_FLM = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $DF_OUT_FLM = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $NT1D_OUT_FLM = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $JUMLAH = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $RPL = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                        $FLM = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                        $RPL_ATM_BLN = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                                                                        
                        $temp_data[] = array(
                            'NO'                     => $NO,
                            'KANTOR_CABANG'                => $KANTOR_CABANG,
                            'RATAS_ATM'          => $RATAS_ATM,
                            'AVG_RELIABILITY'              => $AVG_RELIABILITY,
                            'OFF_OUT_FLM'            => $OFF_OUT_FLM,
                            'CO_OUT_FLM'           => $CO_OUT_FLM,
                            'CODF_OUT_FLM'            => $CODF_OUT_FLM,
                            'DF_OUT_FLM'            => $DF_OUT_FLM,
                            'NT1D_OUT_FLM'            => $NT1D_OUT_FLM,
                            'JUMLAH'            => $JUMLAH,
                            'RPL'            => $RPL,
                            'FLM'            => $FLM,
                            'RPL_ATM_BLN'            => $RPL_ATM_BLN,
                            'user'                   => $this->session->userdata("user_login")['username']

                        );

                        $this->db->query("DELETE FROM Div_Layanan.rekap_analisa_problem_kc_selindo WHERE KANTOR_CABANG = '" . $KANTOR_CABANG . "'");
                        // lastq();
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('Rekanalisaproblemkcselindo');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('Rekanalisaproblemkcselindo');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }

//Tabel Rekap FLM bg selindo ------------------------------------------------------------------------------------------------------------
        }else if ($layanan == 'rekap_flm_bg_selindo'){
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $No = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $KANTOR_LAYANAN = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $Januari = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $Februari = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $Maret = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $April = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $Mei = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $Juni = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $Juli = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $Agustus = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $September = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                        $Oktober = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                        $November = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                        $Desember = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                        $Average_ALL = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                                                                                                
                        $temp_data[] = array(
                            'No'                     => $No,
                            'KANTOR_LAYANAN'         => $KANTOR_LAYANAN,
                            'Januari'                => $Januari,
                            'Februari'               => $Februari,
                            'Maret'                  => $Maret,
                            'April'                  => $April,
                            'Mei'                    => $Mei,
                            'Juni'                   => $Juni,
                            'Juli'                   => $Juli,
                            'Agustus'                => $Agustus,
                            'September'              => $September,
                            'Oktober'                => $Oktober,
                            'November'               => $November,
                            'Desember'               => $Desember,
                            'Average_ALL'            => $Average_ALL,
                            'user'                   => $this->session->userdata("user_login")['username']

                        );

                        $this->db->query("DELETE FROM Div_Layanan.rekap_flm_bg_selindo WHERE KANTOR_LAYANAN = '" . $KANTOR_LAYANAN . "'");
                        // lastq();
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('Rekflmbgselindo');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('Rekflmbgselindo');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }

//Tabel Rekap Kinerja KC CIT ------------------------------------------------------------------------------------------------------------
        }else if ($layanan == 'rekap_kinerja_kc_cit'){
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $Laba_Rugi = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $Status_Pencapaian_VS_RKA_Pendapatan = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $Status_Pencapaian_VS_RKA_Biaya = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $Status_Pencapaian_VS_RKA_Laba_Rugi = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $Nama_Kanca = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $Nama_Pembina = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $Jumlah_CIT = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $RKA_Pendapatan = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $RKA_Biaya = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $RKA_LabaRugi = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $Pencapaian_VS_RKA_Pendapatan = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                        $Pencapaian_VS_RKA_Biaya = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                        $Pencapaian_VS_RKA_LabaRugi = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                        $Laba_Rugi_Per_Bulan_Per_CIT = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                        $Laba_Rugi_Per_Bulan_Kontribusi_Pekerja = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                        $Rasio_SDM = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
                        $Total_Pencapaian_Pendapatan = $worksheet->getCellByColumnAndRow(16, $row)->getValue();
                        $Total_Pencapaian_Biaya = $worksheet->getCellByColumnAndRow(17, $row)->getValue();
                        $Total_Pencapaian_Laba_Rugi = $worksheet->getCellByColumnAndRow(18, $row)->getValue();
                        $Total_Pencapaian_BOPO = $worksheet->getCellByColumnAndRow(19, $row)->getValue();
                        $Prognosa_sd_Desember_Pendapatan = $worksheet->getCellByColumnAndRow(20, $row)->getValue();
                        $Prognosa_sd_Desember_Biaya = $worksheet->getCellByColumnAndRow(21, $row)->getValue();
                        $Prognosa_sd_Desember_Laba_Rugi = $worksheet->getCellByColumnAndRow(22, $row)->getValue();
                                                                                                                        
                        $temp_data[] = array(
                            'Laba_Rugi'                                 => $Laba_Rugi,
                            'Status_Pencapaian_VS_RKA_Pendapatan'       => $Status_Pencapaian_VS_RKA_Pendapatan,
                            'Status_Pencapaian_VS_RKA_Biaya'            => $Status_Pencapaian_VS_RKA_Biaya,
                            'Status_Pencapaian_VS_RKA_Laba_Rugi'        => $Status_Pencapaian_VS_RKA_Laba_Rugi,
                            'Nama_Kanca'                                => $Nama_Kanca,
                            'Nama_Pembina'                              => $Nama_Pembina,
                            'Jumlah_CIT'                                => $Jumlah_CIT,
                            'RKA_Pendapatan'                            => $RKA_Pendapatan,
                            'RKA_Biaya'                                 => $RKA_Biaya,
                            'RKA_LabaRugi'                              => $RKA_LabaRugi,
                            'Pencapaian_VS_RKA_Pendapatan'              => $Pencapaian_VS_RKA_Pendapatan,
                            'Pencapaian_VS_RKA_Biaya'                   => $Pencapaian_VS_RKA_Biaya,
                            'Pencapaian_VS_RKA_LabaRugi'                => $Pencapaian_VS_RKA_LabaRugi,
                            'Laba_Rugi_Per_Bulan_Per_CIT'               => $Laba_Rugi_Per_Bulan_Per_CIT,
                            'Laba_Rugi_Per_Bulan_Kontribusi_Pekerja'    => $Laba_Rugi_Per_Bulan_Kontribusi_Pekerja,
                            'Rasio_SDM'                                 => $Rasio_SDM,
                            'Total_Pencapaian_Pendapatan'               => $Total_Pencapaian_Pendapatan,
                            'Total_Pencapaian_Biaya'                    => $Total_Pencapaian_Biaya,
                            'Total_Pencapaian_Laba_Rugi'                => $Total_Pencapaian_Laba_Rugi,
                            'Total_Pencapaian_BOPO'                     => $Total_Pencapaian_BOPO,
                            'Prognosa_sd_Desember_Pendapatan'           => $Prognosa_sd_Desember_Pendapatan,
                            'Prognosa_sd_Desember_Biaya'                => $Prognosa_sd_Desember_Biaya,
                            'Prognosa_sd_Desember_Laba_Rugi'            => $Prognosa_sd_Desember_Laba_Rugi,
                            'user'                                      => $this->session->userdata("user_login")['username']

                        );

                        $this->db->query("DELETE FROM Div_Layanan.rekap_kinerja_kc_cit WHERE Nama_Kanca = '" . $Nama_Kanca . "'");
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('Rekkinerjakccit');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('Rekkinerjakccit');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }

//Tabel Rekap Kinerja KC CRO ------------------------------------------------------------------------------------------------------------
        }else if ($layanan == 'rekap_kinerja_kc_cro'){
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $Laba_Rugi = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $Status_Pencapaian_VS_RKA_Pendapatan = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $Status_Pencapaian_VS_RKA_Biaya = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $Status_Pencapaian_VS_RKA_Laba_Rugi = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $Nama_Kanca = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $Nama_Pembina = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $Jumlah_ATM = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $RKA_Pendapatan_Invoice = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $RKA_Biaya = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $RKA_Laba_Rugi = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $Pencapaian_VS_RKA_Pendapatan_Invoice = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                        $Pencapaian_VS_RKA_Biaya = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                        $Pencapaian_VS_RKA_LabaRugi = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                        $Laba_Rugi_Per_Bulan_Per_ATM = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                        $Laba_Rugi_Per_Bulan_Kontribusi_Pekerja = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                        $Rasio_SDM = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
                        $Total_Pencapaian_Pendapatan_Invoice = $worksheet->getCellByColumnAndRow(16, $row)->getValue();
                        $Total_Pencapaian_Biaya = $worksheet->getCellByColumnAndRow(17, $row)->getValue();
                        $Total_Pencapaian_Laba_Rugi = $worksheet->getCellByColumnAndRow(18, $row)->getValue();
                        $Total_Pencapaian_BOPO = $worksheet->getCellByColumnAndRow(19, $row)->getValue();
                        $Prognosa_sd_Desember_Pendapatan_Invoice = $worksheet->getCellByColumnAndRow(20, $row)->getValue();
                        $Prognosa_sd_Desember_Biaya = $worksheet->getCellByColumnAndRow(21, $row)->getValue();
                        $Prognosa_sd_Desember_Laba_Rugi = $worksheet->getCellByColumnAndRow(22, $row)->getValue();
                                                                                                                        
                        $temp_data[] = array(
                            'Laba_Rugi'                                 => $Laba_Rugi,
                            'Status_Pencapaian_VS_RKA_Pendapatan'       => $Status_Pencapaian_VS_RKA_Pendapatan,
                            'Status_Pencapaian_VS_RKA_Biaya'            => $Status_Pencapaian_VS_RKA_Biaya,
                            'Status_Pencapaian_VS_RKA_Laba_Rugi'        => $Status_Pencapaian_VS_RKA_Laba_Rugi,
                            'Nama_Kanca'                                => $Nama_Kanca,
                            'Nama_Pembina'                              => $Nama_Pembina,
                            'Jumlah_ATM'                                => $Jumlah_ATM,
                            'RKA_Pendapatan_Invoice'                    => $RKA_Pendapatan_Invoice,
                            'RKA_Biaya'                                 => $RKA_Biaya,
                            'RKA_Laba_Rugi'                             => $RKA_Laba_Rugi,
                            'Pencapaian_VS_RKA_Pendapatan_Invoice'      => $Pencapaian_VS_RKA_Pendapatan_Invoice,
                            'Pencapaian_VS_RKA_Biaya'                   => $Pencapaian_VS_RKA_Biaya,
                            'Pencapaian_VS_RKA_LabaRugi'                => $Pencapaian_VS_RKA_LabaRugi,
                            'Laba_Rugi_Per_Bulan_Per_ATM'               => $Laba_Rugi_Per_Bulan_Per_ATM,
                            'Laba_Rugi_Per_Bulan_Kontribusi_Pekerja'    => $Laba_Rugi_Per_Bulan_Kontribusi_Pekerja,
                            'Rasio_SDM'                                 => $Rasio_SDM,
                            'Total_Pencapaian_Pendapatan_Invoice'       => $Total_Pencapaian_Pendapatan_Invoice,
                            'Total_Pencapaian_Biaya'                    => $Total_Pencapaian_Biaya,
                            'Total_Pencapaian_Laba_Rugi'                => $Total_Pencapaian_Laba_Rugi,
                            'Total_Pencapaian_BOPO'                     => $Total_Pencapaian_BOPO,
                            'Prognosa_sd_Desember_Pendapatan_Invoice'   => $Prognosa_sd_Desember_Pendapatan_Invoice,
                            'Prognosa_sd_Desember_Biaya'                => $Prognosa_sd_Desember_Biaya,
                            'Prognosa_sd_Desember_Laba_Rugi'            => $Prognosa_sd_Desember_Laba_Rugi,
                            'user'                                      => $this->session->userdata("user_login")['username']

                        );

                        $this->db->query("DELETE FROM Div_Layanan.rekap_kinerja_kc_cro WHERE Nama_Kanca = '" . $Nama_Kanca . "'");
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('Rekkinerjakccro');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('Rekkinerjakccro');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }
//Tabel Rekap Persediaan Log KC ------------------------------------------------------------------------------------------------------------
        }else if ($layanan == 'rekap_persedian_log_kc'){
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $No = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $Nama_Barang = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $Spesifikasi_Terperinci = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $Jumlah = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $Satuan = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $Harga_per_pcs = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $Subtotal = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $Keperluan_KC_BG = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $Diterima = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $Bulan = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $Kanca = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                        $Barang = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                                                                                                                                                
                        $temp_data[] = array(
                            'No'                                 => $No,
                            'Nama_Barang'                        => $Nama_Barang,
                            'Spesifikasi_Terperinci'             => $Spesifikasi_Terperinci,
                            'Jumlah'                             => $Jumlah,
                            'Satuan'                             => $Satuan,
                            'Harga_per_pcs'                      => $Harga_per_pcs,
                            'Subtotal'                           => $Subtotal,
                            'Keperluan_KC_BG'                    => $Keperluan_KC_BG,
                            'Diterima'                           => $Diterima,
                            'Bulan'                              => $Bulan,
                            'Kanca'                              => $Kanca,
                            'Barang'                             => $Barang,
                            'user'                               => $this->session->userdata("user_login")['username']

                        );

                        // $this->db->query("DELETE FROM Div_Layanan.rekap_persedian_log_kc WHERE pn = '" . $pn . "'");
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('Rekpersedianlogkc');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('Rekpersedianlogkc');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }
//Tabel Rekap RPL BG Selindo ------------------------------------------------------------------------------------------------------------
        }else if ($layanan == 'rekap_rpl_bg_selindo'){
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $No = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $KANTOR_LAYANAN = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $Januari = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $Februari = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $Maret = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $April = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $Mei = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $Juni = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $Juli = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $Agustus = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $September = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                        $Oktober = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                        $November = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                        $Desember = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                        $Average_ALL = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                                                                                                
                        $temp_data[] = array(
                            'No'                     => $No,
                            'KANTOR_LAYANAN'         => $KANTOR_LAYANAN,
                            'Januari'                => $Januari,
                            'Februari'               => $Februari,
                            'Maret'                  => $Maret,
                            'April'                  => $April,
                            'Mei'                    => $Mei,
                            'Juni'                   => $Juni,
                            'Juli'                   => $Juli,
                            'Agustus'                => $Agustus,
                            'September'              => $September,
                            'Oktober'                => $Oktober,
                            'November'               => $November,
                            'Desember'               => $Desember,
                            'Average_ALL'            => $Average_ALL,
                            'user'                   => $this->session->userdata("user_login")['username']

                        );

                        $this->db->query("DELETE FROM Div_Layanan.rekap_rpl_bg_selindo WHERE KANTOR_LAYANAN = '" . $KANTOR_LAYANAN . "'");
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('Rekrplbgselindo');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('Rekrplbgselindo');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }

//Tabel Rekon ATM Bank BJB ------------------------------------------------------------------------------------------------------------
        }else if ($layanan == 'rekon_atm_bank_bjb'){
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $No = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $BJB = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $TOTAL_PENGISIAN = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $PENGOSONGAN = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $BG = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $TOTAL_PENGISIAN1 = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $SELISIH = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        // $TANGGAL_1 = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $TANGGAL_1_row = $worksheet->getCellByColumnAndRow(7, $row);
                        $TANGGAL_1 = $TANGGAL_1_row->getValue();
                        if(PHPExcel_Shared_Date::isDateTime($TANGGAL_1_row)) {
                             $TANGGAL_1 = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($TANGGAL_1)); 
                        }
                        // $TANGGAL_2 = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $TANGGAL_2_row = $worksheet->getCellByColumnAndRow(8, $row);
                        $TANGGAL_2 = $TANGGAL_2_row->getValue();
                        if(PHPExcel_Shared_Date::isDateTime($TANGGAL_2_row)) {
                             $TANGGAL_2 = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($TANGGAL_2)); 
                        }
                        // $TANGGAL_3 = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $TANGGAL_3_row = $worksheet->getCellByColumnAndRow(9, $row);
                        $TANGGAL_3 = $TANGGAL_3_row->getValue();
                        if(PHPExcel_Shared_Date::isDateTime($TANGGAL_3_row)) {
                             $TANGGAL_3 = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($TANGGAL_3)); 
                        }
                        
                                                                                                
                        $temp_data[] = array(
                            'No'                     => $No,
                            'BJB'                    => $BJB,
                            'TOTAL_PENGISIAN'        => $TOTAL_PENGISIAN,
                            'PENGOSONGAN'            => $PENGOSONGAN,
                            'BG'                     => $BG,
                            'TOTAL_PENGISIAN1'       => $TOTAL_PENGISIAN1,
                            'SELISIH'                => $SELISIH,
                            'TANGGAL_1'              => $TANGGAL_1,
                            'TANGGAL_2'              => $TANGGAL_2,
                            'TANGGAL_3'              => $TANGGAL_3,
                            'user'                   => $this->session->userdata("user_login")['username']

                        );

                        $this->db->query("DELETE FROM Div_Layanan.rekon_atm_bank_bjb WHERE BJB = '" . $BJB . "'");
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('Rekatmbankbjb');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('Rekatmbankbjb');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }

//Tabel Rekon FLM Bank BJB ------------------------------------------------------------------------------------------------------------
        }else if ($layanan == 'rekon_flm_bank_bjb'){
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $NO = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $VERSI_MONITORING = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $ID_ATM = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $NAMA_ATM = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $PROBLEM = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        // $TANGGAL = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $TANGGAL_row = $worksheet->getCellByColumnAndRow(5, $row);
                        $TANGGAL = $TANGGAL_row->getValue();
                        if(PHPExcel_Shared_Date::isDateTime($TANGGAL_row)) {
                             $TANGGAL = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($TANGGAL)); 
                        }
                        $WAKTU_REQUEST = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $NO_TIKET = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $VERSI_BG = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $ID_ATM1 = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $NAMA_ATM1 = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                        $PROBLEM1 = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                        // $TANGGAL1 = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                        $TANGGAL1_row = $worksheet->getCellByColumnAndRow(12, $row);
                        $TANGGAL1 = $TANGGAL1_row->getValue();
                        if(PHPExcel_Shared_Date::isDateTime($TANGGAL1_row)) {
                             $TANGGAL1 = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($TANGGAL1)); 
                        }
                        $WAKTU_REQUEST1 = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                        $NO_TIKET_CATATAN_BG = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                       
                        
                                                                                                
                        $temp_data[] = array(
                            'NO'                     => $NO,
                            'VERSI_MONITORING'       => $VERSI_MONITORING,
                            'ID_ATM'                 => $ID_ATM,
                            'NAMA_ATM'               => $NAMA_ATM,
                            'PROBLEM'                => $PROBLEM,
                            'TANGGAL'                => $TANGGAL,
                            'WAKTU_REQUEST'          => $WAKTU_REQUEST,
                            'NO_TIKET'               => $NO_TIKET,
                            'VERSI_BG'               => $VERSI_BG,
                            'ID_ATM1'                => $ID_ATM1,
                            'NAMA_ATM1'              => $NAMA_ATM1,
                            'PROBLEM1'                => $PROBLEM1,
                            'TANGGAL1'                => $TANGGAL1,
                            'WAKTU_REQUEST1'         => $WAKTU_REQUEST1,
                            'NO_TIKET_CATATAN_BG'    => $NO_TIKET_CATATAN_BG,
                            'user'                   => $this->session->userdata("user_login")['username']

                        );

                        $this->db->query("DELETE FROM Div_Layanan.rekon_flm_bank_bjb WHERE ID_ATM = '" . $ID_ATM . "'");
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('Rekflmbankbjb');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('Rekflmbankbjb');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }

//Tabel Data SM ---------------------------------------------------------------------------------------------------------------
        } else if ($layanan == 'data_sm'){
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $NO = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $KANTOR_LAYANAN = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $TID = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $SN = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $LOKASI = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $KANWIL = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $GARANSI = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $DONE_SM = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $BELUM_SM = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        // $TANGGAL_SM = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $TANGGAL_SM_row = $worksheet->getCellByColumnAndRow(9, $row);
                        $TANGGAL_SM = $TANGGAL_SM_row->getValue();
                        if(PHPExcel_Shared_Date::isDateTime($TANGGAL_SM_row)) {
                             $TANGGAL_SM = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($TANGGAL_SM)); 
                        }
                        $KETERANGAN = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                                                                                                                        
                        $temp_data[] = array(
                            'NO'                     => $NO,
                            'KANTOR_LAYANAN'         => $KANTOR_LAYANAN,
                            'TID'                    => $TID,
                            'SN'                     => $SN,
                            'LOKASI'                 => $LOKASI,
                            'KANWIL'                 => $KANWIL,
                            'GARANSI'                => $GARANSI,
                            'DONE_SM'                => $DONE_SM,
                            'BELUM_SM'               => $BELUM_SM,
                            'TANGGAL_SM'             => $TANGGAL_SM,
                            'KETERANGAN'              => $KETERANGAN,
                            'user'                   => $this->session->userdata("user_login")['username']

                        );

                        $this->db->query("DELETE FROM Div_Layanan.data_sm WHERE TID = '" . $TID . "'");

                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('Datasm');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('Datasm');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }

//Tabel Reliability Harian BG ---------------------------------------------------------------------------------------------------------------

        } else if ($layanan == 'reliability_harian_bg'){
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $Kantor_Layanan = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $Jam_Capture_0 = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $Jam_Capture_3 = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $Jam_Capture_6 = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $Jam_Capture_9 = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $Jam_Capture_12 = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $Jam_Capture_15 = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $Jam_Capture_18 = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $Jam_Capture_21 = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $Average = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                                                                                                                        
                        $temp_data[] = array(
                            'no'                     => $no,
                            'Kantor_Layanan'         => $Kantor_Layanan,
                            'Jam_Capture_0'          => $Jam_Capture_0,
                            'Jam_Capture_3'          => $Jam_Capture_3,
                            'Jam_Capture_6'          => $Jam_Capture_6,
                            'Jam_Capture_9'          => $Jam_Capture_9,
                            'Jam_Capture_12'         => $Jam_Capture_12,
                            'Jam_Capture_15'         => $Jam_Capture_15,
                            'Jam_Capture_18'         => $Jam_Capture_18,
                            'Jam_Capture_21'         => $Jam_Capture_21,
                            'Average'                => $Average,
                            'user'                   => $this->session->userdata("user_login")['username']

                        );

                        $this->db->query("DELETE FROM Div_Layanan.reliability_harian_bg WHERE Kantor_Layanan = '" . $Kantor_Layanan . "'");
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('ReliabilityHarianBG');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('ReliabilityHarianBG');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }


//Tabel Rekap Presentase Return RPL KL Selindo ---------------------------------------------------------------------------------------------------------------

        } else if ($layanan == 'rekap_presentase_return_rpl_kl_selindo') {
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $Kantor_Layanan = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $Tgl_1 = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $Tgl_2 = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $Tgl_3 = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $Tgl_4 = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $Tgl_5 = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $Tgl_6 = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $Tgl_7 = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $Tgl_8 = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $Tgl_9 = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                        $Tgl_10 = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                        $Tgl_11 = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                        $Tgl_12 = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                        $Tgl_13 = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                        $Tgl_14 = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
                        $Tgl_15 = $worksheet->getCellByColumnAndRow(16, $row)->getValue();
                        $Tgl_16 = $worksheet->getCellByColumnAndRow(17, $row)->getValue();
                        $Tgl_17 = $worksheet->getCellByColumnAndRow(18, $row)->getValue();
                        $Tgl_18 = $worksheet->getCellByColumnAndRow(19, $row)->getValue();
                        $Tgl_19 = $worksheet->getCellByColumnAndRow(20, $row)->getValue();
                        $Tgl_20 = $worksheet->getCellByColumnAndRow(21, $row)->getValue();
                        $Tgl_21 = $worksheet->getCellByColumnAndRow(22, $row)->getValue();
                        $Tgl_22 = $worksheet->getCellByColumnAndRow(23, $row)->getValue();
                        $Tgl_23 = $worksheet->getCellByColumnAndRow(24, $row)->getValue();
                        $Tgl_24 = $worksheet->getCellByColumnAndRow(25, $row)->getValue();
                        $Tgl_25 = $worksheet->getCellByColumnAndRow(26, $row)->getValue();
                        $Tgl_26 = $worksheet->getCellByColumnAndRow(27, $row)->getValue();
                        $Tgl_27 = $worksheet->getCellByColumnAndRow(28, $row)->getValue();
                        $Tgl_28 = $worksheet->getCellByColumnAndRow(29, $row)->getValue();
                        $Tgl_29 = $worksheet->getCellByColumnAndRow(30, $row)->getValue();
                        $Tgl_30 = $worksheet->getCellByColumnAndRow(31, $row)->getValue();
                        $Tgl_31 = $worksheet->getCellByColumnAndRow(32, $row)->getValue();
                        $Average = $worksheet->getCellByColumnAndRow(33, $row)->getValue();
                                                                                                                        
                        $temp_data[] = array(
                            'no'             => $no,
                            'Kantor_Layanan' => $Kantor_Layanan,
                            'Tgl_1'          => $Tgl_1,
                            'Tgl_2'          => $Tgl_2,
                            'Tgl_3'          => $Tgl_3,
                            'Tgl_4'          => $Tgl_4,
                            'Tgl_5'          => $Tgl_5,
                            'Tgl_6'          => $Tgl_6,
                            'Tgl_7'          => $Tgl_7,
                            'Tgl_8'          => $Tgl_8,
                            'Tgl_9'          => $Tgl_9,
                            'Tgl_10'          => $Tgl_10,
                            'Tgl_11'          => $Tgl_11,
                            'Tgl_12'          => $Tgl_12,
                            'Tgl_13'          => $Tgl_13,
                            'Tgl_14'          => $Tgl_14,
                            'Tgl_15'          => $Tgl_15,
                            'Tgl_16'          => $Tgl_16,
                            'Tgl_17'          => $Tgl_17,
                            'Tgl_18'          => $Tgl_18,
                            'Tgl_19'          => $Tgl_19,
                            'Tgl_20'          => $Tgl_20,
                            'Tgl_21'          => $Tgl_21,
                            'Tgl_22'          => $Tgl_22,
                            'Tgl_23'          => $Tgl_23,
                            'Tgl_24'          => $Tgl_24,
                            'Tgl_25'          => $Tgl_25,
                            'Tgl_26'          => $Tgl_26,
                            'Tgl_27'          => $Tgl_27,
                            'Tgl_28'          => $Tgl_28,
                            'Tgl_29'          => $Tgl_29,
                            'Tgl_30'          => $Tgl_30,
                            'Tgl_31'          => $Tgl_31,
                            'Average'         => $Average,
                            'user'            => $this->session->userdata("user_login")['username']

                        );

                        $this->db->query("DELETE FROM Div_Layanan.rekap_presentase_return_rpl_kl_selindo WHERE Kantor_Layanan = '" . $Kantor_Layanan . "'");
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('RekapPresentaseReturnRPL');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('RekapPresentaseReturnRPL');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }


//Tabel Data Laporan vaksin ---------------------------------------------------------------------------------------------------------------

        } else if ($layanan == 'tb_vaksin') {
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $pn = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $nama = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $jabatan = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $divisi = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $bagian = $worksheet->getCellByColumnAndRow(5, $row)->getValue();

                        // $Tanggal_Vaksin_Vaksin_I = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $vaksin_1 = $worksheet->getCellByColumnAndRow(6, $row);
                        $tgl_vaksin_1 = $vaksin_1->getValue();
                        if(PHPExcel_Shared_Date::isDateTime($vaksin_1)) {
                             $tgl_vaksin_1 = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($tgl_vaksin_1)); 
                        }

                        // $Tanggal_Vaksin_Vaksin_II = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $vaksin_2 = $worksheet->getCellByColumnAndRow(7, $row);
                        $tgl_vaksin_2 = $vaksin_2->getValue();
                        if(PHPExcel_Shared_Date::isDateTime($vaksin_2)) {
                             $tgl_vaksin_2 = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($tgl_vaksin_2)); 
                        }

                        $lokasi = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $keterangan = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $status = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                        $cek_vaksin_1 = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                        $cek_vaksin_2 = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                        $cek_tidak_layak = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                        $cek_terjadwal = $worksheet->getCellByColumnAndRow(14, $row)->getValue();

                                                                                                                        
                        $temp_data[] = array(
                            'no'                         => $no,
                            'pn'                     => $pn,
                            'nama'                => $nama,
                            'jabatan'                       => $jabatan,
                            'divisi'                    => $divisi,
                            'bagian'          => $bagian,
                            'vaksin_1'      => $tgl_vaksin_1,
                            'vaksin_2'      => $tgl_vaksin_2,
                            'lokasi'        => $lokasi,
                            'keterangan'              => $keterangan,
                            'status'                 => $status,
                            'cek_vaksin_1'                 => $cek_vaksin_1,
                            'cek_vaksin_2'                 => $cek_vaksin_2,
                            'cek_tidak_layak'                 => $cek_tidak_layak,
                            'cek_terjadwal'                 => $cek_terjadwal,
                            'user'                       => $this->session->userdata("user_login")['username']

                        );
                        $this->db->query("DELETE FROM Div_Layanan.tb_vaksin WHERE pn = '".$pn."'");                    }
                    // lastq();
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('DataVaksin');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('DataVaksin');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }


//Tabel Data Vaksin Sudah vaksin ---------------------------------------------------------------------------------------------------------------

        } else if ($layanan == 'data_vaksin_div_layanan_sudah_vaksin') {
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $ID_Personal = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $Nama = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $Jabatan = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $Unit_Kerja = $worksheet->getCellByColumnAndRow(4, $row)->getValue();

                        // $Tanggal_Vaksin_Vaksin_I = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $Tanggal_Vaksin_Vaksin_I = $worksheet->getCellByColumnAndRow(5, $row);
                        $tgl_Vaksin_1 = $Tanggal_Vaksin_Vaksin_I->getValue();
                        if(PHPExcel_Shared_Date::isDateTime($Tanggal_Vaksin_Vaksin_I)) {
                             $tgl_Vaksin_1 = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($tgl_Vaksin_1)); 
                        }

                        // $Tanggal_Vaksin_Vaksin_II = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $Tanggal_Vaksin_Vaksin_II = $worksheet->getCellByColumnAndRow(6, $row);
                        $tgl_Vaksin_2 = $Tanggal_Vaksin_Vaksin_II->getValue();
                        if(PHPExcel_Shared_Date::isDateTime($Tanggal_Vaksin_Vaksin_II)) {
                             $tgl_Vaksin_2 = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($tgl_Vaksin_2)); 
                        }
                                                                                                                        
                        $temp_data[] = array(
                            'no'                         => $no,
                            'ID_Personal'                => $ID_Personal,
                            'Nama'                       => $Nama,
                            'Jabatan'                    => $Jabatan,
                            'Unit_Kerja'                 => $Unit_Kerja,
                            'Tanggal_Vaksin_Vaksin_I'    => $tgl_Vaksin_1,
                            'Tanggal_Vaksin_Vaksin_II'   => $tgl_Vaksin_2,
                            'user'                       => $this->session->userdata("user_login")['username']

                        );
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('DataVaksinSudahVaksin');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('DataVaksinSudahVaksin');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }


//Tabel Closed Case Shortage Januari-Oktober ---------------------------------------------------------------------------------------------------------------

        } else if ($layanan == 'Closed_Case_shortage_Januari_Oktober_berdasarkan_kategori_kasus') {
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $Kategori_Kasus = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $Frekuensi = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $Nominal = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $Freq = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $Nom = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                                                                                                                        
                        $temp_data[] = array(
                            'no'                => $no,
                            'Kategori_Kasus'    => $Kategori_Kasus,
                            'Frekuensi'         => $Frekuensi,
                            'Nominal'           => $Nominal,
                            'Freq'              => $Freq,
                            'Nom'               => $Nom,
                            'user'              => $this->session->userdata("user_login")['username']

                        );

                        $this->db->query("DELETE FROM Div_Layanan.Closed_Case_shortage_Januari_Oktober_berdasarkan_kategori_kasus WHERE Kategori_Kasus = '" . $Kategori_Kasus . "'");
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('ClosedCaseShortageJanuariOktober');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('ClosedCaseShortageJanuariOktober');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }


//Tabel Closed Case Shortage September ---------------------------------------------------------------------------------------------------------------

        } else if ($layanan == 'Closed_Case_shortage_September_berdasarkan_kategori_kasus') {
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $Kategori_Kasus = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $Frekuensi = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $Nominal = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $Freq = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $Nom = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                                                                                                                        
                        $temp_data[] = array(
                            'no'                => $no,
                            'Kategori_Kasus'    => $Kategori_Kasus,
                            'Frekuensi'         => $Frekuensi,
                            'Nominal'           => $Nominal,
                            'Freq'              => $Freq,
                            'Nom'               => $Nom,
                            'user'              => $this->session->userdata("user_login")['username']

                        );

                        $this->db->query("DELETE FROM Div_Layanan.Closed_Case_shortage_September_berdasarkan_kategori_kasus WHERE Kategori_Kasus = '" . $Kategori_Kasus . "'");
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('ClosedCaseShortageSeptember');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('ClosedCaseShortageSeptember');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }


//Tabel Update Kategori Kasus Closed Case Frekuensi ---------------------------------------------------------------------------------------------------------------

        } else if ($layanan == 'Update_Kategori_kasus_Closed_Case_Frekuensi') {
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $Frekuensi_Periode = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $Kategori_Anomali_Cardless = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $Balancing_Tidak_Tertib_RPL = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $Cocok_Surplus_berdasarkan_Rekon_EJ_Trx = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $CPC_Tidak_Tertib = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $Indikasi_Fraud = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $Kesalahan_Rekon_Membaca_Billcounter = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $Vandalisme = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $Open = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $Grand_Total = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                                                                                                                        
                        $temp_data[] = array(
                            'no'                                        => $no,
                            'Frekuensi_Periode'                         => $Frekuensi_Periode,
                            'Kategori_Anomali_Cardless'                 => $Kategori_Anomali_Cardless,
                            'Balancing_Tidak_Tertib_RPL'                => $Balancing_Tidak_Tertib_RPL,
                            'Cocok_Surplus_berdasarkan_Rekon_EJ_Trx'    => $Cocok_Surplus_berdasarkan_Rekon_EJ_Trx,
                            'CPC_Tidak_Tertib'                          => $CPC_Tidak_Tertib,
                            'Indikasi_Fraud'                            => $Indikasi_Fraud,
                            'Kesalahan_Rekon_Membaca_Billcounter'       => $Kesalahan_Rekon_Membaca_Billcounter,
                            'Vandalisme'                                => $Vandalisme,
                            'Open'                                      => $Open,
                            'Grand_Total'                               => $Grand_Total,
                            'user'                              => $this->session->userdata("user_login")['username']

                        );

                        $this->db->query("DELETE FROM Div_Layanan.Update_Kategori_kasus_Closed_Case_Frekuensi WHERE Frekuensi_Periode = '" . $Frekuensi_Periode . "'");
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('UpdateKategoriKasusClosedCaseFrekuensi');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('UpdateKategoriKasusClosedCaseFrekuensi');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }


//Tabel Update Kategori Kasus Closed Case Nominal ---------------------------------------------------------------------------------------------------------------

        } else if ($layanan == 'Update_Kategori_kasus_Closed_Case_Nominal') {
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $Nominal_Periode = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $Kategori_Anomali_Cardless = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $Balancing_Tidak_Tertib_RPL = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $Cocok_Surplus_berdasarkan_Rekon_EJ_Trx = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $CPC_Tidak_Tertib = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $Indikasi_Fraud = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $Kesalahan_Rekon_Membaca_Billcounter = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $Vandalisme = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $Open = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $Grand_Total = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                                                                                                                        
                        $temp_data[] = array(
                            'no'                                        => $no,
                            'Nominal_Periode'                           => $Nominal_Periode,
                            'Kategori_Anomali_Cardless'                 => $Kategori_Anomali_Cardless,
                            'Balancing_Tidak_Tertib_RPL'                => $Balancing_Tidak_Tertib_RPL,
                            'Cocok_Surplus_berdasarkan_Rekon_EJ_Trx'    => $Cocok_Surplus_berdasarkan_Rekon_EJ_Trx,
                            'CPC_Tidak_Tertib'                          => $CPC_Tidak_Tertib,
                            'Indikasi_Fraud'                            => $Indikasi_Fraud,
                            'Kesalahan_Rekon_Membaca_Billcounter'       => $Kesalahan_Rekon_Membaca_Billcounter,
                            'Vandalisme'                                => $Vandalisme,
                            'Open'                                      => $Open,
                            'Grand_Total'                               => $Grand_Total,
                            'user'                              => $this->session->userdata("user_login")['username']

                        );

                        $this->db->query("DELETE FROM Div_Layanan.Update_Kategori_kasus_Closed_Case_Nominal WHERE Nominal_Periode = '" . $Nominal_Periode . "'");
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('UpdateKategoriKasusClosedCaseNominal');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('UpdateKategoriKasusClosedCaseNominal');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }


//Tabel Monitoring Instruksi Investigasi Shortage BG Selindo ---------------------------------------------------------------------------------------------------------------

        } else if ($layanan == 'Monitoring_Instruksi_Investigasi_Shortage_BG_Selindo') {
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $No = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $Kantor_Cabang = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $Frekuensi = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $Nominal = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $Frekuensi_Kasus_New = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $Frekuensi_Kasus_Open = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $Frekuensi_Kasus_Close = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $Frekuensi_Kasus = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $Closed_Case_Done = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $Closed_Case_Progress = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $Pending = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                        $Periode = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                                                                                                                        
                        $temp_data[] = array(
                            'No'                      => $No,
                            'Kantor_Cabang'           => $Kantor_Cabang,
                            'Frekuensi'               => $Frekuensi,
                            'Nominal'                 => $Nominal,
                            'Frekuensi_Kasus_New'     => $Frekuensi_Kasus_New,
                            'Frekuensi_Kasus_Open'    => $Frekuensi_Kasus_Open,
                            'Frekuensi_Kasus_Close'   => $Frekuensi_Kasus_Close,
                            'Frekuensi_Kasus'       => $Frekuensi_Kasus,
                            'Closed_Case_Done'        => $Closed_Case_Done,
                            'Closed_Case_Progress'    => $Closed_Case_Progress,
                            'Pending'                 => $Pending,
                            'Periode'                 => $Periode,
                            'user'                    => $this->session->userdata("user_login")['username']

                        );

                        $this->db->query("DELETE FROM Div_Layanan.Monitoring_Instruksi_Investigasi_Shortage_BG_Selindo WHERE Kantor_Cabang = '" . $Kantor_Cabang . "'");
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('MonitoringInstruksiInvestigasiShortageBGSelindo');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('MonitoringInstruksiInvestigasiShortageBGSelindo');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }


//Tabel Monitoring Outstanding Shortage BG Selindo ---------------------------------------------------------------------------------------------------------------

        } else if ($layanan == 'Monitoring_Outstanding_Shortage_BG_Selindo') {
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $Kantor_Cabang = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $Frekuensi = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $Nominal = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $Frekuensi_Kasus_New = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $Frekuensi_Kasus_Open = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $Frekuensi_Kasus_Close = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $Frekuensi_Kasus = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $Progress_Mingguan = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $Closed_Case_Done = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $Closed_Case_Progress = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                        $Pending_Jan_Sept = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                        $Pending_Oktober = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                        $All_Pending = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                                                                                                                        
                        $temp_data[] = array(
                            'no'                      => $no,
                            'Kantor_Cabang'           => $Kantor_Cabang,
                            'Frekuensi'               => $Frekuensi,
                            'Nominal'                 => $Nominal,
                            'Frekuensi_Kasus_New'     => $Frekuensi_Kasus_New,
                            'Frekuensi_Kasus_Open'    => $Frekuensi_Kasus_Open,
                            'Frekuensi_Kasus_Close'   => $Frekuensi_Kasus_Close,
                            'Frekuensi_Kasus'         => $Frekuensi_Kasus,
                            'Progress_Mingguan'       => $Progress_Mingguan,
                            'Closed_Case_Done'        => $Closed_Case_Done,
                            'Closed_Case_Progress'    => $Closed_Case_Progress,
                            'Pending_Jan_Sept'        => $Pending_Jan_Sept,
                            'Pending_Oktober'         => $Pending_Oktober,
                            'All_Pending'             => $All_Pending,
                            'user'                    => $this->session->userdata("user_login")['username']

                        );

                        $this->db->query("DELETE FROM Div_Layanan.Monitoring_Outstanding_Shortage_BG_Selindo WHERE Kantor_Cabang = '" . $Kantor_Cabang . "'");
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('MonitoringOutstandingShortageBGSelindo');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('MonitoringOutstandingShortageBGSelindo');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }


//Tabel Grafik Progress & Pending Case Cabang ---------------------------------------------------------------------------------------------------------------

        } else if ($layanan == 'Grafik_Progress_dan_Pending_CaseCabang') {
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $Kantor_Cabang = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $Progress_Minggu_3 = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $Pending = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                                                                                                                        
                        $temp_data[] = array(
                            'no'                      => $no,
                            'Kantor_Cabang'           => $Kantor_Cabang,
                            'Progress_Minggu_3'       => $Progress_Minggu_3,
                            'Pending'                 => $Pending,
                            'user'                    => $this->session->userdata("user_login")['username']

                        );

                        $this->db->query("DELETE FROM Div_Layanan.Grafik_Progress_dan_Pending_CaseCabang WHERE Kantor_Cabang = '" . $Kantor_Cabang . "'");
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('GrafikProgressdanPendingCaseCabang');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('GrafikProgressdanPendingCaseCabang');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }



    //Tabel Data Vaksin ---------------------------------------------------------------------------------------------------------------

        } else if ($layanan == 'tb_vaksin') {
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $pn = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $nama = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $jabatan = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $divisi = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $bagian = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $vaksin_1 = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $vaksin_2 = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $lokasi = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $keterangan = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $status = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                        $cek_vaksin_1 = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                        $cek_vaksin_2 = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                        $cek_tidak_layak = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                        $cek_terjadwal = $worksheet->getCellByColumnAndRow(14, $row)->getValue();

                                                                                                                        
                        $temp_data[] = array(
                            'no'                      => $no,
                            'pn'           => $pn,
                            'nama'       => $nama,
                            'jabatan'                 => $jabatan,
                            'divisi'           => $divisi,
                            'bagian'           => $bagian,
                            'vaksin_1'           => $vaksin_1,
                            'vaksin_2'           => $vaksin_2,
                            'lokasi'           => $lokasi,
                            'keterangan'           => $keterangan,
                            'status'           => $status,
                            'cek_vaksin_1'           => $cek_vaksin_1,
                            'cek_vaksin_2'           => $cek_vaksin_2,
                            'cek_tidak_layak'           => $cek_tidak_layak,
                            'cek_terjadwal'           => $cek_terjadwal,
                            'user'                    => $this->session->userdata("user_login")['username']

                        );


                        $this->db->query("DELETE FROM Div_Layanan.tb_vaksin WHERE pn = '" . $pn . "'");
                        // lastq();

                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('DataVaksin');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('DataVaksin');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }


        //Tabel Proyeksi Nilai Sanggahan ---------------------------------------------------------------------------------------------------------------

        } else if ($layanan == 'proyeksi_nilai_sanggahan') {
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $cpc = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $reability_avg = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $Tier_Invoice_before = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $Total_Qty_ATM = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $Proyeksi_Pendapatan_Sebelum_Sanggahan = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $Reliability = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $delta = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $Tier_Invoice_after = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $V3_G = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $V3_NG = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                        $V4_G = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                        $V4_NG = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                        $Total_ATM = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                        $Proyeksi_Pendapatan = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                        $Selisih_Pendapatan_Dgn_Sebelum_Sanggahan = $worksheet->getCellByColumnAndRow(15, $row)->getValue();

                                                                                                                        
                        $temp_data[] = array(
                            'no'                                        => $no,
                            'cpc'                                       => $cpc,
                            'reability_avg'                             => $reability_avg,
                            'Tier_Invoice_before'                       => $Tier_Invoice_before,
                            'Total_Qty_ATM'                             => $Total_Qty_ATM,
                            'Proyeksi_Pendapatan_Sebelum_Sanggahan'     => $Proyeksi_Pendapatan_Sebelum_Sanggahan,
                            'Reliability'                               => $Reliability,
                            'delta'                                     => $delta,
                            'Tier_Invoice_after'                        => $Tier_Invoice_after,
                            'V3_G'                                      => $V3_G,
                            'V3_NG'                                     => $V3_NG,
                            'V4_G'                                      => $V4_G,
                            'V4_NG'                                     => $V4_NG,
                            'Total_ATM'                                 => $Total_ATM,
                            'Proyeksi_Pendapatan'                       => $Proyeksi_Pendapatan,
                            'Selisih_Pendapatan_Dgn_Sebelum_Sanggahan'  => $Selisih_Pendapatan_Dgn_Sebelum_Sanggahan,
                            'user'                                      => $this->session->userdata("user_login")['username']

                        );


                        $this->db->query("DELETE FROM Div_Layanan.proyeksi_nilai_sanggahan WHERE cpc = '" . $cpc . "'");
                        // lastq();

                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('ProyeksiNilaiSanggahan');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('ProyeksiNilaiSanggahan');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }



        //Tabel Update CRO CRM ---------------------------------------------------------------------------------------------------------------

        } else if ($layanan == 'update_cro_crm') {
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $kantor_cabang = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $total_crm = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $capt_00 = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $capt_03 = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $capt_06 = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $capt_09 = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $capt_12 = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $capt_15 = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $capt_18 = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $capt_21 = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                        $avg = $worksheet->getCellByColumnAndRow(11, $row)->getValue();

                                                                                                                        
                        $temp_data[] = array(
                            'no'               => $no,
                            'kantor_cabang'    => $kantor_cabang,
                            'total_crm'        => $total_crm,
                            'capt_00'          => $capt_00,
                            'capt_03'          => $capt_03,
                            'capt_06'          => $capt_06,
                            'capt_09'          => $capt_09,
                            'capt_12'          => $capt_12,
                            'capt_15'          => $capt_15,
                            'capt_18'          => $capt_18,
                            'capt_21'          => $capt_21,
                            'avg'              => $avg,
                            'user'             => $this->session->userdata("user_login")['username']

                        );


                        $this->db->query("DELETE FROM Div_Layanan.update_cro_crm WHERE kantor_cabang = '" . $kantor_cabang . "'");
                        // lastq();

                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('UpdateCROCRM');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('UpdateCROCRM');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }



        //Tabel Performance SLM BG Jalin ---------------------------------------------------------------------------------------------------------------

        } else if ($layanan == 'performance_slm_bg_jalin') {
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();

                        // $Tanggal = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $Tanggal = $worksheet->getCellByColumnAndRow(1, $row);
                        $tanggal_final = $Tanggal->getValue();
                        if(PHPExcel_Shared_Date::isDateTime($Tanggal)) {
                             $tanggal_final = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($tanggal_final)); 
                        }

                        $Kantor_Cabang = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $Jumlah_Mesin = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $Performance_Reliability_SLM_Jalin = $worksheet->getCellByColumnAndRow(4, $row)->getValue();

                                                                                                                        
                        $temp_data[] = array(
                            'no'                                => $no,
                            'Tanggal'                           => $tanggal_final,
                            'Kantor_Cabang'                     => $Kantor_Cabang,
                            'Jumlah_Mesin'                      => $Jumlah_Mesin,
                            'Performance_Reliability_SLM_Jalin' => $Performance_Reliability_SLM_Jalin,
                            'user'                              => $this->session->userdata("user_login")['username']

                        );


                        // $this->db->truncate($layanan);
                        $this->db->query("DELETE FROM Div_Layanan.performance_slm_bg_jalin WHERE Kantor_Cabang = '" . $Kantor_Cabang . "'");
                        // lastq();

                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('PerformanceSLMBGJalin');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('PerformanceSLMBGJalin');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }


        //Tabel Rekap Laporan Poisisi Kas UTLE ---------------------------------------------------------------------------------------------------------------


        } else if ($layanan == 'rekap_laporan_posisi_kas_utle_bg') {
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $BC = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $KANTOR_CABANG = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $POSISI_UTLE_DI_BRANKAS_100000 = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $POSISI_UTLE_DI_BRANKAS_50000 = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $POSISI_UTLE_DI_BRANKAS_TOTAL = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $Posisi_Tanggal = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $POSISI_UTLE_DI_BRANKAS_100000_2 = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $POSISI_UTLE_DI_BRANKAS_50000_2 = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $POSISI_UTLE_DI_BRANKAS_TOTAL_2 = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $Posisi_Tanggal_2 = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                        $Keterangan = $worksheet->getCellByColumnAndRow(11, $row)->getValue();

                                                                                                                        
                        $temp_data[] = array(
                            'no'                                => $no,
                            'BC'                                => $BC,
                            'KANTOR_CABANG'                     => $KANTOR_CABANG,
                            'POSISI_UTLE_DI_BRANKAS_100000'     => $POSISI_UTLE_DI_BRANKAS_100000,
                            'POSISI_UTLE_DI_BRANKAS_50000'      => $POSISI_UTLE_DI_BRANKAS_50000,
                            'POSISI_UTLE_DI_BRANKAS_TOTAL'      => $POSISI_UTLE_DI_BRANKAS_TOTAL,
                            'Posisi_Tanggal'                    => $Posisi_Tanggal,
                            'POSISI_UTLE_DI_BRANKAS_100000_2'   => $POSISI_UTLE_DI_BRANKAS_100000_2,
                            'POSISI_UTLE_DI_BRANKAS_50000_2'    => $POSISI_UTLE_DI_BRANKAS_50000_2,
                            'POSISI_UTLE_DI_BRANKAS_TOTAL_2'    => $POSISI_UTLE_DI_BRANKAS_TOTAL_2,
                            'Posisi_Tanggal_2'                  => $Posisi_Tanggal_2,
                            'Keterangan'                        => $Keterangan,
                            'user'                              => $this->session->userdata("user_login")['username']

                        );


                        $this->db->query("DELETE FROM Div_Layanan.rekap_laporan_posisi_kas_utle_bg WHERE KANTOR_CABANG = '" . $KANTOR_CABANG . "'");
                        // lastq();

                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('RekapLaporanPosisiKasUTLE');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('RekapLaporanPosisiKasUTLE');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }


        //Tabel Posisi Saldo Kas Sortir ---------------------------------------------------------------------------------------------------------------

        } else if ($layanan == 'posisi_saldo_kas_sortir') {
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $KANTOR_LAYANAN = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $KANCAKO = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $SALDO_AWAL_31_OKTOBER_2021 = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $TAMBAHAN_KAS_31_OKTOBER_2021 = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $SORTIR_SETOR_31_OKTOBER_2021 = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $SALDO_AKHIR_31_OKTOBER_2021 = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $KETERANGAN = $worksheet->getCellByColumnAndRow(7, $row)->getValue();

                                                                                                                        
                        $temp_data[] = array(
                            'no'                                => $no,
                            'KANTOR_LAYANAN'                    => $KANTOR_LAYANAN,
                            'KANCAKO'                           => $KANCAKO,
                            'SALDO_AWAL_31_OKTOBER_2021'        => $SALDO_AWAL_31_OKTOBER_2021,
                            'TAMBAHAN_KAS_31_OKTOBER_2021'      => $TAMBAHAN_KAS_31_OKTOBER_2021,
                            'SORTIR_SETOR_31_OKTOBER_2021'      => $SORTIR_SETOR_31_OKTOBER_2021,
                            'SALDO_AKHIR_31_OKTOBER_2021'       => $SALDO_AKHIR_31_OKTOBER_2021,
                            'KETERANGAN'                        => $KETERANGAN,
                            'user'                              => $this->session->userdata("user_login")['username']

                        );


                        $this->db->query("DELETE FROM Div_Layanan.posisi_saldo_kas_sortir WHERE KANTOR_LAYANAN = '" . $KANTOR_LAYANAN . "'");
                        // lastq();

                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('PosisiSaldoKasSortir');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('PosisiSaldoKasSortir');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }



        //Tabel Update Kirim BA HO Bank BJB ---------------------------------------------------------------------------------------------------------------

        } else if ($layanan == 'update_kirim_ba_ho_bjb') {
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $KANCA_BG = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $TOTAL_ATM_IN = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $TOTAL_ATM_OUT = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $TOTAL_ATM_DONE_HO = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $TOTAL_BA = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $KEKURANGAN_BA = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $STATUS_KIRIM = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $KETERANGAN = $worksheet->getCellByColumnAndRow(8, $row)->getValue();

                                                                                                                        
                        $temp_data[] = array(
                            'no'                    => $no,
                            'KANCA_BG'              => $KANCA_BG,
                            'TOTAL_ATM_IN'          => $TOTAL_ATM_IN,
                            'TOTAL_ATM_OUT'         => $TOTAL_ATM_OUT,
                            'TOTAL_ATM_DONE_HO'     => $TOTAL_ATM_DONE_HO,
                            'TOTAL_BA'              => $TOTAL_BA,
                            'KEKURANGAN_BA'         => $KEKURANGAN_BA,
                            'STATUS_KIRIM'          => $STATUS_KIRIM,
                            'KETERANGAN'            => $KETERANGAN,
                            'user'                  => $this->session->userdata("user_login")['username']

                        );


                        $this->db->query("DELETE FROM Div_Layanan.update_kirim_ba_ho_bjb WHERE KANCA_BG = '" . $KANCA_BG . "'");
                        // lastq();
                        
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('UpdateKirimBAHOBJB');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('UpdateKirimBAHOBJB');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }





        //Tabel Rekap Data PM ---------------------------------------------------------------------------------------------------------------

        } else if ($layanan == 'rekap_data_pm') {
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $KANTOR_LAYANAN = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $JUMLAH_ATM = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $ON_PROGRES_PM_4 = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $DONE_PM_4 = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $PRESENTASE_PM_4 = $worksheet->getCellByColumnAndRow(5, $row)->getValue();

                                                                                                                        
                        $temp_data[] = array(
                            'no'                => $no,
                            'KANTOR_LAYANAN'    => $KANTOR_LAYANAN,
                            'JUMLAH_ATM'        => $JUMLAH_ATM,
                            'ON_PROGRES_PM_4'   => $ON_PROGRES_PM_4,
                            'DONE_PM_4'         => $DONE_PM_4,
                            'PRESENTASE_PM_4'   => $PRESENTASE_PM_4,
                            'user'              => $this->session->userdata("user_login")['username']

                        );


                        $this->db->query("DELETE FROM Div_Layanan.rekap_data_pm WHERE KANTOR_LAYANAN = '" . $KANTOR_LAYANAN . "'");
                        // lastq();
                        
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('RekapDataPM');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('RekapDataPM');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }




        //Tabel Rekap Data SM ---------------------------------------------------------------------------------------------------------------

        } else if ($layanan == 'rekap_data_sm') {
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $KANTOR_LAYANAN = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $JUMLAH_ATM = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $ON_PROGRES_SM = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $DONE_SM = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $PRESENTASE_SM = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $ESTIMASI_DENDA = $worksheet->getCellByColumnAndRow(6, $row)->getValue();

                                                                                                                        
                        $temp_data[] = array(
                            'no'                => $no,
                            'KANTOR_LAYANAN'    => $KANTOR_LAYANAN,
                            'JUMLAH_ATM'        => $JUMLAH_ATM,
                            'ON_PROGRES_SM'     => $ON_PROGRES_SM,
                            'DONE_SM'           => $DONE_SM,
                            'PRESENTASE_SM'     => $PRESENTASE_SM,
                            'ESTIMASI_DENDA'    => $ESTIMASI_DENDA,
                            'user'              => $this->session->userdata("user_login")['username']

                        );


                        $this->db->query("DELETE FROM Div_Layanan.rekap_data_sm WHERE KANTOR_LAYANAN = '" . $KANTOR_LAYANAN . "'");
                        // lastq();
                        
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('RekapDataSM');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('RekapDataSM');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }



        //Tabel Rekap Maintenance CCTV ATM ---------------------------------------------------------------------------------------------------------------

        } else if ($layanan == 'rekap_maintenance_cctv_atm') {
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $KANTOR_LAYANAN = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $JUMLAH_ATM = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $WEEK_1_ON_PROGRESS = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $WEEK_1_DONE = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $WEEK_2_ON_PROGRESS = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $WEEK_2_DONE = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $WEEK_3_ON_PROGRESS = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $WEEK_3_DONE = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $WEEK_4_ON_PROGRESS = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $WEEK_4_DONE = $worksheet->getCellByColumnAndRow(10, $row)->getValue();

                                                                                                                        
                        $temp_data[] = array(
                            'no'                    => $no,
                            'KANTOR_LAYANAN'        => $KANTOR_LAYANAN,
                            'JUMLAH_ATM'            => $JUMLAH_ATM,
                            'WEEK_1_ON_PROGRESS'    => $WEEK_1_ON_PROGRESS,
                            'WEEK_1_DONE'           => $WEEK_1_DONE,
                            'WEEK_2_ON_PROGRESS'    => $WEEK_2_ON_PROGRESS,
                            'WEEK_2_DONE'           => $WEEK_2_DONE,
                            'WEEK_3_ON_PROGRESS'    => $WEEK_3_ON_PROGRESS,
                            'WEEK_3_DONE'           => $WEEK_3_DONE,
                            'WEEK_4_ON_PROGRESS'    => $WEEK_4_ON_PROGRESS,
                            'WEEK_4_DONE'           => $WEEK_4_DONE,
                            'user'                  => $this->session->userdata("user_login")['username']

                        );


                        $this->db->query("DELETE FROM Div_Layanan.rekap_maintenance_cctv_atm WHERE KANTOR_LAYANAN = '" . $KANTOR_LAYANAN . "'");
                        // lastq();
                        
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('RekapMaintenanceCCTVATM');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('RekapMaintenanceCCTVATM');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }



        //Tabel Denda Return JABODETABEK ---------------------------------------------------------------------------------------------------------------

        } else if ($layanan == 'denda_return_jabodetabek') {
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $Kantor_Cabang = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $no_9822 = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $no_9825 = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $no_9850 = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $no_9921 = $worksheet->getCellByColumnAndRow(5, $row)->getValue();

                                                                                                                        
                        $temp_data[] = array(
                            'no'              => $no,
                            'Kantor_Cabang'   => $Kantor_Cabang,
                            'no_9822'         => $no_9822,
                            'no_9825'         => $no_9825,
                            'no_9850'         => $no_9850,
                            'no_9921'         => $no_9921,
                            'user'            => $this->session->userdata("user_login")['username']

                        );


                        $this->db->query("DELETE FROM Div_Layanan.denda_return_jabodetabek WHERE Kantor_Cabang = '" . $Kantor_Cabang . "'");
                        // lastq();
                        
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('DendaReturnJabodetabek');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('DendaReturnJabodetabek');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }



        //Tabel Rekap Data Performance Cluster Bulanan ---------------------------------------------------------------------------------------------------------------

        } else if ($layanan == 'rekap_data_performance_cluster_bulanan') {
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $KANTOR_CABANG = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $Total_ATM = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $RELIABILITY = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $no_0_sd_10 = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $no_11_sd_15 = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $no_16_sd_20 = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $no_21_sd_25 = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $no_26_sd_30 = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $Diatas_30 = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $Total_RPL = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                        $RPL_per_HARI = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                        $RPL_ATM_BLN = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                        $CLUSTER = $worksheet->getCellByColumnAndRow(13, $row)->getValue();

                                                                                                                        
                        $temp_data[] = array(
                            'no'              => $no,
                            'KANTOR_CABANG'   => $KANTOR_CABANG,
                            'Total_ATM'       => $Total_ATM,
                            'RELIABILITY'     => $RELIABILITY,
                            'no_0_sd_10'      => $no_0_sd_10,
                            'no_11_sd_15'     => $no_11_sd_15,
                            'no_16_sd_20'     => $no_16_sd_20,
                            'no_21_sd_25'     => $no_21_sd_25,
                            'no_26_sd_30'     => $no_26_sd_30,
                            'Diatas_30'       => $Diatas_30,
                            'Total_RPL'       => $Total_RPL,
                            'RPL_per_HARI'    => $RPL_per_HARI,
                            'RPL_ATM_BLN'     => $RPL_ATM_BLN,
                            'CLUSTER'         => $CLUSTER,
                            'user'            => $this->session->userdata("user_login")['username']

                        );


                        $this->db->query("DELETE FROM Div_Layanan.rekap_data_performance_cluster_bulanan WHERE KANTOR_CABANG = '" . $KANTOR_CABANG . "'");
                        // lastq();
                        
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('RekapDataPerformanceClusterBulanan');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('RekapDataPerformanceClusterBulanan');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }



        //Tabel Rekap Penggunaan Sparepart ---------------------------------------------------------------------------------------------------------------

        } else if ($layanan == 'rekap_penggunaan_sparepart') {
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();

                        // $TANGGAL = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $TANGGAL = $worksheet->getCellByColumnAndRow(1, $row);
                        $tanggal_final = $TANGGAL->getValue();
                        if(PHPExcel_Shared_Date::isDateTime($TANGGAL)) {
                             $tanggal_final = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($tanggal_final)); 
                        }


                        $TID = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $Kantor_Layanan = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $LOKASI = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $MERK = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $TEKNISI = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $PART = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $BC = $worksheet->getCellByColumnAndRow(8, $row)->getValue();

                                                                                                                        
                        $temp_data[] = array(
                            'no'                => $no,
                            'TANGGAL'           => $tanggal_final,
                            'TID'               => $TID,
                            'Kantor_Layanan'    => $Kantor_Layanan,
                            'LOKASI'            => $LOKASI,
                            'MERK'              => $MERK,
                            'TEKNISI'           => $TEKNISI,
                            'PART'              => $PART,
                            'BC'                => $BC,
                            'user'              => $this->session->userdata("user_login")['username']

                        );


                        // $this->db->query("DELETE FROM Div_Layanan.rekap_penggunaan_sparepart WHERE KANTOR_CABANG = '" . $KANTOR_CABANG . "'");
                        // lastq();
                        
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('RekapPenggunaaSparepart');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('RekapPenggunaaSparepart');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }



        //Tabel Rekap RPL Bank BJB ---------------------------------------------------------------------------------------------------------------

        } else if ($layanan == 'rekap_rpl_bank_bjb') {
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();

                        // $TANGGAL = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $Tgl_Rep = $worksheet->getCellByColumnAndRow(1, $row);
                        $tanggal_Rep = $Tgl_Rep->getValue();
                        if(PHPExcel_Shared_Date::isDateTime($Tgl_Rep)) {
                             $tanggal_Rep = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($tanggal_Rep)); 
                        }


                        $ID_ATM = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $BG = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $Lokasi = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $Time = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $Denom = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $Tot_Replenish = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $BC = $worksheet->getCellByColumnAndRow(8, $row)->getValue();

                                                                                                                        
                        $temp_data[] = array(
                            'no'                => $no,
                            'Tgl_Rep'           => $tanggal_Rep,
                            'ID_ATM'            => $ID_ATM,
                            'BG'                => $BG,
                            'Lokasi'            => $Lokasi,
                            'Time'              => $Time,
                            'Denom'             => $Denom,
                            'Tot_Replenish'     => $Tot_Replenish,
                            'user'              => $this->session->userdata("user_login")['username']

                        );


                        $this->db->query("DELETE FROM Div_Layanan.rekap_rpl_bank_bjb WHERE ID_ATM = '" . $ID_ATM . "'");
                        // lastq();
                        
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('RekapRPLBankBJB');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('RekapRPLBankBJB');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }



        //Tabel Data Vandalisme & Relokasi ---------------------------------------------------------------------------------------------------------------

        } else if ($layanan == 'data_vandalisme_relokasi') {
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $Kantor_Cabang = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $Total_ATM = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $Vandalisme = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $Location = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $Total = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $Presentase = $worksheet->getCellByColumnAndRow(6, $row)->getValue();

                                                                                                                        
                        $temp_data[] = array(
                            'no'                => $no,
                            'Kantor_Cabang'     => $Kantor_Cabang,
                            'Total_ATM'         => $Total_ATM,
                            'Vandalisme'        => $Vandalisme,
                            'Location'          => $Location,
                            'Total'             => $Total,
                            'Presentase'        => $Presentase,
                            'user'              => $this->session->userdata("user_login")['username']

                        );


                        $this->db->query("DELETE FROM Div_Layanan.data_vandalisme_relokasi WHERE Kantor_Cabang = '" . $Kantor_Cabang . "'");
                        // lastq();
                        
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('DataVandalismeRelokasi');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('DataVandalismeRelokasi');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }



        //Tabel Format Proyeksi Kebutuhan Kas BG Selindo ---------------------------------------------------------------------------------------------------------------

        } else if ($layanan == 'format_proyeksi_kebutuhan_kas_bg_selindo') {
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $Kantor_Cabang = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $RPL_50 = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $RPL_100 = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $TK_50 = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $TK_100 = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $Grand_Total = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $Average_Kas_Per_ATM_50 = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $Average_Kas_Per_ATM_100 = $worksheet->getCellByColumnAndRow(8, $row)->getValue();

                                                                                                                        
                        $temp_data[] = array(
                            'no'                            => $no,
                            'Kantor_Cabang'                 => $Kantor_Cabang,
                            'RPL_50'                        => $RPL_50,
                            'RPL_100'                       => $RPL_100,
                            'TK_50'                         => $TK_50,
                            'TK_50'                         => $TK_50,
                            'TK_100'                        => $TK_100,
                            'Grand_Total'                   => $Grand_Total,
                            'Average_Kas_Per_ATM_50'        => $Average_Kas_Per_ATM_50,
                            'Average_Kas_Per_ATM_100'       => $Average_Kas_Per_ATM_100,
                            'user'                          => $this->session->userdata("user_login")['username']

                        );


                        $this->db->query("DELETE FROM Div_Layanan.format_proyeksi_kebutuhan_kas_bg_selindo WHERE Kantor_Cabang = '" . $Kantor_Cabang . "'");
                        // lastq();
                        
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('FormatProyeksiKebutuhanKasBGSelindo');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('FormatProyeksiKebutuhanKasBGSelindo');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }



        //Tabel Rekap EJ BG Selindo ---------------------------------------------------------------------------------------------------------------

        } else if ($layanan == 'rekap_ej_bg_selindo') {
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $Kantor_Layanan = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $tgl_1 = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $tgl_2 = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $tgl_3 = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $tgl_4 = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $tgl_5 = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $tgl_6 = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $tgl_7 = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $tgl_8 = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $tgl_9 = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                        $tgl_10 = $worksheet->getCellByColumnAndRow(11, $row)->getValue();

                        $tgl_11 = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                        $tgl_12 = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                        $tgl_13 = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                        $tgl_14 = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
                        $tgl_15 = $worksheet->getCellByColumnAndRow(16, $row)->getValue();
                        $tgl_16 = $worksheet->getCellByColumnAndRow(17, $row)->getValue();
                        $tgl_17 = $worksheet->getCellByColumnAndRow(18, $row)->getValue();
                        $tgl_18 = $worksheet->getCellByColumnAndRow(19, $row)->getValue();
                        $tgl_19 = $worksheet->getCellByColumnAndRow(20, $row)->getValue();
                        $tgl_20 = $worksheet->getCellByColumnAndRow(21, $row)->getValue();

                        $tgl_21 = $worksheet->getCellByColumnAndRow(22, $row)->getValue();
                        $tgl_22 = $worksheet->getCellByColumnAndRow(23, $row)->getValue();
                        $tgl_23 = $worksheet->getCellByColumnAndRow(24, $row)->getValue();
                        $tgl_24 = $worksheet->getCellByColumnAndRow(25, $row)->getValue();
                        $tgl_25 = $worksheet->getCellByColumnAndRow(26, $row)->getValue();
                        $tgl_26 = $worksheet->getCellByColumnAndRow(27, $row)->getValue();
                        $tgl_27 = $worksheet->getCellByColumnAndRow(28, $row)->getValue();
                        $tgl_28 = $worksheet->getCellByColumnAndRow(29, $row)->getValue();
                        $tgl_29 = $worksheet->getCellByColumnAndRow(30, $row)->getValue();
                        $tgl_30 = $worksheet->getCellByColumnAndRow(31, $row)->getValue();

                        $tgl_31 = $worksheet->getCellByColumnAndRow(32, $row)->getValue();
                        $TOTAL = $worksheet->getCellByColumnAndRow(33, $row)->getValue();
                        $Periode = $worksheet->getCellByColumnAndRow(34, $row)->getValue();

                                                                                                                        
                        $temp_data[] = array(
                            'no'                            => $no,
                            'Kantor_Layanan'                => $Kantor_Layanan,
                            'tgl_1'                         => $tgl_1,
                            'tgl_2'                         => $tgl_2,
                            'tgl_3'                         => $tgl_3,
                            'tgl_4'                         => $tgl_4,
                            'tgl_5'                         => $tgl_5,
                            'tgl_6'                         => $tgl_6,
                            'tgl_7'                         => $tgl_7,
                            'tgl_8'                         => $tgl_8,
                            'tgl_9'                         => $tgl_9,
                            'tgl_10'                        => $tgl_10,

                            'tgl_11'                        => $tgl_11,
                            'tgl_12'                        => $tgl_12,
                            'tgl_13'                        => $tgl_13,
                            'tgl_14'                        => $tgl_14,
                            'tgl_15'                        => $tgl_15,
                            'tgl_16'                        => $tgl_16,
                            'tgl_17'                        => $tgl_17,
                            'tgl_18'                        => $tgl_18,
                            'tgl_19'                        => $tgl_19,
                            'tgl_20'                        => $tgl_20,

                            'tgl_21'                        => $tgl_21,
                            'tgl_22'                        => $tgl_22,
                            'tgl_23'                        => $tgl_23,
                            'tgl_24'                        => $tgl_24,
                            'tgl_25'                        => $tgl_25,
                            'tgl_26'                        => $tgl_26,
                            'tgl_27'                        => $tgl_27,
                            'tgl_28'                        => $tgl_28,
                            'tgl_29'                        => $tgl_29,
                            'tgl_30'                        => $tgl_30,
                            'tgl_31'                        => $tgl_31,

                            'TOTAL'                         => $TOTAL,
                            'Periode'                       => $Periode,
                            'user'                          => $this->session->userdata("user_login")['username']

                        );


                        $this->db->query("DELETE FROM Div_Layanan.rekap_ej_bg_selindo WHERE Kantor_Layanan = '" . $Kantor_Layanan . "'");
                        // lastq();
                        
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('RekapEJBGSelindo');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('RekapEJBGSelindo');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }




        //Tabel Rekap Saldo DSR CRO BJB ---------------------------------------------------------------------------------------------------------------

        } else if ($layanan == 'rekap_saldo_dsr_cro_bjb') {
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $KANTOR_CABANG = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $SALDO_AWAL_CRO = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $RETURN_CRO = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $SALDO_AKHIR_CRO = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $SALDO_AWAL_DSR = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $RETURN_DSR = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $SALDO_AKHIR_DSR = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $KETERANGAN = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $NOMINAL = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $KETERANGAN1 = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                        $NOMINAL1 = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                        $KETERANGAN2 = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                        $NOMINAL2 = $worksheet->getCellByColumnAndRow(13, $row)->getValue();

                                                                                                                        
                        $temp_data[] = array(
                            'no'                           => $no,
                            'KANTOR_CABANG'                => $KANTOR_CABANG,
                            'SALDO_AWAL_CRO'               => $SALDO_AWAL_CRO,
                            'RETURN_CRO'                   => $RETURN_CRO,
                            'SALDO_AKHIR_CRO'              => $SALDO_AKHIR_CRO,
                            'SALDO_AWAL_DSR'               => $SALDO_AWAL_DSR,
                            'RETURN_DSR'                   => $RETURN_DSR,
                            'SALDO_AKHIR_DSR'              => $SALDO_AKHIR_DSR,
                            'KETERANGAN'                   => $KETERANGAN,
                            'NOMINAL'                      => $NOMINAL,
                            'KETERANGAN1'                  => $KETERANGAN1,
                            'NOMINAL1'                     => $NOMINAL1,
                            'KETERANGAN2'                  => $KETERANGAN2,
                            'NOMINAL2'                     => $NOMINAL2,
                            'user'                         => $this->session->userdata("user_login")['username']

                        );


                        $this->db->query("DELETE FROM Div_Layanan.rekap_saldo_dsr_cro_bjb WHERE KANTOR_CABANG = '" . $KANTOR_CABANG . "'");
                        // lastq();
                        
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('RekapSaldoDSRCROBJB');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('RekapSaldoDSRCROBJB');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }



        //Tabel Rekap Saldo DSR CRO BRI ---------------------------------------------------------------------------------------------------------------

        } else if ($layanan == 'rekap_saldo_dsr_cro_bri') {
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $BC = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $KANTOR_CABANG = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $SALDO_AWAL_CRO = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $RETURN_CRO = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $SALDO_AKHIR_CRO = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $SALDO_AWAL_DSR = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $RETURN_DSR = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $SALDO_AKHIR_DSR = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $KETERANGAN = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $NOMINAL = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                        $KETERANGAN1 = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                        $NOMINAL1 = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                        $KETERANGAN2 = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                        $NOMINAL2 = $worksheet->getCellByColumnAndRow(14, $row)->getValue();

                                                                                                                        
                        $temp_data[] = array(
                            'no'                           => $no,
                            'BC'                           => $BC,
                            'KANTOR_CABANG'                => $KANTOR_CABANG,
                            'SALDO_AWAL_CRO'               => $SALDO_AWAL_CRO,
                            'RETURN_CRO'                   => $RETURN_CRO,
                            'SALDO_AKHIR_CRO'              => $SALDO_AKHIR_CRO,
                            'SALDO_AWAL_DSR'               => $SALDO_AWAL_DSR,
                            'RETURN_DSR'                   => $RETURN_DSR,
                            'SALDO_AKHIR_DSR'              => $SALDO_AKHIR_DSR,
                            'KETERANGAN'                   => $KETERANGAN,
                            'NOMINAL'                      => $NOMINAL,
                            'KETERANGAN1'                  => $KETERANGAN1,
                            'NOMINAL1'                     => $NOMINAL1,
                            'KETERANGAN2'                  => $KETERANGAN2,
                            'NOMINAL2'                     => $NOMINAL2,
                            'user'                         => $this->session->userdata("user_login")['username']

                        );


                        $this->db->query("DELETE FROM Div_Layanan.rekap_saldo_dsr_cro_bri WHERE KANTOR_CABANG = '" . $KANTOR_CABANG . "'");
                        // lastq();
                        
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('RekapSaldoDSRCROBRI');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('RekapSaldoDSRCROBRI');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }



        //Tabel Saldo Restocking Terpusat ---------------------------------------------------------------------------------------------------------------

        } else if ($layanan == 'saldo_restocking_terpusat') {
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $KANTOR_LAYANAN = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $BC = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $RETURN_50 = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $RETURN_100 = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $JUMLAH = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $SALDO_AWAL_PAGI_50 = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $SALDO_AWAL_PAGI_100 = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $JUMLAH1 = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $RPL_PAGI_50 = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $RPL_PAGI_100 = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                        $JUMLAH2 = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                        $SALDO_RESTOCKING_PAGI_50 = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                        $SALDO_RESTOCKING_PAGI_100 = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                        $JUMLAH3 = $worksheet->getCellByColumnAndRow(14, $row)->getValue();

                                                                                                                        
                        $temp_data[] = array(
                            'no'                        => $no,
                            'KANTOR_LAYANAN'            => $KANTOR_LAYANAN,
                            'BC'                        => $BC,
                            'RETURN_50'                 => $RETURN_50,
                            'RETURN_100'                => $RETURN_100,
                            'JUMLAH'                    => $JUMLAH,
                            'SALDO_AWAL_PAGI_50'        => $SALDO_AWAL_PAGI_50,
                            'SALDO_AWAL_PAGI_100'       => $SALDO_AWAL_PAGI_100,
                            'JUMLAH1'                   => $JUMLAH1,
                            'RPL_PAGI_50'               => $RPL_PAGI_50,
                            'RPL_PAGI_100'              => $RPL_PAGI_100,
                            'JUMLAH2'                   => $JUMLAH2,
                            'SALDO_RESTOCKING_PAGI_50'  => $SALDO_RESTOCKING_PAGI_50,
                            'SALDO_RESTOCKING_PAGI_100' => $SALDO_RESTOCKING_PAGI_100,
                            'JUMLAH3'                   => $JUMLAH3,
                            'user'                      => $this->session->userdata("user_login")['username']

                        );


                        $this->db->query("DELETE FROM Div_Layanan.saldo_restocking_terpusat WHERE KANTOR_LAYANAN = '" . $KANTOR_LAYANAN . "'");
                        // lastq();
                        
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('SaldoRestockingTerpusat');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('SaldoRestockingTerpusat');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }




        //Tabel Saldo Restocking ---------------------------------------------------------------------------------------------------------------

        } else if ($layanan == 'saldo_restocking') {
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $KANTOR_LAYANAN = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $BC = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $RETURN_50 = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $RETURN_100 = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $SALDO_AWAL_50 = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $SALDO_AWAL_100 = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $RPL_50 = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $RPL_100 = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $SALDO_AKHIR_50 = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $SALDO_AKHIR_100 = $worksheet->getCellByColumnAndRow(10, $row)->getValue();

                                                                                                                        
                        $temp_data[] = array(
                            'no'                        => $no,
                            'KANTOR_LAYANAN'            => $KANTOR_LAYANAN,
                            'BC'                        => $BC,
                            'RETURN_50'                 => $RETURN_50,
                            'RETURN_100'                => $RETURN_100,
                            'SALDO_AWAL_50'             => $SALDO_AWAL_50,
                            'SALDO_AWAL_100'            => $SALDO_AWAL_100,
                            'RPL_50'                    => $RPL_50,
                            'RPL_100'                   => $RPL_100,
                            'SALDO_AKHIR_50'            => $SALDO_AKHIR_50,
                            'SALDO_AKHIR_100'           => $SALDO_AKHIR_100,
                            'user'                      => $this->session->userdata("user_login")['username']

                        );


                        // $this->db->query("DELETE FROM Div_Layanan.saldo_restocking WHERE KANTOR_LAYANAN = '" . $KANTOR_LAYANAN . "'");
                        // lastq();
                        
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('SaldoRestocking');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('SaldoRestocking');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }




        //Tabel Reability Harian BG Kolaborasi ---------------------------------------------------------------------------------------------------------------

        } else if ($layanan == 'reability_harian_bg_kolaborasi') {
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $Kantor_Layanan = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $Jam_Capture_0 = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $Jam_Capture_3 = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $Jam_Capture_6 = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $Jam_Capture_9 = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $Jam_Capture_12 = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $Jam_Capture_15 = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $Jam_Capture_18 = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $Jam_Capture_21 = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $Average = $worksheet->getCellByColumnAndRow(10, $row)->getValue();

                                                                                                                        
                        $temp_data[] = array(
                            'no'                => $no,
                            'Kantor_Layanan'    => $Kantor_Layanan,
                            'Jam_Capture_0'     => $Jam_Capture_0,
                            'Jam_Capture_3'     => $Jam_Capture_3,
                            'Jam_Capture_6'     => $Jam_Capture_6,
                            'Jam_Capture_9'     => $Jam_Capture_9,
                            'Jam_Capture_12'    => $Jam_Capture_12,
                            'Jam_Capture_15'    => $Jam_Capture_15,
                            'Jam_Capture_18'    => $Jam_Capture_18,
                            'Jam_Capture_21'    => $Jam_Capture_21,
                            'Average'           => $Average,
                            'user'              => $this->session->userdata("user_login")['username']

                        );


                        $this->db->query("DELETE FROM Div_Layanan.reability_harian_bg_kolaborasi WHERE Kantor_Layanan = '" . $Kantor_Layanan . "'");
                        // lastq();
                        
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('ReliabilityHarianBGKolaborasi');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('ReliabilityHarianBGKolaborasi');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }



        //Tabel Update Data Alat Alarm System & Acces Door ---------------------------------------------------------------------------------------------------------------

        } else if ($layanan == 'update_data_alat_alarm_system_dan_acces_door') {
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        // $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $jumlah = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $update_data_alat_alarm_system_acces_door = $worksheet->getCellByColumnAndRow(2, $row)->getValue();

                                                                                                                        
                        $temp_data[] = array(
                            // 'no'                                        => $no,
                            'jumlah'                                    => $jumlah,
                            'update_data_alat_alarm_system_acces_door'  => $update_data_alat_alarm_system_acces_door,
                            'user'                                      => $this->session->userdata("user_login")['username']

                        );
                        $this->layanan->truncate($layanan);
                        // lastq();
                    }
                   
                }

                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('UpdatedataAlatAlarmSystemDanAccesDoor');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('UpdatedataAlatAlarmSystemDanAccesDoor');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }



        //Tabel Update Data CCTV Kolaborasi ---------------------------------------------------------------------------------------------------------------


        } else if ($layanan == 'update_data_cctv_kolaborasi') {
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        // $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $jumlah = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $update_data_cctv_kolaborasi = $worksheet->getCellByColumnAndRow(2, $row)->getValue();

                                                                                                                        
                        $temp_data[] = array(
                            // 'no'                                        => $no,
                            'jumlah'                                    => $jumlah,
                            'update_data_cctv_kolaborasi'               => $update_data_cctv_kolaborasi,
                            'user'                                      => $this->session->userdata("user_login")['username']

                        );                        
                        $this->layanan->truncate($layanan);
                    }
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('UpdateDataCctvKolaborasi');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('UpdateDataCctvKolaborasi');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }



        //Tabel update_data_kecelakaan ---------------------------------------------------------------------------------------------------------------

        } else if ($layanan == 'update_data_kecelakaan') {
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        // $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $jumlah = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $update_data_kecelakaan = $worksheet->getCellByColumnAndRow(2, $row)->getValue();

                                                                                                                        
                        $temp_data[] = array(
                            // 'no'                                        => $no,
                            'jumlah'                                    => $jumlah,
                            'update_data_kecelakaan'                    => $update_data_kecelakaan,
                            'user'                                      => $this->session->userdata("user_login")['username']

                        );
                        $this->layanan->truncate($layanan);
                    }
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('UpdateDataKecelakaan');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('UpdateDataKecelakaan');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }



        //Tabel update_data_passthru ---------------------------------------------------------------------------------------------------------------

        } else if ($layanan == 'update_data_passthru') {
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        // $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $jumlah = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $update_data_passthru = $worksheet->getCellByColumnAndRow(2, $row)->getValue();

                                                                                                                        
                        $temp_data[] = array(
                            // 'no'                                        => $no,
                            'jumlah'                                    => $jumlah,
                            'update_data_passthru'                    => $update_data_passthru,
                            'user'                                      => $this->session->userdata("user_login")['username']

                        );
                        $this->layanan->truncate($layanan);
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('UpdateDataPassthru');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('UpdateDataPassthru');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }



        //Tabel update_data_petugas_satpam ---------------------------------------------------------------------------------------------------------------

        } else if ($layanan == 'update_data_petugas_satpam') {
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        // $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $jumlah = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $update_data_petugas_satpam = $worksheet->getCellByColumnAndRow(2, $row)->getValue();

                                                                                                                        
                        $temp_data[] = array(
                            // 'no'                                        => $no,
                            'jumlah'                                    => $jumlah,
                            'update_data_petugas_satpam'                    => $update_data_petugas_satpam,
                            'user'                                      => $this->session->userdata("user_login")['username']

                        );
                        $this->layanan->truncate($layanan);                        
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('UpdateDataPetugasSatpam');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('UpdateDataPetugasSatpam');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }



        //Tabel update_data_simcard_pada_alat_alarm_system ---------------------------------------------------------------------------------------------------------------

        } else if ($layanan == 'update_data_simcard_pada_alat_alarm_system') {
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        // $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $jumlah = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $update_simcard_alarm_system = $worksheet->getCellByColumnAndRow(2, $row)->getValue();

                                                                                                                        
                        $temp_data[] = array(
                            // 'no'                                        => $no,
                            'jumlah'                                    => $jumlah,
                            'update_simcard_alarm_system'                    => $update_simcard_alarm_system,
                            'user'                                      => $this->session->userdata("user_login")['username']

                        );
                        $this->layanan->truncate($layanan);
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('UpdateDataSimcardAlatAlarmSystem');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('UpdateDataSimcardAlatAlarmSystem');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }



        //Tabel update_data_temuan_unit_siu ---------------------------------------------------------------------------------------------------------------

        } else if ($layanan == 'update_data_temuan_unit_siu') {
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        // $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $Cabang = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $Kriteria_Pelanggaran_Admin = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $Kriteria_Pelanggaran_CPC = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $Kriteria_Pelanggaran_Gerbang_Utama = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $Kriteria_Pelanggaran_Kunci = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $Kriteria_Pelanggaran_Khasanah = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $Kriteria_Pelanggaran_Loading = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $Kriteria_Pelanggaran_Passthru = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $Kriteria_Pelanggaran_Maintrap = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $Kriteria_Pelanggaran_Rutang = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                        $Kriteria_Pelanggaran_Steril = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                        $Kriteria_Pelanggaran_Kendaraan = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                        $Total_Jumlah_Pelanggaran = $worksheet->getCellByColumnAndRow(13, $row)->getValue();


                                                                                                                        
                        $temp_data[] = array(
                            // 'no'                                        => $no,
                            'Cabang'                                    => $Cabang,
                            'Kriteria_Pelanggaran_Admin'                    => $Kriteria_Pelanggaran_Admin,

                            'Kriteria_Pelanggaran_CPC'                    => $Kriteria_Pelanggaran_CPC,
                            'Kriteria_Pelanggaran_Gerbang_Utama'                    => $Kriteria_Pelanggaran_Gerbang_Utama,
                            'Kriteria_Pelanggaran_Kunci'                    => $Kriteria_Pelanggaran_Kunci,
                            'Kriteria_Pelanggaran_Khasanah'                    => $Kriteria_Pelanggaran_Khasanah,
                            'Kriteria_Pelanggaran_Loading'                    => $Kriteria_Pelanggaran_Loading,
                            'Kriteria_Pelanggaran_Passthru'                    => $Kriteria_Pelanggaran_Passthru,
                            'Kriteria_Pelanggaran_Maintrap'                    => $Kriteria_Pelanggaran_Maintrap,
                            'Kriteria_Pelanggaran_Rutang'                    => $Kriteria_Pelanggaran_Rutang,

                            'Kriteria_Pelanggaran_Steril'                    => $Kriteria_Pelanggaran_Steril,
                            'Kriteria_Pelanggaran_Kendaraan'                    => $Kriteria_Pelanggaran_Kendaraan,
                            'Total_Jumlah_Pelanggaran'                    => $Total_Jumlah_Pelanggaran,
                            'user'                                      => $this->session->userdata("user_login")['username']

                        );
                        $this->layanan->truncate($layanan);
                        
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('UpdateDataTemuanUnitSiu');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('UpdateDataTemuanUnitSiu');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }





        //Tabel rekap_monitoring_pelanggaran_sop_kc_selindo ---------------------------------------------------------------------------------------------------------------
        } else if ($layanan == 'rekap_monitoring_pelanggaran_sop_kc_selindo') {
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        // $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $unit_kerja = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $tgl_1 = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $tgl_2 = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $tgl_3 = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $tgl_4 = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $tgl_5 = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $tgl_6 = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $tgl_7 = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $tgl_8 = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $tgl_9 = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                        $tgl_10 = $worksheet->getCellByColumnAndRow(11, $row)->getValue();

                        $tgl_11 = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                        $tgl_12 = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                        $tgl_13 = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                        $tgl_14 = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
                        $tgl_15 = $worksheet->getCellByColumnAndRow(16, $row)->getValue();
                        $tgl_16 = $worksheet->getCellByColumnAndRow(17, $row)->getValue();
                        $tgl_17 = $worksheet->getCellByColumnAndRow(18, $row)->getValue();
                        $tgl_18 = $worksheet->getCellByColumnAndRow(19, $row)->getValue();
                        $tgl_19 = $worksheet->getCellByColumnAndRow(20, $row)->getValue();
                        $tgl_20 = $worksheet->getCellByColumnAndRow(21, $row)->getValue();

                        $tgl_21 = $worksheet->getCellByColumnAndRow(22, $row)->getValue();
                        $tgl_22 = $worksheet->getCellByColumnAndRow(23, $row)->getValue();
                        $tgl_23 = $worksheet->getCellByColumnAndRow(24, $row)->getValue();
                        $tgl_24 = $worksheet->getCellByColumnAndRow(25, $row)->getValue();
                        $tgl_25 = $worksheet->getCellByColumnAndRow(26, $row)->getValue();
                        $tgl_26 = $worksheet->getCellByColumnAndRow(27, $row)->getValue();
                        $tgl_27 = $worksheet->getCellByColumnAndRow(28, $row)->getValue();
                        $tgl_28 = $worksheet->getCellByColumnAndRow(29, $row)->getValue();
                        $tgl_29 = $worksheet->getCellByColumnAndRow(30, $row)->getValue();
                        $tgl_30 = $worksheet->getCellByColumnAndRow(31, $row)->getValue();
                        $grand_total = $worksheet->getCellByColumnAndRow(32, $row)->getValue();
                        


                                                                                                                        
                        $temp_data[] = array(
                            // 'no'                                        => $no,
                            'unit_kerja'                                    => $unit_kerja,
                            'tgl_1'                    => $tgl_1,
                            'tgl_2'                    => $tgl_2,
                            'tgl_3'                    => $tgl_3,
                            'tgl_4'                    => $tgl_4,
                            'tgl_5'                    => $tgl_5,
                            'tgl_6'                    => $tgl_6,
                            'tgl_7'                    => $tgl_7,
                            'tgl_8'                    => $tgl_8,
                            'tgl_9'                    => $tgl_9,
                            'tgl_10'                    => $tgl_10,

                            'tgl_11'                    => $tgl_11,
                            'tgl_12'                    => $tgl_12,
                            'tgl_13'                    => $tgl_13,
                            'tgl_14'                    => $tgl_14,
                            'tgl_15'                    => $tgl_15,
                            'tgl_16'                    => $tgl_16,
                            'tgl_17'                    => $tgl_17,
                            'tgl_18'                    => $tgl_18,
                            'tgl_19'                    => $tgl_19,
                            'tgl_20'                    => $tgl_20,

                            'tgl_21'                    => $tgl_21,
                            'tgl_22'                    => $tgl_22,
                            'tgl_23'                    => $tgl_23,
                            'tgl_24'                    => $tgl_24,
                            'tgl_25'                    => $tgl_25,
                            'tgl_26'                    => $tgl_26,
                            'tgl_27'                    => $tgl_27,
                            'tgl_28'                    => $tgl_28,
                            'tgl_29'                    => $tgl_29,
                            'tgl_30'                    => $tgl_30,
                            'grand_total'                    => $grand_total,

                            
                            'user'                                      => $this->session->userdata("user_login")['username']

                        );


                        $this->db->query("DELETE FROM Div_Layanan.rekap_monitoring_pelanggaran_sop_kc_selindo WHERE unit_kerja = '" . $unit_kerja . "'");
                        // lastq();
                        
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('RekapMonitoringPelanggaranSOPkcSelindo');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('RekapMonitoringPelanggaranSOPkcSelindo');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }




        //Tabel update_acces_door_kantor_kolaborasi ---------------------------------------------------------------------------------------------------------------
        } else if ($layanan == 'update_acces_door_kantor_kolaborasi') {
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $Update_Data_Access_Door_Kantor_Kolaborasi = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        
                        
                                                                                            
                        $temp_data[] = array(
                            'no'                                            => $no,
                            'Update_Data_Access_Door_Kantor_Kolaborasi'     => $Update_Data_Access_Door_Kantor_Kolaborasi,
                            'user'                                          => $this->session->userdata("user_login")['username']

                        );


                        $this->db->truncate($layanan);
                        // $this->db->query("DELETE FROM Div_Layanan.update_acces_door_kantor_kolaborasi WHERE unit_kerja = '" . $unit_kerja . "'");
                        // lastq();
                        
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('UpdateAccesDoorKantorKolaborasi');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('UpdateAccesDoorKantorKolaborasi');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }


// ------------------------ OUTSTANDING 2022

        } else if ($layanan == 'Monitoring_Outstanding_Shortage_BG_Selindo_22') {
            // cetak_die($layanan);
            if (isset($_FILES["fileExcel"]["name"])) {
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $Kantor_Cabang = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $Frekuensi = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $Nominal = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $Frekuensi_Kasus_New = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $Frekuensi_Kasus_Open = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $Frekuensi_Kasus_Close = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $Frekuensi_Kasus = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $Progress_Mingguan = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $Closed_Case_Done = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $Closed_Case_Progress = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                        $Pending_Jan_Sept = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                        $Pending_Oktober = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                        $All_Pending = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                                                                                                                        
                        $temp_data[] = array(
                            'no'                      => $no,
                            'Kantor_Cabang'           => $Kantor_Cabang,
                            'Frekuensi'               => $Frekuensi,
                            'Nominal'                 => $Nominal,
                            'Frekuensi_Kasus_New'     => $Frekuensi_Kasus_New,
                            'Frekuensi_Kasus_Open'    => $Frekuensi_Kasus_Open,
                            'Frekuensi_Kasus_Close'   => $Frekuensi_Kasus_Close,
                            'Frekuensi_Kasus'         => $Frekuensi_Kasus,
                            'Progress_Mingguan'       => $Progress_Mingguan,
                            'Closed_Case_Done'        => $Closed_Case_Done,
                            'Closed_Case_Progress'    => $Closed_Case_Progress,
                            'Pending_Jan_Sept'        => $Pending_Jan_Sept,
                            'Pending_Oktober'         => $Pending_Oktober,
                            'All_Pending'             => $All_Pending,
                            'user'                    => $this->session->userdata("user_login")['username']

                        );

                        $this->db->query("DELETE FROM Div_Layanan.Monitoring_Outstanding_Shortage_BG_Selindo_22 WHERE Kantor_Cabang = '" . $Kantor_Cabang . "'");
                    }
                    // cetak_die($temp_data);
                }
                // $this->load->model('ImportModel');
                $insert = $this->layanan->insert_batch($layanan, $temp_data);
                // lastq();
                if ($insert) {
                    // if ($layanan) {
                        $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Berhasil');
                        redirect('MonitoringOutstandingShortageBGSelindo22');
                    // }
                } else {
                    $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                    redirect('MonitoringOutstandingShortageBGSelindo22');
                }
            } else {
                echo "Tidak ada file yang masuk";
            }

        }

    }
}
