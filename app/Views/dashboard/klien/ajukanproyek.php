<?= $this->extend('dashboard/klien/template'); ?>
<?= $this->section('dashboardklien'); ?>
<div class="container-fluid px-5 d-flex justify-content-center py-5">
    <div class="card shadow w-50">
        <div class="card-body p-4 bg-white">
            <h3 class="card-title pb-4">Silakan Isi Form Berikut Untuk Mengajukan Proyek</h3>
            <form>
                <div class="mb-3 row">
                    <label for="staticEmail" class="col-sm-3 col-form-label">Nama</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="staticEmail">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-3 col-form-label">Alamat</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="inputPassword">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-3 col-form-label">No Telpon</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="inputPassword">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-3 col-form-label">Nama Proyek</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="inputPassword">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-3 col-form-label">Jenis Proyek</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="inputPassword">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-3 col-form-label">Lokasi Proyek</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="inputPassword">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-3 col-form-label">Catatan</label>
                    <div class="col-sm-9">
                        <textarea type="input" class="form-control" id="inputPassword"></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Ajukan</button>
            </form>

            <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="card-link">Card link</a>
            <a href="#" class="card-link">Another link</a> -->
        </div>
    </div>
</div>

<?= $this->endSection(); ?>