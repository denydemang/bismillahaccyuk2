$(document).ready(function(){

    //Menu KelolaDatauser di Dashboard Admin
    $('.tombolhapus').click(function(){
         const user = $(this).data('user');
         const id_user =$(this).data('id');
        
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
            position: 'center',
            icon: 'success',
            title: 'Ajuan Proyek Berhasil Dikirim',
            showConfirmButton: false,
            timer: 3000
          })
    }
    // end form ajuan didaasboard klien
    
    //form ajuan proyek di dashboard admin

    //notif ajuan
    const namaproyek = $('.flashdata').data('namaproyek');
    const namaklien = $('.flashdata').data('namaklien');
    var pesan =  $('.flashdata').data('pesan');
    //notif jika diterima
    if (pesan =="diterima"){
        Swal.fire({
            icon: 'success',
            title: 'Ajuan Proyek Berhasil Diterima',
            text: 'Ajuan Proyek '+namaproyek+' dengan pengaju bernama '+namaklien+' telah diterima',
          })
    // notif jika ditolak
    } else if (pesan=="ditolak"){
        Swal.fire({
            icon: 'success',
            title: 'Ajuan Proyek Berhasil Ditolak',
            text: 'Ajuan Proyek '+namaproyek+' dengan pengaju bernama '+namaklien+' telah ditolak',
          })
        //   notif jika dihapus
    }else if (pesan=="dihapus"){
        Swal.fire({
            icon: 'success',
            title: 'Ajuan Proyek Berhasil Dihapus',
            text: 'Ajuan Proyek '+namaproyek+' dengan pengaju bernama '+namaklien+' telah dihapus',
          })
        }
    //jika admin menerima ajuan
    $('.terima').click(function(){
        let namaproyek = $(this).data('namaproyek');
        let namaklien = $(this).data('namaklien');
        let idajuan =$(this).data('idajuan');
        Swal.fire({
            title: 'Terima Ajuan Proyek?',
            text: "Ajuan Proyek "+namaproyek+" dengan pengaju bernama "+namaklien+" Akan Diterima",
            icon: 'question',
            showCancelButton: true,
            cancelButtonText: 'Batal',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya'
        }).then((result) => {
            if (result.isConfirmed) {
                location.href = 'http://localhost:8080/admin/terimaajuan/'+idajuan
            }
        })
    })
    //jika admin menolak ajuan
    $('.tolak').click(function(){
        let namaproyek = $(this).data('namaproyek');
        let namaklien = $(this).data('namaklien');
        let idajuan =$(this).data('idajuan');
        Swal.fire({
            title: 'Tolak Ajuan Proyek?',
            text: "Ajuan Proyek "+namaproyek+" dengan pengaju bernama "+namaklien+" Akan Ditolak",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Batal',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya'
        }).then((result) => {
            if (result.isConfirmed) {
                location.href = 'http://localhost:8080/admin/tolakajuan/'+idajuan
            }
        })

    })
    //jika admin menghapus ajuan
    $('.hapusajuan').click(function(){
        let namaproyek = $(this).data('namaproyek');
        let namaklien = $(this).data('namaklien');
        let idajuan =$(this).data('idajuan');
        Swal.fire({
            title: 'Hapus Ajuan Proyek?',
            text: "Ajuan Proyek "+namaproyek+" dengan pengaju bernama "+namaklien+" Akan Dihapus",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Batal',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya'
        }).then((result) => {
            if (result.isConfirmed) {
                location.href = 'http://localhost:8080/admin/hapusajuan/'+idajuan
            }
        })

    })

    // end form ajuan proyek di dashboard admin

    //Form Detail Ajuan didashboard admin
    $('.detailajuan').click(function(){
   
        let idajuan = $(this).data('idajuan');
        $('.detailcreate').data('detailid',idajuan);
        $('.detailterima').data('detailid',idajuan);
        $('.detailtolak').data('detailid',idajuan);
        $('.detailhapus').data('detailid',idajuan);

        $.ajax({
            url: 'http://localhost:8080/DashboardAdmin/detailajuanproyek',
            data: {id : idajuan},
            method: 'post',
            dataType: 'json',
            success: function(data){
                if (data[0]['status_id'] =='1'){
                    $('.detailterima').show();
                    $('.detailtolak').show();
                    $('.detailcreate').hide();
                    $('.detailhapus').hide();
                    $('.detailnamastatus').removeClass('badge-primary')
                    $('.detailnamastatus').removeClass('badge-danger')
                    $('.detailnamastatus').addClass('badge-secondary')
                } else if (data[0]['status_id'] =='2') {
                    $('.detailcreate').show();
                    $('.detailterima').hide();
                    $('.detailhapus').hide();
                    $('.detailtolak').hide();
                    $('.detailnamastatus').removeClass('badge-secondary')
                    $('.detailnamastatus').removeClass('badge-danger')
                    $('.detailnamastatus').addClass('badge-primary')
                } else{
                    $('.detailcreate').hide();
                    $('.detailterima').hide();
                    $('.detailhapus').show();
                    $('.detailtolak').hide();

                    $('.detailnamastatus').removeClass('badge-secondary')
                    $('.detailnamastatus').removeClass('badge-primary')
                    $('.detailnamastatus').addClass('badge-danger')
                }
                $('.detailidajuan').html(data[0]['idajuan']);
                $('.detailiduser').html(data[0]['user_id']);
                $('.detailnamaproyek').html(data[0]['namaproyek']);
                $('.detailnamastatus').html(data[0]['keterangan']);
                $('.detailjenisproyek').html(data[0]['jenisproyek']);
                $('.detaillokasiproyek').html(data[0]['lokasiproyek']);
                $('.detailnama').html(data[0]['nama']);
                $('.detailemail').html(data[0]['email']);
                $('.detailalamat').html(data[0]['alamat']);
                $('.detailtelp').html(data[0]['notelp']);
                $('.detailcatatanproyek').html(data[0]['catatanproyek']);
                
            }


        })
          
    })
    //aksi di form modal detail ajuan
    $('.detailterima').click(function(){
        let id = $(this).data('detailid');
        Swal.fire({
            title: 'Terima Ajuan Proyek ini',
            icon: 'question',
            showCancelButton: true,
            cancelButtonText: 'Batal',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya'
        }).then((result) => {
            if (result.isConfirmed) {
                location.href = 'http://localhost:8080/admin/terimaajuan/'+id
            }
        })
    })
    $('.detailcreate').click(function(){
       
        location.href = 'http://localhost:8080/admin/buatproyek/'
    
    })
    $('.detailtolak').click(function(){
        let id = $(this).data('detailid');
        Swal.fire({
            title: 'Tolak Ajuan Proyek Ini?',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Batal',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya'
        }).then((result) => {
            if (result.isConfirmed) {
                location.href = 'http://localhost:8080/admin/tolakajuan/'+id
            }
        })
    })
    $('.detailhapus').click(function(){
        let id = $(this).data('detailid');
        Swal.fire({
            title: 'Hapus Ajuan Proyek Ini?',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Batal',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya'
        }).then((result) => {
            if (result.isConfirmed) {
                location.href = 'http://localhost:8080/admin/hapusajuan/'+id
            }
        })
    })
    // let data =  $('.detailcreate').data('detailid')
    // let data2=  $('.detailterima').data('detailid')
    //  console.log(data);
    //  console.log(data2);
    
    //end form detail ajuan proyek di dashboard admin
 
})