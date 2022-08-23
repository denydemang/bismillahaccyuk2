<?php

use App\Models\BOPModel;
?>

<?php $this->extend('dashboard/kelolaproyek/template') ?>
<?php $this->section('dashboardkelolaproyek') ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Kelola Biaya Operasional</h1>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-lg">
                            <thead>
                                <tr>
                                    <th>ID Biaya</th>
                                    <th>Nama Transaksi</th>
                                    <th>Quantity</th>
                                    <th>Satuan</th>
                                    <th>Harga</th>
                                    <th>Tot Biaya</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($kelolabop as $row) : ?>
                                    <tr>
                                        <td><?= $row['id_pbop']; ?></td>
                                        <td><?= $row['namatrans']; ?></td>
                                        <td><?= $row['quantity']; ?></td>
                                        <td><?= $row['satuan']; ?></td>
                                        <td>Rp <?= number_format($row['harga'], 0, '', '.'); ?>,-</td>
                                        <td>Rp <?= number_format($row['tot_biaya'], 0, '', '.'); ?>,-</td>
                                        <?php
                                        $bop = new BOPModel();
                                        $data = $bop->where('id_pbop', $row['id_pbop'])->find();
                                        ?>
                                        <?php if (empty($data)) : ?>
                                            <td><span class="badge badge-secondary">Belum Bayar</span></td>
                                        <?php else : ?>
                                            <td><span class="badge badge-success">Sudah Bayar</span></td>
                                        <?php endif; ?>
                                        <td>

                                            <?php if (empty($data)) : ?>
                                                <button data-toggle="modal" data-id="<?= $row['id_pbop']; ?>" data-target="#ModalTenaker" class="btn btn-primary btn-sm rounded-circle bayar">Bayar</button>
                                            <?php else : ?>
                                                <button data-id="<?= $row['id_pbop']; ?>" class="btn btn-warning btn-sm rounded-circle">Detail</button>
                                                <button data-id="<?= $row['id_pbop']; ?>" class="btn btn-success btn-sm rounded-circle">Jurnal</button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <section>
        <div class="modal fade" id="ModalTenaker" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="TitleLabel">Bayar Biaya Operasional</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="formbop" method="post" action="<?= base_url('DashboardKelolaProyek/BayarBOP'); ?>">
                            <?= csrf_field(); ?>
                            <div class="form-row mb-3">
                                <div class="col">
                                    <label for="id_pbop">ID TK</label>
                                    <input type="text" readonly class="form-control id_pbop" name="id_pbop" id="id_pbop">
                                    <input type="hidden" readonly class="form-control id_pbopr" id="id_pbopr" name="id_pbopr" value="<?= $id_pbopr; ?>">
                                </div>
                                <div class="col">
                                    <label for="idproyek">Id Proyek</label>
                                    <input type="text" readonly class="form-control idproyek" id="idproyek" name="idproyek" value="<?= $idproyek; ?>">
                                </div>
                            </div>
                            <div class="form-row mb-3">
                                <div class="col">
                                    <label for="namatrans">Nama Transaksi</label>
                                    <input readonly type="text" class="form-control namatrans" id="namatrans" name="namatrans">
                                    <div class="sudah_bayarinvalid invalid-feedback"></div>
                                </div>
                                <div class="col">
                                    <label for="tanggal">Tanggal</label>
                                    <input readonly type="text" class="form-control tanggal" id="tanggal" name="tanggal" value="<?= date("Y-m-d"); ?>">
                                    <div class="sudah_bayarinvalid invalid-feedback">

                                    </div>
                                </div>
                            </div>
                            <div class="form-row mb-3">
                                <div class="col">
                                    <label for="quantity">Qty</label>
                                    <input readonly type="text" class="form-control quantity" id="quantity" name="quantity">
                                    <div class="gajiinvalid invalid-feedback"></div>
                                </div>
                                <div class="col">
                                    <label for="satuan">Satuan</label>
                                    <input readonly type="text" class="form-control satuan" name="satuan" id="satuan">
                                    <div class="belum_bayarinvalid invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <label for="hargaawal">Harga Awal</label>
                                    <input readonly type="text" class="form-control hargaawal" name="hargaawal" id="hargaawal" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                    <div class="belum_bayarinvalid invalid-feedback"></div>
                                </div>
                                <div class="col">
                                    <label for="harga">Harga Asli</label>
                                    <input type="text" class="form-control harga" name="harga" id="harga" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                    <div class="belum_bayarinvalid invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <label for="harga">Total</label>
                                    <input readonly type="text" class="form-control tot_biaya" name="tot_biaya" id="tot_biaya" name="tot_biaya" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                </div>
                            </div>
                            <button id="btnsimpantenaker" type="submit" class="btn btn-primary btn-sm btnsimpantenaker mt-4">Bayar</button>
                            <button id="btnsimpancanceltenaker" type="button" class="btn btn-danger btn-sm submit mt-4">Clear</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>
<script>
    $('.bayar').click(function() {
        let id = $(this).data('id');
        $.ajax({
            url: "http://localhost:8080/DashboardKelolaProyek/getbop/" + id,
            dataType: "json",
            success: function(response) {
                console.log(response);
                $('.id_pbop').val(response[0]['id_pbop'])
                $('.namatrans').val(response[0]['namatrans'])
                $('.quantity').val(response[0]['quantity'])
                $('.satuan').val(response[0]['satuan'])
                $('.hargaawal').val(response[0]['harga'])
            }
        });
    })
    $('.harga').keyup(function() {
        let harga = parseInt($(this).val());
        let qty = parseInt($('.quantity').val());
        let total = harga * qty
        if (!isNaN(total)) {
            $('.tot_biaya').val(total);
        } else {
            $('.tot_biaya').val(0);
        }
    })
</script>
<?= $this->endSection(); ?>