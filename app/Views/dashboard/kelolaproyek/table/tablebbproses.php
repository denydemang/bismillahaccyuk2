<div class="table-responsive text-nowrap">
    <?php

    use App\Models\BahanBakuProsesModel;

    function tanggal_indonesia($tanggal)
    {
        $bulan = array(
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );

        $pecahkan = explode('-', $tanggal);

        // variabel pecahkan 0 = tanggal
        // variabel pecahkan 1 = bulan
        // variabel pecahkan 2 = tahun

        return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
    }
    ?>

    <table id="tablebb" class="table table-striped table-sm">
        <thead>
            <th>No</th>
            <th>Id Bahan Baku</th>
            <th>Nama Bahan</th>
            <th>Harga</th>
            <th>Status</th>
            <th>Jumlah Dibeli</th>
            <th>Tgl Beli</th>
            <th>Total</th>
            <th>Aksi</th>

        </thead>
        <tbody>
            <?php $nomor = 1 ?>
            <?php foreach ($databb as $row) : ?>

                <?php $bbproses = new BahanBakuProsesModel();
                $databbproses = $bbproses->where('id_pbb', $row['id_pbb'])->first();
                $total = $row['harga'] *  (empty($databbproses) ? 0 : intval($databbproses['jumlah_beli']));
                ?>
                <tr>
                    <td><?= $nomor++; ?></td>
                    <td><?= $row['id_pbb']; ?></td>
                    <td><?= $row['namabahan']; ?></td>
                    <td>Rp <?= number_format($row['harga'], 0, '', '.'); ?>,-</td>
                    <?php if (empty($databbproses)) : ?>
                        <td><span class="badge badge-secondary">Belum Dibeli</span></td>
                    <?php else : ?>
                        <td><span class="badge badge-success">Sudah Dibeli</span></td>
                    <?php endif; ?>
                    <?php if (empty($databbproses)) : ?>
                        <td>0</td>
                    <?php else : ?>
                        <td><?= $databbproses['jumlah_beli']; ?></td>
                    <?php endif; ?>
                    <?php if (empty($databbproses)) : ?>
                        <td>-</td>
                    <?php else : ?>
                        <td><?= tanggal_indonesia($databbproses['tgl_beli']); ?></td>
                    <?php endif; ?>
                    <td>Rp <?= number_format($total, 0, '', '.'); ?>,-</td>
                    <?php if (empty($databbproses)) : ?>
                        <td><button data-id_pbb="<?= $row['id_pbb']; ?>" data-toggle="modal" data-target="#modalbb" class="btn btn-danger btn-sm belibb"><i class="fas fa-money-bill mr-2"></i> Beli</button></td>
                    <?php else : ?>
                        <td></td>
                    <?php endif; ?>
                </tr>

            <?php endforeach ?>
        </tbody>

    </table>
</div>
<script>
    $(document).ready(function() {
        $('#tablebb').DataTable({
            "columnDefs": [{
                orderable: false,
                targets: [4, 5, 6, 7]
            }],
            "fixedColumns": {
                leftColumns: 1,
                rightColumns: 1
            },
        });
    })
</script>