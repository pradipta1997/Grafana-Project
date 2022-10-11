<form action="<?= base_url('PSD/import_excel'); ?>" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    <span <?php echo $My_Controller->savePermission; ?>> </span>

                    <div class="form-group">
                        <label class="col-sm-3 col-form-label">Pilih Table</label>
                        <select class="form-control select2" style="width: 50%;" name="psd" id="psd">
                            <option value="">--Select Tabel--</option>
                            <option value="control_masa_STNK_kendaraan">Control Masa STNK Kendaraan</option>
                            <option value="rekap_SDM_karyawan_cro">SDM Karyawan CRO</option>
                            <option value="rekap_SDM_karyawan_cit">SDM Karyawan CIT</option>
                            <option value="rekap_SDM_satpam_bg">Rekap SDM Satpam BG</option>
                            <option value="rekap_SDM_pertumbuhan_atm">Rekap SDM Pertumbuhan ATM</option>
                            <option value="register_penugasan_2021">Register Penugasan 2021</option>
                            <option value="data_vaksin_pt_bg">Laporan Vaksin</option>
                            <option value="data_non_vaksin_pt_bg">Laporan Non Vaksin</option>
                            <option value="daftar_pekerja_terdaftar_vaksin_dan_sudah_di_vaksin">Pekerja Terdaftar Vaksin dan Sudah di Vaksin</option>
                            <option value="rekap_pekerja_tdk_masuk_bg">Pekerja Tidak Masuk BG</option>
                            <option value="data_pembina">Data Pembina</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-form-label">Pilih File Excel</label>
                        <input type="file" name="fileExcel">
                    </div>
                    <div class="row text-center" style="margin-bottom: 20px;">
                    <button type="submit" id='addBarang' class="btn btn-info" >
                        Import <i class="fa fa-plus"></i>
                    </button>
                    </div>
                    <hr style="border: 1px solid #013a63;">
                    <div class="form-group">
                        <div class="col-sm" style="width: 100%;">
                            <div>
                                <a class="col-sm-" href="Contstnkkend" style="color: #013a63;"> <b style="color:orange;">|</b> Control Masa STNK Kendaraan <b style="color:orange;">|</b> </a>
                                <a class="col-sm-" href="Sdmkaryawancro" style="color: #013a63;">SDM Karyawan CRO <b style="color:orange;">|</b> </a>
                                <a class="col-sm-" href="Sdmkaryawancit" style="color: #013a63;">SDM Karyawan CIT <b style="color:orange;">|</b> </a>
                                <a class="col-sm-" href="Reksatpambg" style="color: #013a63;">Rekap SDM Satpam BG <b style="color:orange;">|</b> </a>
                                <a class="col-sm-" href="Reksdmperatm" style="color: #013a63;">Rekap SDM Pertumbuhan ATM <b style="color:orange;">|</b> </a>
                                <a class="col-sm-" href="Regpenugasan2021" style="color: #013a63;">Register Penugasan 2021 <b style="color:orange;">|</b> </a>
                                <br><hr style="border: 1px solid #013a63;">
                                <a class="col-sm-" href="Vaksinpsd" style="color: #013a63;">Laporan Vaksin <b style="color:orange;">|</b> </a>
                                <a class="col-sm-" href="Nonvaksinpsd" style="color: #013a63;">Laporan Non Vaksin <b style="color:orange;">|</b> </a>
                                <a class="col-sm-" href="Pektervak" style="color: #013a63;">Pekerja Terdaftar Vaksin dan Sudah di Vaksin <b style="color:orange;">|</b> </a>
                                <a class="col-sm-" href="Rekpektdkmsk" style="color: #013a63;">Pekerja Tidak Masuk BG <b style="color:orange;">|</b> </a>
                                <a class="col-sm-" href="Datapembina" style="color: #013a63;">Data Pembina <b style="color:orange;">|</b> </a>
                                <hr style="border: 1px solid #013a63;">
                            </div>
                        </div>
                    </div>
                </header>
                <div class="panel-body">
                    <table id="tableBarang" class="table table-bordered table-striped" style="width: 100%;">
                        <thead style="background-color: #012a4a; color: white;">
                            <tr role="row">
                                <th>No</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Penugasan</th>
                                <th>Lokasi Penugasan</th>
                                <th>No SK Penugasan</th>
                                <th>Tanggal SK Penugasan</th>
                                <th>Penugasan Dari</th>
                                <th>Penugasan Sampai</th>
                                <th>Periode</th>
                                <th>User</th>
                                <th>Tanggal Update</th>
                            </tr>
                        </thead>
                        <tbody role="alert" aria-live="polite" aria-relevant="all" style="background-color: rgba(1, 42, 74, 0.3);">
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</form>

<script>
    const urlRegpenugasan2021 = '<?= site_url("Regpenugasan2021/") ?>';
    let table;

    $(function() {
        $('.select2').select2();
    })

    $(function() {
        if (!$.fn.DataTable.isDataTable('#tableBarang')) {
            table = $('#tableBarang').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                order: [],
                scrollX: true,
                ajax: {
                    url: urlRegpenugasan2021 + "listRegpenugasan2021",
                    type: "POST"
                },
                columnDefs: [{
                    targets: [0, -1],
                    orderable: false,
                }, ],
            });
        }
    });
</script>