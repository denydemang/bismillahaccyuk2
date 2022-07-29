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
                            <form>
                                <div class="form-row form-group-sm mb-3">
                                    <div class="col">
                                        <label for="idajuan">Id Ajuan</label>
                                        <select class="form-control" id="exampleFormControlSelect1">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="exampleInputPassword1">User_id</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col">
                                        <label for="exampleInputtext1">Nama Bahan</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col">
                                        <label for="exampleInputEmail1">Ukuran</label>
                                        <input type="email" class="form-control">
                                    </div>
                                    <div class="col">
                                        <label for="exampleInputtext1">Tebal</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col">
                                        <label for="exampleInputtext1">Jenis</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col">
                                        <label for="exampleInputEmail1">Berat</label>
                                        <input type="email" class="form-control">
                                    </div>
                                    <div class="col">
                                        <label for="exampleInputtext1">Kualitas</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col">
                                        <label for="exampleInputtext1">Panjang</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col-4">
                                        <label for="exampleInputEmail1">Harga</label>
                                        <input type="email" class="form-control">
                                    </div>
                                    <div class="col-4">
                                        <label for="exampleInputEmail1">Jumlah Beli</label>
                                        <input type="email" class="form-control">
                                    </div>
                                    <div class="col-4">
                                        <label for="exampleInputEmail1">Total Harga</label>
                                        <input type="email" class="form-control">
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan</button>
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
                        <div class="table-responsive text-nowrap">
                            <table class="table table-sm ">
                                <thead>
                                    <th scope="col">No</th>
                                    <th scope="col">Id Ajuan</th>
                                    <th scope="col">User Id</th>
                                    <th scope="col">JenisPekerjaan</th>
                                    <th scope="col">Gaji</th>
                                    <th scope="col">Hari</th>
                                    <th scope="col">Total Pekerja</th>
                                    <th scope="col">Total Gaji</th>
                                    <th scope="col">Aksi</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>AJP001</td>
                                        <td>USR001</td>
                                        <td>Mandor</td>
                                        <td>8000000</td>
                                        <td>8</td>
                                        <td>15</td>
                                        <td>90000000</td>
                                        <td><button class="btn btn-sm btn-danger">Edit</button><button class="btn btn-sm btn-warning">Hapus</button></td>
                                    </tr>

                                </tbody>
                            </table>
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
                        <div class="table-responsive text-nowrap">
                            <table class="table table-sm ">
                                <thead>
                                    <th scope="col">No</th>
                                    <th scope="col">Id Ajuan</th>
                                    <th scope="col">User Id</th>
                                    <th scope="col-2">Nama Transaksi</th>
                                    <th scope="col">Total Biaya</th>
                                    <th scope="col">Aksi</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>AJP001</td>
                                        <td>USR001</td>
                                        <td>Transportasi</td>
                                        <td>500000</td>
                                        <td><button class="btn btn-sm btn-danger">Edit</button><button class="btn btn-sm btn-warning">Hapus</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<script>
    $(document).ready(function() {

        //Perhitungan BB
        $.ajax({
            url: 'http://localhost:8080/TampilTable/tableperhitunganbb',
            dataType: "json",
            success: function(response) {
                $('.tampilbahanbaku').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    })
</script>
<?= $this->endSection(); ?>