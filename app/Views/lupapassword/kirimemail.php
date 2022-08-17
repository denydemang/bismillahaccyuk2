<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Password</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="<?= base_url('assetslte') ?>/plugins/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="<?= base_url('assetslte') ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">

    <link rel="stylesheet" href="<?= base_url('assetslte') ?>/dist/css/adminlte.min.css?v=3.2.0">

</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <img src="<?= base_url('img/logo.png'); ?>" alt="" width="160">
        </div>

        <div class="card">
            <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                </symbol>
                <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                </symbol>
            </svg>
            <?php if (session()->getFlashdata('pesanemail')) : ?>
                <?php if (session()->getFlashdata('pesanemail') == 'Email Pergantian Password Berhasil Dikirim Silakan Cek Kotak Masuk Atau Spam Email') : ?>
                    <div class="alert alert-success p-1 d-flex align-items-center" style="height:50px;" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                            <use xlink:href="#check-circle-fill" />
                        </svg>
                        <div>
                            <?= session()->getFlashdata('pesanemail'); ?>
                        </div>
                    </div>
                <?php elseif (session()->getFlashdata('pesanemail') !== 'Email Pergantian Password Berhasil Dikirim Silakan Cek Kotak Masuk Atau Spam Email') : ?>
                    <div class="alert alert-danger p-1 d-flex align-items-center" style="height:50px;" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                            <use xlink:href="#exclamation-triangle-fill" />
                        </svg>
                        <div>
                            <?= session()->getFlashdata('pesanemail'); ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php else : ?>
                <div></div>
            <?php endif; ?>
            <div class="card-body login-card-body">
                <p class="login-box-msg">Lupa Password? Silakan Masukkan Email Anda Untuk Pergantian Password</p>
                <form class="formlupapasword" action="<?= base_url('lupapassword/kirimpassword'); ?>">
                    <div class="input-group mb-3">
                        <input type="email" name="emailpemulihan" class="form-control emailpemulihan" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        <div class="invalid-feedback emailinvalid"></div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block btnpassword">Minta Password Baru</button>
                        </div>
                    </div>
                </form>
                <p class="mt-3 mb-1">
                    <a href="<?= base_url('login'); ?>">Login</a>
                </p>
                <p class="mb-0">
                    <a href="<?= base_url('registrasi'); ?>" class="text-center">Registrasi</a>
                </p>
            </div>

        </div>
    </div>


    <script src="<?= base_url('assetslte') ?>/plugins/jquery/jquery.min.js"></script>

    <script src="<?= base_url('assetslte') ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>


    <script src="<?= base_url('assetslte') ?>/dist/js/adminlte.min.js?v=3.2.0"></script>
</body>

</html>
<script>
    $(document).ready(function() {
        const base_url = 'http://localhost:8080/';

        $('.formlupapasword').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                type: 'post',
                success: function(response) {
                    console.log(response);

                    if (response.errorrequired) {
                        $('.emailpemulihan').addClass('is-invalid');
                        $('.emailinvalid').html(response.errorrequired)

                    } else if (response.emptyemail) {
                        $('.emailpemulihan').addClass('is-invalid');
                        $('.emailinvalid').html(response.emptyemail)

                    } else {
                        $('.emailpemulihan').removeClass('is-invalid');
                        let email = response.email
                        let token = response.token
                        let nama = response.nama
                        location.href = "http://localhost:8080/lupapassword/kirimemailgantipw/" + email + "/" + token + '/' + nama
                    }

                }
            });

        })
    });
</script>