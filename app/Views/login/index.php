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
                    <h5 class="card-title text-center mb-3">Halaman Login</h5>

                    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </symbol>
                    </svg>
                    <!-- Pesan Message Ketika Berhasil buat Akun -->
                    <?php if (session()->getFlashdata('pesan')) : ?>
                        <div class="alert alert-success p-1 d-flex align-items-center" style="height:50px;" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                                <use xlink:href="#check-circle-fill" />
                            </svg>
                            <div>
                                <?= session()->getFlashdata('pesan'); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <!-- End Pesan Message Ketika Berhasil buat Akun -->
                    <form action="<?= base_url(); ?>/login/cekuser" method="post">
                        <?= csrf_field(); ?>
                        <div class="mb-3">
                            <?php
                            $isInvalidUser = (session()->getFlashdata('errUsername')) ? 'is-invalid' : '';
                            ?>
                            <label for="exampleInputEmail1" class="form-label">Email / Username</label>
                            <input type="text" id="username" name="username" class="form-control <?= $isInvalidUser; ?>" placeholder="Silakan Masukkan Email atau Username" aria-describedby="emailHelp" value="<?= old('username'); ?>" autocomplete="off">
                            <div id="username" class="invalid-feedback">
                                <?= session()->getFlashdata('errUsername'); ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <?php
                            $isInvalidPassword = (session()->getFlashdata('errPassword')) ? 'is-invalid' : '';
                            ?>
                            <label for="exampleInputEmail1" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control pw <?= $isInvalidPassword; ?>" placeholder="Silakan Masukkan Password" aria-describedby="emailHelp" value="<?= old('password'); ?>" autocomplete="off">
                            <div class="invalid-feedback">
                                <?= session()->getFlashdata('errPassword'); ?>
                            </div>

                        </div>
                        <div class="d-flex">
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" onclick="ShowPassword()">
                                <label class="form-check-label" for="exampleCheck1">Show Password</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-arrow-right-to-bracket"></i> Masuk</button>
                        <a href="<?= base_url(); ?>" type="submit" class="btn btn-danger"><i class="fa-solid fa-house"></i>
                            Kembali</a>
                        <?php if (!session()->getFlashdata('pesan')) : ?>
                            <div class="mt-2">
                                <small>Belum Punya Akun ? <a href="<?= base_url(); ?>/registrasi">Registrasi</a></small>
                            </div>
                        <?php endif; ?>
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