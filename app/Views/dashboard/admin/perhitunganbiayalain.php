<?= $this->extend('dashboard/admin/template'); ?>
<?= $this->section('dashboardadmin'); ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Perhitungan Biaya Operasional</h1>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <button data-toggle="modal" data-target="#modalbop" class="btn btn-outline-warning mb-2 btntambah"><i class="fas fa-plus-circle mr-2"></i>Tambah Biaya Operasional</button>
                    <div class="dropdown">
                        <button type="button" data-toggle="dropdown" class="btn btn-primary mb-2 pilihajuan">Pilih Id Ajuan <i class="ml-2 mb-2 dropdown-toggle"></i></button>
                        <div class="dropdown-menu dropdown-menu-lg">
                            <div class="card" style="width:600px !important">
                                <div class="card-header">
                                    <h3 class="card-title">Daftar Ajuan Proyek Diterima</h3>
                                </div>
                                <div class="card-body p-3">
                                    <table class="table text-nowrap daftarajuan">
                                        <thead>
                                            <th scope="col">ID AJUAN</th>
                                            <th scope="col">Nama Proyek</th>
                                            <th scope="col">Jenis Proyek</th>
                                            <th scope="col">Nama Klien</th>
                                        </thead>
                                        <tbody>
                                            <?php if ($dataajuannn) : ?>
                                                <?php foreach ($dataajuannn as $row) : ?>
                                                    <tr>
                                                        <td><button type="button" data-id="<?= $row['idajuan']; ?>" class="btn btn-primary btn-sm btnidajuan"><?= $row['idajuan']; ?></button> </td>
                                                        <td><?= $row['namaproyek']; ?></td>
                                                        <td><?= $row['jenisproyek']; ?></td>
                                                        <td><?= $row['nama']; ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="tablebop table table-bordered table-striped table-hover text-center">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">ID Biaya</th>
                                    <th scope="col">ID Ajuan</th>
                                    <th scope="col">Nama Transaksi</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Satuan</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Total Biaya</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <?php $No = 1 ?>
                            <?php

                            use App\Models\PerhitunganBOPRevisiModel;

                            ?>

                            <tbody>
                                <?php if (!empty($bop)) : ?>
                                    <?php foreach ($bop as $row) : ?>
                                        <tr>
                                            <td scope="col"><?= $No++; ?></td>
                                            <td scope="col"><?= $row['id_pbop']; ?></td>
                                            <td scope="col"><?= $row['idajuan']; ?></td>
                                            <td scope="col"><?= $row['namatrans']; ?></td>
                                            <td scope="col"><?= $row['quantity']; ?></td>
                                            <td scope="col"><?= $row['satuan']; ?></td>
                                            <td scope="col">Rp <?= number_format($row['harga'], 0, '', '.'); ?>,-</td>
                                            <td scope="col">Rp <?= number_format($row['tot_biaya'], 0, '', '.'); ?>,-</td>
                                            <?php $boprevisi = new PerhitunganBOPRevisiModel();
                                            $getdata = $boprevisi->find($row['id_pbop']);
                                            ?>
                                            <?php if ($getdata['revisi_id'] != 0) : ?>
                                                <td scope="col">
                                                    <span class="badge badge-warning">Direvisi</span>
                                                </td>
                                            <?php else : ?>
                                                <td scope="col">
                                                    <span class="badge badge-secondary">Tidak Direvisi</span>
                                                </td>
                                            <?php endif; ?>
                                            <td>
                                                <?php if ($getdata['revisi_id'] != 0) : ?>
                                                    <div class="flex-column">
                                                        <button data-id="<?= $row['id_pbop']; ?>" class="btn btn-danger rounded-circle hapusbop"><i style="color:white;font-weight:bold" class="fas fa-trash"></i></button>
                                                    </div>
                                                <?php else : ?>
                                                    <div class="flex-column">
                                                        <button data-toggle="modal" data-target="#modalbop" data-id="<?= $row['id_pbop']; ?>" class=" btn btn-info rounded-circle btneditbop"><i style="color:white;font-weight:bold" class="fas fa-edit"></i></button>
                                                        <button data-id="<?= $row['id_pbop']; ?>" class="btn btn-danger rounded-circle hapusbop"><i style="color:white;font-weight:bold" class="fas fa-trash"></i></button>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>

                                <?php endif; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">

                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4>Revisi Biaya Operasional</h4>
                    <div class="table-responsive mt-3">
                        <table class="tablebop table table-bordered table-striped table-hover text-center">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">ID Biaya</th>
                                    <th scope="col">Nama Transaksi</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Satuan</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Total Biaya</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <?php $No = 1 ?>
                            <tbody>
                                <?php if (!empty($bopr)) : ?>
                                    <?php foreach ($bopr as $row) : ?>
                                        <tr>
                                            <td scope="col"><?= $No++; ?></td>
                                            <td scope="col"><?= $row['id_pbop']; ?></td>
                                            <td scope="col"><?= $row['namatrans']; ?></td>
                                            <td scope="col"><?= $row['quantity']; ?></td>
                                            <td scope="col"><?= $row['satuan']; ?></td>
                                            <td scope="col">Rp <?= number_format($row['harga'], 0, '', '.'); ?>,-</td>
                                            <td scope="col">Rp <?= number_format($row['tot_biaya'], 0, '', '.'); ?>,-</td>
                                            <td>
                                                <div class="flex-column">
                                                    <button data-toggle="modal" data-target="#modalbop" data-id="<?= $row['id_pbop']; ?>" class=" btn btn-info rounded-circle btneditbopr"><i style="color:white;font-weight:bold" class="fas fa-edit"></i></button>
                                                    <button data-id="<?= $row['id_pbop']; ?>" class="btn btn-danger rounded-circle hapusbopr"><i style="color:white;font-weight:bold" class="fas fa-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>

                                <?php endif; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">

                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="modal fade" id="modalbop">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content bg-warning">
                    <div class="modal-header">
                        <h4 class="modal-title judulmodal">
                            Tambah Biaya Operasional
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-12">

                            <form method="post" class="formbop" action="<?= base_url('DashboardAdmin/simpanbop'); ?>">
                                <div class="form-group form-row">
                                    <div class="col-lg-6 col-6">
                                        <label for="id_pbop">ID Biaya</label>
                                        <input readonly type="text" style="color:black;font-weight:bolder" name="id_pbop" id="id_pbop" class="form-control id_pbop" value="<?= $id_pbop; ?>">
                                    </div>
                                    <div class="col-lg-6 col-6">
                                        <label for="idajuan">ID AJUAN</label>
                                        <input readonly type="text" style="color:black;font-weight:bolder" name="idajuan" id="idajuan" class="form-control idajuan" value="<?= $idajuan; ?>">
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="namatrans">Nama Transaksi*</label>
                                        <input type="text" style="color:black;font-weight:bolder" name="namatrans" id="namatrans" name="namatrans" class="form-control namatrans">
                                    </div>
                                </div>
                                <div class="form-group form-row">
                                    <div class="col-lg-4 col-6">
                                        <label for="satuan">Satuan*</label>
                                        <input type="text" name="satuan" style="color:black;font-weight:bolder" id="satuan" class="form-control satuan">
                                    </div>
                                    <div cla <div class="col-lg-4 col-6">
                                        <label for="quantity">Qty*</label>
                                        <input type="text" name="quantity" style="color:black;font-weight:bolder" id="quantity" class="form-control quantity" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                    </div>
                                    <div class="col-lg-4 col-6">
                                        <label for="harga">Harga*</label>
                                        <input type="text" name="harga" style="color:black;font-weight:bolder" id="harga" class="form-control harga">
                                    </div>
                                </div>
                                <div class="form-row form-group">
                                    <div class="col-lg-4">
                                        <label for="tot_biaya">Total Biaya*</label>
                                        <input readonly type="text" style="color:black;font-weight:bolder" name="tot_biaya" id="tot_biaya" class="form-control tot_biaya">
                                    </div>
                                </div>
                                <div class="form-group form-row">
                                    <button type="submit" class="btn btn-info btn-sm mr-2 simpan">Simpan</button>
                                    <button type="button" data-dismiss="modal" class="btn btn-danger btn-sm btncancel">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </div>
        <div class="pesanbop" data-gagal="<?= session()->getFlashdata('gagal'); ?>" data-berhasil="<?= session()->getFlashdata('berhasil'); ?>"></div>
    </section>
</div>
<script src="<?= base_url('js/perhitunganbop.js'); ?>"></script>
<?= $this->endSection(); ?>