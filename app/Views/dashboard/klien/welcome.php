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
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-lg-8">

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Form Ajukan Proyek</h3>
                        </div>
                        <form>
                            <div class="card-body">
                                <div class="form-row form-group">
                                    <div class="col">
                                        <label for="email">Nama</label>
                                        <input type="text" readonly class="form-control" class="nama" name="nama" value="<?= $nama; ?>">
                                    </div>
                                    <div class="col">
                                        <label for="alamat">Alamat</label>
                                        <input type="text" readonly class="form-control" id="alamat" name="alamat" value="<?= $alamat; ?>">
                                    </div>
                                </div>
                                <div class=" form-group form-row">
                                    <div class="col">
                                        <label for="notelp">No Telpon</label>
                                        <input type="text" readonly class="form-control" id="notelp" name="notelp" value="<?= $notelp; ?>">
                                    </div>
                                    <div class="col">
                                        <label for="namaproyek">Nama Proyek</label>
                                        <input type="text" class="form-control" id="namaproyek" id="namaproyek" name="namaproyek">
                                    </div>
                                </div>
                                <div class="form-row form-group">
                                    <div class="col">
                                        <label for="jenisproyek">Jenis Proyek</label>
                                        <input type="text" class="form-control" id="jenisproyek" name="jenisproyek">
                                    </div>
                                    <div class="form-group">
                                        <label for="lokasiproyek">Lokasi Proyek</label>
                                        <input type="text" class="form-control" id="lokasiproyek" name="lokasiproyek">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="lokasiproyek">Catatan</label>
                                    <textarea class="form-control" id="catatan" rows="2" name="catatan"></textarea>
                                </div>
                                <div class=" form-group">
                                    <label for="exampleInputFile">Masukkan File (optional)</label>
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