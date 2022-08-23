<?php $this->extend('dashboard/kelolaproyek/template') ?>
<?php $this->section('dashboardkelolaproyek') ?>
<div class="content-wrapper">
    <section>
        <div class="container-fluid mt-5" style="display:flex;flex-direction:column;justify-content:center;">
            <div class="card">
                <div class="card-body">
                    <div style="display:flex;flex-direction:row;justify-content:space-evenly">
                        <div style="width:200px;">
                            <label for="">Id Ajuan</label>
                            <input type="text" readonly name="idajuan" id="idajuan" name="idajuan" class="form-control">
                        </div>
                        <div>
                            <label for="tot_biaya">Total Yang DIba</label>
                            <input type="text" style="color:red; font-weight:bold" readonly name="tot_biaya" id="tot_biaya" name="tot_biaya" class="form-control">
                        </div>
                        <div>
                            <label for="tot_biaya">Total Biaya Proyek</label>
                            <input type="text" style="color:red; font-weight:bold" readonly name="tot_biaya" id="tot_biaya" name="tot_biaya" class="form-control">
                        </div>

                        <div style="display:flex; flex-direction:row;align-items:center;justify-content:space-between" class="pt-3">

                            <div>
                                <button class="btn btn-success cetak1" readonly> <i class="fas fa-file-pdf mr-3"></i>Cetak PDF (Pertama)</button>
                            </div>

                            <div>
                                <button class="btn btn-primary cetak2" readonly> <i class="fas fa-file-pdf mr-3"></i>Cetak PDF (Revisi)</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </section>
</div>
<?= $this->endSection(); ?>