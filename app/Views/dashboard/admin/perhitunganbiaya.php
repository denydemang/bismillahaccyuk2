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
    <section class="content">
        <div class="container-fluid">
            <table>
                <thead>
                    <th>
                        Nama Transaksi
                    </th>
                    <th>
                        Biaya
                    </th>
                </thead>
                <tbody>
                    <tr class="baris">
                        <td><input class="form-control" type="text" name="" id="" style="width:300px"></td>
                        <td><input class="form-control line" type="text" name="number0" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"></td>
                    </tr>

                </tbody>

            </table>
            <button id="add-row" class="btn btn-primary"><i class="fas fa-plus"></i>Tambah</button></td>
            <div style="width:150px;">Hasil Jumlah<label for=""></label><input id="sum" type="text" class="form-control"></div>

        </div>
    </section>
</div>
<?= $this->endSection(); ?>