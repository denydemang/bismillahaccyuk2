<?= $this->extend('dashboard/admin/template'); ?>
<?= $this->section('dashboardadmin'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Perhitungan Biaya Material Penyusun (<?= $namamaterial; ?>)</h1>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div style="display:flex;align-items:center;justify-content:space-between;flex-direction:row">
                        <button data-toggle="modal" data-target="#modalmaterial" class="btn btn-outline-success mb-2 btntambah"><i class="fas fa-plus-circle mr-2"></i>Tambah Material Penyusun</button>
                        <a href="<?= base_url('admin/perhitunganbiayamaterial'); ?>"><button style="white-space:nowrap" class="btn btn-outline-warning">Kembali <i class="fas fa-arrow-right ml-2"></i></button></a>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="tablematerial table table-bordered table-striped table-hover text-center">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">ID MP</th>
                                    <th scope="col">ID Material</th>
                                    <th scope="col">Nama Material Penyusun</th>
                                    <th scope="col">Spesifikasi</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Satuan</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <?php $No = 1 ?>
                            <tbody>
                                <?php if (!empty($material)) : ?>
                                    <?php foreach ($material as $row) : ?>
                                        <tr>
                                            <td scope="col"><?= $No++; ?></td>
                                            <td scope="col"><?= $row['idmaterialpenyusun']; ?></td>
                                            <td scope="col"><?= $row['idmaterial']; ?></td>
                                            <td scope="col"><?= $row['namamp']; ?></td>
                                            <td scope="col"><?= $row['spesifikasimp']; ?></td>
                                            <td scope="col"><?= $row['jumlahmp']; ?></td>
                                            <td scope="col"><?= $row['satuanmp']; ?></td>
                                            <td scope="col">Rp <?= number_format($row['hargamp'], 0, '', '.'); ?>,-</td>
                                            <td scope="col-4">Rp <?= number_format($row['totalmp'], 0, '', '.'); ?>,-</td>
                                            <?php if ($row['revisi_id'] == 0) : ?>
                                                <td scope="col-4"><span class="badge badge-primary">Tidak Direvisi</span></td>
                                            <?php else : ?>
                                                <td scope="col-4"><span class="badge badge-success">Direvisi</span></td>
                                            <?php endif; ?>
                                            <?php if ($row['revisi_id'] != 0) : ?>
                                                <td>
                                                    <div class="flex-column">
                                                        <button data-id="<?= $row['idmaterialpenyusun']; ?>" data-id2="<?= $row['idmaterial']; ?>" class="btn btn-danger rounded-circle hapusmaterial"><i style="color:white;font-weight:bold" class="fas fa-trash"></i></button>
                                                    </div>
                                                </td>
                                            <?php else : ?>
                                                <td>
                                                    <div class="flex-column">
                                                        <button data-toggle="modal" data-target="#modalmaterial" data-id="<?= $row['idmaterialpenyusun']; ?>" class="btn btn-info rounded-circle btneditmaterial"><i style="color:white;font-weight:bold" class="fas fa-edit"></i></button>
                                                        <button data-id="<?= $row['idmaterialpenyusun']; ?>" data-id2="<?= $row['idmaterial']; ?>" class="btn btn-danger rounded-circle hapusmaterial"><i style="color:white;font-weight:bold" class="fas fa-trash"></i></button>
                                                    </div>
                                                </td>
                                            <?php endif; ?>
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
        <div class="card revisimaterial">
            <div class="card-header">
                <h4>Revisi Material Penyusun</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive mt-3">
                    <table class="tablematerial table table-bordered table-striped table-hover text-center">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">ID Revisi</th>
                                <th scope="col">ID MP</th>
                                <th scope="col">Nama Material Penyusun</th>
                                <th scope="col">Spesifikasi</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Satuan</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Total</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <?php $No = 1 ?>
                        <tbody>
                            <?php if (!empty($mprevisi)) : ?>
                                <?php foreach ($mprevisi as $row) : ?>
                                    <tr>
                                        <td scope="col"><?= $No++; ?></td>
                                        <td scope="col"><?= $row['idmprevisi']; ?></td>
                                        <td scope="col"><?= $row['idmaterialpenyusun']; ?></td>
                                        <td scope="col"><?= $row['namampr']; ?></td>
                                        <td scope="col"><?= $row['spesifikasimpr']; ?></td>
                                        <td scope="col"><?= $row['jumlahmpr']; ?></td>
                                        <td scope="col"><?= $row['satuanmpr']; ?></td>
                                        <td scope="col">Rp <?= number_format($row['hargampr'], 0, '', '.'); ?>,-</td>
                                        <td scope="col-4">Rp <?= number_format($row['totalmpr'], 0, '', '.'); ?>,-</td>
                                        <td>
                                            <div class="flex-column">
                                                <button data-toggle="modal" data-target="#modalmpr" data-id="<?= $row['idmprevisi']; ?>" class="btn btn-info rounded-circle btneditmpr"><i style="color:white;font-weight:bold" class="fas fa-edit"></i></button>
                                                <button data-id="<?= $row['idmprevisi']; ?>" data-id2="<?= $row['idmaterial']; ?>" data-id3="<?= $row['idmaterialpenyusun']; ?>" class="btn btn-danger rounded-circle hapusmpr"><i style="color:white;font-weight:bold" class="fas fa-trash"></i></button>
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
    </section>
    <section>
        <div class="modal fade" id="modalmaterial">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content bg-success">
                    <div class="modal-header">
                        <h4 class="modal-title judulmodal">
                            Tambah Material Penyusun
                        </h4>
                        <button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-12">
                            <form method="post" class="formmaterialpenyusun" action="<?= base_url('DashboardAdmin/simpanmaterialpenyusun'); ?>">
                                <div class="form-group form-row">
                                    <div class="col-lg-4 col-6">
                                        <label for="idmaterialpenyusun">ID Bahan Penyusun</label>
                                        <input type="text" readonly style="color:black;font-weight:bolder" name="idmaterialpenyusun" id="idmaterialpenyusun" class="form-control idmaterialpenyusun" value="<?= $idmaterialpenyusun; ?>">
                                    </div>
                                    <div class="col-lg-4 col-6">
                                        <label for="idmaterial">ID Material</label>
                                        <input type="text" readonly style="color:black;font-weight:bolder" name="idmaterial" id="idmaterial" class="form-control idmaterial" value="<?= $idmaterial; ?>">
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="idajuan">ID Ajuan *</label>
                                        <input type="text" readonly style="color:black;font-weight:bolder" name="idajuan" id="idajuan" name="idajuan" class="form-control idajuan" value="<?= $idajuan; ?>">
                                    </div>
                                </div>
                                <div class="form-group form-row">
                                    <div class="col-lg-4 col-6">
                                        <label for="namamp">Nama Material*</label>
                                        <input type="text" name="namamp" style="color:black;font-weight:bolder" id="namamp" class="form-control namamp">
                                    </div>
                                    <div class="col-lg-4 col-6">
                                        <label for="spesifikasimp">Spesifikasi *</label>
                                        <input type="text" style="color:black;font-weight:bolder" name="spesifikasimp" id="spesifikasimp" class="form-control spesifikasimp">
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="satuanmp">Satuan *</label>
                                        <select type="text" style="color:black;font-weight:bolder" name="satuanmp" id="satuanmp" class="form-control satuanmp">
                                            <option disabled selected>--Pilih Satuan--</option>
                                            <option value="Lot">Lot</option>
                                            <option value="Lbr">Lembar</option>
                                            <option value="Pcs">Pcs</option>
                                            <option value="Set">Set</option>
                                            <option value="Btg">Batang</option>
                                            <option value="Mtr">Meter</option>
                                            <option value="Cm">Centimeter</option>
                                            <option value="Kg">Kilogram</option>
                                            <option value="Can">Can</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group form-row">
                                    <div class="col-lg-4 col-6">
                                        <label for="jumlahmp">Qty *</label>
                                        <input type="text" style="color:purple;font-weight:bolder" name="jumlahmp" id="jumlahmp" class="form-control jumlahmp" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                    </div>
                                    <div class="col-lg-4 col-6">
                                        <label for="hargamp">Harga Satuan *</label>
                                        <input type="text" style="color:purple;font-weight:bolder" name="hargamp" id="hargamp" class="form-control hargamp">
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="totalmp">Total *</label>
                                        <input type="text" style="color:red;font-weight:bolder;font-size:larger" readonly name="totalmp" id="totalmp" class="form-control totalmp">
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
        <div class="modal fade" id="modalmpr">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content bg-success">
                    <div class="modal-header">
                        <h4 class="modal-title judulmodal">
                            Edit Revisi
                        </h4>
                        <button type="button" id="closempr" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-12">
                            <form method="post" class="formmpr" action="<?= base_url('DashboardAdmin/editrevisimp'); ?>">
                                <div class="form-group form-row">
                                    <div class="col-lg-6 col-6">
                                        <label for="idmprevisi">ID Revisi</label>
                                        <input type="text" readonly style="color:black;font-weight:bolder" name="idmprevisi" id="idmprevisi" class="form-control idmprevisi">
                                        <input type="hidden" readonly style="color:black;font-weight:bolder" name="idmaterial" id="idmaterial" class="form-control idmaterial">
                                    </div>
                                    <div class="col-lg-6 col-6">
                                        <label for="idmaterialpenyusun">ID MP</label>
                                        <input type="text" readonly style="color:black;font-weight:bolder" name="idmaterialpenyusun" id="idmaterialpenyusun" class="form-control idmaterialpenyusun">
                                    </div>
                                </div>
                                <div class="form-group form-row">
                                    <div class="col-lg-4 col-6">
                                        <label for="namampr">Nama Material*</label>
                                        <input type="text" readonly name="namampr" style="color:black;font-weight:bolder" id="namampr" class="form-control namampr">
                                    </div>
                                    <div class="col-lg-4 col-6">
                                        <label for="spesifikasimpr">Spesifikasi *</label>
                                        <input type="text" style="color:black;font-weight:bolder" name="spesifikasimpr" id="spesifikasimpr" class="form-control spesifikasimpr">
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="satuanmpr">Satuan *</label>
                                        <select type="text" style="color:black;font-weight:bolder" name="satuanmpr" id="satuanmpr" class="form-control satuanmpr">
                                            <option disabled selected>--Pilih Satuan--</option>
                                            <option value="Lot">Lot</option>
                                            <option value="Lbr">Lembar</option>
                                            <option value="Pcs">Pcs</option>
                                            <option value="Set">Set</option>
                                            <option value="Btg">Batang</option>
                                            <option value="Mtr">Meter</option>
                                            <option value="Cm">Centimeter</option>
                                            <option value="Kg">Kilogram</option>
                                            <option value="Can">Can</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group form-row">
                                    <div class="col-lg-4 col-6">
                                        <label for="jumlahmpr">Qty *</label>
                                        <input type="text" style="color:purple;font-weight:bolder" name="jumlahmpr" id="jumlahmpr" class="form-control jumlahmpr" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                    </div>
                                    <div class="col-lg-4 col-6">
                                        <label for="hargampr">Harga Satuan *</label>
                                        <input type="text" style="color:purple;font-weight:bolder" name="hargampr" id="hargampr" class="form-control hargampr">
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="totalmpr">Total *</label>
                                        <input type="text" style="color:red;font-weight:bolder;font-size:larger" readonly name="totalmpr" id="totalmpr" class="form-control totalmpr">
                                    </div>
                                </div>
                                <div class="form-group form-row">
                                    <button type="submit" class="btn btn-info btn-sm mr-2 simpan">Revisi Lagi</button>
                                    <button type="button" data-dismiss="modal" id="btncancelmpr" class="btn btn-danger btn-sm btncancel1">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </div>
        <div class="pesanmaterialpenyusun" data-gagal="<?= session()->getFlashdata('gagal'); ?>" data-berhasil="<?= session()->getFlashdata('berhasil'); ?>"></div>
    </section>
</div>
<script src="<?= base_url('js/pbmaterialpenyusun.js'); ?>"></script>


<?= $this->endSection(); ?>