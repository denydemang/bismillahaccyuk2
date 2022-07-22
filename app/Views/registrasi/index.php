<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>

<section style="background-color: #eee;">
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="card mt-2 mb-2 text-black" style="border-radius: 25px; width:58rem">
                <div class="row justify-content-center">
                    <div class="row">
                        <div class="d-flex justify-content-between">
                            <p class="h2 fw-bold mb-5 mx-1 mx-md-4 mt-4"><a href="<?= base_url(); ?>/" class="text-decoration-none fa-solid fa-arrow-left"></a> Silakan Registrasi</p>
                            <img src="<?= base_url('img/logo.png'); ?>" class="img-fluid mt-3" style="width:250px; height:50px" alt="">
                        </div>
                        <div class="col-md-8 col-sm-12">
                            <form id="formregistrasi" action="<?= base_url(); ?>/registrasi/save" method="post" class="mx-1 mx-md-4">
                                <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                                    </symbol>
                                </svg>
                                <!-- Pesan Message Ketika Berhasil buat Akun -->
                                <?php if ($validation->hasError('email') && $validation->hasError('username')) : ?>
                                    <div class="alert alert-danger p-1 d-flex align-items-center" style="height:50px;" role="alert">
                                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                                            <use xlink:href="#exclamation-triangle-fill" />
                                        </svg>
                                        <div>
                                            Email dan Username Sudah Terdaftar
                                        </div>
                                    </div>
                                <?php elseif ($validation->hasError('email') || $validation->hasError('username')) : ?>
                                    <div class="alert alert-danger p-1 d-flex align-items-center" style="height:50px;" role="alert">
                                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                                            <use xlink:href="#exclamation-triangle-fill" />
                                        </svg>
                                        <div>
                                            <?= $validation->getError('username'); ?><?= $validation->getError('email'); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?= csrf_field(); ?>
                                <div class="row">
                                    <div class="col d-flex flex-row align-items-center mb-4">
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="nama">Nama</label>
                                            <input type="text" id="nama" class="form-control" name="nama" autocomplete="off" value="<?= old('nama'); ?>" />
                                        </div>
                                    </div>
                                    <div class="col d-flex flex-row align-items-center mb-4">
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="email">Email</label>
                                            <input type="email" class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : ''; ?>" name="email" autocomplete="off" value="<?= old('email'); ?>" />

                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col d-flex flex-row align-items-center mb-4">
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="username">Username</label>
                                            <input type="text" id="username" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : ''; ?>" name="username" autocomplete="off" value="<?= old('username'); ?>" />
                                        </div>
                                    </div>
                                    <div class="col d-flex flex-row align-items-center mb-4">
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="notelp">No Telepon</label>
                                            <input type="text" id="notelp" class="form-control" autocomplete="off" name="telpon" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" value="<?= old('telpon'); ?>" />

                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2 mb-3 d-flex mt-2 flex-row align-items-center mb-4">
                                    <div class="form-outline flex-fill mb-0">
                                        <label class="form-label" for="alamat">Alamat</label>
                                        <input type="text" id="alamat" class="form-control" name="alamat" value="<?= old('alamat'); ?>" />
                                    </div>
                                </div>
                                <div class="row mt-2 pt-2">
                                    <div class="col d-flex flex-row align-items-center mb-4">
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="password">Password</label>
                                            <input type="password" id="password" class="form-control" name="password" autocomplete="off" />

                                        </div>
                                    </div>
                                    <div class=" col d-flex flex-row align-items-center mb-4">
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="konfirpw">Konfirmasi Password</label>
                                            <input type="password" id="konfirpw" class="form-control" name="konfirpassword" autocomplete="off" />

                                        </div>
                                    </div>
                                </div>

                                <div class=" w-100 mt-4 mb-5">
                                    <button type="submit" class="btn btn-primary w-100 mb-3">Register</button>
                                    <small class="text-center d-block text-center">Sudah Punya Akun ? <a href="<?= base_url(); ?>/login">Log In</a></small>
                                </div>

                            </form>


                        </div>
                        <div class="col-md-4 gambarregistrasi h-100 d-flex align-items-center">
                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.webp" class="img-fluid" style="height:60%;margin-bottom:120px;" alt="Sample image">
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?= $this->endSection(); ?>