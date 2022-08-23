<?php $this->extend('dashboard/kelolaproyek/template') ?>
<?php $this->section('dashboardkelolaproyek') ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h2>Selamat Datang <?= $nama; ?></h2>
                Anda Masuk Ke Dashboard Kelola Proyek dengan ID Proyek <strong><?= $idproyek; ?></strong>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Detail Proyek</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <strong><i class="fas fa-book mr-1"></i>Nama Proyek</strong><strong>(<?= $idproyek; ?>)</strong>
                            <p class="text-muted detailnamaproyek mr-1">
                                <?= $dataproyek[0]['namaproyek']; ?>
                            </p>
                        </div>
                        <div class="col">
                            <strong><i class="fas fa-info mr-1"></i>Status</strong>
                            <?php if (($dataproyek[0]['belum_bayar']) == '0') : ?>
                                <p class="mr-1">
                                    <span class="badge badge-success detailnamastatus">Lunas</span>
                                </p>
                            <?php else : ?>
                                <p class="mr-1">
                                    <span class="badge badge-danger detailnamastatus">Belum Lunas</span>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <strong><i class="fas fa-briefcase mr-1"></i>Jenis Proyek</strong>
                            <p class="text-muted detailjenisproyek mr-1">
                                <?= $dataproyek[0]['jenisproyek']; ?>
                            </p>
                        </div>
                        <div class="col">
                            <strong><i class="fas fa-map-marker-alt mr-1"></i>Lokasi Proyek</strong>
                            <p class="text-muted detaillokasiproyek mr-1">
                                <?= $dataproyek[0]['lokasiproyek']; ?>
                            </p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <strong><i class="fas fa-user mr-1"></i>Nama Klien</strong><strong>(<?= $dataproyek[0]['user_id']; ?>)</strong>
                            <p class="text-muted detailnama mr-1">
                                <?= $dataproyek[0]['nama']; ?>
                            </p>
                        </div>
                        <div class="col">
                            <strong><i class="fas fa-money-check-alt mr-1"></i>Biaya Proyek</strong>
                            <p class="text-muted detailemail mr-1">
                                Rp. <?= $dataproyek[0]['biaya']; ?> ,-
                            </p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <strong><i class="fas fa-dollar-sign mr-1"></i>Sudah Bayar</strong>
                            <p class="text-muted detailalamat mr-1">
                                Rp. <?= $dataproyek[0]['sudah_bayar']; ?> ,-
                            </p>
                        </div>
                        <div class="col">
                            <strong><i class="fas fa-money-bill mr-1"></i>Belum Bayar</strong>
                            <p class="text-muted detailtelp mr-1">
                                Rp. <?= $dataproyek[0]['belum_bayar']; ?> ,-
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

</div>

<?php $this->endSection() ?>