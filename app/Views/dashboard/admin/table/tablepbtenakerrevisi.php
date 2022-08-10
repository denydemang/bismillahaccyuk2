<div class="table-responsive text-nowrap">
    <table id="tenaker" class="table table-sm ">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">ID Biaya TK</th>
                <th scope="col">Id Ajuan</th>
                <th scope="col">User Id</th>
                <th scope="col">Nama Proyek</th>
                <th scope="col">JenisPekerjaan</th>
                <th scope="col">Gaji</th>
                <th scope="col">Hari</th>
                <th scope="col">Total Pekerja</th>
                <th scope="col">Total Gaji</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $nomer = 1 ?>
            <?php foreach ($tenaker as $row) : ?>
                <tr>
                    <th scope="row"><?= $nomer++; ?></th>
                    <td><?= $row['id_pbtenaker']; ?></td>
                    <td><?= $row['idajuan']; ?></td>
                    <td><?= $row['user_id']; ?></td>
                    <td><?= $row['namaproyek']; ?></td>
                    <td><?= $row['jenispekerjaan']; ?></td>
                    <td><?= number_format($row['gaji'], 0, ",", "."); ?></td>
                    <td><?= $row['hari']; ?></td>
                    <td><?= $row['total_pekerja']; ?></td>
                    <td><?= number_format($row['total_gaji'], 0, ",", "."); ?></td>
                    <td>
                        <button data-id="<?= $row['id_pbtenakerr']; ?>" data-idtenaker="<?= $row['id_pbtenaker']; ?>" data-jenispekerjaan="<?= $row['jenispekerjaan']; ?>" class="btn btn-sm btn-success edittk">Edit</button>
                        <button data-id="<?= $row['id_pbtenakerr']; ?>" data-idtenaker="<?= $row['id_pbtenaker']; ?>" data-jenispekerjaan="<?= $row['jenispekerjaan']; ?>" class="btn btn-sm btn-warning hapustk">Hapus</button>
                    </td>
                </tr>
            <?php endforeach; ?>

        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('#tenaker').DataTable({
            "pageLength": 3,
            "columnDefs": [{
                orderable: false,
                targets: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
            }],
            "fixedColumns": {
                leftColumns: 1,
                rightColumns: 2
            },
            "lengthChange": false
        });

    })
</script>