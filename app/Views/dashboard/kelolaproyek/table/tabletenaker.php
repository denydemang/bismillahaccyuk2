<div class="table-responsive text-nowrap">
    <table id="tabletenaker" class="table table-striped table-sm">
        <thead>
            <th>No</th>
            <th>Id Tenaker</th>
            <th>Id Proyek</th>
            <th>Nama </th>
            <th>Gaji </th>
            <th>Status</th>
            <th>Aksi</th>
        </thead>
        <tbody>
            <?php $Nomer = 1; ?>
            <?php foreach ($datatenaker as $row) : ?>
                <tr>
                    <th><?= $Nomer++; ?></th>
                    <td><?= $row['idtenaker']; ?></td>
                    <td><?= $row['idproyek']; ?></td>
                    <td><?= $row['namatenaker'] ?></td>
                    <td>Rp. <?= number_format($row['gaji'], 0, '', '.') ?></td>
                    <?php if ($row['belum_bayar'] == 0) : ?>
                        <td><span class="badge badge-info">Lunas</span></td>
                    <?php else : ?>
                        <td><span class="badge badge-danger">Belum Lunas</span></td>
                    <?php endif; ?>
                    <td><button id="btndetailtenaker" data-id="<?= $row['idtenaker']; ?>" data-namatk="<?= $row['namatenaker']; ?>" data-toggle="modal" data-target="#ModalDetail" class="btn btn-sm btndetailtenaker btn-secondary">Detail</button> <button id="btnedittenaker" data-toggle="modal" data-target="#ModalTenaker" data-id="<?= $row['idtenaker']; ?>" data-namatk="<?= $row['namatenaker']; ?>" class="btn btn-success btn-sm btnedittenaker">Edit</button> <button id="btnhapustenaker" data-id="<?= $row['idtenaker']; ?>" data-namatk="<?= $row['namatenaker']; ?>" class="btn btn-danger btn-sm btnhapustenaker">Hapus</button>
                        <?php if ($row['belum_bayar'] != 0) : ?>
                            <button data-toggle="modal" data-target="#modal-sm" data-id="<?= $row['idtenaker']; ?>" data-namatk="<?= $row['namatenaker']; ?>" id="btnbayartenaker" class="btn btn-primary btn-sm btnbayartenaker">Bayar</button>
                        <?php endif; ?>
                    </td>

                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>
</div>
<script>
    $('#tabletenaker').DataTable({
        "columnDefs": [{
            orderable: false,
            targets: [3, 4, 5, 6]
        }],
        "fixedColumns": {
            leftColumns: 1,
            rightColumns: 1
        },

    });
</script>