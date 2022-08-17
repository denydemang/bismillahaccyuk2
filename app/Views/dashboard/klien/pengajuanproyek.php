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
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <th>No</th>
                                    <th>Nama Proyek</th>
                                    <th>Nama Pengaju</th>
                                    <th>Jenis Proyek</th>
                                    <th>Lokasi Proyek</th>
                                    <th>File RAB</th>
                                    <th>Status</th>
                                    <th>#</th>
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
                                            <?php if (empty($ajuan['file_admin'])) : ?>
                                                <td>Belum Ada File</td>
                                            <?php else : ?>
                                                <td><?= $ajuan['file_admin']; ?></td>
                                            <?php endif; ?>
                                            <?php if ($ajuan['status_id'] == '1') : ?>
                                                <td><span class="badge badge-secondary"><?= $ajuan['keterangan']; ?></span></td>
                                            <?php elseif ($ajuan['status_id'] == '2') : ?>
                                                <td><span class="badge badge-primary"><?= $ajuan['keterangan']; ?></span></td>
                                            <?php elseif ($ajuan['status_id'] == '3') : ?>
                                                <td><span class="badge badge-danger"><?= $ajuan['keterangan']; ?></span></td>
                                            <?php elseif ($ajuan['status_id'] == '4') : ?>
                                                <td><span class="badge badge-success"><?= $ajuan['keterangan']; ?></span></td>
                                            <?php elseif ($ajuan['status_id'] == '5') : ?>
                                                <td><span class="badge badge-warning"><?= $ajuan['keterangan']; ?></span></td>
                                            <?php elseif ($ajuan['status_id'] == '6') : ?>
                                                <td><span class="badge badge-info"><?= $ajuan['keterangan']; ?></span></td>
                                            <?php elseif ($ajuan['status_id'] == '7') : ?>
                                                <td><span class="badge badge-primary"><?= $ajuan['keterangan']; ?></span></td>
                                            <?php elseif ($ajuan['status_id'] == '8') : ?>
                                                <td><span class="badge badge-secondary"><?= $ajuan['keterangan']; ?></span></td>
                                            <?php endif; ?>
                                            <?php if ($ajuan['status_id'] == '1') : ?>
                                                <td><span>Ajuan Anda Belum Kami Tinjau</span></td>
                                            <?php elseif ($ajuan['status_id'] == '2') : ?>
                                                <td><span>Ajuan Anda Sedang Kami Lakukan Perhitungan Biaya</span></td>
                                            <?php elseif ($ajuan['status_id'] == '3') : ?>
                                                <td><span>Mohon Maaf Ajuan Anda Kami Tolak</span></td>
                                            <?php elseif ($ajuan['status_id'] == '4') : ?>
                                                <td><span>Ajuan Anda Sedang Kami Kerjakan</span></td>
                                            <?php elseif ($ajuan['status_id'] == '5') : ?>
                                                <td>
                                                    <div>
                                                        <a href="<?= base_url('klien/terimaRAB/' . $ajuan['idajuan']); ?>"><button class="btn btn-sm btn-primary">Terima RAB</button></a>
                                                        <button class="btn btn-sm btn-danger">Tolak RAB</button>
                                                        <button class="btn btn-sm btn-success">Adakan Meeting</button>
                                                    </div>
                                                </td>
                                            <?php elseif ($ajuan['status_id'] == '6') : ?>
                                                <td>
                                                    RAB Telah Di Setujui Klien, Kami Akan Segera Melakukan Pengerjaan Proyek Yang Diajukan
                                                </td>
                                            <?php elseif ($ajuan['status_id'] == '7') : ?>
                                                <td>
                                                    Keterangan Penolakan <?= $ajuan['status_id']; ?>
                                                </td>
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
<script>

</script>
<?= $this->endSection(); ?>