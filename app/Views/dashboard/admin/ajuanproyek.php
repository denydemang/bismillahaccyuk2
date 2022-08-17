<?= $this->extend('dashboard/admin/template'); ?>
<?= $this->section('dashboardadmin'); ?>
<div class="content-wrapper">
    <div class="flashdata" data-pesan="<?= session()->getFlashdata('pesan'); ?>" data-namaproyek="<?= session()->getFlashdata('namaproyek'); ?>" data-namaklien="<?= session()->getFlashdata('namaklien'); ?>"></div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Ajuan Proyek Klien</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="col-lg-12 dropdown">
                        <button type="button" data-toggle="dropdown" class="btn btn-info">Detail Ajuan<i class="bg-info mb-2 dropdown-toggle"></i></button>
                        <div class="dropdown-menu dropdown-menu-lg">
                            <div class="card" style="width:400px !important">
                                <div class="card-body row p-3">
                                    <div class="card card-primary col-lg-12 card-outline">
                                        <div class="card-body box-profile ">
                                            <h3 class="profile-username text-center">Detail Ajuan</h3>
                                            <ul class="list-group list-group-unbordered mb-3">
                                                <li class="list-group-item">
                                                    <b>Total Ajuan</b><span class="float-right" style="font-weight:bold;color:black"><?= $status['totalajuan']; ?></span>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Ajuan Diterima & Dikerjakan</b><span class="float-right" style="font-weight:bold;color:green"><?= $status['dikerjakan']; ?></span>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Ajuan Diterima</b><span class="float-right" style="font-weight:bold;color:blue"><?= $status['diterima']; ?></span>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Ajuan Ditolak</b><span class="float-right" style="font-weight:bold;color:red"><?= $status['ditolak']; ?></span>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Ajuan Belum Ditinjau</b><span class="float-right" style="font-weight:bold;color:cyan"><?= $status['belumditinjau']; ?></span>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Ajuan Sudah Dihitung</b><span class="float-right" style="font-weight:bold;color:purple"><?= $status['dihitung']; ?></span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tableajuan" class="table table-bordered table-striped">
                            <thead>
                                <th>No</th>
                                <th>Id Ajuan</th>
                                <th>Nama Proyek</th>
                                <th>Jenis Proyek</th>
                                <th>Anggaran</th>
                                <th>File RAB</th>
                                <th>Status</th>
                                <th>Hitung RAB</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
                                <?php $Nomer = 1; ?>
                                <?php foreach ($dataajuan as $ajuan) : ?>
                                    <tr>
                                        <td><?= $Nomer++; ?></td>
                                        <td><?= $ajuan->idajuan; ?></td>
                                        <td><?= $ajuan->namaproyek; ?></td>
                                        <td><?= $ajuan->jenisproyek; ?></td>
                                        <td><?= number_format($ajuan->anggaran, 0, '', '.'); ?></td>
                                        <?php if (!empty($ajuan->file_admin)) : ?>
                                            <td><?= $ajuan->file_admin; ?></td>
                                        <?php else : ?>
                                            <td>Belum Ada RAB Terlampir</td>
                                        <?php endif; ?>
                                        <?php if ($ajuan->status_id == '1') : ?>
                                            <td><span class="badge badge-secondary"><?= $ajuan->keterangan; ?></span></td>
                                        <?php elseif ($ajuan->status_id == '2') : ?>
                                            <td><span class="badge badge-primary"><?= $ajuan->keterangan; ?></span></td>
                                        <?php elseif ($ajuan->status_id == '3') : ?>
                                            <td><span class="badge badge-danger"><?= $ajuan->keterangan; ?></span></td>
                                        <?php elseif ($ajuan->status_id == '4') : ?>
                                            <td><span class="badge badge-success"><?= $ajuan->keterangan; ?></span></td>
                                        <?php elseif ($ajuan->status_id == '5') : ?>
                                            <td><span class="badge badge-warning"><?= $ajuan->keterangan; ?></span></td>
                                        <?php elseif ($ajuan->status_id == '6') : ?>
                                            <td><span class="badge badge-primary"><?= $ajuan->keterangan; ?></span></td>
                                        <?php elseif ($ajuan->status_id == '7') : ?>
                                            <td><span class="badge badge-info"><?= $ajuan->keterangan; ?></span></td>
                                        <?php elseif ($ajuan->status_id == '8') : ?>
                                            <td><span class="badge badge-secondary"><?= $ajuan->keterangan; ?></span></td>
                                        <?php endif; ?>
                                        <?php if ($ajuan->revisi_id == '0') : ?>
                                            <td><span class="badge badge-warning">Belum Dihitung</span></td>
                                        <?php elseif ($ajuan->revisi_id == '1') : ?>
                                            <td><span class="badge badge-success">Sudah Dihitung</span></td>
                                        <?php endif; ?>
                                        <td>
                                            <div style="display:flex;flex-direction:row;justify-content:center;align-items:center">
                                                <button class="btn btn-sm btn-success detailajuan" data-toggle="modal" data-target="#exampleModal" data-idajuan="<?= $ajuan->idajuan; ?>">Detail</button>
                                                <?php if ($ajuan->status_id == '2' &&  $ajuan->revisi_id == '0') : ?>
                                                    <button class=" btn btn-sm btn-info detailhitung" data-detailid="<?= $ajuan->idajuan; ?>" style="white-space:nowrap !important;max-width:something !important;" data-namaproyek="<?= $ajuan->namaproyek; ?>" data-namaklien="<?= $ajuan->nama; ?>" data-idajuan="<?= $ajuan->idajuan; ?>">Buat Perhitungan</button>
                                                <?php elseif ($ajuan->status_id == '2' &&  $ajuan->revisi_id == '1') : ?>
                                                    <button class=" btn btn-sm btn-info kirimfilerab" data-detailid="<?= $ajuan->idajuan; ?>" style="white-space:nowrap !important;max-width:something !important;" data-namaproyek="<?= $ajuan->namaproyek; ?>" data-namaklien="<?= $ajuan->nama; ?>" data-idajuan="<?= $ajuan->idajuan; ?>"> Kirim File RAB</button>
                                                <?php else : ?>
                                                    <button class="btn btn-primary">OK</button>
                                                <?php endif; ?>
                                            </div>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>

                        </table>
                    </div>

                </div>
                <div class="card-footer">

                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <section>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Detail Ajuan Proyek</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <strong><i class="fas fa-book mr-1"></i>Nama Proyek</strong> <strong>(Id Ajuan:<span class="detailidajuan">1</span>)</strong>
                                        <p class="text-muted detailnamaproyek mr-1">
                                        </p>
                                    </div>
                                    <div class="col">
                                        <strong><i class="fas fa-info mr-1"></i>Status</strong>
                                        <p class="mr-1">
                                            <span class="badge detailnamastatus"></span>
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col">
                                        <strong><i class="fas fa-briefcase mr-1"></i>Jenis Proyek</strong>
                                        <p class="text-muted detailjenisproyek mr-1">
                                        </p>
                                    </div>
                                    <div class="col">
                                        <strong><i class="fas fa-map-marker-alt mr-1"></i>Lokasi Proyek</strong>
                                        <p class="text-muted detaillokasiproyek mr-1">
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col">
                                        <strong><i class="fas fa-user mr-1"></i>Nama Pengaju(Klien)</strong><strong>(id_user:<span class="detailiduser">1</span>)</strong>
                                        <p class="text-muted detailnama mr-1">
                                        </p>
                                    </div>
                                    <div class="col">
                                        <strong><i class="fas fa-building mr-1"></i>Nama Perusahaan</strong>
                                        <p class="text-muted detailnamaperusahaan mr-1">
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col">
                                        <strong><i class="fas fa-envelope mr-1"></i>Email Klien</strong>
                                        <p class="text-muted detailemail mr-1">
                                        </p>
                                    </div>
                                    <div class="col">
                                        <strong><i class="fas fa-address-card mr-1"></i>Jabatan</strong>
                                        <p class="text-muted detailjabatan mr-1">
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col">
                                        <strong><i class="fas fa-home mr-1"></i>Alamat Klien</strong>
                                        <p class="text-muted detailalamat mr-1">
                                        </p>
                                    </div>
                                    <div class="col">
                                        <strong><i class="fas fa-map mr-1"></i>Alamat Perusahaan</strong>
                                        <p class="text-muted detailalamatperusahaan mr-1">
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col">
                                        <strong><i class="fas fa-money-bill mr-1"></i>Anggaran Proyek</strong>
                                        <p class="text-muted detailanggaran mr-1">
                                        </p>
                                    </div>
                                    <div class="col">
                                        <strong><i class="fas fa-phone mr-1"></i>No Telpon Klien</strong>
                                        <p class="text-muted detailnotelp mr-1">
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col">
                                        <strong><i class="fas fa-calendar mr-1"></i>Jadwal Proyek</strong>
                                        <p class="text-muted detailjadwalproyek mr-1">
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col col-sm">
                                        <strong><i class="fas fa-download mr-1"></i>File Lampiran</strong>
                                        <p class="text-muted detailuploadfile mr-1">
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-detailid="5" class="btn btn-primary detailcreate">Create Project</button>
                        <button type="button" data-detailid="5" class="btn btn-primary detailkirimfile">Kirim File</button>
                        <button type="button" data-detailid="5" class="btn btn-primary detailhitung">Buat Perhitungan</button>
                        <button type="button" data-detailid="5" class="btn btn-primary detailterima">Terima</button>
                        <button type="button" data-detailid="5" class="btn btn-danger detailtolak">Tolak</button>
                        <button type="button" data-detailid="5" class="btn btn-warning detailhapus">Hapus</button>
                    </div>
                </div>

            </div>
        </div>

    </section>

</div>
<script src="<?= base_url('js/myscript.js'); ?>"></script>
<script>
    $(document).ready(function() {
        $('#tableajuan').DataTable({
            "pageLength": 5,
            "columnDefs": [{
                orderable: false,
                targets: [2, 3, 4, 5, 6, 7, 8]
            }],
            "fixedColumns": {
                leftColumns: 1,
                rightColumns: 1
            },
        });
    })
</script>
<?= $this->endSection(); ?>