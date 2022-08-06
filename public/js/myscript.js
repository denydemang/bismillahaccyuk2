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
   
    
    

})