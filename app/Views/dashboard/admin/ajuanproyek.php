<?= $this->extend('dashboard/admin/template'); ?>
<?= $this->section('dashboardadmin'); ?>
<div class="content-wrapper">
    <div class="flashdata" data-pesan="<?= session()->getFlashdata('pesan'); ?>" data-namaproyek="<?= session()->getFlashdata('namaproyek'); ?>" data-namaklien="<?= session()->getFlashdata('namaklien'); ?>"></div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Ajuan Proyek Klien</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tableajuan" class="table table-striped table-sm ">
                            <thead>
                                <th>No</th>
                                <th>Id Ajuan</th>
                                <th>Nama Proyek</th>
                                <th>Jenis Proyek</th>
                                <th>Lokasi Proyek</th>
                                <th>Nama Klien</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
                                <?php $Nomer = 1; ?>
                                <?php foreach ($dataajuan as $ajuan) : ?>
                                    <tr>
                                        <td><?= $Nomer++; ?></td>
                                        <td><?= $ajuan->idajuan; ?></td>
                                        <td><?= $ajuan->namaproyek; ?></td>
                                        <td><?= $ajuan->jenisproyek; ?></td>
                                        <td><?= $ajuan->lokasiproyek; ?></td>
                                        <td><?= $ajuan->nama; ?></td>
                                        <?php if ($ajuan->status_id == '1') : ?>
                                            <td><span class="badge badge-secondary"><?= $ajuan->keterangan; ?></span></td>
                                        <?php elseif ($ajuan->status_id == '2') : ?>
                                            <td><span class="badge badge-primary"><?= $ajuan->keterangan; ?></span></td>
                                        <?php elseif ($ajuan->status_id == '3') : ?>
                                            <td><span class="badge badge-danger"><?= $ajuan->keterangan; ?></span></td>
                                        <?php elseif ($ajuan->status_id == '4') : ?>
                                            <td><span class="badge badge-success"><?= $ajuan->keterangan; ?></span></td>
                                        <?php endif; ?>
                                        <td><a class="btn btn-sm btn-success detailajuan" data-toggle="modal" data-target="#exampleModal" data-idajuan="<?= $ajuan->idajuan; ?>">Detail</a>
                                            <?php if ($ajuan->status_id == '1') : ?>
                                                <button class=" btn btn-sm btn-primary terima" data-namaproyek="<?= $ajuan->namaproyek; ?>" data-namaklien="<?= $ajuan->nama; ?>" data-idajuan="<?= $ajuan->idajuan; ?>">Terima </button>
                                                <button data-namaproyek="<?= $ajuan->namaproyek; ?>" data-namaklien="<?= $ajuan->nama; ?>" data-idajuan="<?= $ajuan->idajuan; ?>" class="btn btn-sm btn-danger tolak">Tolak</button>
                                            <?php elseif ($ajuan->status_id == '3') : ?>
                                                <button data-namaproyek="<?= $ajuan->namaproyek; ?>" data-namaklien="<?= $ajuan->nama; ?>" data-idajuan="<?= $ajuan->idajuan; ?>" class="btn btn-sm btn-warning hapusajuan">Hapus</button>
                                            <?php endif ?>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>

                        </table>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <!-- Modal -->
    <section>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Detail Ajuan Proyek</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <strong><i class="fas fa-book mr-1"></i>Nama Proyek</strong> <strong>(Id Ajuan:<span class="detailidajuan">1</span>)</strong>
                                        <p class="text-muted detailnamaproyek mr-1">
                                        </p>
                                    </div>
                                    <div class="col">
                                        <strong><i class="fas fa-info mr-1"></i>Status</strong>
                                        <p class="mr-1">
                                            <span class="badge detailnamastatus"></span>
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col">
                                        <strong><i class="fas fa-briefcase mr-1"></i>Jenis Proyek</strong>
                                        <p class="text-muted detailjenisproyek mr-1">
                                        </p>
                                    </div>
                                    <div class="col">
                                        <strong><i class="fas fa-map-marker-alt mr-1"></i>Lokasi Proyek</strong>
                                        <p class="text-muted detaillokasiproyek mr-1">
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col">
                                        <strong><i class="fas fa-user mr-1"></i>Nama Pengaju(Klien)</strong><strong>(id_user:<span class="detailiduser">1</span>)</strong>
                                        <p class="text-muted detailnama mr-1">
                                        </p>
                                    </div>
                                    <div class="col">
                                        <strong><i class="fas fa-envelope mr-1"></i>Email Klien</strong>
                                        <p class="text-muted detailemail mr-1">
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col">
                                        <strong><i class="fas fa-home mr-1"></i>Alamat Klien</strong>
                                        <p class="text-muted detailalamat mr-1">
                                        </p>
                                    </div>
                                    <div class="col">
                                        <strong><i class="fas fa-phone mr-1"></i>No Telepon</strong>
                                        <p class="text-muted detailtelp mr-1">
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <strong><i class="far fa-file-alt mr-1"></i>Catatan</strong>
                                <p class="text-muted detailcatatanproyek">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-detailid="5" class="btn btn-primary detailcreate">Create Project</button>
                        <button type="button" data-detailid="5" class="btn btn-primary detailterima">Terima</button>
                        <button type="button" data-detailid="5" class="btn btn-danger detailtolak">Tolak</button>
                        <button type="button" data-detailid="5" class="btn btn-warning detailhapus">Hapus</button>
                    </div>
                </div>

            </div>
        </div>

    </section>

</div>
<script src="<?= base_url('js/myscript.js'); ?>"></script>
<script>
    $(document).ready(function() {
        $('#tableajuan').DataTable({
            "pageLength": 5,
            "columnDefs": [{
                orderable: false,
                targets: [1, 2, 3, 4, 5, 6, 7]
            }],
            "fixedColumns": {
                leftColumns: 1,
                rightColumns: 1
            },
        });
    })
</script>
<?= $this->endSection(); ?>