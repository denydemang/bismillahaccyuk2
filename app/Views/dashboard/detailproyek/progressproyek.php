<?= $this->extend('dashboard/detailproyek/template'); ?>
<?= $this->section('dashboardetailproyek'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Progress Proyek</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <th>Id Proyek</th>
                                    <th>Nama Proyek</th>
                                    <th>Tanggal</th>
                                    <th>Progress Proyek </th>
                                    <th>Persentase</th>
                                    <th>Gambar</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>PRY001</td>
                                        <td>Proyek Uhuy</td>
                                        <td>12/07/2022</td>
                                        <td>Pembuatan rangka mesin</td>
                                        <td>25%</td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
<?= $this->endSection(); ?>