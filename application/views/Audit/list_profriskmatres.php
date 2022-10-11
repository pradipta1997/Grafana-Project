<form action="<?= base_url('Auditinternal/import_excel'); ?>" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <section class="panel">
                <header class="panel-heading">
                    <span <?php echo $My_Controller->savePermission; ?>> </span>

                    <div class="form-group">
                        <label class="col-sm-3 col-form-label">Pilih Table</label>
                        <select class="form-control select2" style="width: 50%;" name="audit" id="audit">
                            <option value="">--Select Tabel--</option>
                            <option value="profile_risk_matrisk_resiko">Profile Risk Matrisk Resiko</option>
                            <option value="monitoring_rpm">Monitor RPM</option>
                            <option value="profile_risk_resiko">Profile Risk Resiko</option>
                            <option value="profile_risk_temuan_kc">Profile Risk Temuan KC</option>
                            <option value="vaksin">Data Vaksin</option>
                            <option value="vaksin_global">Data Vaksin Global</option>
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
                                <a class="col-sm-" href="Profriskmatres" style="color: #013a63;"><b style="color:orange;">|</b> Profile Risk Matrisk Resiko <b style="color:orange;">|</b> </a>
                                <a class="col-sm-" href="Monitorrpm" style="color: #013a63;">Monitor RPM <b style="color:orange;">|</b> </a>
                                <a class="col-sm-" href="Profriskresiko" style="color: #013a63;">Profile Risk Resiko <b style="color:orange;">|</b> </a>
                                <a class="col-sm-" href="Profrisktemkc" style="color: #013a63;">Profile Risk Temuan KC <b style="color:orange;">|</b> </a>
                                <a class="col-sm-" href="DataVaksinAudit" style="color: #013a63;">Data Vaksin <b style="color: orange;">|</b> </a>
                                <a class="col-sm-" href="DataVaksinGlobal" style="color: #013a63;">Data Vaksin Global <b style="color: orange;">|</b> </a>
                                <hr style="border: 1px solid #013a63;">
                            </div>
                        </div>
                    </div>
                </header>
            </section>
                <div class="panel-body">
                    <table id="tableBarang" class="table table-bordered table-striped" style="width: 100%;">
                        <thead style="background-color: #012a4a; color: white;">
                            <tr role="row">
                                <th>No</th>
                                <th>Tahun Audit</th>
                                <th>Kantor Cabang</th>
                                <th>No Temuan</th>
                                <th>Aktivitas</th>
                                <th>Aktivitas 1</th>
                                <th>Sub Aktivitas</th>
                                <th>Judul</th>
                                <th>Kode Risiko</th>
                                <th>Issue Risiko</th>
                                <th>Tipe temuan</th>
                                <th>Kategori Temuan</th>
                                <th>Penyebab (level 1)</th>
                                <th>Penyebab (level 2)</th>
                                <th>Tingkat Penyelesaian</th>
                                <th>Total Loss</th>
                                <th>User</th>
                                <th>Tanggal Update</th>
                                <!-- <th>denom</th>
                                <th>keterangan</th> -->
                            </tr>
                        </thead>
                        <tbody role="alert" aria-live="polite" aria-relevant="all" style="background-color: rgba(1, 42, 74, 0.3);"></tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</form>

<script>
    const urlProfriskmatres = '<?= site_url("Profriskmatres/") ?>';
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
                    url: urlProfriskmatres + "listProfriskmatres",
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