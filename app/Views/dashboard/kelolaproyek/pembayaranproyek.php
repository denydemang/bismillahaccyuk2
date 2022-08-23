<?php $this->extend('dashboard/kelolaproyek/template') ?>
<?php $this->section('dashboardkelolaproyek') ?>
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
    <section>
        <?php $this->extend('dashboard/kelolaproyek/template') ?>
        <?php $this->section('dashboardkelolaproyek') ?>
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
            <section>
                <div class="card">
                    <div class="card-header">
                        <button data-toggle="modal" data-target="#modaldetail" class="btn btn-outline-success"><i class="fas fa-plus"> Tambah Progress</i></button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tabletenaker" class="table table-bordered table-striped text-center">
                                <thead>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Pekerjaan Diselesaikan</th>
                                    <th>Persentase</th>
                                    <th>Gambar</th>
                                    <th>Aksi</th>
                                </thead>
                                <tbody>
                                    <?php $nomor = 1 ?>
                                    <?php foreach ($progress as $row) : ?>
                                        <tr>
                                            <td><?= $nomor++; ?></td>
                                            <td><?= date('d F Y', strtotime($row['tanggal'])); ?></td>
                                            <td><?= $row['pekerjaandiselesaikan']; ?></td>
                                            <td>
                                                <span><?= $row['persentase']; ?>%</span>
                                                <div class="progress">
                                                    <div class="progress-bar bg-primary progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: <?= $row['persentase']; ?>%">
                                                        <span class="sr-only">40% Complete (success)</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><a href="<?= base_url('DashboardKelolaProyek/downloadfile/' . $row['gambar'] . '/fileadmin'); ?>"><img style="width:250px;object-fit:contain" src="<?= base_url('fileadmin/' . $row['gambar']); ?>" alt=""></a></td>
                                            <td>
                                                <button data-id="<?= $row['idprogress']; ?>" class="btn btn-danger hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </section>
            <section>
                <div class="modal fade" id="modaldetail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content bg-success">
                            <div class="modal-header">
                                <h5 class="modal-title" id="TitleLabel">Tambah Progress Proyek</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" id="formprogress" class="formprogress" enctype='multipart/form-data' action="<?= base_url('DashboardKelolaProyek/SimpanProgress'); ?>">
                                    <div class="form-group form-row">
                                        <div class="col">
                                            <label for="idproyek">Id Proyek</label>
                                            <input readonly type="text" name="idproyek" id="idproyek" class="form-control idproyek" value="<?= $idproyek; ?>">
                                        </div>
                                        <div class="col">
                                            <label for="namaproyek">Nama Proyek</label>
                                            <input readonly type="text" name="namaproyek" id="namaproyek" class="form-control namaproyek" value="<?= $namaproyek; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group form-row">
                                        <div class="col">
                                            <label for="tanggal">Tanggal*</label>
                                            <input type="text" name="tanggal" id="tanggal" class="form-control tanggal" autocomplete="off">

                                        </div>
                                        <div class="col">
                                            <label for="persentase">Persentase Proyek*</label>
                                            <input type="text" name="persentase" id="persentase" class="form-control persentase" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                        </div>
                                    </div>
                                    <div class="form-group form-row">
                                        <div class="col">
                                            <label for="pekerjaandiselesaikan">Pekerjaan Yang Sudah Selesai</label>
                                            <input type="text" name="pekerjaandiselesaikan" id="pekerjaandiselesaikan" class="form-control pekerjaandiselesaikan">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="custom-file col-8">
                                            <label for="exampleFormControlFile1">Pilih Gambar</label>
                                            <input type="file" class="form-control-file" id="exampleFormControlFile1" name="uploadfile">
                                            <small id="emailHelp" class="form-text text-white">File Gambar Ukuran Maks 5mb </small>
                                        </div>
                                    </div>
                                    <button type="submit " class="btn btn-primary simpanprogress">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <div class="notif" data-gagal="<?= session()->getFlashdata('gagal'); ?>" data-berhasil="<?= session()->getFlashdata('berhasil'); ?>"></div>
        </div>
    </section>
</div>
<?= $this->endSection(); ?>