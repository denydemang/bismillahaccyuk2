<?php

use App\Models\BahanBakuProsesModel;
?>
<?php $this->extend('dashboard/kelolaproyek/template') ?>
<?php $this->section('dashboardkelolaproyek') ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Kelola Bahan Material</h1>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header row">
                    <div class="col-lg-10 col-6">
                        <h5>Table Data Material Penyusun Untuk Proyek <?= $dataproyek[0]['idproyek']; ?></h5>
                    </div>
                    <div class="col-lg-2 col-6">
                        <a href="<?= base_url('kelolaproyek/bbmaterialutama'); ?>"><button class="btn btn-outline-warning">Kembali<i class="fas fa-arrow-right ml-2"></i></button></a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- <button type="button" id="btntambahbahanbaku" class="btn btn-outline-danger btn-sm mb-3" data-toggle="modal" data-target="#modalbb">
                        <i class="fas fa-plus-circle mr-3"></i>Tambah Bahan Baku
                    </button> -->
                    <table id="tablebb" class="table table-striped table-sm">
                        <thead>
                            <th>No</th>
                            <th>Id Material Penyusun</th>
                            <th>Id Material Utama</th>
                            <th>Nama Material</th>
                            <th>Spesifikasi</th>
                            <th>Qty</th>
                            <th>Satuan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </thead>
                        <tbody>
                            <?php $No = 1 ?>
                            <?php foreach ($databb as $row) : ?>
                                <tr>
                                    <td><?= $No++; ?></td>
                                    <td><?= $row['idmaterialpenyusun']; ?></td>
                                    <td><?= $row['idmaterial']; ?></td>
                                    <td><?= $row['namamp']; ?></td>
                                    <td><?= $row['spesifikasimp']; ?></td>
                                    <td><?= $row['jumlahmp']; ?></td>
                                    <td><?= $row['satuanmp']; ?></td>
                                    <?php
                                    $belibb = new BahanBakuProsesModel();
                                    $data = $belibb->where('idmaterialpenyusun', $row['idmaterialpenyusun'])->find()
                                    ?>
                                    <?php if (empty($data)) : ?>
                                        <td><span class="badge badge-secondary">Belum Dibeli</span></td>
                                    <?php else : ?>
                                        <td><span class="badge badge-primary">Sudah Dibeli</span></td>
                                    <?php endif; ?>

                                    <td>
                                        <?php if (empty($data)) : ?>
                                            <button data-toggle="modal" data-id="<?= $row['idmaterialpenyusun']; ?>" data-target="#modalbb" class="btn btn-primary btnbeli">Beli</button>
                                        <?php else : ?>
                                            <button data-toggle='modal' data-target='#modaldetail' data-id="<?= $row['idmaterialpenyusun']; ?>" class="btn btn-danger btn-sm btnview"><i class="fas fa-eye"></i></button>
                                            <button data-id="<?= $row['idmaterialpenyusun']; ?>" class="btn btn-warning btn-sm btnbeli">Buat Jurnal</button>
                                        <?php endif; ?>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                    </table>
                </div>
            </div>
    </section>
    <section>
        <div class="modal fade" id="modalbb">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content bg-success">
                    <div class="modal-header">
                        <h4 class="modal-title judulmodal">Beli Bahan Baku</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formbbproses" method="post" action="<?= base_url('DashboardKelolaProyek/simpanbelibb'); ?>">
                            <?= csrf_field(); ?>
                            <div class="form-row form-group">
                                <div class="col">
                                    <label for="idproyek">Nama Material Penyusun</label>
                                    <input type="text" style="color:black;font-weight:bolder" readonly name="namamp" id="namamp" name="namamp" class="form-control namamp">
                                    <input type="hidden" style="color:black;font-weight:bolder" readonly name="idproyek" id="idproyek" name="idproyek" class="form-control idproyek" value="<?= session()->get('idproyek'); ?>">
                                    <input type="hidden" style="color:black;font-weight:bolder" readonly name="idmaterialpenyusun" id="idmaterialpenyusun" name="idmaterialpenyusun" class="form-control idmaterialpenyusun">
                                    <input type="hidden" style="color:black;font-weight:bolder" readonly name="idmaterial" id="idmaterial" name="idmaterial" class="form-control idmaterial">
                                </div>
                                <div class="col">
                                    <label for="tgl_beli">Tanggal Beli*</label>
                                    <div class="input-group date">
                                        <div class="input-group-append">
                                            <div class="input-group-text"><i class="fa fa-calendar tgl_beli"></i></div>
                                        </div>
                                        <input type="text" style="color:black;font-weight:bolder" id="tgl_beli" name="tgl_beli" class="form-control tgl_beli">
                                        <div class="invalid-feedback tgl_beliinvalid"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row form-group">

                                <div class="col">
                                    <label for="jumlah_beli">Qty</label>
                                    <input type="text" readonly style="color:#c6098d;font-weight:bolder" readonly id="jumlahmp" name="jumlahmp" class="form-control jumlahmp">
                                </div>
                                <div class="col">
                                    <label for="hargamp">Harga</label>
                                    <input type="text" readonly style="color:#c6098d;font-weight:bolder" id="hargamp" name="hargamp" class="form-control hargamp">
                                </div>
                            </div>
                            <div class="form-row form-group">
                                <div class="col">
                                    <label for="harga">Harga</label>
                                    <input type="text" style="color:#28A745;font-weight:bolder" id="harga" name="harga" class="form-control harga">
                                    <div class="invalid-feedback hargainvalid"></div>
                                </div>
                            </div>
                            <div class="form-group">
                            </div>
                            <div class="form-group">
                                <label for="totalharga">Total Harga</label>
                                <input type="text" readonly style="color:#101dbe;font-weight:bolder" id="totalharga" name="totalharga" class="form-control totalharga">
                            </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" id="btnsimpanbbproses" class="btn btnsimpanbbproses" style="background-color:aqua;font-weight:bolder"><i class="fas fa-money-bill mr-2"></i> Beli</button>
                        </form>
                        <button type="button" class="btn btn-danger btn btnclear">Clear</button>
                    </div>
                </div>
            </div>
        </div>

</div>
<script src="<?= base_url('jquery-ui-1.13.2') ?>/jquery-ui.js"></script>
<!-- <script src="<//?= base_url('jquery-month-picker') ?>/src/MonthPicker.js"></script> -->
<script src="<?= base_url('daterangepicker') ?>/moment.min.js"></script>
<script src="<?= base_url('daterangepicker') ?>/daterangepicker.js"></script>
<script src="<?= base_url('js/bbmaterialpenyusun.js'); ?>"></script>

<?= $this->endSection(); ?>