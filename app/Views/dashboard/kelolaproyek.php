<?= $this->extend('dashboard/template'); ?>

<?= $this->section('dashboard'); ?>

<div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <div class="bg-white" id="sidebar-wrapper">
        <div class="sidebar-heading text-center py-4 primary-text fs-5 fw-bold text-uppercase border-bottom"><img src="<?= base_url(); ?>/img/logo.png" class="me-5" width="140" " alt=""></div>
        <div class=" list-group list-group-flush my-3">
            <a href="#collapseBahanBaku" id="bahanbaku" aria-expanded="false" aria-controls="collapseExample" data-bs-toggle="collapse" aria-expanded="false" class="list-group-item list-group-item-action bg-transparent second-text aktif fw-bold"><i class="fas fa-tachometer-alt me-2"></i>Bahan Baku <i class="fa-solid fa-caret-right float-end"></i></a>
            <div class="collapse" id="collapseBahanBaku">
                <div class="card card-body">
                    <a href="" class="sub-item second-text fw-bold bg-transparent"><i class="fa-solid fa-helmet-safety me-2"></i>Kelola Data Akun</a>
                    <a href="" class="sub-item second-text fw-bold bg-transparent"><i class="fa-solid fa-gear me-2"></i>Beli Bahan Baku</a>
                    <a href="" class="sub-item second-text fw-bold bg-transparent"><i class="fa-solid fa-gear me-2"></i>Gunakan Bahan Baku</a>
                </div>
            </div>
            <a href="#collapseTenagaKerja" id="tenagakerja" aria-expanded="false" aria-controls="collapseExample" data-bs-toggle="collapse" aria-expanded="false" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i class="fas fa-database me-2"></i>Tenaga Kerja <i class="fa-solid fa-caret-right float-end"></i></a>
            <div class="collapse" id="collapseTenagaKerja">
                <div class="card card-body">
                    <a href="" class="sub-item second-text fw-bold bg-transparent"><i class="fa-solid fa-helmet-safety me-2"></i>Kelola Tenaga Kerja</a>
                </div>
            </div>
            <a class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i class="fas fa-database me-2"></i>Transaksi BOP</a>
            <a class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i class="fas fa-database me-2"></i>Progress Proyek</a>
            <a class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i class="fas fa-database me-2"></i>Pembayaran Proyek</a>
            <a class="list-group-item list-group-item-action bg-transparent second-text fw-bold" id="dataproyek"><i class="fa-solid fa-message me-2"></i>Message</a>


            <a href="#" class="list-group-item list-group-item-action bg-transparent text-danger fw-bold"><i class="fas fa-power-off me-2"></i>Logout</a>
        </div>

    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <nav class="navbar shadow-lg navbar-expand-lg navbar-light bg-transparent py-2 px-4">
            <div class="d-flex align-items-center">
                <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                <h2 class="fs-4 m-0">Dashboard Kelola Proyek</h2>
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
                            <li><a class="dropdown-item" href="#">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container-fluid px-4">
            <div class="row g-3 my-2">
                <div class="col-md-3">
                    <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                        <div>
                            <h3 class="fs-2">720</h3>
                            <p class="fs-5">Menu 1</p>
                        </div>
                        <i class="fas fa-gift fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                        <div>
                            <h3 class="fs-2">4920</h3>
                            <p class="fs-5">Menu 2</p>
                        </div>
                        <i class="fas fa-hand-holding-usd fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                        <div>
                            <h3 class="fs-2">3899</h3>
                            <p class="fs-5">Menu 3</p>
                        </div>
                        <i class="fas fa-truck fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                        <div>
                            <h3 class="fs-2">%25</h3>
                            <p class="fs-5">Menu 3</p>
                        </div>
                        <i class="fas fa-chart-line fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                    </div>
                </div>
            </div>



        </div>
    </div>
    <?= $this->endSection(); ?>