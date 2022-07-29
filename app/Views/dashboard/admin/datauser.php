<?= $this->extend('dashboard/admin/template'); ?>
<?= $this->section('dashboardadmin'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Kelola Data User</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <div id="tampiluser">

                    </div>
                </div>

            </div>
        </div>
    </section>
    <section>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="<?= base_url(); ?>/DashboardAdmin/ubahUser">
                            <?= csrf_field(); ?>
                            <input type="hidden" class="form-control" id="user_id" name="user_id">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" readonly class="form-control" id="username" name="username">
                            </div>
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" readonly class="form-control" id="email" name="email">
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat">
                            </div>
                            <div class="form-group">
                                <label for="notelp">No Telpon</label>
                                <input type="text" class="form-control" id="notelp" name="notelp">
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select name="role" id="role" class="custom-select">
                                    <option value="1">Admin</option>
                                    <option value="2">Klien</option>
                                </select>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Ubah User</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
</body>

</html>

<script>
    $(document).ready(function() {

        $.ajax({
            url: 'http://localhost:8080/TampilTable/tableuser',
            dataType: "json",
            success: function(response) {
                $('#tampiluser').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    })
</script>
<?= $this->endSection(); ?>