$(document).ready(function(){

    //Menu KelolaDatauser di Dashboard Admin
    $('.tombolhapus').click(function(){
         const user = $(this).data('user');
         const id_user =$(this).data('id');
         console.log(id_user);
            Swal.fire({
                title: 'Yakin?',
                text: "Akun Dengan Username "+user+" Akan Dihapus ",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href = 'http://localhost:8080/admin/deleteuser/'+id_user
                }
            })
                })
    $('.ubahuser').click(function(){

        const id = $(this).data('id');
        $.ajax({
            url: 'http://localhost:8080/DashboardAdmin/getUser',
            data: {id : id},
            method: 'post',
            dataType: 'json',
            success: function(data){
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
    // End KelolaDataUser di Dashboard Admin

    //form ajuan proyek di dashboard klien
    var pesan = $('.pesan').data('flash')
    if(pesan == 'berhasildiajukan'){
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Ajuan Proyek Berhasil Dikirim',
            showConfirmButton: false,
            timer: 3000
          })
    }
    // if(pesan == 'berhasil'){

    // }

})