<?= $this->extend('layouts/template'); ?>
<?= $this->section('content'); ?>
<section class="d-flex align-items-center justify-content-center vh-100" style="background-color: #eee;">
    <div class="card rounded mb-3 shadow" style="border: 2px solid #4C98C9;width: 600px;">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="<?= base_url(); ?>/img/pemandangan.jpg" class="img-fluid rounded-start h-100 w-100" alt="...">
            </div>
            <div class="col-md-8">
                <div class="card-body p-3">
                    <h5 class="card-title text-center mb-3">Silakan Login</h5>
                    <form>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Username</label>
                            <input type="input" class="form-control" id="exampleInputEmail1" placeholder="Silakan Masukkan Username" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label" ">Password</label>
                            <input type=" password" class="form-control" placeholder="Silakan Masukkan Password" id=" exampleInputPassword1">
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Remember me</label>
                        </div>
                        <a href="<?= base_url(); ?>/klien" type="submit" class="btn btn-primary"><i class="fa-solid fa-arrow-right-to-bracket"></i> Masuk</a>
                        <a href="<?= base_url(); ?>" type="submit" class="btn btn-danger"><i class="fa-solid fa-house"></i>
                            Kembali</a>
                    </form>
                </div>
            </div>
        </div>
</section>
<?= $this->endSection(); ?>