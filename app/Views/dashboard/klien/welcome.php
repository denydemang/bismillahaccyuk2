<?= $this->extend('dashboard/klien/template'); ?>
<?= $this->section('dashboardklien'); ?>
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h2>Selamat Datang <?= $nama; ?></h2>
                Anda Dapat Ajukan Tawaran Proyek Di Bawah
            </div>
            <?php if (!empty($ajuanditerima)) : ?>
                <div class="contain-row">
                    <div class="alert alert-success col-lg-8" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?php foreach ($ajuanditerima as $terima) : ?>
                            <strong>Ajuan Proyek Anda <em><?= $terima['namaproyek']; ?></em> Telah Diterima !</strong>
                        <?php endforeach ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (!empty($ajuanditolak)) : ?>
                <div class="contain-row">
                    <div class="alert alert-danger col-lg-8" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?php foreach ($ajuanditolak as $tolak) : ?>
                            <strong>Maaf Ajuan Proyek Anda <em><?= $tolak['namaproyek']; ?></em> Kami Tolak !</strong>
                        <?php endforeach ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (!empty($ajuandikerjakan)) : ?>
                <div class="contain-row">
                    <div class="alert alert-primary col-lg-12" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?php foreach ($ajuandikerjakan as $kerja) : ?>
                            <strong>Ajuan Proyek Anda <em><?= $kerja['namaproyek']; ?></em> Sedang Kami Kerjakan, Silakan Ke Menu Progress Proyek !</strong>
                        <?php endforeach ?>
                    </div>
                </div>
            <?php endif; ?>

    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-lg-8">
                    <div class="pesan" data-flash="<?= session()->getFlashdata('pesan'); ?>"></div>
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Form Ajukan Proyek</h3>
                        </div>
                        <form id="formajuanproyek" method="post" action="<?= base_url('/DashboardKlien/simpanajuanproyek'); ?>">
                            <?= csrf_field(); ?>
                            <div class="card-body">
                                <div class="form-row form-group">
                                    <div class="col">
                                        <input type="hidden" class="form-control" class="nama" name="user_id" value="<?= $user_id; ?>">
                                        <label for="email">Nama </label>
                                        <input type="text" readonly class="form-control" class="nama" name="nama" value="<?= $nama; ?>">
                                    </div>
                                    <div class="col">
                                        <label for="email">Email</label>
                                        <input type="text" readonly class="form-control" id="email" name="email" value="<?= $email; ?>">
                                    </div>
                                </div>
                                <div class=" form-group form-row">
                                    <div class="col">
                                        <label for="notelp">No Telpon </label>
                                        <input type="text" readonly class="form-control" id="notelp" name="notelp" value="<?= $notelp; ?>">
                                    </div>
                                    <div class="col">
                                        <label for="alamat">Alamat </label>
                                        <input type="text" readonly class="form-control" id="alamat" name="alamat" value="<?= $alamat; ?>">
                                    </div>
                                </div>
                                <div class="form-row form-group">
                                    <div class="col">
                                        <label for="namaproyek">Nama Proyek *</label>
                                        <input type="text" class="form-control" id="namaproyek" id="namaproyek" name="namaproyek">

                                    </div>
                                    <div class="col">
                                        <label for="lokasiproyek">Lokasi Proyek *</label>
                                        <input type="text" class="form-control" id="lokasiproyek" name="lokasiproyek">
                                    </div>
                                </div>
                                <div class="form-row form-group">
                                    <div class="col">
                                        <label for="jenisproyek">Jenis Proyek *</label>
                                        <input type="text" class="form-control" id="jenisproyek" name="jenisproyek">
                                    </div>
                                    <div class="col">
                                        <label for="lokasiproyek">Catatan *</label>
                                        <textarea class="form-control" id="catatan" rows="2" name="catatan"></textarea>
                                    </div>
                                </div>
                                <div class=" form-group">
                                    <label for="exampleInputFile">Masukkan File</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="exampleInputFile">
                                            <label class="custom-file-label" for="exampleInputFile">Pilih File</label>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Upload</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Ajukan Proyek</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
<?= $this->endSection(); ?>