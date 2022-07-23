<?= $this->extend('dashboard/detailproyek/template'); ?>
<?= $this->section('dashboardetailproyek'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pembayaran Proyek</h1>
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
                    <div class="col-8">
                        <ul class="list-group">
                            <li class="list-group-item">idproyek: PRY001</li>
                            <li class="list-group-item">Jumlah yang Harus Dibayar: 5000000</li>
                            <li class="list-group-item">Jumlah yang Sudah Dibayar: 3000000</li>
                            <li class="list-group-item">Total yang Belum Dibayar: 2000000</li>

                        </ul>
                    </div>
                    <br>
                    <table class="table">
                        <thead class="bg-dark">
                            <tr>
                                <th>Id Proyek</th>
                                <th>Nama Proyek</th>
                                <th>Tanggal</th>
                                <th>Jumlah yang Belum Dibayar</th>
                        </thead>
                        <tbody>
                            <tr>
                                <th>PRY001</th>
                                <th>Proyek Uhuy</th>
                                <th>22/12/2020</th>
                                <th>2000000</th>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </section>
</div>
<?= $this->endSection(); ?>