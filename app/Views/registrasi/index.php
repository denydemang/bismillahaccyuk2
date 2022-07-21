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
                                            <div class="invalid-feedback pesanerror">
                                                <?= $validation->getError('email'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col d-flex flex-row align-items-center mb-4">
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="username">Username</label>
                                            <input type="text" id="username" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : ''; ?>" name="username" autocomplete="off" value="<?= old('username'); ?>" />
                                            <div class="invalid-feedback pesanerror">
                                                <?= $validation->getError('username'); ?>
                                            </div>
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