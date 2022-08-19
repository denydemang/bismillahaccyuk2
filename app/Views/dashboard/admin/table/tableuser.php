    <div class="table-responsive">
        <table id="tableuser" class="table table-striped tableuser">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Id</th>
                    <th>User Name</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>No Telpon</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1 ?>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $user->user_id; ?></td>
                        <td><?= $user->user_name; ?></td>
                        <td><?= $user->nama; ?></td>
                        <td><?= $user->email; ?></td>
                        <td><?= $user->alamat; ?></td>
                        <td><?= $user->notelp; ?></td>
                        <td><?= $user->levelnama; ?></td>
                        <td><button data-id="<?= $user->user_id; ?>" class="btn btn-primary ubahuser" data-toggle="modal" data-target="#exampleModal" style="width:50px"><i class="fas fa-edit"></i></button><button class="btn btn-danger tombolhapus" data-id="<?= $user->user_id; ?>" data-user="<?= $user->user_name; ?>" style="width:50px"><i class=" fas fa-trash"></i></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script>
        $(document).ready(function() {
            $('#tableuser').DataTable({
                "pageLength": 3,
                "fixedColumns": {
                    leftColumns: 1,
                    rightColumns: 1
                },
                "columnDefs": [{
                    orderable: false,
                    targets: [1, 2, 3, 4, 5, 6, 7, 8]
                }],
            });
            $(document).on('click', '.tombolhapus', function() {
                const user = $(this).data('user');
                const id_user = $(this).data('id');

                Swal.fire({
                    title: 'Yakin?',
                    text: "Akun Dengan Username " + user + " Akan Dihapus ",
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya'
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.href = 'http://localhost:8080/admin/deleteuser/' + id_user
                    }
                })

            })
            $(document).on('click', '.ubahuser', function() {
                const id = $(this).data('id');
                $.ajax({
                    url: 'http://localhost:8080/DashboardAdmin/getUser',
                    data: {
                        id: id
                    },
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        $('#user_id').val(data[0].user_id);
                        $('#username').val(data[0].user_name);
                        $('#nama').val(data[0].nama);
                        $('#email').val(data[0].email);
                        $('#alamat').val(data[0].alamat);
                        $('#notelp').val(data[0].notelp);
                        $('#role').val(data[0].user_level);
                    }
                })
            })
        })
    </script>