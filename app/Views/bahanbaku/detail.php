<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid d-flex justify-content-center">
    <div class="card" style="width: 18rem;">
        <div class="card-header">
            <h3 class="text-center"><?= $bahanbaku['namabahan'] ?></h3>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">Id Proyek : <?= $bahanbaku['idproyek']; ?></li>
            <li class="list-group-item">Nama Bahan: <?= $bahanbaku['namabahan']; ?></li>
            <li class="list-group-item">Berat : <?= $bahanbaku['berat']; ?></li>
            <li class="list-group-item">Size : <?= $bahanbaku['size']; ?></li>
            <li class="list-group-item">Tipe : <?= $bahanbaku['tipe']; ?></li>
            <li class="list-group-item">Jumlah : <?= $bahanbaku['jumlah']; ?></li>
            <li class="list-group-item">Harga_Satuan : Rp <?= $bahanbaku['harga_satuan']; ?> </li>
            <li class="list-group-item">Total Harga : Rp <?= $bahanbaku['total_harga']; ?> </li>
        </ul>
        <div class="card-footer">
            <p><a href="<?= base_url(); ?>/bahanbaku">Kembali</a></p>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>