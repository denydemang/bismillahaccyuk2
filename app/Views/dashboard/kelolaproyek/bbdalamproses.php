<?php $this->extend('dashboard/kelolaproyek/template') ?>
<?php $this->section('dashboardkelolaproyek') ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>BAHAN BAKU DALAM PROSES</h1>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h5>Table Data Bahan Baku Untuk Proyek <?= $dataproyek[0]['idproyek']; ?></h5>
                </div>
                <div class="card-body">
                    <!-- <button type="button" id="btntambahbahanbaku" class="btn btn-outline-danger btn-sm mb-3" data-toggle="modal" data-target="#modalbb">
                        <i class="fas fa-plus-circle mr-3"></i>Tambah Bahan Baku
                    </button> -->
                    <div id="tampiltablebb">

                    </div>
                </div>

            </div>
        </div>
    </section>
    <section>
        <!-- <div class="modal fade" id="modalbb">
            <div class="modal-dialog modal- modal-dialog-scrollable">
                <div class="modal-content bg-success">
                    <div class="modal-header">
                        <h4 class="modal-title judulmodal">Beli Bahan Baku</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="formbbproses" action="<?= base_url('DashboardKelolaProyek/simpanbbproses'); ?>">
                            <?= csrf_field(); ?>
                            <div class="form-row form-group">
                                <div class="col">
                                    <label for="idproyek"> ID Proyek</label>
                                    <input type="text" style="color:black;font-weight:bolder" readonly name="idproyek" id="idproyek" name="idproyekbb" class="form-control idproyek">
                                </div>
                                <div class="col">
                                    <label for="idbelibahan"> ID Beli</label>
                                    <input type="text" style="color:black;font-weight:bolder" readonly name="idbelibahan" id="idbelibahan" name="idbeli" class="form-control idbelibahan">
                                </div>
                            </div>
                            <div class="form-row form-group">
                                <div class="col">
                                    <label for="namabahan">Nama Bahan</label>
                                    <input type="text" style="color:black;font-weight:bolder" name="namabahan" id="namabahan" name="namabahan" class="form-control namabahan">
                                    <div class="invalid-feedback namabahaninvalid"></div>
                                </div>
                                <div class="col">
                                    <label for="tgl_beli">Tanggal Beli</label>
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
                                    <label for="harga">Harga</label>
                                    <input type="text" style="color:#28A745;font-weight:bolder" id="harga" name="harga" class="form-control harga">
                                    <div class="invalid-feedback hargainvalid"></div>
                                </div>
                                <div class="col">
                                    <label for="jumlah_beli">Jumlah Beli</label>
                                    <input type="text" style="color:#c6098d;font-weight:bolder" id="jumlah_beli" name="jumlah_beli" class="form-control jumlah_beli">
                                    <div class="invalid-feedback hargainvalid"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="totalharga">Total Harga</label>
                                <input type="text" readonly style="color:#101dbe;font-weight:bolder" id="totalharga" name="totalharga" class="form-control totalharga">
                            </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" id="btnsimpanbbproses" class="btn btnsimpanbbproses" style="background-color:aqua;font-weight:bolder"><i class="fas fa-save"></i> Simpan</button>
                        </form>
                        <button type="button" class="btn btn-danger btn btnclear">Clear</button>
                    </div>
                </div>
            </div>
        </div> -->


    </section>
    <section>
        <div class="modal fade" id="ModalDetailBB">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Tenaga Kerja</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <strong><i class="fas fa-book mr-1"></i> Nama Proyek <span class="detailidproyek">(ID: )</span></strong>
                                        <p class="text-muted detailnamaproyek mr-1">

                                        </p>
                                    </div>
                                    <div class="col">
                                        <strong><i class="fab fa-apple mr-1"></i>Nama Bahan <span class="detailidbelibahan">(ID: )</span></strong>
                                        <p class="text-muted mr-1 detailnamabahan">

                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col">
                                        <strong><i class="fas fa-calendar mr-1"></i> Tanggal Beli</strong>
                                        <p class="text-muted detailtgl_beli mr-1">

                                        </p>
                                    </div>
                                    <div class="col">
                                        <strong><i class="fas fa-ruler mr-1"></i> Ukuran</strong>
                                        <p class="text-muted detailukuran mr-1">

                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col">
                                        <strong><i class="fas fa-award mr-1"></i> Kualitas</strong>
                                        <p class="text-muted detailukuran mr-1">

                                        </p>
                                    </div>
                                    <div class="col">
                                        <strong><i class="fab fa-centos mr-1"></i> Jenis</strong>
                                        <p class="text-muted detailjenis mr-1">

                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col">
                                        <strong><i class="fab fa-hotjar mr-1"></i> Berat</strong>
                                        <p class="text-muted detailberat mr-1">

                                        </p>
                                    </div>
                                    <div class="col">
                                        <strong><i class="fas fa-infinity mr-1"></i> Ketebalan</strong>
                                        <p class="text-muted detailketebalan mr-1">
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col">
                                        <strong><i class="fas fa-ruler-combined mr-1"></i> Panjang</strong>
                                        <p class="text-muted detailpanjang mr-1">

                                        </p>
                                    </div>
                                    <div class="col">
                                        <strong><i class="fas fa-dollar-sign mr-1"></i> Harga</strong>
                                        <p class="text-muted detailharga mr-1">
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col">
                                        <strong><i class="fas fa-bullseye mr-1"></i> Jumlah Beli</strong>
                                        <p class="text-muted detailjumlah_beli mr-1">

                                        </p>
                                    </div>
                                    <div class="col">
                                        <strong><i class="fas fa-money-bill mr-1"></i> Total</strong>
                                        <p class="text-muted detailtotal mr-1">

                                        </p>
                                    </div>
                                </div>
                                <hr>

                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="<?= base_url('js/bbdalamproses.js'); ?>"></script>

<?= $this->endSection(); ?>