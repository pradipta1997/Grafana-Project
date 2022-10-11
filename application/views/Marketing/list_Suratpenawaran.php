<form action="<?= base_url('Marketing/import_excel'); ?>" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    <span <?php echo $My_Controller->savePermission; ?>> </span>

                    <div class="form-group">
                        <label class="col-sm-3 col-form-label">Pilih Table</label>
                        <select class="form-control select2" style="width: 50%;" name="marketing" id="marketing">
                            <option value="">--Select Tabel--</option>
                            <option value="inisiasi_proyek">Inisiasi Proyek</option>
                            <option value="laporan_vaksin">Laporan Vaksin</option>
                            <option value="surat_penawaran">Surat Penawaran</option>
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
                                <a class="col-sm-" href="Inisiasiproyek" style="color: #013a63;"><b style="color:orange;">|</b> Inisiasi Proyek <b style="color:orange;">|</b> </a>
                                <a class="col-sm-" href="Laporanvaksin" style="color: #013a63;">Laporan Vaksin <b style="color:orange;">|</b> </a>
                                <a class="col-sm-" href="" style="color: #013a63;">Surat Penawaran <b style="color:orange;">|</b> </a>
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
                                <th>Projek</th>
                                <th>Deskripsi</th>
                                <th>Keterangan</th>
                                <th>Penawaran</th>
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
    const urlSuratpenawaran = '<?= site_url("Suratpenawaran/") ?>';
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
                    url: urlSuratpenawaran + "listSuratpenawaran",
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