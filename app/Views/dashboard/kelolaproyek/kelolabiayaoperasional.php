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
                                                <button data-toggle="modal" data-target="#modaldetail" data-id="<?= $row['id_pbop']; ?>" class="btn btn-warning btn-sm rounded-circle btndetailbop"><i class="fas fa-eye text-white"></i></button>
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
                                    <input type="text" class="form-control tanggal" id="tanggal" name="tanggal" value="<?= date("Y-m-d"); ?>">
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
                                    <input type="text" class="form-control harga" name="harga" id="harga">
                                    <div class="belum_bayarinvalid invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <label for="harga">Total</label>
                                    <input readonly type="text" class="form-control tot_biaya" name="tot_biaya" id="tot_biaya" name="tot_biaya">
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
    <section>
        <div class="modal fade" id="modaldetail">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content bg-primary">
                    <div class="modal-header">
                        <h4 class="modal-title judulmodal">
                            Detail BOP
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-12">
                            <div class="table-responsive">
                                <h4>Rincian Biaya Operasional Di RAB</h4>
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nama Transaksi</th>
                                            <th>Quantity</th>
                                            <th>Satuan</th>
                                            <th>Harga</th>
                                            <th>Total Biaya</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="namatransdetail"></td>
                                            <td class="quantitydetail"></td>
                                            <td class="satuandetail"></td>
                                            <td class="hargadetail"></td>
                                            <td class="totaldetail"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive ">
                                <h4>Biaya Operasonal Sesungguhnya</h4>
                                <table class="table bahanpenyusun table-bordered table-sm">
                                    <tr>
                                        <th>Nama Transaksi</th>
                                        <th>Quantity</th>
                                        <th>Satuan</th>
                                        <th>Harga</th>
                                        <th>Total Harga</th>
                                    </tr>
                                    <tr>
                                        <td class="namatransdetails">Nama Material</td>
                                        <td class="quantitydetails">Spesifikasi</td>
                                        <td class="satuandetails">Satuan</td>
                                        <td class="hargadetails">Qty</td>
                                        <td class="totaldetails">Harga</td>
                                    <tr>
                                        <th colspan="4">Selisih</th>
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
</div>
<script src="<?= base_url('jquery-ui-1.13.2') ?>/jquery-ui.js"></script>
<script>
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
    $(document).ready(function() {
        $('.tanggal').datepicker({
            dateFormat: 'yy-mm-dd'
        })
        $(function() {
            $('.tanggal').keypress(function(event) {
                event.preventDefault();
                return false;
            });
        })
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
                    $('.hargaawal').val(formatRupiah1(response[0]['harga']))
                }
            });
        })
        $('.btndetailbop').click(function() {
            let id_pbop = $(this).data('id');
            console.log('ok');

            $.ajax({
                url: "http://localhost:8080/DashboardKelolaProyek/getdetailbop/" + id_pbop,
                dataType: "json",
                success: function(response) {
                    console.log(response);


                    $('.namatransdetail').html(response.databoprab[0]['namatrans'])
                    $('.quantitydetail').html(response.databoprab[0]['quantity'])
                    $('.satuandetail').html(response.databoprab[0]['satuan'])
                    $('.hargadetail').html(formatRupiah1(response.databoprab[0]['harga']))
                    $('.totaldetail').html(formatRupiah1(response.databoprab[0]['tot_biaya']))

                    $('.namatransdetails').html(response.databoprab[0]['namatrans'])
                    $('.quantitydetails').html(response.databoprab[0]['quantity'])
                    $('.satuandetails').html(response.databoprab[0]['satuan'])
                    $('.hargadetails').html(formatRupiah1(response.databopasli[0]['harga']))
                    $('.totaldetails').html(formatRupiah1(response.databopasli[0]['tot_biaya']))

                    let keuntungan = parseInt(response.databoprab[0]['tot_biaya']) - parseInt(response.databopasli[0]['tot_biaya']);
                    $('.keuntungan').html(formatRupiah1(keuntungan))

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        })

        $('.harga').keyup(function() {
            $(this).val(formatRupiahtyping($(this).val()));
            let str = $(this).val()
            str = str.replace(/[^0-9/]/g, '')
            let harga = parseInt(str);
            let qty = parseInt($('.quantity').val());
            let total = harga * qty
            $('.tot_biaya').val(formatRupiah1(total));
        })
    })
</script>
<?= $this->endSection(); ?>