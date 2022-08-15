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
                        <form id="formajuanproyek" method="post" action="<?= base_url('/DashboardKlien/simpanajuanproyek'); ?>" enctype="multipart/form-data">
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
                                        <select type="text" class="form-control" id="jenisproyek" name="jenisproyek">
                                            <option selected disabled> --Pilih Jenis Proyek--</option>
                                            <option value="Engineering Konstruksi">Engineering Konstruksi</option>
                                            <option value="Engineering Manufacture">Engineering Manufacture</option>
                                            <option value="Pelayanan Manajemen">Pelayanan Manajemen</option>
                                            <option value="Penelitian Dan Pengembangan">Penelitian Dan Pengembangan</option>
                                            <option value="Proyek Kapital">Proyek Kapital</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="anggaran">Anggaran Yang Ditawarkan*</label>
                                        <input class="form-control" id="anggaran" name="anggaran"></input>
                                    </div>
                                </div>
                                <div class="form-row form-group">
                                    <div class="col">
                                        <label for="tglmulai">Tanggal Mulai Proyek *</label>
                                        <input type="text" class="form-control" id="tglmulai" name="tglmulai">
                                    </div>
                                    <div class="col">
                                        <label for="tgldeadline">Tanggal Deadline*</label>
                                        <input class="form-control" id="tgldeadline" name="tgldeadline"></input>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="custom-file col-8">
                                        <label for="exampleFormControlFile1">Pilih File *</label>
                                        <input type="file" class="form-control-file" id="exampleFormControlFile1" name="uploadfile">
                                        <small id="emailHelp" class="form-text text-muted">Masukkan File Pendukung Untuk Deskripsi Lebih Detail Dari Proyek yang diajukan (Bisa berupa Gambar Atau Pdf)</small>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer mb-2">
                                <button type="submit" class="btn btn-primary">Ajukan Proyek</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
<script>
    $(document).ready(function() {
        $('#anggaran').keyup(function() {
            $(this).val(formatRupiahtyping($(this).val()));
        })
        $("#tglmulai").on('keydown paste focus mousedown', function(e) {
            if (e.keyCode != 9) // ignore tab
                e.preventDefault();
        });
        $("#tgldeadline").on('keydown paste focus mousedown', function(e) {
            if (e.keyCode != 9) // ignore tab
                e.preventDefault();
        });
        $('#tglmulai').dtDateTime();
        $('#tgldeadline').dtDateTime();
    })
</script>
<?= $this->endSection(); ?>