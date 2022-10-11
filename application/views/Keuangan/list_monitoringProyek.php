<form action="<?= base_url('Keuangan/import_excel'); ?>" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    <span <?php echo $My_Controller->savePermission; ?>> </span>

                    <div class="form-group">
                        <label class="col-sm-3 col-form-label">Pilih Table</label>
                        <select class="form-control select2" style="width: 50%;" name="keuangan" id="keuangan" required>
                            <option value="">--Select Tabel--</option>
                            <option value="tbl_summary_rekonsiliasi">Summary Rekonsiliasi</option>
                            <option value="tbl_laporan_vaksin">Laporan Vaksin</option>
                            <option value="monitoring_proyek">Monitoring Proyek</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-form-label">Pilih File Excel</label>
                        <input type="file" name="fileExcel" required>
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
                                <a class="col-sm-" href="Sumrekon" style="color: #013a63;"><b style="color:orange;">|</b> Summary Rekonsiliasi <b style="color:orange;">|</b> </a>
                                <a class="col-sm-" href="Lapvaksin" style="color: #013a63;">Laporan Vaksin <b style="color:orange;">|</b> </a>
                                <a class="col-sm-" href="MonitoringProyek" style="color: #013a63;">Monitoring Proyek <b style="color: orange;">|</b> </a>
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
                                <th>NAMA PROYEK</th>
                                <th>JANUARI 2021</th>
                                <th>FEBRUARI 2021</th>
                                <th>MARET 2021</th>
                                <th>APRIL 2021</th>
                                <th>MEI 2021</th>
                                <th>JUNI 2021</th>
                                <th>JULI 2021</th>
                                <th>AGUSTUS 2021</th>
                                <th>SEPTEMBER 2021</th>
                                <th>OKTOBER 2021</th>
                                <th>NOVEMBER 2021</th>
                                <th>DESEMBER 2021</th>
                                <th>JANUARI 2022</th>
                                <th>FEBRUARI 2022</th>
                                <th>MARET 2022</th>
                                <th>APRIL 2022</th>
                                <th>MEI 2022</th>
                                <th>JUNI 2022</th>
                                <th>JULI 2022</th>
                                <th>AGUSTUS 2022</th>
                                <th>SEPTEMBER 2022</th>
                                <th>OKTOBER 2022</th>
                                <th>NOVEMBER 2022</th>
                                <th>DESEMBER 2022</th>
                                <th>KETERANGAN</th>
                                <th>User</th>
                                <th>Tanggal Update</th>
                        
                            </tr>
                        </thead>
                        <tbody role="alert" aria-live="polite" aria-relevant="all" style="background-color: rgba(1, 42, 74, 0.3);"></tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</form>

<script type="text/javascript">
	const urlMonitoringProyek = '<?= site_url("MonitoringProyek/") ?>';
    let table;

    $(function() {
        if (!$.fn.DataTable.isDataTable('#tableBarang')) {
            table = $('#tableBarang').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                order: [],
                scrollX: true,
                ajax: {
                    url: urlMonitoringProyek + "listMonitoringProyek",
                    type: "POST"
                },
                columnDefs: [{
                    targets: [0, -1],
                    orderable: false,
                }, ],
            });
        }
    });


    $(function() {
        $('.select2').select2();
    })   
</script>