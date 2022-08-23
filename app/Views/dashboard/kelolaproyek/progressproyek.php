<?php $this->extend('dashboard/kelolaproyek/template') ?>
<?php $this->section('dashboardkelolaproyek') ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Progress Proyek</h1>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="card">
            <div class="card-header">
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tabletenaker" class="table table-striped table-sm">
                        <thead>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Pekerjaan Diselesaikan</th>
                            <th>Persentase</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>14/11/2022</td>
                                <td>50%</td>
                                <td>Memasang Rangka</td>
                                <td>hahahaha</td>
                                <td>Edit | Hapus</td>
                            </tr>
                        </tbody>

                    </table>
                </div>


            </div>

        </div>
    </section>
</div>
<?= $this->endSection(); ?>