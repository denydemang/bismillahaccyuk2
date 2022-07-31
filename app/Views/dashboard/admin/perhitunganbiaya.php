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
                            <form>
                                <div class="form-row form-group-sm mb-3">
                                    <div class="col">
                                        <label for="idajuan">Id Ajuan</label>
                                        <select class="form-control" id="exampleFormControlSelect1">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="exampleInputPassword1">User_id</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col">
                                        <label for="exampleInputtext1">Jenis Pekerjaan</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col">
                                        <label for="exampleInputEmail1">Gaji</label>
                                        <input type="email" class="form-control">
                                    </div>
                                    <div class="col">
                                        <label for="exampleInputtext1">Hari</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col">
                                        <label for="exampleInputtext1">Total Pekerja</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col-4">
                                        <label for="exampleInputEmail1">Total Gaji</label>
                                        <input type="email" class="form-control">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-secondary">Simpan</button>
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
                                <div class="form-row form-group-sm mb-3">
                                    <div class="col">
                                        <label for="idajuan">Id Ajuan</label>
                                        <select class="form-control" id="exampleFormControlSelect1">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="exampleInputPassword1">User_id</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col">
                                        <label for="exampleInputtext1">Nama Transaksi</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="co">
                                        <label for="exampleInputtext1">Total Biaya</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Simpan</button>
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
<?= $this->endSection(); ?>