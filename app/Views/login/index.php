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

                    <form action="<?= base_url(); ?>/login/cekuser" method="post">
                        <?= csrf_field(); ?>
                        <div class="mb-3">
                            <?php
                            $isInvalidUser = (session()->getFlashdata('errUsername')) ? 'is-invalid' : '';
                            ?>
                            <label for="exampleInputEmail1" class="form-label">Username</label>
                            <input type="text" id="username" name="username" class="form-control <?= $isInvalidUser; ?>" placeholder="Silakan Masukkan Username" aria-describedby="emailHelp" value="<?= old('username'); ?>">
                            <div id="username" class="invalid-feedback">
                                <?= session()->getFlashdata('errUsername'); ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <?php
                            $isInvalidPassword = (session()->getFlashdata('errPassword')) ? 'is-invalid' : '';
                            ?>
                            <label for="exampleInputEmail1" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control pw <?= $isInvalidPassword; ?>" placeholder="Silakan Masukkan Password" aria-describedby="emailHelp" value="<?= old('password'); ?>">
                            <div class="invalid-feedback">
                                <?= session()->getFlashdata('errPassword'); ?>
                            </div>

                        </div>
                        <div class="d-flex">
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input">
                                <label class="form-check-label" for="exampleCheck1">Remember me</label>
                            </div>
                            <div class="mb-3 ms-3 form-check">
                                <input type="checkbox" class="form-check-input" onclick="ShowPassword()">
                                <label class="form-check-label" for="exampleCheck1">Show Password</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-arrow-right-to-bracket"></i> Masuk</button>
                        <a href="<?= base_url(); ?>" type="submit" class="btn btn-danger"><i class="fa-solid fa-house"></i>
                            Kembali</a>
                    </form>
                </div>
            </div>
        </div>
</section>
<script>
    function ShowPassword() {
        var pw = document.getElementById('password');
        if (pw.type === 'password') {
            pw.type = 'text';
        } else {
            pw.type = 'password';
        };
    }
</script>
<?= $this->endSection(); ?>