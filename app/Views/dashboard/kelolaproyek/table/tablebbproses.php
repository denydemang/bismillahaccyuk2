<div class="table-responsive text-nowrap">
    <table id="tablebb" class="table table-striped table-sm">
        <thead>
            <th>No</th>
            <th>Id Proyek</th>
            <th>Id Beli</th>
            <th>Nama Proyek</th>
            <th>Tanggal Beli</th>
            <th>Nama Bahan</th>
            <th>Harga</th>
            <th>Jumlah Beli</th>
            <th>Total</th>
            <th>Aksi</th>
        </thead>
        <tbody>
            <?php $Nomer = 1; ?>

            <?php foreach ($databb as $row) :  ?>
                <?php $totalbeli = (($row['harga']) * ($row['jumlah_beli'])) ?>
                <tr>
                    <th><?= $Nomer++; ?></th>
                    <td><?= $row['idproyek']; ?></td>
                    <td><?= $row['idbelibahan']; ?></td>
                    <td><?= $row['namaproyek']; ?></td>
                    <td><?= date('d F Y', strtotime($row['tgl_beli'])); ?></td>
                    <td><?= $row['namabahan']; ?></td>
                    <td>Rp <?= number_format($row['harga'], 0, '', '.'); ?>,-</td>
                    <td><?= $row['jumlah_beli']; ?></td>
                    <td>
                        Rp <?= number_format($totalbeli, 0, '', '.'); ?>,-
                    </td>
                    <td><button data-id="<?= $row['idbelibahan']; ?>" data-namabahan="<?= $row['namabahan']; ?>" data-toggle="modal" data-target="#ModalDetailBB" class="btn btn-sm btn-outline-secondary detailbbproses">Detail</button>
                        <button data-id="<?= $row['idbelibahan']; ?>" data-namabahan="<?= $row['namabahan']; ?>" data-toggle="modal" data-target="#modalbb" class="btn btn-sm btn-outline-primary editbbproses">Edit</button>
                        <button data-id="<?= $row['idbelibahan']; ?>" data-namabahan="<?= $row['namabahan']; ?>" class="btn btn-sm btn-outline-danger hapusbbproses">Hapus</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>
</div>
<script>
    $(document).ready(function() {
        $('#tablebb').DataTable({
            "columnDefs": [{
                orderable: false,
                targets: [3, 4, 5, 6, 7, 8, 9]
            }],
            "fixedColumns": {
                leftColumns: 1,
                rightColumns: 1
            },
        });
    })
</script>