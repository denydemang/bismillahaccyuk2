<div class="table-responsive text-nowrap">
    <table id="bahanbaku" class="table table-sm ">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Id Ajuan</th>
                <th scope="col">User Id</th>
                <th scope="col-2">Nama Bahan</th>
                <th scope="col">Ukuran</th>
                <th scope="col">Kualitas</th>
                <th scope="col">Berat</th>
                <th scope="col">Ketebalan</th>
                <th scope="col">Panjang</th>
                <th scope="col">Harga</th>
                <th scope="col">Jumlah Beli</th>
                <th scope="col">Total Harga</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $nomor = 1 ?>
            <?php foreach ($bahanbaku as $row) : ?>
                <tr>
                    <th scope="row"><?= $nomor++; ?></th>
                    <td><?= $row['idajuan']; ?></td>
                    <td><?= $row['user_id']; ?></td>
                    <td><?= $row['namabahan']; ?></td>
                    <td><?= $row['ukuran']; ?></td>
                    <td><?= $row['kualitas']; ?></td>
                    <td><?= $row['berat']; ?></td>
                    <td><?= $row['ketebalan']; ?></td>
                    <td><?= $row['panjang']; ?></td>
                    <td><?= $row['harga']; ?></td>
                    <td><?= $row['jumlah_beli']; ?></td>
                    <td><?= $row['total_harga']; ?></td>
                    <td><button class="btn btn-sm btn-danger">Edit</button><button class="btn btn-sm btn-warning">Hapus</button></td>
                </tr>
            <?php endforeach; ?>

        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('#bahanbaku').DataTable({
            "pageLength": 3,
            "columnDefs": [{
                orderable: false,
                targets: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
            }],
            "fixedColumns": {
                leftColumns: 1,
                rightColumns: 1
            },
            "lengthChange": false
        });

    })
</script>