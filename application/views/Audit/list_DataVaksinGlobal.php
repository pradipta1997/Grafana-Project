<form action="<?= base_url('Auditinternal/import_excel'); ?>" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-sm-12">
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
                <div class="panel-body">
                    <table id="tableBarang" class="table table-bordered table-striped" style="width: 100%;">
                        <thead style="background-color: #012a4a; color: white;">
                            <tr role="row">
                                <th>No</th>
                                <th>Indonesia (Status Covid19)</th>
                                <th>Indonesia (Penambahan)</th>
                                <th>Indonesia (Total)</th>
                                <th>Indonesia (Persentase)</th>
                                <th>Jakarta (Penambahan)</th>
                                <th>Jakarta (Total)</th>
                                <th>Jakarta (Persentase)</th>
                                <th>BG (Status Covid-19)</th>
                                <th>BG (Penambahan)</th>
                                <th>BG (Total)</th>
                                <th>BG (Persentase)</th>
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

<script>
    const urlDataVaksinGlobal = '<?= site_url("DataVaksinGlobal/") ?>';
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
                    url: urlDataVaksinGlobal + "listDataVaksinGlobal",
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