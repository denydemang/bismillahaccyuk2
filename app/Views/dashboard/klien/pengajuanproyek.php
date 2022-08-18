<?= $this->extend('dashboard/klien/template'); ?>
<?= $this->section('dashboardklien'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Ajuan Proyek Anda</h1>
                </div>
            </div>
        </div>
    </section>
    <div class="container">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <th>No</th>
                                    <th>Nama Proyek</th>
                                    <th>Anggaran</th>
                                    <th>Jenis Proyek</th>
                                    <th>Lokasi Proyek</th>
                                    <th>File RAB</th>
                                    <th>Status</th>
                                    <th>#</th>
                                </thead>
                                <tbody>
                                    <?php $no = 1 ?>
                                    <?php foreach ($ajuanklien as $ajuan) : ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $ajuan['namaproyek']; ?></td>
                                            <td>Rp <?= number_format($ajuan['anggaran'], 0, '', '.'); ?>,-</td>
                                            <td><?= $ajuan['jenisproyek']; ?></td>
                                            <td><?= $ajuan['lokasiproyek']; ?></td>
                                            <?php if (empty($ajuan['file_admin'])) : ?>
                                                <td>Belum Ada File</td>
                                            <?php else : ?>
                                                <td><a href="<?= base_url('admin/downloadfile/' . $ajuan['file_admin'] . '/fileadmin'); ?>"><?= $ajuan['file_admin']; ?></a></td>
                                            <?php endif; ?>
                                            <?php if ($ajuan['status_id'] == '1') : ?>
                                                <td><span class="badge badge-secondary"><?= $ajuan['keterangan']; ?></span></td>
                                            <?php elseif ($ajuan['status_id'] == '2') : ?>
                                                <td><span class="badge badge-primary"><?= $ajuan['keterangan']; ?></span></td>
                                            <?php elseif ($ajuan['status_id'] == '3') : ?>
                                                <td><span class="badge badge-danger"><?= $ajuan['keterangan']; ?></span></td>
                                            <?php elseif ($ajuan['status_id'] == '4') : ?>
                                                <td><span class="badge badge-success"><?= $ajuan['keterangan']; ?></span></td>
                                            <?php elseif ($ajuan['status_id'] == '5') : ?>
                                                <td><span class="badge badge-warning"><?= $ajuan['keterangan']; ?></span></td>
                                            <?php elseif ($ajuan['status_id'] == '6') : ?>
                                                <td><span class="badge badge-info"><?= $ajuan['keterangan']; ?></span></td>
                                            <?php elseif ($ajuan['status_id'] == '7') : ?>
                                                <td><span class="badge badge-danger"><?= $ajuan['keterangan']; ?></span></td>
                                            <?php elseif ($ajuan['status_id'] == '8') : ?>
                                                <td>
                                                    <span data-id="<?= $ajuan['idajuan']; ?>" style="cursor:pointer" data-toggle="modal" data-target="#meeting" class="badge badge-secondary meetingdetail"><?= $ajuan['keterangan']; ?><i class="ml-2 fas fa-eye"></i></span>
                                                </td>
                                            <?php endif; ?>
                                            <?php if ($ajuan['status_id'] == '1') : ?>
                                                <td><span>Ajuan Anda Belum Kami Tinjau</span></td>
                                            <?php elseif ($ajuan['status_id'] == '2') : ?>
                                                <td><span>Ajuan Anda Sedang Kami Lakukan Perhitungan Biaya</span></td>
                                            <?php elseif ($ajuan['status_id'] == '3') : ?>
                                                <td><span>Mohon Maaf Ajuan Anda Kami Tolak</span></td>
                                            <?php elseif ($ajuan['status_id'] == '4') : ?>
                                                <td><span>Ajuan Anda Sedang Kami Kerjakan</span></td>
                                            <?php elseif ($ajuan['status_id'] == '5') : ?>
                                                <td>
                                                    <div style="display:flex;flex-direction:column;justify-content:center;align-items:center">
                                                        <a style="white-space:nowrap !important"><button data-ajuan="<?= $ajuan['idajuan']; ?>" class="btn btn-sm btn-primary terimarab">Terima RAB</button></a>
                                                        <button style="white-space:nowrap !important" data-ajuan="<?= $ajuan['idajuan']; ?>" data-toggle="modal" data-target="#ditolak" class=" btn btn-sm btn-danger detailtolakrab">Tolak RAB</button>
                                                        <button style="white-space:nowrap !important" data-ajuan="<?= $ajuan['idajuan']; ?>" data-toggle="modal" data-target="#permintaanmeeting" class=" btn btn-sm btn-success detailmeeting">Adakan Meeting</button>
                                                    </div>
                                                </td>
                                            <?php elseif ($ajuan['status_id'] == '6') : ?>
                                                <td>
                                                    <span>RAB Telah Di Setujui, Kami Akan Segera Melakukan Pengerjaan Proyek Yang Diajukan</span>
                                                </td>
                                            <?php elseif ($ajuan['status_id'] == '7') : ?>
                                                <td>
                                                    Keterangan Penolakan : <span style="color:red"><?= $ajuan['alasanpenolakan'] ?></span>
                                                </td>
                                            <?php elseif ($ajuan['status_id'] == '8') : ?>
                                                <td>
                                                    <div style="display:flex;flex-direction:column;justify-content:center;align-items:center">
                                                        <a style="white-space:nowrap !important"><button data-ajuan="<?= $ajuan['idajuan']; ?>" class="btn btn-sm btn-primary terimarab">Terima RAB</button></a>
                                                        <button style="white-space:nowrap !important" data-ajuan="<?= $ajuan['idajuan']; ?>" data-toggle="modal" data-target="#ditolak" class=" btn btn-sm btn-danger detailtolakrab">Tolak RAB</button>
                                                    </div>
                                                </td>
                                            <?php endif; ?>
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
            <!-- modal detail meeting -->
            <div class="modal fade" id="meeting" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="">
                                <div class="card card-widget widget-user-2">
                                    <div class="widget-user-header bg-warning">
                                        <h5>Detail Meeting</h5>
                                    </div>
                                    <div class="card-footer p-0">
                                        <ul class="nav flex-column">
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                    Nama Meeting <span class="float-right badge namameeting bg-primary">Pembahasan Mengenai AJP001</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                    Lokasi Meeting <span class="float-right badge lokasimeeting bg-info">Jln Tlogosari Utara IV no 13 Tembalang Semarang</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                    Tanggal Meeting <span class="float-right badge tanggalmeeting bg-success">14 November 2022 12.12PM</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <!-- modal tolak ajuan-->
            <div class="modal fade" id="ditolak" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="tolakrab" action="<?= base_url('DashboardKlien/validasitolakrab'); ?>">
                                <div class="form-group">
                                    <label for="namameeting">Alasan Tolak</label>
                                    <input type="hidden" class="idajuan" name="idajuan">
                                    <textarea type="text" name="alasantolak" id="alasantolak" class="form-control"></textarea>
                                    <div class="invalid-feedback alasantolakinvalid">asdasdasdad</div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-danger tbltolak">Tolak</button>
                                    <button type="button" data-dismiss="modal" class="btn btn-secondary">Batal</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="permintaanmeeting" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" class="formpermintaanmeeting" action="<?= base_url('DashboardKlien/permintaanmeeting'); ?>">
                                <div class="form-group">
                                    <input type="hidden" class="idajuan" name="idajuan">
                                    <label for="tanggalmeeting">Nama Meeting *</label>
                                    <input type="text" name="namameeting" id="namameeting" class="form-control"></input>

                                </div>
                                <div class="form-group">
                                    <label for="tanggalmeeting">Tanggal Meeting *</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-calendar"></i></span>
                                        </div>
                                        <input type="text" autocomplete="off" class="form-control tanggalmeeting" placeholder="'YYYY-MM-DD HH:mm" name="tanggalmeeting" id="tanggalmeeting">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="lokasimeeting">Lokasi Meeting*</label>
                                    <input type="text" name="lokasimeeting" id="lokasimeeting" name="lokasimeeting" class="form-control">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">Adakan Meeting</button>
                                    <button type="button" data-dismiss="modal" class="btn btn-secondary">Batal</button>
                                </div>
                            </form>

                        </div>
                        <div class="modal-footer">

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="pesanrab" data-pesanrab="<?= session()->getFlashdata('pesanrab'); ?>"></div>
</div>
<script src="<?= base_url('jquery-ui-1.13.2') ?>/jquery-ui.js"></script>
<script src="<?= base_url('daterangepicker') ?>/moment.min.js"></script>
<script src="<?= base_url('daterangepicker') ?>/daterangepicker.js"></script>
<script src="<?= base_url('js/ajuanproyekdbklien.js'); ?>"></script>
<?= $this->endSection(); ?>