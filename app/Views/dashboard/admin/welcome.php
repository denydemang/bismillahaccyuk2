<?= $this->extend('dashboard/admin/template'); ?>

<?= $this->section('dashboardadmin'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h2>Selamat Datang <?= $nama; ?></h2>
                Anda Login Sebagai Admin
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= $jumlahproyek; ?></h3>
                            <p>Proyek</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-android-list"></i>
                        </div>
                        <a href="<?= base_url(); ?>/admin/dataproyek" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= $jumlahdataakun; ?></h3>
                            <p>User Terdaftar</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="<?= base_url(); ?>/admin/datauser" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= $jumlahajuan; ?></h3>
                            <p>Ajuan Proyek Belum Ditinjau</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-ios-briefcase"></i>
                        </div>
                        <a href="<?= base_url('admin/ajuanproyek'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?= $this->endSection(); ?>