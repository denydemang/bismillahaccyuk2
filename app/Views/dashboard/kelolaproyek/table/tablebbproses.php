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
            <th>Id Material Penyusun</th>
            <th>Id Material Utama</th>
            <th>Nama Material</th>
            <th>Spesifikasi</th>
            <th>Qty</th>
            <th>Satuan</th>
            <th>Harga</th>
            <th>Total Harga</th>
            <th>Aksi</th>
        </thead>
        <tbody>
            <?php foreach ($databb as $row) : ?>
                <tr>
                    <td><?= $row['idmaterialpenyusun']; ?></td>
                    <td><?= $row['idmaterial']; ?></td>
                    <td><?= $row['namamp']; ?></td>
                    <td><?= $row['spesifikasimp']; ?></td>
                    <td><?= $row['satuanmp']; ?></td>
                    <td><?= $row['jumlahmp']; ?></td>
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
                targets: [4, 5, 6, 7]
            }],
            "fixedColumns": {
                leftColumns: 1,
                rightColumns: 1
            },
        });
    })
</script>