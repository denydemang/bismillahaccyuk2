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
               <button data-toggle="modal" data-target="#modalmaterial" class="btn btn-outline-info mb-2"><i class="fas fa-plus-circle mr-2"></i>Tambah Material</button>
               <div class="table-responsive">
                  <table class="table table-bordered table-info table-striped table-hover text-center">
                     <thead>
                        <th scope="col">No</th>
                        <th scope="col">ID</th>
                        <th scope="col">ID Ajuan</th>
                        <th scope="col">Nama Material</th>
                        <th scope="col">Material Penyusun</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Total Harga</th>
                        <th scope="col">Aksi</th>
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
                                 <td><a href="<?= base_url(''); ?>"></a><button class="btn btn-warning rounded-circle"><i style="color:white;font-weight:bold" class="fas fa-pen"></i></button></td>
                                 <td><?= $row['qtymaterial']; ?></td>
                                 <td>Rp <?= number_format($row['hargamaterial'], 0, '', '.'); ?>,-</td>
                                 <?php $total = (intval($row['hargamaterial']) * intval($row['qtymaterial'])) ?>
                                 <td>Rp <?= number_format($total, 0, '', '.'); ?>,-</td>
                                 <td>
                                    <button data-id="<?= $row['idmaterial']; ?>" class="btn btn-success rounded-circle detailmaterial"><i style="color:white;font-weight:bold" class="fas fa-eye"></i></button>
                                    <button data-id="<?= $row['idmaterial']; ?>" class="btn btn-primary rounded-circle editmaterial"><i style="color:white;font-weight:bold" class="fas fa-edit"></i></button>
                                    <button data-id="<?= $row['idmaterial']; ?>" class="btn btn-danger rounded-circle hapusmaterial"><i style="color:white;font-weight:bold" class="fas fa-trash"></i></button>
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
                        <button type="button" data-toggle="dropdown" class="btn btn-secondary mb-2">Pilih Id Ajuan <i class="ml-2 mb-2 dropdown-toggle"></i></button>
                        <div class="dropdown-menu dropdown-menu-lg">
                           <div class="card" style="width:600px !important">
                              <div class="card-header">
                                 <h3 class="card-title">Daftar Ajuan Proyek Diterima</h3>
                              </div>
                              <div class="card-body p-3">
                                 <table class="table text-nowrap daftarajuan">
                                    <thead>
                                       <th>ID AJUAN</th>
                                       <th>Nama Proyek</th>
                                       <th>Jenis Proyek</th>
                                       <th>Nama Klien</th>
                                       </tr>
                                    </thead>
                                    <tbody>

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
                              <input type="text" name="idmaterial" id="idmaterial" name="idmaterial" class="form-control idmaterial">
                           </div>
                           <div class="col-lg-4 col-6">
                              <label for="idajuan">ID Ajuan</label>
                              <input type="text" name="idajuan" id="idajuan" name="idajuan" class="form-control idmaterial">
                           </div>
                           <div class="col-lg-4">
                              <label for="jenismaterial">Jenis Material</label>
                              <input type="text" name="jenismaterial" id="jenismaterial" name="jenismaterial" class="form-control jenismaterial">
                           </div>
                        </div>
                        <div class="form-group form-row">
                           <div class="col-lg-4 col-6">
                              <label for="namamaterial">Nama Material</label>
                              <input type="text" name="namamaterial" id="namamaterial" name="namamaterial" class="form-control namamaterial">
                           </div>
                           <div class="col-lg-4 col-6">
                              <label for="satuanmaterial">Satuan</label>
                              <input type="text" name="satuanmaterial" id="satuanmaterial" name="satuanmaterial" class="form-control satuanmaterial">
                           </div>
                           <div class="col-lg-4">
                              <label for="qtymaterial">Qty</label>
                              <input type="text" name="qtymterial" id="qtymterial" name="qtymaterial" class="form-control qtymaterial">
                           </div>
                        </div>
                        <div class="form-group form-row">
                           <div class="col-lg-6 col-6">
                              <label for="hargamaterial">Harga</label>
                              <input type="text" name="hargamaterial" id="hargamaterial" name="hargamaterial" class="form-control hargamaterial">
                           </div>
                           <div class="col-lg-6 col-6">
                              <label for="totalhargamaterial">Total Harga</label>
                              <input type="text" name="totalhargamaterial" id="totalhargamaterial" name="totalhargamaterial" class="form-control totalhargamaterial">
                           </div>
                        </div>
                        <div class="form-group form-row">
                           <button type="submit" class="btn btn-success btn-sm mr-2">Simpan</button>
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
   </section>
</div>
<script src="<?= base_url('js/pbmaterial.js'); ?>"></script>


<?= $this->endSection(); ?>