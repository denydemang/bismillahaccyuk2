<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= base_url(); ?>/css/dashboard.css">
    <title><?= $judul; ?></title>
</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 primary-text fs-5 fw-bold text-uppercase border-bottom"><img src="<?= base_url(); ?>/img/logo.png" class="me-5" width="140" " alt=""></div>
        <div class=" list-group list-group-flush my-3">
                <a href="<?= base_url(); ?>/admin" class="list-group-item list-group-item-action bg-transparent <?= ($_SESSION['aktif'] == 'welcome') ? 'aktif' : ''; ?> second-text fw-bold"><i class="fa-solid fa-house me-2"></i>Home</a>
                <a href="<?= base_url(); ?>/admin/ajuanproyek" class="list-group-item list-group-item-action bg-transparent <?= ($_SESSION['aktif'] == 'ajuan') ? 'aktif' : ''; ?> second-text fw-bold"><i class="fas fa-tachometer-alt me-2"></i>Ajuan Proyek</a>
                <a href="<?= base_url() ?>/admin/dataklien" class="list-group-item list-group-item-action bg-transparent <?= ($_SESSION['aktif'] == 'dataklien') ? 'aktif' : ''; ?> second-text fw-bold"><i class="fas fa-database me-2"></i>Data Klien</a>
                <a href="<?= base_url() ?>/admin/dataproyek" class="list-group-item list-group-item-action bg-transparent <?= ($_SESSION['aktif'] == 'dataproyek') ? 'aktif' : ''; ?> second-text fw-bold" id="dataproyek"><i class="fas fa-project-diagram me-2"></i>Data Proyek</a>
                <a href="<?= base_url() ?>/admin/message" class="list-group-item list-group-item-action bg-transparent second-text  <?= ($_SESSION['aktif'] == 'message') ? 'aktif' : ''; ?> fw-bold"><i class="fa-solid fa-message me-2"></i>Message</a>


                <a href="<?= base_url(); ?>/logout" class="list-group-item list-group-item-action bg-transparent text-danger fw-bold"><i class="fas fa-power-off me-2"></i>Logout</a>
            </div>

        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar shadow-lg navbar-expand-lg navbar-light bg-transparent py-2 px-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                    <h2 class="fs-4 m-0">Dashboard Admin</h2>
                </div>
                <div class="ms-5 me-2 primary-text position-relative">
                    <i class="fa-solid fa-bell fs-4"></i>
                    <span class="position-absolute ms-2 top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        99+
                        <span class="visually-hidden">unread messages</span>
                    </span>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <p class="d-inline me-2">Demang</p>
                                <img class="rounded-circle z-depth-2" alt="100x100" width="50" src="<?= base_url(); ?>/img/undraw_profile.svg" data-holder-rendered="true">

                                <!-- John Doe <img src="https://mdbootstrap.com/img/new/avatars/2.jpg" class="img-fluid mx-2" style="width: 35px;" alt="" /> -->
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Profile</a></li>
                                <li><a class="dropdown-item" href="#">Settings</a></li>
                                <li><a class="dropdown-item" href="<?= base_url(); ?>/logout">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            <?= $this->renderSection('dashboardadmin'); ?>

        </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
    var el = document.getElementById("wrapper");
    var toggleButton = document.getElementById("menu-toggle");

    toggleButton.onclick = function() {
        el.classList.toggle("toggled");
    };
    $('#dataproyek').click(function() {
        $('.fa-caret-right').toggleClass('rotate');

    })
    $('#bahanbaku').click(function() {
        $(this).$('.fa-caret-right').toggleClass('rotate');

    })
    $('.list-group-item').click(function() {
        $('.list-group-item').removeClass('aktif');
        $(this).addClass('aktif');
    })
</script>

</html>