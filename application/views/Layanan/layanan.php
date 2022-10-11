<form action="<?= base_url('Layanan/import_excel'); ?>" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-sm-12">
            <section class="panel" style="background-color: #012a4a; color:#FFF;">
                <header class="panel-heading">
                    <span <?php echo $My_Controller->savePermission; ?>> </span>

                    <div class="form-group">
                        <label class="col-sm-3 col-form-label">Pilih Table</label>
                        <select class="form-control select2" style="width: 50%;" name="layanan" id="layanan">
                            <option value="">--Select Tabel--</option>
                            <option value="data_segel_tas">Data Segel Tas (DSP)</option>
                            <option value="gps_kendaraan">GPS Kendaraan (DSP)</option>
                            <option value="kendaraan">Kendaraan (DSP)</option>
                            <option value="tbl_mhu_dan_msu">MHU & MSU (DSP)</option>
                            <option value="rekap_analisa_kc_non_cro_cit">Rekap Analisa KC Non CRO CIT (DSP)</option>
                            <option value="rekap_analisa_kc_total">Rekap Analisa KC Total (DSP)</option>
                            <option value="rekap_kinerja_kc_cit">Rekap Kinerja KC CIT (DSP)</option>
                            <option value="rekap_kinerja_kc_cro">Rekap Kinerja KC CRO (DSP)</option>
                            <option value="rekap_persedian_log_kc">Rekap Persediaan Log KC (DSP)</option>
                            <option value="tb_vaksin">Data Vaksin (DSP)</option>
                            <!-- <option value="tb_vaksin">Data Laporan Vaksin (DSP)</option> -->

                            <option value="tbl_data_kas">Data Kas (ANEV)</option>
                            <option value="tbl_masterkas">Master Kas (ANEV)</option>
                            <option value="rekap_bank_bjb">Rekap Bank BJB (ANEV)</option>
                            <option value="rekap_cr_bank_bjb">Rekap CR Bank BJB (ANEV)</option>
                            <option value="rekap_flm_bank_bjb">Rekap FLM Bank BJB (ANEV)</option>
                            <option value="rekap_biaya_cr_flm_bank_bjb">Rekap Biaya CR FLM Bank BJB (ANEV)</option>
                            <option value="harga_kegiatan_bank_bjb">Harga Kegiatan Bank BJB (ANEV)</option>
                            <option value="rekap_analisa_problem_kc_selindo">Rekap Analisa Problem KC Selindo (ANEV)</option>
                            <option value="rekap_flm_bg_selindo">Rekap FLM BG Selindo (ANEV)</option>
                            <option value="rekap_rpl_bg_selindo">Rekap RPL BG Selindo (ANEV)</option>
                            <option value="rekon_atm_bank_bjb">Rekon ATM Bank BJB (ANEV)</option>
                            <option value="rekon_flm_bank_bjb">Rekon FLM Bank BJB (ANEV)</option>
                            <option value="data_sm">Data SM (ANEV)</option>
                            <option value="reliability_harian_bg">Reability Harian BG (ANEV)</option>
                            <option value="reability_harian_bg_kolaborasi">Reability Harian BG Kolaborasi (ANEV)</option>
                            <option value="rekap_presentase_return_rpl_kl_selindo">Rekap Presentase Return RPL KL Selindo (ANEV)</option>
                            <option value="proyeksi_nilai_sanggahan">Proyeksi Nilai Sanggahan (ANEV)</option>
                            <option value="update_cro_crm">Update CRO CRM (ANEV)</option>
                            <option value="performance_slm_bg_jalin">Performance SLM BG Jalin (ANEV)</option>
                            <option value="rekap_laporan_posisi_kas_utle_bg">Rekap Laporan Posisi Kas UTLE BG (ANEV/Weekly)</option>
                            <option value="posisi_saldo_kas_sortir">Posisi Saldo Kas Sortir (ANEV/Weekly)</option>
                            <option value="update_kirim_ba_ho_bjb">Update Kirim BA HO BJB (ANEV/Weekly)</option>
                            <option value="rekap_data_pm">Rekap Data PM (ANEV/Weekly)</option>
                            <option value="rekap_data_sm">Rekap Data SM (ANEV/Weekly)</option>
                            <option value="rekap_maintenance_cctv_atm">Rekap Maintenance CCTV ATM (ANEV/Weekly)</option>
                            <option value="denda_return_jabodetabek">Denda Return JABODETABEK (ANEV/Monthly)</option>
                            <option value="rekap_data_performance_cluster_bulanan">Rekap Data Performance Cluster Bulanan (ANEV/Monthly)</option>
                            <option value="rekap_penggunaan_sparepart">Rekap Penggunaan Sparepart (ANEV/Monthly)</option>
                            <option value="rekap_rpl_bank_bjb">Rekap RPL Bank BJB (ANEV/Monthly)</option>
                            <option value="data_vandalisme_relokasi">Data Vandalisme & Relokasi (ANEV/Daily)</option>
                            <option value="format_proyeksi_kebutuhan_kas_bg_selindo">Format Proyeksi Kebutuhan Kas BG Selindo (ANEV/Daily)</option>
                            <option value="rekap_ej_bg_selindo">Rekap EJ BG Selindo (ANEV/Daily)</option>
                            <option value="rekap_saldo_dsr_cro_bjb">Rekap Saldo DSR CRO BJB (ANEV/Daily)</option>
                            <option value="rekap_saldo_dsr_cro_bri">Rekap Saldo DSR CRO BRI (ANEV/Daily)</option>
                            <option value="saldo_restocking_terpusat">Saldo Restocking Terpusat (ANEV/Daily)</option>
                            <option value="saldo_restocking">Saldo Restocking (ANEV/Daily)</option>

                            <option value="tbl_rekap_shortage">Rekap Shortage (RDI)</option>
                            <option value="Closed_Case_shortage_Januari_Oktober_berdasarkan_kategori_kasus">Closed Case Shortage Berdasarkan Kategori Kasus Tahunan (RDI)</option>
                            <option value="Closed_Case_shortage_September_berdasarkan_kategori_kasus">Closed Case Shortage Berdasarkan Kategori Kasus Bulanan (RDI)</option>
                            <option value="Update_Kategori_kasus_Closed_Case_Frekuensi">Update Kategori Kasus Closed Case Frekuensi (RDI)</option>
                            <option value="Update_Kategori_kasus_Closed_Case_Nominal">Update Kategori Kasus Closed Case Nominal (RDI)</option>
                            <option value="Monitoring_Instruksi_Investigasi_Shortage_BG_Selindo">Monitoring Instruksi Investigasi Shortage BG Selindo (RDI)</option>
                            <option value="Monitoring_Outstanding_Shortage_BG_Selindo">Monitoring Outstanding Shortage BG Selindo 2021 (RDI)</option>
                            <option value="Monitoring_Outstanding_Shortage_BG_Selindo_22">Monitoring Outstanding Shortage BG Selindo 2022 (RDI)</option>
                            <option value="Grafik_Progress_dan_Pending_CaseCabang">Grafik Progress & Pending Case Cabang (RDI)</option>

                            <option value="update_data_alat_alarm_system_dan_acces_door">Update Data Alat Alarm System & Acces Door (SIU)</option>
                            <option value="update_data_cctv_kolaborasi">Update Data CCTV Kolaborasi (SIU)</option>
                            <option value="update_data_kecelakaan">Update Data Kecelakaan (SIU)</option>
                            <option value="update_data_passthru">Update Data Passthru (SIU)</option>
                            <option value="update_data_petugas_satpam">Update Data Petugas Satpam (SIU)</option>
                            <option value="update_data_simcard_pada_alat_alarm_system">Update Data Simcard Pada Alat Alarm System (SIU)</option>
                            <option value="update_data_temuan_unit_siu">Update Data Temuan Unit SIU (SIU)</option>
                            <option value="rekap_monitoring_pelanggaran_sop_kc_selindo">Rekap Monitoring Pelanggaran SOP KC Selindo (SIU)</option>
                            <option value="update_acces_door_kantor_kolaborasi">Update Acces Door Kantor Kolaborasi (SIU)</option>
                        </select>
                    </div>
                    

                    <div class="form-group">
                        <label class="col-sm-3 col-form-label">Pilih File Excel</label>
                        <input type="file" name="fileExcel">
                    </div>
                    <div class="row text-center" style="margin-bottom: 20px;">
                    <button type="submit" id='addBarang' class="btn btn-info " >
                        Import <i class="fa fa-plus"></i>
                    </button>
                    </div>
                    <hr>
                    <div class="form-group">
                        <div class="col-sm" style="width: 100%;">
                            <div>
                                <a class="col-sm-" href="Gpskendaraan" style="color: white;"><b style="color:orange;">|</b> GPS Kendaraaan <b style="color:orange;"> (DSP) |</b> </a>
                                <a class="col-sm-" href="Datasegeltas" style="color: white;">Data Segel Tas <b style="color:orange;"> (DSP) |</b> </a>
                                <a class="col-sm-" href="Kendaraan" style="color: white;">Kendaraan <b style="color:orange;"> (DSP) |</b> </a>
                                <a class="col-sm-" href="Mhumsu" style="color: white;">MHU & MSU <b style="color:orange;"> (DSP) |</b> </a>
                                <a class="col-sm-" href="Rekanalisakcnoncrocit" style="color: white;">Rekap Analisa KC Non CRO CIT <b style="color:orange;"> (DSP) |</b> </a>
                                <a class="col-sm-" href="Rekapanalisakctotal" style="color: white;">Rekap Analisa KC Total <b style="color:orange;"> (DSP) |</b> </a>
                                <a class="col-sm-" href="Rekkinerjakccit" style="color: white;">Rekap Kinerja KC CIT <b style="color:orange;"> (DSP) |</b> </a>
                                <a class="col-sm-" href="Rekkinerjakccro" style="color: white;">Rekap Kinerja KC CRO <b style="color:orange;"> (DSP) |</b> </a>
                                <a class="col-sm-" href="Rekpersedianlogkc" style="color: white;">Rekap Persediaan Log KC <b style="color:orange;"> (DSP) |</b> </a>
                                <a class="col-sm-" href="DataVaksin" style="color: white;">Data Vaksin <b style="color:orange;"> (DSP) |</b> </a>

                                <br> <hr>
                                
                                <a class="col-sm-" href="Datakas" style="color: white;">Data Kas <b style="color:orange;"> (ANEV) |</b> </a>
                                <a class="col-sm-" href="Masterkas" style="color: white;">Master Kas <b style="color:orange;"> (ANEV) |</b> </a>
                                <a class="col-sm-" href="Rekapbankbjb" style="color: white;">Rekap Bank BJB <b style="color:orange;"> (ANEV) |</b> </a>
                                <a class="col-sm-" href="Rekapcrbankbjb" style="color: white;">Rekap CR Bank BJB <b style="color:orange;"> (ANEV) |</b> </a>
                                <a class="col-sm-" href="Rekapflmbankbjb" style="color: white;">Rekap FLM Bank BJB <b style="color:orange;"> (ANEV) |</b> </a>
                                <a class="col-sm-" href="Rekapbiayacrflmbjb" style="color: white;">Rekap Biaya CR FLM Bank BJB <b style="color:orange;"> (ANEV) |</b> </a>
                                <a class="col-sm-" href="Hargakegiatanbankbjb" style="color: white;">Harga Kegiatan Bank BJB <b style="color:orange;"> (ANEV) |</b> </a>
                                <br>
                                <a class="col-sm-" href="Rekanalisaproblemkcselindo" style="color: white;">Rekap Analisa Problem KC Selindo <b style="color:orange;"> (ANEV) |</b> </a>
                                <a class="col-sm-" href="Rekflmbgselindo" style="color: white;">Rekap FLM BG Selindo <b style="color:orange;"> (ANEV) |</b> </a>
                                <a class="col-sm-" href="Rekrplbgselindo" style="color: white;">Rekap RPL BG Selindo <b style="color:orange;"> (ANEV) |</b> </a>
                                <a class="col-sm-" href="Rekatmbankbjb" style="color: white;">Rekon ATM Bank BJB <b style="color:orange;"> (ANEV) |</b> </a>
                                <a class="col-sm-" href="Rekflmbankbjb" style="color: white;">Rekon FLM Bank BJB <b style="color:orange;"> (ANEV) |</b> </a>
                                <a class="col-sm-" href="Datasm" style="color: white;">Data SM <b style="color:orange;"> (ANEV) |</b> </a>
                                <br>
                                <a class="col-sm-" href="ReliabilityHarianBG" style="color: white;">Reliability Harian BG <b style="color:orange;"> (ANEV) |</b> </a>
                                <a class="col-sm-" href="ReliabilityHarianBGKolaborasi" style="color: white;">Reliability Harian BG Kolaborasi <b style="color:orange;"> (ANEV) |</b> </a>
                                <a class="col-sm-" href="RekapPresentaseReturnRPL" style="color: white;">Rekap Presentase Return RPL KL Selindo <b style="color:orange;"> (ANEV) |</b> </a>
                                <a class="col-sm-" href="ProyeksiNilaiSanggahan" style="color: white;">Proyeksi Nilai Sanggahan <b style="color:orange;"> (ANEV) |</b> </a>
                                <a class="col-sm-" href="UpdateCROCRM" style="color: white;">Update CRO CRM <b style="color:orange;"> (ANEV) |</b> </a>
                                <a class="col-sm-" href="PerformanceSLMBGJalin" style="color: white;">Performance SLM BG Jalin <b style="color:orange;"> (ANEV) |</b> </a>
                                <a class="col-sm-" href="RekapLaporanPosisiKasUTLE" style="color: white;">Rekap Laporan Posisi Kas UTLE BG <b style="color:orange;"> (ANEV/Weekly) |</b> </a>
                                <a class="col-sm-" href="PosisiSaldoKasSortir" style="color: white;">Posisi Saldo Kas Sortir <b style="color:orange;"> (ANEV/Weekly) |</b> </a>
                                <a class="col-sm-" href="UpdateKirimBAHOBJB" style="color: white;">Update Kirim BA HO BJB <b style="color:orange;"> (ANEV/Weekly) |</b> </a>
                                <a class="col-sm-" href="RekapDataPM" style="color: white;">Rekap Data PM <b style="color:orange;"> (ANEV/Weekly) |</b> </a>
                                <a class="col-sm-" href="RekapDataSM" style="color: white;">Rekap Data SM <b style="color:orange;"> (ANEV/Weekly) |</b> </a>
                                <a class="col-sm-" href="RekapMaintenanceCCTVATM" style="color: white;">Rekap Maintenance CCTV ATM <b style="color:orange;"> (ANEV/Weekly) |</b> </a>
                                <a class="col-sm-" href="DendaReturnJabodetabek" style="color: white;">Denda Return JABODETABEK <b style="color:orange;"> (ANEV/Monthly) |</b> </a>
                                <a class="col-sm-" href="RekapDataPerformanceClusterBulanan" style="color: white;">Rekap Data Performance Cluster Bulanan <b style="color:orange;"> (ANEV/Monthly) |</b> </a>
                                <a class="col-sm-" href="RekapPenggunaaSparepart" style="color: white;">Rekap Penggunaan Sparepart <b style="color:orange;"> (ANEV/Monthly) |</b> </a>
                                <a class="col-sm-" href="RekapRPLBankBJB" style="color: white;">Rekap RPL Bank BJB <b style="color:orange;"> (ANEV/Monthly) |</b> </a>
                                <a class="col-sm-" href="DataVandalismeRelokasi" style="color: white;">Data Vandalisme & Relokasi <b style="color:orange;"> (ANEV/Daily) |</b> </a>
                                <a class="col-sm-" href="FormatProyeksiKebutuhanKasBGSelindo" style="color: white;">Format Proyeksi Kebutuhan Kas BG Selindo <b style="color:orange;"> (ANEV/Daily) |</b> </a>
                                <a class="col-sm-" href="RekapEJBGSelindo" style="color: white;">Rekap EJ BG Selindo <b style="color:orange;"> (ANEV/Daily) |</b> </a>
                                <br>
                                <a class="col-sm-" href="RekapSaldoDSRCROBJB" style="color: white;">Rekap Saldo DSR CRO BJB <b style="color:orange;"> (ANEV/Daily) |</b> </a>
                                <a class="col-sm-" href="RekapSaldoDSRCROBRI" style="color: white;">Rekap Saldo DSR CRO BRI <b style="color:orange;"> (ANEV/Daily) |</b> </a>
                                <a class="col-sm-" href="SaldoRestockingTerpusat" style="color: white;">Saldo Restocking Terpusat <b style="color:orange;"> (ANEV/Daily) |</b> </a>
                                <a class="col-sm-" href="SaldoRestocking" style="color: white;">Saldo Restocking <b style="color:orange;"> (ANEV/Daily) |</b> </a>

                                <br> <hr>

                                <a class="col-sm-" href="Rekapshortage" style="color: white;">Rekap Shortage <b style="color:orange;"> (RDI) |</b> </a>
                                <a class="col-sm-" href="ClosedCaseShortageJanuariOktober" style="color: white;">Closed Case Shortage Berdasarkan Kategori Kasus Tahunan <b style="color:orange;"> (RDI) |</b> </a>
                                <a class="col-sm-" href="ClosedCaseShortageSeptember" style="color: white;">Closed Case Shortage Berdasarkan Kategori Kasus Bulanan <b style="color:orange;"> (RDI) |</b> </a>
                                <a class="col-sm-" href="UpdateKategoriKasusClosedCaseFrekuensi" style="color: white;">Update Kategori Kasus Closed Case Frekuensi <b style="color:orange;"> (RDI) |</b> </a>
                                <a class="col-sm-" href="UpdateKategoriKasusClosedCaseNominal" style="color: white;">Update Kategori Kasus Closed Case Nominal <b style="color:orange;"> (RDI) |</b> </a>
                                <a class="col-sm-" href="MonitoringInstruksiInvestigasiShortageBGSelindo" style="color: white;">Monitoring Instruksi Investigasi Shortage BG Selindo <b style="color:orange;"> (RDI) |</b> </a>
                                <a class="col-sm-" href="MonitoringOutstandingShortageBGSelindo" style="color: white;">Monitoring Outstanding Shortage BG Selindo 2021 <b style="color:orange;"> (RDI) |</b> </a>
                                <a class="col-sm-" href="MonitoringOutstandingShortageBGSelindo22" style="color: white;">Monitoring Outstanding Shortage BG Selindo 2022 <b style="color:orange;"> (RDI) |</b> </a>
                                <a class="col-sm-" href="GrafikProgressdanPendingCaseCabang" style="color: white;">Grafik Progress & Pending Case Cabang <b style="color:orange;"> (RDI) |</b> </a>
                            
                                <br> <hr>

                                <a class="col-sm-" href="UpdatedataAlatAlarmSystemDanAccesDoor" style="color: white;">Update Data Alat Alarm System & Acces Door <b style="color:orange;"> (SIU) |</b> </a>
                                <a class="col-sm-" href="UpdateDataCctvKolaborasi" style="color: white;">Update Data CCTV Kolaborasi <b style="color:orange;"> (SIU) |</b> </a>
                                <a class="col-sm-" href="UpdateDataKecelakaan" style="color: white;">Update Data Kecelakaan <b style="color:orange;"> (SIU) |</b> </a>
                                <a class="col-sm-" href="UpdateDataPassthru" style="color: white;">Update Data Passthru <b style="color:orange;"> (SIU) |</b> </a>
                                <a class="col-sm-" href="UpdateDataPetugasSatpam" style="color: white;">Update Data Petugas Satpam <b style="color:orange;"> (SIU) |</b> </a>
                                <a class="col-sm-" href="UpdateDataSimcardAlatAlarmSystem" style="color: white;">Update Data Simcard Pada Alat Alarm System <b style="color:orange;"> (SIU) |</b> </a>
                                <a class="col-sm-" href="UpdateDataTemuanUnitSiu" style="color: white;">Update Data Temuan Unit SIU <b style="color:orange;"> (SIU) |</b> </a>
                                <a class="col-sm-" href="RekapMonitoringPelanggaranSOPkcSelindo" style="color: white;">Rekap Monitoring Pelanggaran SOP KC Selindo <b style="color:orange;"> (SIU) |</b> </a>
                                <a class="col-sm-" href="UpdateAccesDoorKantorKolaborasi" style="color: white;">Update Acces Door Kantor Kolaborasi <b style="color:orange;"> (SIU) |</b> </a>

                                <br> <hr>

                            </div>
                        </div>
                    </div>
                </header>
                
            </section>
        </div>
    </div>
</form>

<script type="text/javascript">
     $(function() {
        $('.select2').select2();
    })
</script>