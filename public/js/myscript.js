//pengajuan proyek


$(document).ready(function(){
    let lineNo = 1;
       
            $("#add-row").click(function () {
                markup ='<tr class="baris"><td><input class="form-control" type="text"  id="" style="width:300px"></td><td><input class="form-control line" type="text" name="number'+lineNo+'" id=""></td></tr>';
                tableBody = $("table tbody");
                tableBody.append(markup);
                $('#sum').val(getSum(lineNo));
                lineNo++;
             
          
        }); 
        function getSum(numberOfDivs) {
            var sum = 0;
            for (var i=0 ; i<numberOfDivs; i++) {
              sum += parseInt(document.getElementsByName('number' + i)[0].value);
            }
            return sum;
          }

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
<<<<<<< HEAD
    // $('.klikklien').click(function(){
    //     const id_user =$(this).data('uid');
    //     console.log(id_user);
        
    //     // Pusher.logToConsole = true;

    //     // var pusher = new Pusher('e0bd82d32cf9d6ef3c0f', {
    //     //     cluster: 'ap1'
    //     //     });

    //     // // var idus=$(this).data('uid');
    //     // // var channel = pusher.subscribe(idus);
    //     // var channel = pusher.subscribe(id_user);

    //     // channel.bind('my-event', function(data) {
    //     //     alert(JSON.stringify(data));
    //     //     addData(data);
    //     //     hapuschat();
    //     //     });
    //     //     function addData(data){
    //     //         var str='';
    //     //         for(var z in data){
    //     //             str +=
    //     //             (data[z].id_admin === '0') ?
    //     //             '<div class="direct-chat-msg"><div class="direct-chat-infos clearfix"><span class="direct-chat-name float-left">Admin</span><span class="direct-chat-timestamp float-right">23 Jan 2:00 pm</span></div><img class="direct-chat-img" src='+windows.location('assetslte/dist/img/user1-128x128.jpg')+' alt="message user image"><div class="direct-chat-text">'+$data[z].pesan+'</div></div>':
    //     //             '<div class="direct-chat-msg right"><div class="direct-chat-infos clearfix"><span class="direct-chat-name float-right">Klien</span><span class="direct-chat-timestamp float-left">23 Jan 2:05 pm</span></div><img class="direct-chat-img" src='+windows.location('assetslte/dist/img/user3-128x128.jpg')+' alt="message user image"><div id="pesan" name="pesan" class="direct-chat-text">'+$data[z].pesan+'</div></div>';
    //     //         }
    //     //         $('#didchat').html(str);
    //     //     }
    //     //     function hapuschat(){
    //     // 		document.getElementById('pesan').value='';
    //     //     }
    //     $.ajax({
    //         // url: 'http://localhost:8080/DashboardAdmin/getklien',
    //         url: 'http://localhost:8080/DashboardAdmin/message/'+id_user,
    //         data: {id_client : id_user},
    //         method: 'post',
    //         dataType: 'json',
    //         success: function(data){
    //             $('#id_admin').val(data[0].id_admin);
    //             $('#id_client').val(data[0].id_client);
    //             $('#nama_user').val(data[0].nama_user);
    //             $('#pesan').val(data[0].pesan);
    //         }
    //     })
    //    }
    // )
    $('.store').click(function(){
        console.log('aaa');
            
        var value = {
            id_admin: $('#id_admin').val(),
            id_client: $('#id_client').val(),
            nama_user: $('#nama_user').val(),
            pesan: $('#pesan').val(),	
        }
        $.ajax({
            // url: '<?= site_url(/DashboardAdmin/store);?>',
            // url: 'http://localhost:8080/DashboardAdmin/message/'+id_client,
            url: 'http://localhost:8080/DashboardAdmin/store',
            type: 'POST',
            data: value,
            // dataType: 'json',
        })
        
    })
    // $('.store2').click(function(){
    //     console.log('aaa');
            
    //     var value = {
    //         id_admin: $('#id_admin').val(),
    //         id_client: $('#id_client').val(),
    //         nama_user: $('#nama_user').val(),
    //         pesan: $('#pesan').val(),	
    //     }
    //     $.ajax({
    //         // url: '<?= site_url(/DashboardAdmin/store);?>',
    //         // url: 'http://localhost:8080/DashboardAdmin/message/'+id_client,
    //         url: 'http://localhost:8080/DashboardKlien/store2',
    //         type: 'POST',
    //         data: value,
    //         // dataType: 'json',
            
    //     })
        
    // })
=======
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
                    $('.detailnamastatus').removeClass('badge-success')
                    $('.detailnamastatus').addClass('badge-secondary')
                } else if (data[0]['status_id'] =='2') {
                    $('.detailcreate').show();
                    $('.detailterima').hide();
                    $('.detailhapus').hide();
                    $('.detailtolak').hide();
                    $('.detailnamastatus').removeClass('badge-secondary')
                    $('.detailnamastatus').removeClass('badge-danger')
                    $('.detailnamastatus').removeClass('badge-success')
                    $('.detailnamastatus').addClass('badge-primary')
                }else if (data[0]['status_id'] =='3') {
                    $('.detailcreate').hide();
                    $('.detailterima').hide();
                    $('.detailhapus').show();
                    $('.detailtolak').hide();
                    $('.detailnamastatus').removeClass('badge-secondary')
                    $('.detailnamastatus').removeClass('badge-primary')
                    $('.detailnamastatus').removeClass('badge-success')
                    $('.detailnamastatus').addClass('badge-danger')
                   
                } 
                else if (data[0]['status_id'] =='4'){
                    $('.detailcreate').hide();
                    $('.detailterima').hide();
                    $('.detailhapus').hide();
                    $('.detailtolak').hide();
                    $('.detailnamastatus').removeClass('badge-secondary')
                    $('.detailnamastatus').removeClass('badge-danger')
                    $('.detailnamastatus').removeClass('badge-primary')
                    $('.detailnamastatus').addClass('badge-success')
                    
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
       var id = $(this).data('detailid');
        location.href = 'http://localhost:8080/admin/dataproyek/'+id
    
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
 

    //Form Data Proyek Di Dashboard Admin
    $('#idajuan').change(function(){
        let idajuan = $(this).val();
        $.ajax({
            url: 'http://localhost:8080/DashboardAdmin/detailajuanproyek',
            data: {id : idajuan},
            method: 'post',
            dataType: 'json',
            success: function(data){
               $('#user_id').val(data[0]['user_id'])
               $('#namaproyek').val(data[0]['namaproyek'])
               $('#jenisproyek').val(data[0]['jenisproyek'])
               $('#nama').val(data[0]['nama'])
            }


        })
    })
    //data otomatis terisi jika ada data yang dikirim dari menu ajuan proyek
    let getidajuan = $('.getbuatproyek').data('idajuan');
    let getnamaklien = $('.getbuatproyek').data('namaklien');
    let getnamaproyek = $('.getbuatproyek').data('namaproyek');
    let getjenisproyek = $('.getbuatproyek').data('jenisproyek');
    let getidklien = $('.getbuatproyek').data('idklien');
    if (getidajuan !==''){
       $('#idajuan').val(getidajuan);
       $('#nama').val(getnamaklien);
       $('#namaproyek').val(getnamaproyek);
       $('#jenisproyek').val(getjenisproyek);
       $('#user_id').val(getidklien);

    }
    function kurang(x, y){
        var xint = parseInt(x);
        var yint = parseInt(y);
        
        hasil = xint- yint;
        return hasil
    }
    $('#sudahbayar').keyup(function(){
       
       let biaya = $('#biaya').val()
       let sudahbayar = $('#sudahbayar').val()
       var belumbayar = kurang(biaya,sudahbayar)
       if (belumbayar < 0) {
        hasil = "Input Tidak Valid"
       } else {
        hasil = belumbayar;
       }
       $('#belumbayar').val(hasil);
    })
    $('#biaya').keyup(function(){
       
       let biaya = $('#biaya').val()
       let sudahbayar = $('#sudahbayar').val()
       var belumbayar = kurang(biaya,sudahbayar)
       if (belumbayar < 0) {
        hasil = "Input Tidak Valid"
       } else if (belumbayar > 0){
        hasil = belumbayar;
       }
       $('#belumbayar').val(hasil);
    })

   // End Form Data Proyek Di Dashboard Admin
   
    
    

>>>>>>> 11c201eee95eba0f92577075e2d8ca9748faf997
})