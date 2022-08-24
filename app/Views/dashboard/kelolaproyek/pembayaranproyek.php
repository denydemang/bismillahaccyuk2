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
        <div class="card">
            <div class="card-header">
                <button data-toggle="modal" data-target="#modaldetail" class="btn btn-outline-success"><i class="fas fa-plus"> Input Pembayaran</i></button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tabletenaker" class="table table-bordered table-striped text-center">
                        <thead>
                            <th>No</th>
                            <th>Id Proyek</th>
                            <th>Tanggal Bayar</th>
                            <th>Total Yang harus Dibayar</th>
                            <th>Total Belum Bayar</th>
                            <th>Bukti bayar</th>
                            <th>Aksi</th>
                        </thead>
                        <tbody>
                            <?php $nomor = 1 ?>
                            <?php foreach ($pembayaranproyek as $row) : ?>
                                <tr>
                                    <td><?= $nomor++; ?></td>
                                    <td><?= $row['idproyek']; ?></td>
                                    <td><?= date('d F Y', strtotime($row['tgl_bayar'])); ?></td>
                                    <td><?= $row['total_bayar']; ?></td>
                                    <td><?= $row['belum_bayar']; ?></td>
                                    <td><?= $row['uploadfile']; ?></td>
                                    <td>
                                        <button class="btn btn-primary-outline">Bayar</button>
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
                        <h5 class="modal-title" id="TitleLabel">Input Pembayaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="formpembayaran" class="formpembayaran" enctype='multipart/form-data' action="<?= base_url('DashboardKelolaProyek/SimpanBayar'); ?>">
                            <div class="form-group form-row">
                                <div class="col">
                                    <label for="idproyek">Id Proyek</label>
                                    <input readonly type="text" name="idproyek" id="idproyek" class="form-control idproyek" value="<?= $idproyek; ?>">
                                </div>
                                <div class="col">
                                    <label for="tgl_bayar">Tanggal Bayar*</label>
                                    <input readonly type="text" name="tgl_bayar" id="tgl_bayar" class="form-control tgl_bayar">
                                </div>
                            </div>
                            <div class="form-group form-row">
                                <div class="col">
                                    <label for="invoice">Bukti bayar*</label>
                                    <input type="text" name="invoice" id="invoice" class="form-control invoice" autocomplete="off">

                                </div>
                                <div class="col">
                                    <label for="total_bayar">Total Bayar*</label>
                                    <input type="text" name="total_bayar" id="total_bayar" class="form-control total_bayar" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                </div>
                            </div>
                            <div class="form-group form-row">
                                <div class="col">
                                    <label for="belum_bayar">Belum Bayar</label>
                                    <input type="text" name="belum_bayar" id="belum_bayar" class="form-control belum_bayar" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="custom-file col-8">
                                    <label for="exampleFormControlFile1">uploadfile</label>
                                    <input type="file" class="form-control-file uploadfile" id="exampleFormControlFile1" name="uploadfile">
                                    <small id="emailHelp" class="form-text text-white">File Gambar Ukuran Maks 5mb </small>
                                </div>
                            </div>
                            <button type="submit " class="btn btn-primary simpanbayar">Simpan</button>
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