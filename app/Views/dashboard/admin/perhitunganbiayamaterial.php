<?= $this->extend('dashboard/admin/template'); ?>
<?= $this->section('dashboardadmin'); ?>
<div class="content-wrapper">
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1>Perhitungan Biaya Material</h1>
            </div>
         </div>
      </div>
   </section>
   <section>
      <div class="container-fluid">
         <div class="card">
            <div class="card-body">
               <button data-toggle="modal" data-target="#modalmaterial" class="btn btn-outline-info mb-2 btntambah"><i class="fas fa-plus-circle mr-2"></i>Tambah Material</button>
               <div class="table-responsive">
                  <table class="tablematerial table table-bordered table-striped table-hover text-center">
                     <thead>
                        <tr>
                           <th scope="col">No</th>
                           <th scope="col">ID</th>
                           <th scope="col">ID Ajuan</th>
                           <th scope="col">Nama Material</th>
                           <th scope="col">Material Penyusun</th>
                           <th scope="col">Qty</th>
                           <th scope="col">Harga</th>
                           <th scope="col">Total Harga</th>
                           <th scope="col">Aksi</th>
                        </tr>
                     </thead>
                     <?php $No = 1 ?>
                     <tbody>
                        <?php if (!empty($datamaterial)) : ?>
                           <?php foreach ($datamaterial as $row) : ?>
                              <tr>
                                 <td><?= $No++; ?></td>
                                 <td><?= $row['idmaterial']; ?></td>
                                 <td><?= $row['idajuan']; ?></td>
                                 <td><?= $row['namamaterial']; ?></td>
                                 <td><a href="<?= base_url('admin/perhitunganbiayamaterialpenyusun/' . $row['idmaterial']); ?>"><button class="btn btn-warning rounded-circle"><i style="color:white;font-weight:bold" class="fas fa-pen"></i></button></a></td>
                                 <td><?= $row['qtymaterial']; ?></td>
                                 <?php if (!empty($row['hargamaterial'])) : ?>
                                    <td>Rp <?= number_format($row['hargamaterial'], 0, '', '.'); ?>,-</td>
                                 <?php else : ?>
                                    <td>Belum Dihitung</td>
                                 <?php endif; ?>
                                 <?php $total = (intval($row['hargamaterial']) * intval($row['qtymaterial'])) ?>
                                 <?php if (!empty($total)) : ?>
                                    <td>Rp <?= number_format($total, 0, '', '.'); ?>,-</td>
                                 <?php else : ?>
                                    <td>Belum Dihitung</td>
                                 <?php endif; ?>
                                 <td>
                                    <div class="flex-row">
                                       <button data-toggle="modal" data-target="#modaldetail" data-id="<?= $row['idmaterial']; ?>" class="btn btn-success rounded-circle btndetailmaterial"><i style="color:white;font-weight:bold" class="fas fa-eye"></i></button>
                                       <button data-toggle="modal" data-target="#modalmaterial" data-id="<?= $row['idmaterial']; ?>" class="btn btn-info rounded-circle btneditmaterial"><i style="color:white;font-weight:bold" class="fas fa-edit"></i></button>
                                       <button data-id="<?= $row['idmaterial']; ?>" class="btn btn-danger rounded-circle hapusmaterial"><i style="color:white;font-weight:bold" class="fas fa-trash"></i></button>
                                    </div>
                                 </td>
                              </tr>
                           <?php endforeach; ?>
                        <?php else : ?>
                           <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                           </tr>
                        <?php endif; ?>

                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </section>
   <section>
      <div class="modal fade" id="modalmaterial">
         <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content bg-info">
               <div class="modal-header">
                  <h4 class="modal-title judulmodal">
                     Tambah Material
                  </h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <div class="col-12">
                     <div class="dropdown">
                        <button type="button" data-toggle="dropdown" class="btn btn-success mb-2 pilihajuan">Pilih Id Ajuan <i class="ml-2 mb-2 dropdown-toggle"></i></button>
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
                                       <tr>
                                          <?php foreach ($dataajuannn as $row) ?>
                                          <td><button type="button" data-id="<?= $row['idajuan']; ?>" class="btn btn-primary btn-sm btnidajuan"><?= $row['idajuan']; ?></button> </td>
                                          <td><?= $row['namaproyek']; ?></td>
                                          <td><?= $row['jenisproyek']; ?></td>
                                          <td><?= $row['nama']; ?></td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
                     <form method="post" class="formmaterial" action="<?= base_url('DashboardAdmin/simpanmaterial'); ?>">
                        <div class="form-group form-row">
                           <div class="col-lg-4 col-6">
                              <label for="idmaterial">ID</label>
                              <input type="text" readonly name="idmaterial" id="idmaterial" class="form-control idmaterial" value="<?= $idmaterial; ?>">
                           </div>
                           <div class="col-lg-4 col-6">
                              <label for="idajuan">ID Ajuan *</label>
                              <input type="text" readonly name="idajuan" id="idajuan" name="idajuan" class="form-control idajuan">
                           </div>
                           <div class="col-lg-4">
                              <label for="jenismaterial">Jenis Material *</label>
                              <select type="text" name="jenismaterial" id="jenismaterial" class="form-control jenismaterial">
                                 <option selected disaled value="">--Pilih Jenis Material--</option>
                                 <option value="Meterial Utama">Material Utama</option>
                                 <option value="Accessoris">Accessoris</option>
                              </select>
                           </div>
                        </div>
                        <div class="form-group form-row">
                           <div class="col-lg-4 col-6">
                              <label for="namamaterial">Nama Material *</label>
                              <input type="text" name="namamaterial" id="namamaterial" class="form-control namamaterial">
                           </div>
                           <div class="col-lg-4 col-6">
                              <label for="satuanmaterial">Satuan *</label>
                              <select type="text" name="satuanmaterial" id="satuanmaterial" class="form-control satuanmaterial">
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
                           <div class="col-lg-4">
                              <label for="qtymaterial">Qty *</label>
                              <input type="text" name="qtymaterial" id="qtymaterial" class="form-control qtymaterial" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                           </div>
                        </div>
                        <div class="form-group form-row">
                           <button type="submit" class="btn btn-success btn-sm mr-2 simpan">Simpan</button>
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

      <!--  -->
      <div class="modal fade" id="modaldetail">
         <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content bg-success">
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
                        <h4>Material Jadi</h4>
                        <table class="table detailtable table-sm table-bordered">
                           <thead>
                              <th>Nama Material</th>
                              <th>Jenis Material</th>
                              <th>Id Ajuan</th>
                              <th>Satuan Material</th>
                              <th>Qty</th>
                              <th>Harga</th>
                              <th>Total Harga</th>
                           </thead>
                           <tbody>
                              <th class="nm">Nama Material</th>
                              <th class="jm">Nama Material</th>
                              <th class="ia">Id Ajuan</th>
                              <th class="sm">Satuan Material</th>
                              <th class="qty">Qty</th>
                              <th class="hg">Harga</th>
                              <th class="tot">Total Harga</th>
                           </tbody>
                        </table>
                     </div>
                     <div class="table-responsive ">
                        <h4>Bahan Penyusun</h4>
                        <table class="table bahanpenyusun table-bordered table-sm">
                           <tr>
                              <th>Nama Bahan</th>
                              <th>Spesifikasi</th>
                              <th>Jumlah</th>
                              <th>Satuan</th>
                              <th>Harga</th>
                              <th>Total</th>
                           </tr>
                           <tr>
                              <th colspan="4"></th>
                              <th>Grand Total</th>
                              <th class="gt"></th>
                           </tr>
                        </table>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">

               </div>
            </div>
         </div>
      </div>
      <div class="pesanmaterial" data-pesanmaterial="<?= session()->getFlashdata('pesanmaterial'); ?>"></div>
      <div class="alloweditmaterial" data-alloweditmaterial=""></div>
   </section>
</div>
<script src="<?= base_url('js/pbmaterial.js'); ?>"></script>


<?= $this->endSection(); ?>