<div class="table-responsive text-nowrap">
    <table class="table bop table-sm">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Id Ajuan</th>
                <th scope="col">User Id</th>
                <th scope="col-2">Nama Transaksi</th>
                <th scope="col">Total Biaya</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $nomer = 1 ?>
            <?php foreach ($bop as $row) ?>
            <tr>
                <th scope="row"><?= $nomer; ?></th>
                <td><?= $row['idajuan']; ?></td>
                <td><?= $row['user_id']; ?></td>
                <td><?= $row['namatrans']; ?></td>
                <td><?= $row['tot_biaya']; ?></td>
                <td><button class="btn btn-sm btn-danger">Edit</button><button class="btn btn-sm btn-warning">Hapus</button></td>
            </tr>
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('.bop').DataTable({
            "pageLength": 3,
            "columnDefs": [{
                orderable: false,
                targets: [1, 2, 3, 4, 5]
            }],
            "fixedColumns": {
                leftColumns: 1,
                rightColumns: 1
            },
            "lengthChange": false
        });
    })
</script>