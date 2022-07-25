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
                        <table class="table table-striped ">
                            <thead>
                                <th>No</th>
                                <th>Nama Proyek</th>
                                <th>Jenis Proyek</th>
                                <th>Lokasi Proyek</th>
                                <th>Nama Klien</th>
                                <th>Alamat</th>
                                <th>No Telpon</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
                                <?php $Nomer = 1; ?>
                                <?php foreach ($dataajuan as $ajuan) : ?>
                                    <tr>
                                        <td><?= $Nomer++; ?></td>
                                        <td><?= $ajuan->namaproyek; ?></td>
                                        <td><?= $ajuan->jenisproyek; ?></td>
                                        <td><?= $ajuan->lokasiproyek; ?></td>
                                        <td><?= $ajuan->nama; ?></td>
                                        <td><?= $ajuan->alamat; ?></td>
                                        <td><?= $ajuan->notelp; ?></td>
                                        <?php if ($ajuan->status_id == '1') : ?>
                                            <td><span class="badge badge-secondary"><?= $ajuan->keterangan; ?></span></td>
                                        <?php elseif ($ajuan->status_id == '2') : ?>
                                            <td><span class="badge badge-primary"><?= $ajuan->keterangan; ?></span></td>
                                        <?php elseif ($ajuan->status_id == '3') : ?>
                                            <td><span class="badge badge-danger"><?= $ajuan->keterangan; ?></span></td>
                                        <?php endif; ?>
                                        <td><a class="btn btn-sm btn-success">Detail</a>
                                            <?php if ($ajuan->status_id == '1') : ?>
                                                <button class="btn btn-sm btn-primary terima" data-namaproyek="<?= $ajuan->namaproyek; ?>" data-namaklien="<?= $ajuan->nama; ?>" data-idajuan="<?= $ajuan->idajuan; ?>">Terima </button>
                                                <button data-namaproyek="<?= $ajuan->namaproyek; ?>" data-namaklien="<?= $ajuan->nama; ?>" data-idajuan="<?= $ajuan->idajuan; ?>" class="btn btn-sm btn-danger tolak">Tolak</button>
                                            <?php elseif ($ajuan->status_id == '3') : ?>
                                                <button data-namaproyek="<?= $ajuan->namaproyek; ?>" data-namaklien="<?= $ajuan->nama; ?>" data-idajuan="<?= $ajuan->idajuan; ?>" class="btn btn-sm btn-danger hapusajuan">Hapus</button>
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

</div>

<?= $this->endSection(); ?>