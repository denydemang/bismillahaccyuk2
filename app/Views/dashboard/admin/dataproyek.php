<?= $this->extend('dashboard/admin/template'); ?>
<?= $this->section('dashboardadmin'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Proyek</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="getbuatproyek" data-idajuan="<?= $idajuan; ?>" data-namaproyek="<?= $namaproyek; ?>" data-jenisproyek="<?= $jenisproyek; ?>" data-idklien="<?= $idklien; ?>" data-namaklien="<?= $namaklien; ?>" data-biaya="<?= $biaya; ?>">
        </div>
        <div class="container-fluid">
            <div class="card card-danger">
                <div class="card-header">
                </div>
                <div class="card-body row">
                    <div class="card offset-lg-2 col-lg-8">
                        <div class="card-header bg-primary">
                            <h3 class="card-title">Buat Proyek</h3>
                        </div>
                        <div class="card-body">
                            <?php if (session()->getFlashdata('pesan')) : ?>
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
                                    <?= session()->getFlashdata('pesan'); ?>
                                </div>
                            <?php endif; ?>
                            <form id="buatproyek" method="post" action="<?= base_url(); ?>/DashboardAdmin/buatproyek">
                                <?= csrf_field(); ?>
                                <div class="form-row form-group">
                                    <div class="col dropdown">
                                        <button type="button" data-toggle="dropdown" class="btn btn-info">Pilih Id Ajuan <i class="bg-info mb-2 dropdown-toggle"></i></button>
                                        <div class="dropdown-menu dropdown-menu-lg">
                                            <div class="card" style="width:max-content">
                                                <div class="card-header">
                                                    <h3 class="card-title">Daftar Ajuan Proyek Diterima</h3>
                                                </div>
                                                <div class="card-body p-3">
                                                    <table class="table text-nowrap daftarajuan">
                                                        <thead>
                                                            <tr>
                                                                <th>ID AJUAN</th>
                                                                <th>Nama Proyek</th>
                                                                <th>Jenis Proyek</th>
                                                                <th>Nama Klien</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($dataajuan as $row) : ?>
                                                                <tr>
                                                                    <td><button type="button" data-id="<?= $row['idajuan']; ?>" class="badge badge-primary btnidajuanproyek"><?= $row['idajuan']; ?></button></td>
                                                                    <td><?= $row['namaproyek']; ?></td>
                                                                    <td><?= $row['jenisproyek']; ?></td>
                                                                    <td><?= $row['nama']; ?></td>
                                                                </tr>
                                                            <?php endforeach ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row form-group">
                                    <div class="col">
                                        <label for="idproyek">Id Proyek</label>
                                        <input type="text" readonly class="form-control" name="idproyek" id="idproyek" value="<?= $kodeproyek; ?>">
                                    </div>
                                    <div class="col">
                                        <label for="idajuan">Id Ajuan</label>
                                        <input class="form-control" readonly name="idajuan" id="idajuan">
                                    </div>
                                </div>
                                <div class="form-row form-group">
                                    <div class="col">
                                        <label for="user_id">Id Klien</label>
                                        <input type="text" readonly name="user_id" class="form-control" id="user_id">
                                    </div>
                                    <div class="col">
                                        <label for="namaproyek">Nama Proyek</label>
                                        <input type="text" readonly name="namaproyek" class="form-control" id="namaproyek">
                                    </div>
                                </div>
                                <div class="form-row form-group">
                                    <div class="col">
                                        <label for="jenisproyek">Jenis Proyek</label>
                                        <input type="text" name="jenisproyek" readonly class="form-control" id="jenisproyek">
                                    </div>
                                    <div class="col">
                                        <label for="nama">Nama Klien</label>
                                        <input type="text" name="nama" readonly class="form-control" id="nama">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="biaya">Biaya</label>
                                    <input type="text" style="font-weight: bolder; color:purple" readonly class="form-control" name="biaya" id="biaya">
                                </div>
                                <div class="form-group">
                                    <label for="sudahbayar">Sudah Bayar</label>
                                    <input type="text" style="font-weight: bolder; color:green" name="sudahbayar" class="form-control" id="sudahbayar">
                                </div>
                                <div class="form-group">
                                    <label for="belumbayar">Belum Bayar</label>
                                    <input type="text" style="font-weight: bold; color:red" readonly name="belumbayar" class="form-control" id="belumbayar">
                                </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Buat Proyek!</button>
                        </div>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table id="tableproyek" class="table table-striped table-primary">
                            <thead>
                                <th>No</th>
                                <th>Id Proyek</th>
                                <th>Id Ajuan</th>
                                <th>Nama Proyek</th>
                                <th>Jenis Proyek</th>
                                <th>Nama Klien</th>
                                <th>Biaya</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
                                <?php $no = 1 ?>

                                <?php foreach ($proyek as $pry) : ?>
                                    <td><?= $no++ ?></td>
                                    <td><?= $pry['idproyek'] ?></td>
                                    <td><?= $pry['idajuan'] ?></td>
                                    <td><?= $pry['namaproyek'] ?></td>
                                    <td><?= $pry['jenisproyek'] ?></td>
                                    <td><?= $pry['nama'] ?></td>
                                    <td><?= $pry['biaya'] ?></td>
                                    <?php if ($pry['belum_bayar'] == 0) : ?>
                                        <td><span class="badge badge-success">Lunas</span></td>
                                    <?php else : ?>
                                        <td><span class="badge badge-danger">Belum Lunas</span></td>
                                    <?php endif ?>
                                    <td><a data-idproyek="<?= $pry['idproyek']; ?>" data-idajuan="<?= $pry['idajuan']; ?>" class="btn btn-warning btn-sm btnkelola">kelola</a></td>

                                    </tr>
                                <?php endforeach ?>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </section>
</div>
<script src="<?= base_url('js/myscript.js'); ?>"></script>

<script>
    $(document).ready(function() {
        $('#tableproyek').DataTable();
        $('.btnkelola').click(function() {
            let idproyek = $(this).data('idproyek');
            let idajuan = $(this).data('idajuan');
            window.location.href = 'http://localhost:8080/DashboardAdmin/redirectkelola/' + idproyek + '/' + idajuan
        });
        $('.daftarajuan').DataTable({
            "lengthChange": false,
            "info": false,
            "paging": false,
            "fixedHeader": true,
            "scrollY": '150px',
            "scrollX": true,
            // "scrollCollapse": true,
        })
    });
</script>

<?= $this->endSection(); ?>