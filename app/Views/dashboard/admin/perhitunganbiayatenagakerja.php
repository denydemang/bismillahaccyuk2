<?= $this->extend('dashboard/admin/template'); ?>
<?= $this->section('dashboardadmin'); ?>
<?php

use App\Models\PerhitunganTenakerRevisiModel;
?>
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Perhitungan Biaya Tenaga Kerja</h1>
        </div>
      </div>
    </div>
  </section>
  <section>
    <div class="container-fluid">
      <div class="card">
        <div class="card-body">

          <button data-toggle="modal" data-target="#modaltenaker" class="btn btn-outline-success mb-2 btntambah"><i class="fas fa-plus-circle mr-2"></i>Tambah Tenaga Kerja</button>
          <div class="dropdown">
            <button type="button" data-toggle="dropdown" class="btn btn-primary mb-2 pilihajuan">Pilih Id Ajuan <i class="ml-2 mb-2 dropdown-toggle"></i></button>
            <div class="dropdown-menu dropdown-menu-lg">
              <div class="card" style="width:600px !important">
                <div class="card-header">
                  <h3 class="card-title">Daftar Ajuan Proyek</h3>
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
                      <?php if (!empty($dataajuannn)) : ?>
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
            <table class="tabletenaker table table-bordered table-striped table-hover text-center">
              <thead>
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">ID Tenaker</th>
                  <th scope="col">ID Ajuan</th>
                  <th scope="col">Jobdesk</th>
                  <th scope="col">Status Pekerjaan</th>
                  <th scope="col">Gaji</th>
                  <th scope="col">Total Pekerja</th>
                  <th scope="col">Total Gaji</th>
                  <th scope="col">Status</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <?php $No = 1 ?>

              <tbody>
                <?php if (!empty($tenaker)) : ?>
                  <?php foreach ($tenaker as $row) : ?>
                    <tr>
                      <td scope="col"><?= $No++; ?></td>
                      <td scope="col"><?= $row['id_pbtenaker']; ?></td>
                      <td scope="col"><?= $row['idajuan']; ?></td>
                      <td scope="col"><?= $row['jobdesk']; ?></td>
                      <td scope="col"><?= $row['statuspekerjaan']; ?></td>
                      <td scope="col">Rp <?= number_format($row['gaji'], 0, '', '.'); ?></td>
                      <td scope="col"><?= $row['total_pekerja']; ?></td>
                      <td scope="col">Rp <?= number_format($row['total_gaji'], 0, '', '.'); ?>,-</td>
                      <td>

                        <?php

                        $tk = new PerhitunganTenakerRevisiModel();
                        $getdata = $tk->find($row['id_pbtenaker']);

                        if ($getdata['revisi_id'] != 0) :  ?>
                          <span class="badge badge-primary">Direvisi</span>
                        <?php else : ?>
                          <span class="badge badge-secondary">Tidak Direvisi</span>
                        <?php endif; ?>
                      </td>
                      <td>
                        <?php if ($getdata['revisi_id'] != 0) : ?>
                          <div class="flex-column">
                            <button data-id="<?= $row['id_pbtenaker']; ?>" class="btn btn-danger rounded-circle hapustenaker"><i style="color:white;font-weight:bold" class="fas fa-trash"></i></button>
                          </div>
                        <?php else : ?>
                          <div class="flex-column">
                            <button data-toggle="modal" data-target="#modaltenaker" data-id="<?= $row['id_pbtenaker']; ?>" class="btn btn-info rounded-circle btnedittenaker"><i style="color:white;font-weight:bold" class="fas fa-edit"></i></button>
                            <button data-id="<?= $row['id_pbtenaker']; ?>" class="btn btn-danger rounded-circle hapustenaker"><i style="color:white;font-weight:bold" class="fas fa-trash"></i></button>
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
    </div>
  </section>
  <section>
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
          <h2>Revisi Tenaker</h2>
        </div>
        <div class="card-body">
          <div class="table-responsive mt-3">
            <table class="tabletenaker table table-bordered table-striped table-hover text-center">
              <thead>
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">ID Tenaker</th>
                  <th scope="col">Jobdesk</th>
                  <th scope="col">Status Pekerjaan</th>
                  <th scope="col">Gaji</th>
                  <th scope="col">Total Pekerja</th>
                  <th scope="col">Total Gaji</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <?php $No = 1 ?>
              <tbody>
                <?php if (!empty($tkrevisi)) : ?>
                  <?php foreach ($tkrevisi as $row) : ?>
                    <tr>
                      <td scope="col"><?= $No++; ?></td>
                      <td scope="col"><?= $row['id_pbtenaker']; ?></td>
                      <td scope="col"><?= $row['jobdesk']; ?></td>
                      <td scope="col"><?= $row['statuspekerjaan']; ?></td>
                      <td scope="col">Rp <?= number_format($row['gaji'], 0, '', '.'); ?></td>
                      <td scope="col"><?= $row['total_pekerja']; ?></td>
                      <td scope="col">Rp <?= number_format($row['total_gaji'], 0, '', '.'); ?>,-</td>
                      <td>
                        <div class="flex-column">
                          <button data-toggle="modal" data-target="#modaltenakerr" data-id="<?= $row['id_pbtenaker']; ?>" class="btn btn-info rounded-circle btnedittenakerr"><i style="color:white;font-weight:bold" class="fas fa-edit"></i></button>
                          <button data-id="<?= $row['id_pbtenaker']; ?>" class="btn btn-danger rounded-circle hapustenakerr"><i style="color:white;font-weight:bold" class="fas fa-trash"></i></button>
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
    <div class="modal fade" id="modaltenaker">
      <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content bg-secondary">
          <div class="modal-header">
            <h4 class="modal-title judulmodal">
              Tambah Tenaga Kerja
            </h4>
            <button type="button" id="closetk" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="col-12">

              <form method="post" class="formtenaker" action="<?= base_url('DashboardAdmin/simpantenaker'); ?>">
                <div class="form-group form-row">
                  <div class="col-lg-4 col-6">
                    <label readonly for="id_pbtenaker">ID Tenaker</label>
                    <input type="text" readonly style="color:black;font-weight:bolder" name="id_pbtenaker" id="id_pbtenaker" class="form-control id_pbtenaker" value="<?= $id_pbtenaker; ?>">
                  </div>
                  <div class="col-lg-4 col-6">
                    <label for="idajuan">ID Ajuan*</label>
                    <input readonly type="text" readonly style="color:black;font-weight:bolder" name="idajuan" id="idajuan" class="form-control idajuan" value="<?= $idajuan; ?>">
                  </div>
                  <div class="col-lg-4">
                    <label for="jobdesk">JobDesk*</label>
                    <input type="text" style="color:black;font-weight:bolder" name="jobdesk" id="jobdesk" name="jobdesk" class="form-control jobdesk">
                  </div>
                </div>
                <div class="form-group form-row">
                  <div class="col-lg-4 col-6">
                    <label for="statuspekerjaan">Status Pekerjaan*</label>
                    <select type="text" name="statuspekerjaan" style="color:black;font-weight:bolder" id="statuspekerjaan" class="form-control statuspekerjaan">
                      <option selected disabled>Pilih Status Pekerjaan</option>
                      <option value="Harian">Harian</option>
                      <option value="Mingguan">Mingguan</option>
                      <option value="Bulanan">Bulanan</option>
                      <option value="Kontrak">Kontrak</option>

                    </select>
                  </div>
                  <div class="col-lg-4 col-6">
                    <label for="gaji">Gaji *</label>
                    <input type="text" style="color:black;font-weight:bolder" name="gaji" id="gaji" class="form-control gaji">
                  </div>
                  <div class="col-lg-4">
                    <label for="total_pekerja">Total Pekerja *</label>
                    <input type="text" style="color:black;font-weight:bolder" name="total_pekerja" id="total_pekerja" class="form-control total_pekerja" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                  </div>
                </div>
                <div class="form-group form-row">
                  <div class="col-lg-4 col-6">
                    <label for="total_gaji">Total Gaji*</label>
                    <input type="text" readonly style="color:purple;font-weight:bolder" name="total_gaji" id="total_gaji" class="form-control total_gaji">
                  </div>
                </div>
                <div class="form-group form-row">
                  <button type="submit" class="btn btn-info btn-sm mr-2 simpan">Simpan</button>
                  <button id="btncanceltk" type="button" data-dismiss="modal" class="btn btn-danger btn-sm btncancel">Cancel</button>
                </div>
              </form>
            </div>
          </div>
          <div class="modal-footer">

          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modaltenakerr">
      <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content bg-secondary">
          <div class="modal-header">
            <h4 class="modal-title judulmodal">
              Edit Revisi tenaker
            </h4>
            <button type="button" id="closetkr" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="col-12">
              <form method="post" class="formtenakerr" action="<?= base_url('DashboardAdmin/editrevisitenaker'); ?>">
                <div class="form-group form-row">
                  <div class="col-lg-6 col-6">
                    <label readonly for="id_pbtenaker1">ID Tenaker</label>
                    <input type="text" readonly style="color:black;font-weight:bolder" name="id_pbtenaker1" id="id_pbtenaker1" class="form-control id_pbtenaker1">
                  </div>
                  <div class="col-lg-6">
                    <label for="jobdesk1">JobDesk*</label>
                    <input type="text" readonly style="color:black;font-weight:bolder" name="jobdesk1" id="jobdesk1" name="jobdesk1" class="form-control jobdesk1">
                  </div>
                </div>
                <div class="form-group form-row">
                  <div class="col-lg-4 col-6">
                    <label for="statuspekerjaan1">Status Pekerjaan*</label>
                    <select type="text" name="statuspekerjaan1" style="color:black;font-weight:bolder" id="statuspekerjaan1" class="form-control statuspekerjaan1">
                      <option selected disabled>Pilih Status Pekerjaan</option>
                      <option value="Harian">Harian</option>
                      <option value="Mingguan">Mingguan</option>
                      <option value="Bulanan">Bulanan</option>
                      <option value="Kontrak">Kontrak</option>
                      <option value="Borongan">Borongan</option>
                    </select>
                  </div>
                  <div class="col-lg-4 col-6">
                    <label for="gaji1">Gaji *</label>
                    <input type="text" style="color:black;font-weight:bolder" name="gaji1" id="gaji1" class="form-control gaji1">
                  </div>
                  <div class="col-lg-4">
                    <label for="total_pekerja1">Total Pekerja *</label>
                    <input type="text" style="color:black;font-weight:bolder" name="total_pekerja1" id="total_pekerja1" class="form-control total_pekerja1" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                  </div>
                </div>
                <div class="form-group form-row">
                  <div class="col-lg-4 col-6">
                    <label for="total_gaji1">Total Gaji*</label>
                    <input type="text" readonly style="color:purple;font-weight:bolder" name="total_gaji1" id="total_gaji1" class="form-control total_gaji1">
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
    <div class="pesantenaker" data-gagal="<?= session()->getFlashdata('gagal'); ?>" data-berhasil="<?= session()->getFlashdata('berhasil'); ?>"></div>
  </section>
</div>
<script src="<?= base_url('js/perhitungantk.js'); ?>"></script>
<?= $this->endSection(); ?>