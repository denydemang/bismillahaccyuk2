$(document).ready(function(){
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
})