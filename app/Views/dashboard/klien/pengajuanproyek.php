<?= $this->extend('dashboard/klien/template'); ?>
<?= $this->section('dashboardklien'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Ajuan Proyek Anda</h1>
                </div>
            </div>
        </div>
    </section>
    <div class="container">
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
                                    <th>Nama Pengaju</th>
                                    <th>Jenis Proyek</th>
                                    <th>Lokasi Proyek</td>
                                    <th>Catatan</th>
                                    <th>Status</th>
                                </thead>
                                <tbody>
                                    <?php $no = 1 ?>
                                    <?php foreach ($ajuanklien as $ajuan) : ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $ajuan['namaproyek']; ?></td>
                                            <td><?= $ajuan['nama']; ?></td>
                                            <td><?= $ajuan['jenisproyek']; ?></td>
                                            <td><?= $ajuan['lokasiproyek']; ?></td>
                                            <td><?= $ajuan['catatanproyek']; ?></td>
                                            <?php if ($ajuan['status_id'] == '1') : ?>
                                                <td><span class="badge badge-secondary">Belum Ditinjau</span></td>
                                            <?php elseif ($ajuan['status_id'] == '2') : ?>
                                                <td><span class="badge badge-primary">Diterima</span></td>
                                            <?php elseif ($ajuan['status_id'] == '3') : ?>
                                                <td><span class="badge badge-danger">Ditolak</span></td>
                                            <?php elseif ($ajuan['status_id'] == '4') : ?>
                                                <td><span class="badge badge-success">Dikerjakan</span></td>
                                            <?php endif; ?>
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
</div>
<?= $this->endSection(); ?>