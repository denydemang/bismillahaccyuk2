<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $judul; ?></title>
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?= base_url('assetslte') ?>/dist/css/adminlte.min.css?v=3.2.0">
    <link rel="stylesheet" href="<?= base_url('assetslte') ?>/plugins/fontawesome-free/css/all.min.css">
    <style>
        .modal-open .ui-datepicker {
            z-index: 2000 !important
        }
    </style>
    <link rel="stylesheet" href="<?= base_url('assetslte') ?>/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="<?= base_url('DataTables') ?>/datatables.min.css">
    <link rel="stylesheet" href="<?= base_url('DataTables') ?>/FixedColumns-4.1.0/css/fixedColumns.bootstrap4.css">
    <link rel="stylesheet" href="<?= base_url('DataTables') ?>/Responsive-2.3.0/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="<?= base_url('DataTables') ?>/datatables.min.css">
    <link rel="stylesheet" href="<?= base_url('DataTables') ?>/DateTime-1.1.2/css/dataTables.dateTime.css">
    <link rel="stylesheet" href="<?= base_url('jquery-ui-1.13.2') ?>/jquery-ui.css">

    <script src="<?= base_url('assetslte') ?>/plugins/jquery/jquery.min.js"></script>
    <script src="<?= base_url('DataTables') ?>/datatables.min.js"></script>
    <script src="<?= base_url('DataTables/DateTime-1.1.2/js/dataTables.dateTime.min.js'); ?>"></script>
    <script src="<?= base_url('DataTables') ?>/FixedColumns-4.1.0/js/fixedColumns.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script nonce="1a2a044e-6724-4fa0-a605-15124d71b2a4">
        (function(w, d) {
            ! function(a, e, t, r) {
                a.zarazData = a.zarazData || {};
                a.zarazData.executed = [];
                a.zaraz = {
                    deferred: []
                };
                a.zaraz.q = [];
                a.zaraz._f = function(e) {
                    return function() {
                        var t = Array.prototype.slice.call(arguments);
                        a.zaraz.q.push({
                            m: e,
                            a: t
                        })
                    }
                };
                for (const e of ["track", "set", "ecommerce", "debug"]) a.zaraz[e] = a.zaraz._f(e);
                a.zaraz.init = () => {
                    var t = e.getElementsByTagName(r)[0],
                        z = e.createElement(r),
                        n = e.getElementsByTagName("title")[0];
                    n && (a.zarazData.t = e.getElementsByTagName("title")[0].text);
                    a.zarazData.x = Math.random();
                    a.zarazData.w = a.screen.width;
                    a.zarazData.h = a.screen.height;
                    a.zarazData.j = a.innerHeight;
                    a.zarazData.e = a.innerWidth;
                    a.zarazData.l = a.location.href;
                    a.zarazData.r = e.referrer;
                    a.zarazData.k = a.screen.colorDepth;
                    a.zarazData.n = e.characterSet;
                    a.zarazData.o = (new Date).getTimezoneOffset();
                    a.zarazData.q = [];
                    for (; a.zaraz.q.length;) {
                        const e = a.zaraz.q.shift();
                        a.zarazData.q.push(e)
                    }
                    z.defer = !0;
                    for (const e of [localStorage, sessionStorage]) Object.keys(e || {}).filter((a => a.startsWith("_zaraz_"))).forEach((t => {
                        try {
                            a.zarazData["z_" + t.slice(7)] = JSON.parse(e.getItem(t))
                        } catch {
                            a.zarazData["z_" + t.slice(7)] = e.getItem(t)
                        }
                    }));
                    z.referrerPolicy = "origin";
                    z.src = "/cdn-cgi/zaraz/s.js?z=" + btoa(encodeURIComponent(JSON.stringify(a.zarazData)));
                    // t.parentNode.insertBefore(z, t)
                };
                ["complete", "interactive"].includes(e.readyState) ? zaraz.init() : a.addEventListener("DOMContentLoaded", zaraz.init)
            }(w, d, 0, "script");
        })(window, document);
    </script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">
        <!-- Bagian Navbar Atas -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Toggle SideBar Dan Nama Dashboard -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-sm-inline-block" style="margin-top:5px;">
                    <h4>Dashboard Kelola Proyek (<?= $idproyek; ?>)</h4>
                </li>
            </ul>
            <!-- end Toggle Sidebar Dan Nama Dashboard -->
            <ul class="navbar-nav ml-auto">


                <!-- Bagian Enable Full Screen -->
                <li class="nav-item d-none d-lg-inline">
                    <a href="<?= base_url(); ?>/kelolaproyek/backtodataproyek" class="nav-link">
                        <i class="fas fa-arrow-alt-circle-left mr-2" style="color:purple"></i>Back To Data Proyek
                    </a>
                </li>
                <li class="nav-item d-none d-lg-inline">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url(); ?>/logout" role="button">
                        <i class="fas fa-power-off" style="color:red;"></i><span class="d-none mx-2 d-lg-inline">Log Out</span>
                    </a>
                </li>
                <!-- End Bagian Enable Full Screen -->

            </ul>
        </nav>
        <!-- End Bagian Navbar Atas -->

        <!-- Bagian SideBar -->
        <aside class="main-sidebar main-sidebar-custom sidebar-dark-primary elevation-7">
            <!-- Bagian Logo  Dan Judul -->
            <a href="<?= base_url() ?>/dashboard" class="brand-link">
                <img src="<?= base_url() ?>/img/logosmall2.png" alt="AdminLTE Logo" class="brand-image img-circle" style="opacity: 1">
                <span class="brand-text font-weight-light">PT ADIKA JAYA E.</span>
            </a>
            <!-- End Bagian Logo dan Judul -->
            <!-- Bagian Menu Sidebar -->
            <div class="sidebar">
                <!-- Bagian User Profile -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?= base_url() ?>/img/undraw_profile.svg" class="img-circle" alt="User Image">
                    </div>
                    <div class="info">
                        <a class="d-block"><?= $username; ?></a>
                    </div>
                </div>
                <!-- End Bagian User Profile -->
                <!-- Bagian Search SideBar -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- End Bagian Search SideBar -->
                <!-- Bagian Menu Sidebar -->
                <nav class="mt-2">
                    <!-- Bagian Item Menu Sidebar -->
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="<?= base_url() ?>/kelolaproyek" class="nav-link <?= ($_SESSION['aktif'] == 'home') ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-home mr-3"></i>
                                <p>
                                    Home
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url() ?>/kelolaproyek/bbmaterialutama" class="nav-link <?= ($_SESSION['aktif'] == 'bbdalamproses') ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-microchip mr-3"></i>
                                <p>
                                    Kelola Bahan Material
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url() ?>/kelolaproyek/tenagakerja" class="nav-link <?= ($_SESSION['aktif'] == 'tenagakerja') ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-users mr-3"></i>
                                <p>
                                    Tenaga Kerja
                                </p>
                            </a>
                        </li>
                        <!-- <li class="nav-item">
                            <a href="<//?= base_url() ?>/kelolaproyek/progressproyek" class="nav-link  <//?= ($_SESSION['aktif'] == 'progressproyek') ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-hourglass mr-3"></i>
                                <p>
                                    Progress Proyek
                                </p>
                            </a>
                        </li> -->
                        <!-- <li class="nav-item">
                            <a href="<//?= base_url(); ?>/kelolaproyek/pembayaranproyek" class="nav-link  <//?= ($_SESSION['aktif'] == 'pembayaranproyek') ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-money-bill mr-3"></i>
                                <p>
                                    Pembayaran Proyek
                                </p>
                            </a>
                        </li> -->
                        <li class="nav-item">
                            <a href="<?= base_url(); ?>/kelolaproyek/kelolabiayaoperasional" class=" nav-link <?= ($_SESSION['aktif'] == 'kelolabiayaoperasional') ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-tools mr-3"></i>
                                <p>
                                    Kelola B.Operasional
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url(); ?>/kelolaproyek/laporanhpp" class="nav-link <?= ($_SESSION['aktif'] == 'laporanhpp') ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-clipboard mr-3"></i>
                                <p>
                                    Laporan HPP
                                </p>
                            </a>
                        </li>
                        <li class="nav-header">Back</li>
                        <li class="nav-item">
                            <a href="<?= base_url(); ?>/kelolaproyek/backtodataproyek" class="nav-link">
                                <i class="fas fa-arrow-alt-circle-left mr-3"></i>
                                <p>
                                    Back To Data Proyek
                                </p>
                            </a>
                        </li>
                    </ul>
                    <!-- ENd Bagian Item MenuSidebar -->
                </nav>

            </div>
            <!-- End Bagian Menu Sidebar -->
        </aside>
        <!-- End Bagian Sidebar -->

        <!-- Bagian Content -->

        <!-- ENd Bagian Content -->
        <?= $this->renderSection('dashboardkelolaproyek'); ?>
        <!-- Bagian Footer -->
        <footer class=" main-footer">

            <strong>Copyright &copy; 2022 <a href="#">PT. Adika Jaya Engineering</a>.</strong> All rights reserved.
        </footer>
        <!-- End Bagian Footer -->

    </div>


    <script src="<?= base_url('assetslte') ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assetslte') ?>/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <script src="<?= base_url('assetslte') ?>/dist/js/adminlte.min.js?v=3.2.0"></script>
    <script src="<?= base_url('js/additional-methods.min.js'); ?>"></script>
    <script src="<?= base_url('js/validasiform.js'); ?>"></script>
    <!-- <script src="</?= base_url('assetslte'); ?>/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script> -->
    <!-- <script src="</?= base_url('assetslte'); ?>/plugins/bs-stepper/js/bs-stepper.min.js"></script>
    <script src="</?/= base_url('assetslte'); ?>/plugins/dropzone/min/dropzone.min.js"></script> -->
</body>

</html>