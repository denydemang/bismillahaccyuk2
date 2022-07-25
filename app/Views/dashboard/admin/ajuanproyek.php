<?= $this->extend('dashboard/admin/template'); ?>
<?= $this->section('dashboardadmin'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Ajuan Proyek Klien</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped ">
                            <thead>
                                <th>Nama Proyek</th>
                                <th>Jenis Proyek</th>
                                <th>Nama Klien</th>
                                <th>Alamat</th>
                                <th>No Telpon</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>ASU</td>
                                    <td>sdfsfsf</td>
                                    <td>sdfsfs</td>
                                    <td>sdfsf</td>
                                    <td>sdfsf</td>
                                    <td><button class="btn btn-sm btn-success">Detail</button> | <button class="btn btn-sm btn-primary">Terima </button>| <button class="btn btn-sm btn-danger">Tolak</button>|</td>

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