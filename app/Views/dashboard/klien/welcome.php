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
                                        <select type="text" class="form-control" id="jenisproyekkk" name="jenisproyek">
                                            <option selected disabled value=" --Pilih Jenis Proyek--"> --Pilih Jenis Proyek--</option>
                                            <option value="Engineering Konstruksi">Engineering Konstruksi</option>
                                            <option value="Engineering Manufacture">Engineering Manufacture</option>
                                            <option value="Penelitian Dan Pengembangan">Penelitian Dan Pengembangan</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="anggaran">Anggaran Proyek*</label>
                                        <input class="form-control" id="anggaran" name="anggaran"></input>
                                    </div>
                                </div>
                                <div class="form-row form-group">
                                    <div class="col-5">
                                        <label for="tglmulai">Jadwal Proyek *</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-calendar"></i></span>
                                            </div>
                                            <input type="text" autocomplete="off" class="form-control jadwalproyek" placeholder="DD/MM/YYYY - DD/MM/YYYY" name="jadwalproyek" id="jadwalproyek">
                                        </div>
                                    </div>
                                </div>
                                <!-- <input type="text" class="form-control" id="jadwalproyek" name="jadwalproyek"> -->
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
<script src="<?= base_url('jquery-ui-1.13.2') ?>/jquery-ui.js"></script>
<!-- <script src="<//?= base_url('jquery-month-picker') ?>/src/MonthPicker.js"></script> -->
<script src="<?= base_url('daterangepicker') ?>/moment.min.js"></script>
<script src="<?= base_url('daterangepicker') ?>/daterangepicker.js"></script>
<script>
    $(document).ready(function() {
        $('#anggaran').keyup(function() {
            $(this).val(formatRupiahtyping($(this).val()));
        })

        $(function() {
            $('.jadwalproyek').keypress(function(event) {
                event.preventDefault();
                return false;
            });
        })
        $('.jadwalproyek').daterangepicker({
            autoUpdateInput: false,
            showDropdowns: true,
            locale: {
                cancelLabel: 'Clear',
                format: 'DD/MM/YY'
            }
        });
        $('.jadwalproyek').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        });

        $('.jadwalproyek').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });


    });
    // $("#jadwalproyek").on('keydown paste focus mousedown', function(e) {
    //     if (e.keyCode != 9) // ignore tab
    //         e.preventDefault();
    // });
</script>
<?= $this->endSection(); ?>