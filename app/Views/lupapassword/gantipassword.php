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
            <div class="card-body login-card-body">
                <form id="gantipassword" method="post" action="<?= base_url('LupaPassword/updatepassword') ?>">
                    <label for="">Masukkan Password Baru</label>
                    <input type="hidden" name="user_id" value="<?= $user_id; ?>">
                    <div class="input-group bungkus mb-3">
                        <input type="password" class="form-control pw" name="passwordbaru">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="fas fa-key"></i>
                            </div>
                        </div>
                    </div>
                    <label for="" class="form-label">Konfirmasi Password Baru</label>
                    <div class="input-group bungkus mb-3">
                        <input type="password" class="form-control konfirpw" name="konfirpassword">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="fas fa-key"></i>
                            </div>
                        </div>

                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" onclick="ShowPassword()">
                        <label class="form-check-label" for="exampleCheck1">Show Password</label>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block btngantipassword">Ganti Password</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>


    <script src="<?= base_url('assetslte') ?>/plugins/jquery/jquery.min.js"></script>

    <script src="<?= base_url('assetslte') ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>


    <script src="<?= base_url('assetslte') ?>/dist/js/adminlte.min.js?v=3.2.0"></script>
    <script>
        function ShowPassword() {
            pw = document.querySelector('.pw');
            konfirpw = document.querySelector('.konfirpw');
            if (pw.type === 'password') {
                pw.type = 'text';
                konfirpw.type = 'text';
            } else {
                pw.type = 'password';
                konfirpw.type = 'password';
            };
        }

        $('#gantipassword').each(function() {
            $(this).validate({
                rules: {
                    passwordbaru: {
                        required: true,
                    },
                    konfirpassword: {
                        required: true,
                        equalTo: ".pw"
                    },

                },
                messages: {
                    passwordbaru: {
                        required: 'Silakan masukkan Password'

                    },
                    konfirpassword: {
                        required: 'Silakan Ulangi Password',
                        equalTo: 'Password Tidak Sama'
                    },

                },
                errorElement: "div",
                errorPlacement: function(error, element) {

                    // Add the `invalid-feedback` class to the error element
                    error.addClass("invalid-feedback");
                    error.appendTo(element.parents('.bungkus'));
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass("is-invalid").removeClass("is-valid");
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass("is-invalid");
                },
                submitHandler: function(form) {
                    form.submit();

                }



            })
        })
    </script>
</body>

</html>