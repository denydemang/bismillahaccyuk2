<?php

use App\Models\TenakerModel;

$this->extend('dashboard/kelolaproyek/template') ?>
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
                    <div class="table-responsive">
                        <table id="tabletenaker" class="table table-striped table-sm">
                            <thead>
                                <th>No</th>
                                <th>Id Tenaker</th>
                                <th>Jobdesk</th>
                                <th>Status Pekerjaan</th>
                                <th>Total Pekerja</th>
                                <th>Gaji</th>
                                <th>Total Gaji</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
                                <?php $Nomer = 1; ?>
                                <?php foreach ($datatenaker as $row) : ?>
                                    <tr>
                                        <th><?= $Nomer++; ?></th>
                                        <td><?= $row['id_pbtenaker']; ?></td>
                                        <!-- <td></?= $row['idajuan']; ?></td> -->
                                        <!-- <td><//?= $row['idproyek']; ?></td> -->
                                        <td><?= $row['jobdesk'] ?></td>
                                        <td><?= $row['statuspekerjaan'] ?></td>
                                        <td><?= $row['total_pekerja'] ?></td>
                                        <td>Rp <?= number_format($row['gaji'], 0, '', '.') ?>,-</td>
                                        <td>Rp <?= number_format($row['total_gaji'], 0, '', '.') ?>,-</td>
                                        <?php
                                        $tenaker = new TenakerModel();
                                        $data = $tenaker->where('id_pbtenaker', $row['id_pbtenaker'])->find();
                                        if (empty($data)) :
                                        ?>
                                            <td><span class="badge badge-primary">Belum Disewa</span></td>
                                        <?php else : ?>
                                            <td><span class="badge badge-success">Sudah Disewa</span></td>
                                        <?php endif; ?>
                                        <!-- <button id="btndetailtenaker" data-id="<//?= $row['id_pbtenaker']; ?>" data-toggle="modal" data-target="#ModalDetail" class="btn btn-sm btndetailtenaker btn-secondary">Detail</button> -->

                                        <td>
                                            <?php
                                            if (empty($data)) :
                                            ?>
                                                <button id="btnedittenaker" data-toggle="modal" data-target="#ModalTenaker" data-id="<?= $row['id_pbtenaker']; ?>" class="btn btn-success btn-sm btnedittenaker">Sewa</button>
                                            <?php else : ?>
                                                <button id="btnedittenaker" data-toggle="modal" data-target="#ModalTenaker" data-id="<?= $row['id_pbtenaker']; ?>" class="btn btn-success btn-sm btndetailsewa">Detail Sewa</button>
                                                <button id="btnedittenaker" data-toggle="modal" data-target="#ModalTenaker" data-id="<?= $row['id_pbtenaker']; ?>" class="btn btn-success btn-sm btndetailsewa">Jurnal</button>
                                            <?php endif; ?>

                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>

                        </table>
                    </div>


                </div>
                <!-- Modal Tenaker -->
                <div class="modal fade" id="ModalTenaker" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="TitleLabel">Sewa Tenaga Kerja</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form class="formtenaker" method="post" action="<?= base_url('DashboardKelolaProyek/SewaTenaker'); ?>">
                                    <?= csrf_field(); ?>
                                    <div class="form-row mb-3">
                                        <div class="col">
                                            <label for="id_pbtenaker">ID TK</label>
                                            <input type="text" readonly class="form-control id_pbtenaker" name="id_pbtenaker" id="id_pbtenaker" name="id_pbtenaker">
                                            <input type="hidden" readonly class="form-control idsewatenaker" name="idsewatenaker" id="idsewatenaker" name="idsewatenaker" value="<?= $idtenaker; ?>">
                                        </div>
                                        <div class="col">
                                            <label for="idproyek">Id Proyek</label>
                                            <input type="text" readonly class="form-control idproyek" name="idproyek" id="idproyek" name="idproyek" value="<?= $idproyek; ?>">
                                        </div>
                                    </div>
                                    <div class="form-row mb-3">
                                        <div class="col">
                                            <label for="gajiawal">Gaji (Awal)</label>
                                            <input readonly type="text" class="form-control gajiawal" name="gajiawal" id="gajiawal" name="gajiawal">
                                            <div class="sudah_bayarinvalid invalid-feedback"></div>
                                        </div>
                                        <div class="col">
                                            <label for="tanggal">Tanggal</label>
                                            <input readonly type="text" class="form-control tanggal" name="tanggal" id="tanggal" name="tanggal" value="<?= date("Y-m-d"); ?>">
                                            <div class="sudah_bayarinvalid invalid-feedback">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row mb-3">
                                        <div class="col">
                                            <label for="total_pekerja">Total Pekerja</label>
                                            <input readonly type="text" class="form-control total_pekerja" name="total_pekerja" id="total_pekerja" name="total_pekerja">
                                            <div class="gajiinvalid invalid-feedback"></div>
                                        </div>
                                        <div class="col">
                                            <label for="gaji">Sewa Tenaker</label>
                                            <input type="text" class="form-control gaji" name="gaji" id="gaji" name="gaji" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                            <div class="belum_bayarinvalid invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col">
                                            <label for="total_gaji">Total Gaji</label>
                                            <input readonly type="text" class="form-control total_gaji" name="total_gaji" id="total_gaji" name="total_gaji">
                                            <div class="belum_bayarinvalid invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <button id="btnsimpantenaker" type="submit" class="btn btn-primary btn-sm btnsimpantenaker mt-4">Tambah</button>
                                    <button id="btnsimpancanceltenaker" type="button" class="btn btn-danger btn-sm submit mt-4">Clear</button>
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
            </div>
        </div>
    </section>
</div>
<script>
    $('#tabletenaker').DataTable({
        "columnDefs": [{
            orderable: false,
            targets: [3, 4, 5, 6]
        }],
        "fixedColumns": {
            leftColumns: 1,
            rightColumns: 1
        },

    });
</script>
</div>
<script>
    $(document).ready(function() {
        $('.btnedittenaker').click(function() {
            let id_pbtenaker = $(this).data('id')
            $.ajax({
                url: "http://localhost:8080/DashboardKelolaProyek/GetTenaker/" + id_pbtenaker,
                dataType: "json",
                success: function(response) {
                    $('.id_pbtenaker').val(response.id_pbtenaker);
                    $('.id_pbtenaker').val(response.id_pbtenaker);
                    $('.gajiawal').val(response.gajiawal);
                    $('.total_pekerja').val(response.total_pekerja);
                    $('.gajiawal').val(response.gaji);
                }
            });
        })
        $('.tanggal').data
        $('.gaji').keyup(function() {
            let gaji = $(this).val()
            let total_pekerja = $('.total_pekerja').val();
            let total_gaji = gaji * total_pekerja

            $('.total_gaji').val(total_gaji);

        })

    })
</script>
<!-- <script src="<//?= base_url(); ?>/js/tenaker.js"></script> -->
<?= $this->endSection(); ?>