<?= $this->extend('dashboard/admin/template'); ?>
<?= $this->section('dashboardadmin'); ?>
<?= $this->extend('dashboard/admin/template'); ?>
<?= $this->section('dashboardadmin'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Perhitungan Biaya Revisi</h1>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container-fluid">
            <div class="col-lg-12">
                <div class="card card-default collapsed-card bbrevisicard">
                    <div class="card-header bg-primary">
                        <h3 class="card-title">Revisi Biaya Bahan Baku</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="container-fluid mb-3">
                            <form action="<?= base_url(); ?>/DashboardAdmin/simpanrevisibb" class="perhitunganbbrevisi">
                                <?= csrf_field(); ?>
                                <div class="form-row form-group mb-3">
                                    <div class="col">
                                        <label for="id_pbb">Id Biaya BB</label>
                                        <input type="text" readonly class="form-control id_pbb" name="id_pbb" value="<?= $bb['id_pbb'] ?>">
                                        <div class="id_pbbinvalid invalid-feedback">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label for="idajuanbb">Id Ajuan</label>
                                        <input type="text" readonly class="form-control idajuanbb" name="idajuanbb" value="<?= $bb['idajuan'] ?>">
                                    </div>
                                    <div class="col">
                                        <label for="user_idbb">User_id</label>
                                        <input type="text" readonly class="form-control user_idbb" name="user_idbb" value="<?= $bb['user_id'] ?>">
                                    </div>
                                </div>
                                <div class="form-row form-group mb-3">
                                    <div class="col">
                                        <label for="namaproyekbb">Nama Proyek</label>
                                        <input type="text" readonly class="form-control namaproyekbb" name="namaproyekbb" value="<?= $bb['namaproyek'] ?>">
                                    </div>
                                    <div class="col">
                                        <label for="namabahan">Nama Bahan</label>
                                        <input type="text" readonly class="form-control namabahan" name="namabahan" value="<?= $bb['namabahan'] ?>">
                                        <div class="namabahaninvalid invalid-feedback">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label for="ukuran">Ukuran</label>
                                        <input type="text" class="form-control ukuran" name="ukuran" value="<?= $bb['ukuran'] ?>">
                                    </div>
                                </div>
                                <div class="form-row form-group mb-3">
                                    <div class="col">
                                        <label for="tebal">Tebal</label>
                                        <input type="text" class="form-control tebal" name="tebal" value="<?= $bb['ketebalan'] ?>">
                                    </div>
                                    <div class="col">
                                        <label for="jenis">Jenis</label>
                                        <input type="text" class="form-control jenis" name="jenis" value="<?= $bb['jenis'] ?>">
                                    </div>
                                    <div class="col">
                                        <label for="Berat">Berat</label>
                                        <input type="text" class="form-control berat" name="berat" value="<?= $bb['berat'] ?>">
                                    </div>
                                </div>
                                <div class="form-row form-group mb-3">
                                    <div class="col">
                                        <label for="kualitas">Kualitas</label>
                                        <input type="text" class="form-control kualitas" name="kualitas" value="<?= $bb['kualitas'] ?>">
                                    </div>
                                    <div class="col">
                                        <label for="panjang">Panjang</label>
                                        <input type="text" class="form-control panjang" name="panjang" value="<?= $bb['panjang'] ?>">
                                    </div>
                                    <div class="col">
                                        <label for="harga">Harga</label>
                                        <input type="text" class="form-control harga" name="harga" value="<?= empty($bb['harga']) ? '' : "Rp " . number_format(intval($bb['harga']), 0, '', '.') ?>">
                                        <div class="hargainvalid invalid-feedback">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row form-group mb-3">
                                    <div class="col-4">
                                        <label for="jumlahbeli">Jumlah Beli</label>
                                        <input type="text" class="form-control jumlahbeli" name="jumlahbeli" value="<?= $bb['jumlah_beli'] ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                        <div class="jumlahbeliinvalid invalid-feedback">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <label for="totalhrga">Total Harga</label>
                                        <input type="text" readonly style="font-weight:bold;color:blue;font-size:20px" class="form-control totalharga" name="totalharga" value="<?= empty($bb['total_harga']) ? '' : "Rp " . number_format(intval($bb['total_harga']), 0, '', '.') ?>">
                                    </div>
                                </div>
                                <button type="submit" id="btnsimpan" class="btn btn-primary btnsimpanbb">Revisi</button>
                                <button type="button" class="btn btn-danger btncancel1">Cancel</button>
                            </form>
                        </div>
                        <div class="tampilbahanbakurevisi">

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card card-default collapsed-card tkrevisicard">
                    <div class="card-header bg-secondary">
                        <h3 class="card-title">Revisi Biaya Tenaga Kerja</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="container-fluid mb-3">
                            <form class="perhitungantenakerrevisi" action="<?= base_url(); ?>/DashboardAdmin/simpanperhitungantenakerrevisi">
                                <?= csrf_field(); ?>
                                <div class="form-row form-group mb-3">
                                    <div class="col">
                                        <label for="id_pbtenaker">ID Biaya TK</label>
                                        <input type="text" readonly class="form-control id_pbtenaker" name="id_pbtenaker" value="<?= $tk['id_pbtenaker'] ?>">
                                        <div class="id_pbtenakerinvalid invalid-feedback">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label for="idajuantk">Id Ajuan</label>
                                        <input type="text" readonly class="form-control idajuantk" name="idajuantk" value="<?= $tk['idajuan'] ?>">
                                    </div>
                                    <div class="col">
                                        <label for="user_idtk">User_id</label>
                                        <input type="text" readonly class="form-control user_idtk" name="user_idtk" value="<?= $tk['user_id'] ?>">
                                    </div>
                                </div>
                                <div class="form-row form-group mb-3">
                                    <div class="col">
                                        <label for="namaproyektk">Nama Proyek</label>
                                        <input type="text" readonly class="form-control namaproyektk" name="namaproyektk" value="<?= $tk['namaproyek'] ?>">
                                    </div>
                                    <div class="col">
                                        <label for=jenispekerjaan">Jenis Pekerjaan</label>
                                        <input type="text" readonly class="form-control jenispekerjaan" name="jenispekerjaan" value="<?= $tk['jenispekerjaan'] ?>">
                                    </div>
                                    <div class="col">
                                        <label for="gaji">Gaji</label>
                                        <input type="text" class="form-control gaji" name="gaji" value="<?= $tk['gaji'] ?>">
                                        <div class="gajiinvalid invalid-feedback">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col">
                                        <label for="hari">Hari</label>
                                        <input type="text" class="form-control hari" name="hari" value="<?= $tk['hari'] ?>">
                                        <div class="hariinvalid invalid-feedback">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label for="totalpekerja">Total Pekerja</label>
                                        <input type="text" class="form-control totalpekerja" name="totalpekerja" value="<?= $tk['total_pekerja'] ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                        <div class="totalpekerjainvalid invalid-feedback">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label for="totalgaji">Total Gaji</label>
                                        <input type="text" readonly style="font-weight:bold;color:red;font-size:20px" value="<?= empty($tk['total_gaji']) ? '' : "Rp " . number_format(intval($tk['total_gaji']), 0, '', '.') ?>" readonly class="form-control totalgaji" name="totalgaji">
                                    </div>
                                </div>
                                <button type="submit" id="btnsimpantk" class="btn btn-secondary btnsimpantk">Revisi</button>
                                <button type="button" class="btn btn-danger btncancel2">Cancel</button>
                            </form>
                        </div>
                        <div class="tampiltenakerrevisi">

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card card-default collapsed-card boprevisicard">
                    <div class="card-header bg-success">
                        <h3 class="card-title">Revisi Biaya Operasional</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="container-fluid mb-3">
                            <form class="perhitunganboprevisi" action="<?= base_url(); ?>/DashboardAdmin/simpanboprevisi">
                                <?= csrf_field(); ?>
                                <div class="form-row form-group mb-3">
                                    <div class="col">
                                        <label for="id_pbop">Id Biaya OP</label>
                                        <input type="text" readonly class="form-control id_pbop" name="id_pbop" value="<?= $bop['id_pbop']; ?>">
                                        <div class="id_pbopinvalid invalid-feedback">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label for="idajuanbop">Id Ajuan</label>
                                        <input type="text" readonly class="form-control idajuanbop" name="idajuanbop" value="<?= $bop['idajuan']; ?>">
                                    </div>
                                    <div class="col">
                                        <label for="user_idbop">Id User</label>
                                        <input type="text" readonly class="form-control user_idbop" name="user_idbop" value="<?= $bop['user_id']; ?>">
                                    </div>
                                </div>
                                <div class="form-row form-group mb-3">
                                    <div class="col">
                                        <label for="namaproyek">Nama Proyek</label>
                                        <input type="text" readonly class="form-control namaproyekbop" name="namaproyekbop" value="<?= $bop['namaproyek']; ?>">
                                    </div>
                                    <div class="col">
                                        <label for="exampleInputtext1">Nama Transaksi</label>
                                        <input type="text" readonly class="form-control namatransaksi" name="namatransaksi" value="<?= $bop['namatrans']; ?>">
                                    </div>
                                    <div class="col">
                                        <label for="exampleInputtext1">Total Biaya</label>
                                        <input type="text" style="font-weight:bold;color:#28A745;font-size:20px" class="form-control totalbiaya" name="totalbiaya" value="<?= empty($bop['tot_biaya']) ? '' : "Rp " . number_format(intval($bop['tot_biaya']), 0, '', '.'); ?>">
                                        <div class=" totalbiayainvalid invalid-feedback">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" id="btnsimpanbop" class="btn btn-success btnsimpanbop">Revisi</button>
                                <button type="button" class="btn btn-danger btncancel3">Cancel</button>
                            </form>
                        </div>
                        <div class="tampilboprevisi">

                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<script src="<?= base_url() ?>/js/perhitunganbiayarevisi.js"></script>
<script src="<?= base_url() ?>/js/perhitunganbbrevisi.js"></script>
<script src="<?= base_url() ?>/js/perhitunganboprevisi.js"></script>
<script src="<?= base_url() ?>/js/perhitungantkrevisi.js"></script>
<!-- <script src="<//?= base_url() ?>/js/perhitunganbiaya.js"></script>
<script src="<//?= base_url() ?>/js/perhitunganbiayabb.js"></script>
<script src="<//?= base_url() ?>/js/perhitunganbiayatk.js"></script>
<script src="<//?= base_url() ?>/js/perhitunganbiayabop.js"></script> -->
<script>
    $(document).ready(function() {
        $('.bbrevisicard').CardWidget("toggle")
        $('.boprevisicard').CardWidget("toggle")
        $('.tkrevisicard').CardWidget("toggle")
    })
</script>
<?= $this->endSection(); ?>
<?= $this->endSection(); ?>