<?= $this->extend('dashboard/admin/template'); ?>
<?= $this->section('dashboardadmin'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Kelola Proyek</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-danger">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped ">
                            <thead>
                                <th>No</th>
                                <th>Nama Proyek</th>
                                <th>Jenis Proyek</th>
                                <th>Nama Klien</th>
                                <th>Jumlah Yang Belum Dibayar</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="9">
                                        <h5 style="text-align:center">Tidak Ada Data Proyek</h5>
                                    </td>

                                </tr>

                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </section>
</div>




<?= $this->endSection(); ?>