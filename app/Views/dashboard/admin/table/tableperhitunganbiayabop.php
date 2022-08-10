<?php

use App\Models\PerhitunganBOPRevisiModel; ?>
<div class="table-responsive text-nowrap">
    <table class="table bop table-sm">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">ID Biaya Op</th>
                <th scope="col">Id Ajuan</th>
                <th scope="col">User Id</th>
                <th scope="col">Nama Proyek</th>
                <th scope="col-2">Nama Transaksi</th>
                <th scope="col">Total Biaya</th>
                <th scope="col">Revisi</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php function getjumlahrevisibop($idpbop)
            {
                $perhitunganrevisimodel = new PerhitunganBOPRevisiModel();
                $builder = $perhitunganrevisimodel->builder();
                $get = $builder->like('id_pbop', $idpbop)->countAllResults();
                return $get;
            } ?>
            <?php $nomer = 1 ?>
            <?php foreach ($bop as $row) : ?>
                <tr>
                    <th scope="row"><?= $nomer++; ?></th>
                    <td><?= $row['id_pbop']; ?></td>
                    <td><?= $row['idajuan']; ?></td>
                    <td><?= $row['user_id']; ?></td>
                    <td><?= $row['namaproyek']; ?></td>
                    <td><?= $row['namatrans']; ?></td>
                    <td><?= number_format($row['tot_biaya'], 0, ",", "."); ?></td>
                    <td><span class="badge badge-success"><?= getjumlahrevisibop($row['id_pbop']) ?></span></td>
                    <td>
                        <?php if ($row['revisi_id'] == 1) : ?>
                            <button data-id_pbop="<?= $row['id_pbop']; ?>" class="btn btn-sm btn-secondary revisibop">Revisi</button>
                        <?php endif; ?>
                        <button data-idajuan="<?= $row['idajuan']; ?>" data-namatrans="<?= $row['namatrans']; ?>" data-namaproyek="<?= $row['namaproyek']; ?>" data-id="<?= $row['id_pbop']; ?>" class="btn btn-sm btn-warning hapusbop">Hapus</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('.bop').DataTable({
            "pageLength": 3,
            "columnDefs": [{
                orderable: false,
                targets: [1, 2, 3, 4, 5, 6, 7, 8]
            }],
            "fixedColumns": {
                leftColumns: 1,
                rightColumns: 2
            },
            "lengthChange": false
        });

    })
</script>