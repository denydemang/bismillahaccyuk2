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
                                                <button id="btnsewatenaker" data-toggle="modal" data-target="#ModalTenaker" data-id="<?= $row['id_pbtenaker']; ?>" class="btn btn-success btn-sm btnedittenaker">Sewa</button>
                                            <?php else : ?>
                                                <button id="btndetailtenaker" data-toggle="modal" data-target="#modaldetail" data-id="<?= $row['id_pbtenaker']; ?>" class="btn btn-info btn-sm btndetailsewa"><i class="fas fa-eye"></i></button>
                                                <button id="btnjurnatk" data-id="<?= $row['id_pbtenaker']; ?>" class="btn btn-success btn-sm btndetailsewa">Jurnal</button>
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
                                            <label for="gajiawal">Biaya Sewa(RAB)</label>
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
                                    <button id="btnsimpantenaker" type="submit" class="btn btn-success btn-sm btnsimpantenaker mt-4">Sewa</button>

                                </form>
                            </div>
                            <div class="modal-footer">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- modal Detail Tenaga Kerja -->
                <section>
                    <div class="modal fade" id="modaldetail">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                            <div class="modal-content bg-primary">
                                <div class="modal-header">
                                    <h4 class="modal-title judulmodal">
                                        Detail Material
                                    </h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <h4>Rincian Tenaga Kerja Di RAB</h4>
                                            <table class="table table-sm table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Jobdesk</th>
                                                        <th>Status Pekerjaan</th>
                                                        <th>Total Pekerja</th>
                                                        <th>Biaya Sewa</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="jobdeskdetail"></td>
                                                        <td class="statuspekerjaandetail"></td>
                                                        <td class="totalpekerjadetail"></td>
                                                        <td class="biayasewadetail"></td>
                                                        <td class="totaldetail"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="table-responsive ">
                                            <h4>Biaya TK Sesungguhnya</h4>
                                            <table class="table bahanpenyusun table-bordered table-sm">
                                                <tr>
                                                    <th>Jobdesk</th>
                                                    <th>Status Pekerjaan</th>
                                                    <th>Total Pekerja</th>
                                                    <th>Biaya Sewa</th>
                                                    <th>Total Harga</th>
                                                </tr>
                                                <tr>
                                                    <td class="jobdesks">Nama Material</td>
                                                    <td class="statuspekerjaans">Spesifikasi</td>
                                                    <td class="totalpekerjas">Satuan</td>
                                                    <td class="biayasewas">Qty</td>
                                                    <td class="totals">Harga</td>
                                                <tr>
                                                    <th colspan="4">Keuntungan</th>
                                                    <th class="keuntungan">Keuntungan</th>
                                                </tr>

                                                </tr>
                                            </table>


                                        </div>
                                    </div>
                                    <div class="modal-footer">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

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
    const formatRupiahtyping = (money) => {
        angka = money.replace(/[^,\d]/g, "");
        if (isNaN(angka)) {
            angka = 0;
        }
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(angka);
    }
    const formatRupiah1 = (money) => {
        if (isNaN(money)) {
            money = 0;
        }
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(money);
    }
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

        $('.gaji').keyup(function() {
            let gaji = $(this).val()
            let total_pekerja = $('.total_pekerja').val();
            let total_gaji = gaji * total_pekerja

            $('.total_gaji').val(total_gaji);

        })
        $('#btndetailtenaker').click(function() {
            let id_pbtenaker = $(this).data('id');
            console.log('ok');

            $.ajax({
                url: "http://localhost:8080/DashboardKelolaProyek/getdetailtenaker/" + id_pbtenaker,
                dataType: "json",
                success: function(response) {
                    console.log(response);

                    $('.jobdeskdetail').html(response.datatkrab[0]['jobdesk'])
                    $('.statuspekerjaandetail').html(response.datatkrab[0]['statuspekerjaan'])
                    $('.totalpekerjadetail').html(response.datatkrab[0]['total_pekerja'])
                    $('.biayasewadetail').html(formatRupiah1(response.datatkrab[0]['gaji']))
                    $('.totaldetail').html(formatRupiah1(response.datatkrab[0]['total_gaji']))

                    $('.jobdesks').html(response.datatkrab[0]['jobdesk'])
                    $('.statuspekerjaans').html(response.datatkrab[0]['statuspekerjaan'])
                    $('.totalpekerjas').html(response.datatkrab[0]['total_pekerja'])
                    $('.biayasewas').html(formatRupiah1(response.datatkasli[0]['gaji']))
                    $('.totals').html(formatRupiah1(response.datatkasli[0]['total_gaji']))

                    let keuntungan = parseInt(response.datatkrab[0]['total_gaji']) - parseInt(response.datatkasli[0]['total_gaji']);
                    $('.keuntungan').html(formatRupiah1(keuntungan))

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        })

    })
</script>
<!-- <script src="<//?= base_url(); ?>/js/tenaker.js"></script> -->
<?= $this->endSection(); ?>