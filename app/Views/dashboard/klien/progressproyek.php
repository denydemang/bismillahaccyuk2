<?= $this->extend('dashboard/klien/template'); ?>
<?= $this->section('dashboardklien'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Progress Proyek Anda</h1>
                </div>
            </div>
        </div>
    </section>
    <div class="container">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped ">
                                <thead>
                                    <th>No</th>
                                    <th>Id Proyek</th>
                                    <th>Id Ajuan</th>
                                    <th>Id Klien</th>
                                    <th>Tanggal</th>
                                    <th>Nama Proyek</th>
                                    <th>Progress Proyek</th>
                                    <th>Persentase Progress</td>
                                    <th>Gambar</th>
                                </thead>
                                <tbody>
                                    <?php $no = 1 ?>
                                    <?php foreach ($dataprogress as $progress) : ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $progress['idproyek']; ?></td>
                                            <td><?= $progress['idajuan']; ?></td>
                                            <td><?= $progress['user_id']; ?></td>
                                            <td><?= $progress['tanggal']; ?></td>
                                            <td><?= $progress['namaproyek']; ?></td>
                                            <td><?= $progress['progressproyek']; ?></td>
                                            <td><?= $progress['persentase']; ?></td>
                                            <td><?= $progress['gambar']; ?></td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<?= $this->endSection(); ?>