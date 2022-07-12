<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>
<section>
    <div class="container-fluid d-flex justify-content-center">
        <div class="card" style="width:40rem">
            <div class="card-body">
                <h3 class="card-title text-center mb-4">DATA BAHAN BAKU PROYEK</h5>
                    <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#exampleModal">Tambah</button>
                    <div class=" d-flex justify-content-center">
                        <table class="table table-hover">
                            <tr class="table-active">
                                <th class="text-center">Nama Bahan Baku</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-center">Harga satuan</th>
                                <th class="text-center"></th>
                            </tr>
                            <?php foreach ($bahanbaku as $bb) : ?>
                                <tr>
                                    <td class="text-center"><?= $bb['namabahan']; ?></td>
                                    <td class="text-center"><?= $bb['jumlah']; ?></td>
                                    <td class="text-center">Rp. <?= $bb['harga_satuan']; ?></td>
                                    <td class="text-center"><a href="<?= base_url(); ?>/bahanbaku/detail/<?= $bb['idbahan']; ?>" class="btn btn-success btn-sm"> Detail</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>

            </div>

        </div>
    </div>


</section>
<section>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection(); ?>