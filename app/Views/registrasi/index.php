<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>

<section style="background-color: #eee;">
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="card mt-2 mb-2 text-black" style="border-radius: 25px; width:50rem">
                <div class="row justify-content-center">
                    <div class="row">
                        <div class="d-flex justify-content-between">
                            <p class="h2 fw-bold mb-5 mx-1 mx-md-4 mt-4">Silakan Registrasi</p>
                            <img src="<?= base_url('img/logo.png'); ?>" class="img-fluid mt-3" style="width:310px; height:80px" alt="">
                        </div>

                        <div class="col">
                            <form action="<?= base_url(); ?>/registrasi/save" method="post" class="mx-1 mx-md-4">
                                <div class="row">
                                    <div class="col d-flex flex-row align-items-center mb-4">
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="nama">Nama</label>
                                            <input type="text" id="nama" class="form-control" name="nama" />
                                        </div>
                                    </div>
                                    <div class="col d-flex flex-row align-items-center mb-4">
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="email">Email</label>
                                            <input type="email" id="email" class="form-control" name="email" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col d-flex flex-row align-items-center mb-4">
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="username">Username</label>
                                            <input type="text" id="username" class="form-control" name="username" />
                                        </div>
                                    </div>
                                    <div class="col d-flex flex-row align-items-center mb-4">
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="notelp">No Telepon</label>
                                            <input type="number" id="notelp" class="form-control" name="telpon" />
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-row align-items-center mb-4">
                                    <div class="form-outline flex-fill mb-0">
                                        <label class="form-label" for="alamat">Alamat</label>
                                        <input type="text" id="alamat" class="form-control" name="alamat" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col d-flex flex-row align-items-center mb-4">
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="password">Password</label>
                                            <input type="password" id="password" class="form-control" name="password" />
                                        </div>
                                    </div>
                                    <div class="col d-flex flex-row align-items-center mb-4">
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="konfirpw">Konfirmasi Password</label>
                                            <input type="password" id="konfirpw" class="form-control" name="konfirpassword" />
                                        </div>
                                    </div>
                                </div>
                                <div class="w-100 mb-5 ">
                                    <button type="submit" class="btn btn-primary w-100">Register</button>
                                </div>
                            </form>

                        </div>
                        <div class="col h-100 d-flex align-items-center">
                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.webp" class="img-fluid" style="height:60%;margin-bottom:120px;" alt="Sample image">
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?= $this->endSection(); ?>