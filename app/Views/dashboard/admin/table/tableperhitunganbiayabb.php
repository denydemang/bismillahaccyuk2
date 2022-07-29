<table class="table table-sm ">
    <thead>
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
    </thead>
    <tbody>
        <?php foreach ($bahanbaku as $row) : ?>
            <tr>
                <th scope="row">1</th>
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