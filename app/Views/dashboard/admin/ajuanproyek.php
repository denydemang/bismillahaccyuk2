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
                                            <td><a href="<?= base_url('admin/downloadfile/' . $ajuan->file_admin . '/fileadmin'); ?>"><?= $ajuan->file_admin; ?></a></td>
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
                                            <td>
                                                <span style="cursor:pointer" data-toggle="dropdown" class="badge badge-danger"><?= $ajuan->keterangan; ?><i class="ml-3 dropdown-toggle"></i></span>
                                                <div class="dropdown-menu dropdown-menu-lg">
                                                    <div style=" word-wrap:break-word !important"">
                                                        <h3 class=" bg-primary dropdown-item dropdown-header">Alasan Penolakan</h3>
                                                        <a class="dropdown-item bg-secondary">
                                                            <p style="font-weight:bolder"><?= $ajuan->alasanpenolakan; ?></p>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        <?php elseif ($ajuan->status_id == '8') : ?>
                                            <td>
                                                <span data-id="<?= $ajuan->idajuan; ?>" style="cursor:pointer" data-toggle="modal" data-target="#meeting" class="badge badge-secondary permintaanmeeting"><?= $ajuan->keterangan; ?><i class="ml-2 fas fa-eye"></i></span>
                                            </td>
                                        <?php endif; ?>
                                        <?php if ($ajuan->revisi_id == '0') : ?>
                                            <td><span class="badge badge-warning">Belum Dihitung</span></td>
                                        <?php elseif ($ajuan->revisi_id == '1') : ?>
                                            <td><span class="badge badge-success">Sudah Dihitung</span></td>
                                        <?php endif; ?>
                                        <td>
                                            <div style="display:flex;flex-direction:column;justify-content:space-around;align-items:center">
                                                <button class="btn btn-sm btn-success detailajuan" data-toggle="modal" data-target="#exampleModal" data-idajuan="<?= $ajuan->idajuan; ?>">Detail</button>
                                                <?php if ($ajuan->status_id == '2' &&  $ajuan->revisi_id == '0') : ?>
                                                    <button class=" btn btn-sm btn-primary detailhitung" data-detailid="<?= $ajuan->idajuan; ?>" style="white-space:nowrap !important;max-width:something !important;" data-namaproyek="<?= $ajuan->namaproyek; ?>" data-namaklien="<?= $ajuan->nama; ?>" data-idajuan="<?= $ajuan->idajuan; ?>">Buat Perhitungan</button>
                                                <?php elseif ($ajuan->status_id == '2' &&  $ajuan->revisi_id == '1') : ?>
                                                    <button class=" btn btn-sm btn-info detailkirimfilerab" data-detailid="<?= $ajuan->idajuan; ?>" style="white-space:nowrap !important;max-width:something !important;" data-namaproyek="<?= $ajuan->namaproyek; ?>" data-namaklien="<?= $ajuan->nama; ?>" data-idajuan="<?= $ajuan->idajuan; ?>"> Kirim File RAB</button>
                                                <?php else : ?>
                                                    <?php if ($ajuan->status_id == '1') : ?>
                                                        <button class=" btn btn-sm btn-primary terima" data-namaproyek="<?= $ajuan->namaproyek; ?>" data-namaklien="<?= $ajuan->nama; ?>" data-idajuan="<?= $ajuan->idajuan; ?>">Terima </button>
                                                        <button data-namaproyek="<?= $ajuan->namaproyek; ?>" data-namaklien="<?= $ajuan->nama; ?>" data-idajuan="<?= $ajuan->idajuan; ?>" class="btn btn-sm btn-danger tolak">Tolak</button>
                                                    <?php elseif ($ajuan->status_id == '2') : ?>
                                                        <button class=" btn btn-sm btn-info kirimfilerab" style="white-space:nowrap !important;max-width:something !important;" data-namaproyek="<?= $ajuan->namaproyek; ?>" data-namaklien="<?= $ajuan->nama; ?>" data-idajuan="<?= $ajuan->idajuan; ?>">Kirim File</button>
                                                    <?php elseif ($ajuan->status_id == '3') : ?>
                                                        <button data-namaproyek="<?= $ajuan->namaproyek; ?>" data-namaklien="<?= $ajuan->nama; ?>" data-idajuan="<?= $ajuan->idajuan; ?>" class="btn btn-sm btn-warning hapusajuan">Hapus</button>
                                                    <?php elseif ($ajuan->status_id == '6') : ?>
                                                        <button type="button" data-detailid="<?= $ajuan->idajuan; ?>" style="white-space:nowrap !important;max-width:something !important;" class=" btn btn-sm btn-primary detailcreate">Create Project</button>
                                                    <?php elseif ($ajuan->status_id == '7') : ?>
                                                        <button type="button" data-detailid="<?= $ajuan->idajuan; ?>" style="white-space:nowrap !important;max-width:something !important;" class=" btn btn-sm btn-primary detailhitung">Buat Revisi RAB</button>
                                                        <button class="btn btn-sm btn-info kirimfilerab" style="white-space:nowrap !important;max-width:something !important;" data-namaproyek="<?= $ajuan->namaproyek; ?>" data-namaklien="<?= $ajuan->nama; ?>" data-idajuan="<?= $ajuan->idajuan; ?>">Kirim File</button>
                                                    <?php elseif ($ajuan->status_id == '8') : ?>
                                                        <button type="button" data-detailid="<?= $ajuan->idajuan; ?>" style="white-space:nowrap !important;max-width:something !important;" class=" btn btn-sm btn-primary detailhitung">Buat Revisi RAB</button>
                                                        <button class="btn btn-sm btn-info kirimfilerab" style="white-space:nowrap !important;max-width:something !important;" data-namaproyek="<?= $ajuan->namaproyek; ?>" data-namaklien="<?= $ajuan->nama; ?>" data-idajuan="<?= $ajuan->idajuan; ?>">Kirim File</button>
                                                    <?php endif ?>
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
    <section>
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
                        <button type="button" data-detailid="5" class="btn btn-primary detailkirimfilerab">Kirim File</button>
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