<?= $this->extend('dashboard/admin/template'); ?>
<?= $this->section('dashboardadmin'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Perhitungan Biaya</h1>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container-fluid">
            <!-- Perhitungan Bahan Baku -->
            <div class="form-inline d-flex justify-content-end pr-3 mb-2">
                <select class="form-control" id="exampleFormControlSelect1">
                    <option value="Pilih Id Ajuan">Pilih Id Ajuan</option>
                </select>
                <input type="text" class="form-control" placeholder="Total Biaya">
            </div>
            <div class="col-lg-12">
                <div class="card card-default collapsed-card">
                    <div class="card-header bg-primary">
                        <h3 class="card-title">Perhitungan Biaya Bahan Baku</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="container-fluid mb-3">
                            <form action="<?= base_url(); ?>/DashboardAdmin/simpanperhitunganbb" class="perhitunganbb">
                                <?= csrf_field(); ?>
                                <div class="form-row form-group-sm mb-3">
                                    <div class="col">
                                        <label for="idajuan">Id Ajuan</label>
                                        <select id="idajuanbb" class="form-control idajuanbb" name="idajuanbb">
                                            <option selected disabled>Pilih Id Ajuan</option>
                                            <?php foreach ($dataajuan as $row) : ?>
                                                <option value="<?= $row['idajuan']; ?>"><?= $row['idajuan']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="idajuanbbinvalid invalid-feedback">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label for="user_id">User_id</label>
                                        <input type="text" readonly class="form-control user_idbb" name="user_idbb">
                                    </div>
                                    <div class="col">
                                        <label for="namaproyek">Nama Proyek</label>
                                        <input type="text" readonly class="form-control namaproyekbb" name="namaproyekbb">
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col">
                                        <label for="namabahan">Nama Bahan</label>
                                        <input type="text" class="form-control namabahan" name="namabahan">
                                        <div class="namabahaninvalid invalid-feedback">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label for="ukuran">Ukuran</label>
                                        <input type="text" class="form-control ukuran" name="ukuran">
                                    </div>
                                    <div class="col">
                                        <label for="tebal">Tebal</label>
                                        <input type="text" class="form-control tebal" name="tebal">
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col">
                                        <label for="jenis">Jenis</label>
                                        <input type="text" class="form-control jenis" name="jenis">
                                    </div>
                                    <div class="col">
                                        <label for="Berat">Berat</label>
                                        <input type="text" class="form-control berat" name="berat">
                                    </div>
                                    <div class="col">
                                        <label for="kualitas">Kualitas</label>
                                        <input type="text" class="form-control kualitas" name="kualitas">
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col">
                                        <label for="panjang">Panjang</label>
                                        <input type="text" class="form-control panjang" name="panjang">
                                    </div>
                                    <div class="col">
                                        <label for="harga">Harga</label>
                                        <input type="text" class="form-control harga" name="harga" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                        <div class="hargainvalid invalid-feedback">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <label for="jumlahbeli">Jumlah Beli</label>
                                        <input type="text" class="form-control jumlahbeli" name="jumlahbeli" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                        <div class="jumlahbeliinvalid invalid-feedback">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col-6">
                                        <label for="totalhrga">Total Harga</label>
                                        <input type="text" readonly class="form-control totalharga" name="totalharga">
                                    </div>
                                </div>
                                <button type="submit" id="btnsimpan" class="btn btn-primary btnsimpanbb">Simpan</button>

                                <button class="btn btn-danger btncancel1">Cancel</button>
                            </form>
                        </div>
                        <div class="tampilbahanbaku">

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card card-default collapsed-card">
                    <div class="card-header bg-secondary">
                        <h3 class="card-title">Perhitungan Biaya Tenaga Kerja</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="container-fluid mb-3">
                            <form class="perhitungantenaker" action="<?= base_url(); ?>/DashboardAdmin/simpanperhitungantenaker">
                                <?= csrf_field(); ?>
                                <div class="form-row form-group-sm mb-3">
                                    <div class="col">
                                        <label for="idajuan">Id Ajuan</label>
                                        <?php foreach ($dataajuan as $row) : ?>
                                            <select class="form-control idajuantk" name="idajuantk">
                                                <option selected disabled>Pilih Id Ajuan</option>
                                                <option value="<?= $row['idajuan']; ?>"><?= $row['idajuan']; ?></option>
                                            </select>
                                        <?php endforeach ?>
                                        <div class="idajuantkinvalid invalid-feedback">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label for="user_idtk">User_id</label>
                                        <input type="text" readonly class="form-control user_idtk" name="user_idtk">
                                    </div>
                                    <div class="col">
                                        <label for="namaproyektk">Nama Proyek</label>
                                        <input type="text" readonly class="form-control namaproyektk" name="namaproyektk">
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col">
                                        <label for=jenispekerjaan">Jenis Pekerjaan</label>
                                        <input type="text" class="form-control jenispekerjaan" name="jenispekerjaan">
                                        <div class="jenispekerjaaninvalid invalid-feedback">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label for="gaji">Gaji</label>
                                        <input type="text" class="form-control gaji" name="gaji">
                                        <div class="gajiinvalid invalid-feedback">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label for="hari">Hari</label>
                                        <input type="text" class="form-control hari" name="hari">
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col-4">
                                        <label for="totalpekerja">Total Pekerja</label>
                                        <input type="text" class="form-control totalpekerja" name="totalpekerja">
                                        <div class="totalpekerjainvalid invalid-feedback">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <label for="totalgaji">Total Gaji</label>
                                        <input type="text" readonly class="form-control totalgaji" name="totalgaji">
                                    </div>
                                </div>
                                <button type="submit" id="btnsimpantk" class="btn btn-secondary btnsimpantk">Simpan</button>
                                <button class="btn btn-danger btncancel2">Cancel</button>
                            </form>
                        </div>
                        <div class="tampiltenaker">

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card card-default collapsed-card">
                    <div class="card-header bg-success">
                        <h3 class="card-title">Perhitungan BOP</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="container-fluid mb-3">
                            <form>
                                <?= csrf_field(); ?>
                                <div class="form-row form-group-sm mb-3">
                                    <div class="col">
                                        <?php foreach ($dataajuan as $row) : ?>
                                            <label for="idajuanbop">Id Ajuan</label>
                                            <select class="form-control idajuanbop" name="idajuanbop" id="idajuanbop">
                                                <option selected disabled>Pilih Id Ajuan</option>
                                                <option value="<?= $row['idajuan']; ?>"><?= $row['idajuan']; ?></option>
                                            </select>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="col">
                                        <label for="namaproyekbop">Nama Proyek</label>
                                        <input type="text" class="form-control namaproyekbop" name="namaproyekbop">
                                    </div>
                                    <div class="col">
                                        <label for="user_idbop">Nama Proyek</label>
                                        <input type="text" class="form-control namaproyekbop" name="user_idbop">
                                    </div>
                                    <div class="col">
                                        <label for="exampleInputtext1">Nama Transaksi</label>
                                        <input type="text" class="form-control" name="namatransaksi">
                                    </div>
                                </div>
                                <div class="form-row form-group-sm mb-3">
                                    <div class="col-4">
                                        <label for="exampleInputtext1">Total Biaya</label>
                                        <input type="text" class="form-control" name="totalbiaya">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Simpan</button>
                                <button class="btn btn-danger btncancel3">Cancel</button>
                            </form>
                        </div>
                        <div class="tampilbop">

                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<script src="<?= base_url() ?>/js/perhitunganbiaya.js"></script>
<script src="<?= base_url() ?>/js/perhitunganbiayabb.js"></script>
<script src="<?= base_url() ?>/js/perhitunganbiayatk.js"></script>
<?= $this->endSection(); ?>