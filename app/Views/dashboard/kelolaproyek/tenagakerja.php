<?php $this->extend('dashboard/kelolaproyek/template') ?>
<?php $this->section('dashboardkelolaproyek') ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Kelola Tenaga Kerja</h1>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <button type="button" id="btntambahtenaker" class="btn btn-success btn-sm mb-3" data-toggle="modal" data-target="#ModalTenaker">
                        <i class="fas fa-user-plus mr-3"></i></i>Tambah Tenaga Kerja
                    </button>
                    <div id="tampiltabletk">

                    </div>
                </div>

            </div>
            <!-- Modal Tenaker -->
            <div class="modal fade" id="ModalTenaker" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="TitleLabel">Tambah Tenaga Kerja</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="formtenaker" action="<?= base_url('DashboardKelolaProyek/simpantenaker'); ?>">
                                <div class="form-row mb-3">
                                    <div class="col">
                                        <label for="idtenaker">ID Tenaker</label>
                                        <input type="text" readonly class="form-control idtenaker" name="idtenaker" id="idtenaker" name="idtenaker">
                                    </div>
                                    <div class="col">
                                        <label for="idproyek">Id Proyek</label>
                                        <input type="text" readonly class="form-control idproyek" name="idproyek" id="idproyek" name="idproyek">
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col">
                                        <label for="namatenaker">Nama Tenaker</label>
                                        <input type="text" class="form-control namatenaker" name="namatenaker" id="namatenaker" name="namatenaker">
                                        <div class="namatenakerinvalid invalid-feedback">

                                        </div>
                                    </div>
                                    <div class="col">
                                        <label for="almttenaker">Alamat Tenaker</label>
                                        <input type="text" class="form-control almttenaker" name="almttenaker" id="almttenaker" name="almttenaker">
                                        <div class="almttenakerinvalid invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col">
                                        <label for="pekerjaan">Pekerjaan</label>
                                        <input type="text" class="form-control pekerjaan" name="pekerjaan" id="pekerjaan" name="pekerjaan">
                                        <div class="pekerjaaninvalid invalid-feedback"></div>
                                    </div>
                                    <div class="col">
                                        <label for="gaji">Gaji</label>
                                        <input type="text" class="form-control gaji" name="gaji" id="gaji" name="gaji">
                                        <div class="gajiinvalid invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col">
                                        <label for="sudah_bayar">Sudah Bayar</label>
                                        <input type="text" class="form-control sudah_bayar" name="sudah_bayar" id="sudah_bayar" name="sudah_bayar">
                                        <div class="sudah_bayarinvalid invalid-feedback"></div>
                                    </div>
                                    <div class="col">
                                        <label for="belum_bayar">Belum Bayar</label>
                                        <input type="text" class="form-control belum_bayar" name="belum_bayar" id="belum_bayar" name="belum_bayar">
                                        <div class="belum_bayarinvalid invalid-feedback"></div>
                                    </div>
                                </div>
                                <button id="btnsimpantenaker" type="submit" class="btn btn-primary btn-sm btnsimpantenaker">Tambah</button>
                                <button id="btnsimpancanceltenaker" type="button" class="btn btn-danger btn-sm submit">Clear</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>

            <!-- modal Detail Tenaga Kerja -->
            <div class="modal fade" id="ModalDetail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                            <strong><i class="fas fa-book mr-1 "></i>Nama Tenaker <span class="detailidtenaker">(ID: )</span></strong>
                                            <p class="text-muted detailnamatenaker mr-1">

                                            </p>
                                        </div>
                                        <div class="col">
                                            <strong><i class="fas fa-info mr-1"></i>Status Gaji</strong>
                                            <p class="mr-1 detailstatus">

                                            </p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col">
                                            <strong><i class="fas fa-briefcase mr-1"></i>ID Proyek</strong>
                                            <p class="text-muted detailidproyek mr-1">

                                            </p>
                                        </div>
                                        <div class="col">
                                            <strong><i class="fas fa-map-marker-alt mr-1"></i>Alamat Tenaker</strong>
                                            <p class="text-muted detailalamat mr-1">

                                            </p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col">
                                            <strong><i class="fas fa-user mr-1"></i>JobDesk</strong>
                                            <p class="text-muted detailpekerjaan mr-1">

                                            </p>
                                        </div>
                                        <div class="col">
                                            <strong><i class="fas fa-money-check-alt mr-1"></i>Gaji</strong>
                                            <p class="text-muted detailgaji mr-1">

                                            </p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col">
                                            <strong><i class="fas fa-money-bill mr-1"></i>Belum Bayar</strong>
                                            <p class="text-muted detailbelumbayar mr-1">

                                            </p>
                                        </div>
                                        <div class="col">
                                            <strong><i class="fas fa-dollar-sign mr-1"></i>Sudah Bayar</strong>
                                            <p class="text-muted detailsudahbayar mr-1">
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

            <!-- Modal Small -->
            <div class="modal fade" id="modal-sm" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Kurang Bayar</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" class="formbayar">
                                <label for="" style="font-weight:bolder; color:blue" class="labelbiaya">Biaya : Rp 50000</label><br>
                                <label for="" style="font-weight:bolder; color:purple">Sudah_Bayar</label>
                                <input type="text" readonly class="form-control sudah_bayar2" name="sudah_bayar2" id="sudah_bayar2" placeholder="">
                                <label for="" class="mt-3" style="font-weight:bolder; color:coral">Belum_Bayar</label>
                                <input type="text" readonly class="form-control belum_bayar2" name="belum_bayar2" id="belum_bayar2">
                                <input type="text" class="form-control inputbayar mt-3" name="inputbayar2" id="inputbayar2" placeholder="Masukkan Pembayaran Anda">
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="submit" class="btn btn-primary btnbayar">Bayar</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
    </section>
</div>
<script src="<?= base_url(); ?>/js/tenaker.js"></script>
<?= $this->endSection(); ?>