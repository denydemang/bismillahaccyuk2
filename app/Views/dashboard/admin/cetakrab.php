<?= $this->extend('dashboard/admin/template'); ?>

<?= $this->section('dashboardadmin'); ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Cetak RAB</h1>
        </div>
    </section>
    <section>
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <div class="dropdown">
                            <button type="button" data-toggle="dropdown" class="btn btn-success mb-2 pilihajuan">Pilih Id Ajuan <i class="ml-2 mb-2 dropdown-toggle"></i></button>
                            <div class="dropdown-menu dropdown-menu-lg">
                                <div class="card" style="width:600px !important">
                                    <div class="card-header">
                                        <div style="display:flex;flex-direction:row;justify-content:space-between">
                                            <h3 class="card-title">Daftar Ajuan Proyek</h3>
                                        </div>
                                    </div>
                                    <div class="card-body p-3">
                                        <table class="table text-nowrap daftarajuan">
                                            <thead>
                                                <th scope="col">ID AJUAN</th>
                                                <th scope="col">Nama Proyek</th>
                                                <th scope="col">Jenis Proyek</th>
                                                <th scope="col">Nama Klien</th>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($dataajuannn)) : ?>
                                                    <?php foreach ($dataajuannn as $row) : ?>
                                                        <tr>
                                                            <td><button type="button" data-id="<?= $row['idajuan']; ?>" class="btn btn-primary btn-sm btnidajuan"><?= $row['idajuan']; ?></button> </td>
                                                            <td><?= $row['namaproyek']; ?></td>
                                                            <td><?= $row['jenisproyek']; ?></td>
                                                            <td><?= $row['nama']; ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else : ?>

                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="display:flex;flex-direction:row;justify-content:space-evenly">
                        <div style="width:200px;">
                            <label for="">Id Ajuan</label>
                            <input type="text" readonly name="idajuan" id="idajuan" name="idajuan" class="form-control">
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
</div>
</section>
</div>
<script>
    const formatRupiah1 = (money) => {
        if (isNaN(money)) {
            money = 0;
        }
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(money);
    }
    $('.daftarajuan').DataTable({
        "lengthChange": false,
        "fixedHeader": true,
        "info": false,
        "paging": false,
        "scrollY": '150px',
        "scrollCollapse": true,
    })
    $('.btnidajuan').click(function() {
        let id = $(this).data('id')
        $('#idajuan').val(id);
        $('.cetak1').data('id', id);
        $('.cetak2').data('id', id);
        $.ajax({
            url: "http://localhost:8080/DashboardAdmin/totalbiaya/" + id,
            dataType: "json",
            success: function(response) {
                $('#tot_biaya').val(formatRupiah1(response));

            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    })
    $('.cetak2').click(function() {
        let id = $(this).data('id');
        window.location.href = 'http://localhost:8080/admin/printperhitunganbiayarevisi/' + id
    })
    $('.cetak1').click(function() {
        let id = $(this).data('id');
        window.location.href = 'http://localhost:8080/admin/printperhitunganbiaya/' + id
    })
</script>

<?= $this->endSection(); ?>