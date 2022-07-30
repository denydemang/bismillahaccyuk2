<div class="table-responsive text-nowrap">
    <table id="tenaker" class="table table-sm ">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Id Ajuan</th>
                <th scope="col">User Id</th>
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
            <?php foreach ($tenaker as $row) ?>
            <tr>
                <th scope="row"><?= $nomer; ?></th>
                <td><?= $row['idajuan']; ?></td>
                <td><?= $row['user_id']; ?></td>
                <td><?= $row['jenispekerjaan']; ?></td>
                <td><?= $row['gaji']; ?></td>
                <td><?= $row['hari']; ?></td>
                <td><?= $row['total_pekerja']; ?></td>
                <td><?= $row['total_gaji']; ?></td>
                <td><button class="btn btn-sm btn-danger">Edit</button><button class="btn btn-sm btn-warning">Hapus</button></td>
            </tr>

        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('#tenaker').DataTable({
            "pageLength": 3,
            "columnDefs": [{
                orderable: false,
                targets: [1, 2, 3, 4, 5, 6, 7, 8]
            }],
            "fixedColumns": {
                leftColumns: 1,
                rightColumns: 1
            },
            "lengthChange": false
        });
    })
</script>