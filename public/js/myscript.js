
const tglmeeting =(tgl) => {
    let pecah = tgl.split(' ');
   let tanggal = pecah[0];
   let jam = pecah[1];
   let jamonly = jam.split(':')
   let jamfix = jamonly[0]+':'+jamonly[1];
   let pecahtanggal = tanggal.split('-');
   let bulan =pecahtanggal[1];
   let tanggalnew =pecahtanggal[2];
   let tahun = pecahtanggal[0];
    switch (bulan) {

        case '01':
            bulan = "Januari";
            break;
        case '02':
            bulan = "Februari";
            break;
        case '03':
            bulan = "Maret";
            break;
        case '04':
            bulan = "April";
            break;
        case '05':
            bulan = "Mei";
            break;
        case '06':
            bulan = "Juni";
            break;
        case '07':
            bulan = "Juli";
            break;
        case '08':
            bulan = "Agustus";
            break;
        case '09':
            bulan = "September";
            break;
        case '10':
            bulan = "Oktober";
            break;
        case '11':
            bulan = "November";
            break;
        case '12':
            bulan = "Desember";
            break;
    }
    gabung = tanggalnew +' '+bulan+' '+tahun+' Pukul '+jamfix+ ' WIB';
    return gabung

}
const tglindo = (tgl) => {
    let pecah = tgl.split(' - ');
    let tgl1 = pecah[0];
    let tgl2 = pecah[1];
    tgl1 =tgl1.split('/');
    bln1 = tgl1[1];

    tgl2 =tgl2.split('/');
    bln2 =tgl2[1];
      
    
    switch (bln1) {

        case '01':
            bln1 = "Januari";
            break;
        case '02':
            bln1 = "Februari";
            break;
        case '03':
            bln1 = "Maret";
            break;
        case '04':
            bln1 = "April";
            break;
        case '05':
            bln1 = "Mei";
            break;
        case '06':
            bln1 = "Juni";
            break;
        case '07':
            bln1 = "Juli";
            break;
        case '08':
            bln1 = "Agustus";
            break;
        case '09':
            bln1 = "September";
            break;
        case '10':
            bln1 = "Oktober";
            break;
        case '11':
            bln1 = "November";
            break;
        case '12':
            bln1 = "Desember";
            break;
    }
    switch (bln2) {

        case '01':
            bln2 = "Januari";
            break;
        case '02':
            bln2 = "Februari";
            break;
        case '03':
            bln2 = "Maret";
            break;
        case '04':
            bln2 = "April";
            break;
        case '05':
            bln2 = "Mei";
            break;
        case '06':
            bln2 = "Juni";
            break;
        case '07':
            bln2 = "Juli";
            break;
        case '08':
            bln2 = "Agustus";
            break;
        case '09':
            bln2 = "September";
            break;
        case '10':
            bln2 = "Oktober";
            break;
        case '11':
            bln2 = "November";
            break;
        case '12':
            bln2 = "Desember";
            break;
    }
    let gabungan = tgl1[0] +'-'+bln1+'-'+tgl1[2]+' s.d ' +tgl2[0]+'-'+bln2+'-'+tgl2[2]
    return gabungan
    
    
};

const formatRupiahtyping = (money) => {
    angka = money.replace(/[^,\d]/g, "");
  if (isNaN(angka)){
    angka = 0;
  }
    return new Intl.NumberFormat('id-ID',
      { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }
    ).format(angka);
 }
const formatRupiah1 = (money) => {
  if (isNaN(money)){
    money = 0;
  }
    return new Intl.NumberFormat('id-ID',
      { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }
    ).format(money);
 }

const base_url = 'http://localhost:8080/'
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

    // $('.store').click(function(){
    //     console.log('storeklik');
            
    //     var value = {
    //         id_admin: $('#id_admin').val(),
    //         id_client: $('#id_client').val(),
    //         nama_user: $('#nama_user').val(),
    //         nama_client: $('#nama_client').val(),
    //         pesan: $('#pesan').val(),	
    //     }
    //     $.ajax({
    //         // url: '<?= site_url(/DashboardAdmin/store);?>',
    //         // url: 'http://localhost:8080/DashboardAdmin/message/'+id_client,
    //         url: 'http://localhost:8080/DashboardAdmin/store',
    //         type: 'POST',
    //         data: value,
    //         // dataType: 'json',
    //     })
        
    // })
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
        $('.detailhitung').data('detailid',idajuan);
        $('.detailkirimfilerab').data('detailid',idajuan);
        // console.log(idajuan);
        

        $.ajax({
            url: 'http://localhost:8080/DashboardAdmin/detailajuanproyek',
            data: {id : idajuan},
            method: 'post',
            dataType: 'json',
            success: function(data){
                console.log(data);
                
                if (data.data[0]['revisi_id'] =='0' && data.data[0]['status_id'] =='2'){
                    $('.detailcreate').hide();
                    $('.detailterima').hide();
                    $('.detailhapus').hide();
                    $('.detailtolak').hide();
                    $('.detailhitung').show();
                    $('.detailnamastatus').removeClass('badge-secondary')
                    $('.detailnamastatus').removeClass('badge-danger')
                    $('.detailnamastatus').removeClass('badge-success')
                    $('.detailnamastatus').addClass('badge-primary')
                } else if(data.data[0]['revisi_id'] =='1' && data.data[0]['status_id'] =='2'){
                    $('.detailcreate').hide();
                    $('.detailterima').hide();
                    $('.detailhapus').hide();
                    $('.detailtolak').hide();
                    $('.detailhitung').hide();
                    $('.detailkirimfilerab').show();
                    $('.detailnamastatus').removeClass('badge-secondary')
                    $('.detailnamastatus').removeClass('badge-danger')
                    $('.detailnamastatus').removeClass('badge-success')
                    $('.detailnamastatus').addClass('badge-primary')
                }else {
                    if (data.data[0]['status_id'] =='1'){
                        $('.detailterima').show();
                        $('.detailtolak').show();
                        $('.detailcreate').hide();
                        $('.detailhapus').hide();
                        $('.detailhitung').hide();
                        $('.detailkirimfilerab').hide();
                        $('.detailnamastatus').removeClass('badge-primary')
                        $('.detailnamastatus').removeClass('badge-danger')
                        $('.detailnamastatus').removeClass('badge-success')
                        $('.detailnamastatus').addClass('badge-secondary')
                    } else if (data.data[0]['status_id'] =='2') {
                        $('.detailcreate').hide();
                        $('.detailterima').hide();
                        $('.detailhapus').hide();
                        $('.detailtolak').hide();
                        $('.detailhitung').hide();
                        $('.detailkirimfilerab').hide();
                        $('.detailnamastatus').removeClass('badge-secondary')
                        $('.detailnamastatus').removeClass('badge-danger')
                        $('.detailnamastatus').removeClass('badge-success')
                        $('.detailnamastatus').addClass('badge-primary')
                    }else if (data.data[0]['status_id'] =='3') {
                        $('.detailcreate').hide();
                        $('.detailterima').hide();
                        $('.detailhapus').show();
                        $('.detailtolak').hide();
                        $('.detailhitung').hide();
                        $('.detailkirimfilerab').hide();
                        $('.detailnamastatus').removeClass('badge-secondary')
                        $('.detailnamastatus').removeClass('badge-primary')
                        $('.detailnamastatus').removeClass('badge-success')
                        $('.detailnamastatus').addClass('badge-danger')
                       
                    } 
                    else if (data.data[0]['status_id'] =='4'){
                        $('.detailcreate').hide();
                        $('.detailterima').hide();
                        $('.detailhapus').hide();
                        $('.detailtolak').hide();
                        $('.detailhitung').hide();
                        $('.detailkirimfilerab').hide();
                        $('.detailnamastatus').removeClass('badge-secondary')
                        $('.detailnamastatus').removeClass('badge-danger')
                        $('.detailnamastatus').removeClass('badge-primary')
                        $('.detailnamastatus').addClass('badge-success')
                        
                    }
                    else if (data.data[0]['status_id'] =='5'){
                        $('.detailcreate').hide();
                        $('.detailterima').hide();
                        $('.detailhapus').hide();
                        $('.detailtolak').hide();
                        $('.detailhitung').hide();
                        $('.detailkirimfilerab').hide();
                        $('.detailnamastatus').removeClass('badge-secondary')
                        $('.detailnamastatus').removeClass('badge-danger')
                        $('.detailnamastatus').removeClass('badge-primary')
                        $('.detailnamastatus').addClass('badge-warning')
                        
                    }
                    else if (data.data[0]['status_id'] =='6'){
                        $('.detailcreate').show();
                        $('.detailterima').hide();
                        $('.detailhapus').hide();
                        $('.detailtolak').hide();
                        $('.detailhitung').hide();
                        $('.detailkirimfilerab').hide();
                        $('.detailnamastatus').removeClass('badge-secondary')
                        $('.detailnamastatus').removeClass('badge-danger')
                        $('.detailnamastatus').removeClass('badge-primary')
                        $('.detailnamastatus').addClass('badge-primary')
                        
                    }
                    else if (data.data[0]['status_id'] =='7'){
                        $('.detailcreate').hide();
                        $('.detailterima').hide();
                        $('.detailhapus').show();
                        $('.detailtolak').hide();
                        $('.detailhitung').show();
                        $('.detailkirimfilerab').show();
                        $('.detailnamastatus').removeClass('badge-secondary')
                        $('.detailnamastatus').removeClass('badge-danger')
                        $('.detailnamastatus').removeClass('badge-primary')
                        $('.detailnamastatus').addClass('badge-danger')
                        
                    }
                    else if (data.data[0]['status_id'] =='8'){
                        $('.detailcreate').hide();
                        $('.detailterima').hide();
                        $('.detailhapus').hide();
                        $('.detailtolak').hide();
                        $('.detailhitung').show();
                        $('.detailkirimfilerab').show();
                        $('.detailnamastatus').removeClass('badge-secondary')
                        $('.detailnamastatus').removeClass('badge-danger')
                        $('.detailnamastatus').removeClass('badge-primary')
                        $('.detailnamastatus').addClass('badge-secondary')
                        
                    }
                    

                }
               
                $('.detailidajuan').html(data.data[0]['idajuan']);
                $('.detailiduser').html(data.data[0]['user_id']);
                $('.detailnamaproyek').html(data.data[0]['namaproyek']);
                $('.detailnamastatus').html(data.data[0]['keterangan']);
                $('.detailjenisproyek').html(data.data[0]['jenisproyek']);
                $('.detaillokasiproyek').html(data.data[0]['lokasiproyek']);
                $('.detailnama').html(data.data[0]['nama']);
                if (data.data[0]['namaperusahaan']) {$('.detailnamaperusahaan').html(data.data[0]['namaperusahaan'])} else {$('.detailnamaperusahaan').html('---')} 
                (data.data[0]['jabatan']) ?  $('.detailjabatan').html(data.data[0]['jabatan']) :  $('.detailjabatan').html('---');
                (data.data[0]['alamatperusahaan']) ?  $('.detailalamatperusahaan').html(data.data[0]['alamatperusahaan']) :  $('.detailalamatperusahaan').html('---');
                $('.detailemail').html(data.data[0]['email']);
                $('.detailalamat').html(data.data[0]['alamat']);
                $('.detailtelp').html(data.data[0]['notelp']);
                $('.detailanggaran').html(formatRupiah1(data.data[0]['anggaran']));
                $('.detailnotelp').html(data.data[0]['notelp']);
                $('.detailjadwalproyek').html(tglindo(data.data[0]['jadwalproyek']));
                $('.detailuploadfile').html('<a href="http://localhost:8080/admin/downloadfile/'+data.data[0]['file_upload']+'/fileclient'+'">'+data.data[0]['file_upload']+'</a>');
                         
            }


        })
          
    })
    //aksi di form modal detail ajuan
    $('.detailhitung').click(function(){
        let id = $(this).data('detailid');
        location.href=base_url+"admin/perhitunganbiayamaterial"
    })
    $('.detailkirimfilerab').click(function(){
        let id = $(this).data('detailid');
        location.href=base_url+"admin/kirimemail/"+id
    })
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
                location.href = base_url+'admin/terimaajuan/'+id
            }
        })
    })
    $('.detailcreate').click(function(){
       var id = $(this).data('detailid');
        location.href = base_url+'admin/dataproyek/'+id
    
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
                location.href = base_url+'admin/tolakajuan/'+id
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
                location.href = base_url+'admin/hapusajuan/'+id
            }
        })
    })
    $('.permintaanmeeting').click(function(){
        let idajuan = $(this).data('id');
        $.ajax({
            url : base_url+"DashboardAdmin/getmeeting/"+idajuan,
            dataType : "json",
            success: function(response) {
               $('.namameeting').html(response.namameeting)
               $('.lokasimeeting').html(response.lokasimeeting)
               $('.tanggalmeeting').html(tglmeeting(response.tanggalmeeting))
                
            }
        });
        
    })
    // let data =  $('.detailcreate').data('detailid')
    // let data2=  $('.detailterima').data('detailid')
    //  console.log(data);
    //  console.log(data2);
    
    //end form detail ajuan proyek di dashboard admin
 

    //Form Data Proyek Di Dashboard Admin
    $('.btnidajuanproyek').click(function(){
        let idajuan = $(this).data('id');
        $.ajax({
            url: base_url+'DashboardAdmin/detailajuanproyek',
            data: {id : idajuan},
            method: 'post',
            dataType: 'json',
            success: function(data){          
               $('#user_id').val(data.data[0]['user_id'])
               $('#idajuan').val(data.data[0]['idajuan'])
               $('#namaproyek').val(data.data[0]['namaproyek'])
               $('#jenisproyek').val(data.data[0]['jenisproyek'])
               $('#nama').val(data.data[0]['nama'])
               $('#biaya').val(formatRupiah1(data.biaya))
            }


        })
    })
    //data otomatis terisi jika ada data yang dikirim dari menu ajuan proyek
    let getidajuan = $('.getbuatproyek').data('idajuan');
    let getnamaklien = $('.getbuatproyek').data('namaklien');
    let getnamaproyek = $('.getbuatproyek').data('namaproyek');
    let getjenisproyek = $('.getbuatproyek').data('jenisproyek');
    let getidklien = $('.getbuatproyek').data('idklien');
    let getbiaya = $('.getbuatproyek').data('biaya');
    if (getidajuan !==''){
       $('#idajuan').val(getidajuan);
       $('#nama').val(getnamaklien);
       $('#namaproyek').val(getnamaproyek);
       $('#jenisproyek').val(getjenisproyek);
       $('#user_id').val(getidklien);
       $('#biaya').val(formatRupiah1(parseInt(getbiaya)));
    }
    function kurang(x, y){
        var xint = parseInt(x);
        var yint = parseInt(y);
        
        hasil = xint- yint;
        return hasil
    }
    $('#sudahbayar').keyup(function(){

       $(this).val(formatRupiahtyping($(this).val()))
       let str = $('#biaya').val()
       str = str.replace(/[^0-9/]/g,'');
       let biaya= parseInt(str);
       let str2 =$(this).val();
       str2 = str2.replace(/[^0-9/]/g,'')
       let sudahbayar = parseInt(str2)
       var belumbayar = kurang(biaya,sudahbayar)
       if ( belumbayar < 0 ){
        $('#belumbayar').val(formatRupiah1(0));
        $('#sudahbayar').val(formatRupiah1(0));
       } else {

           $('#belumbayar').val(formatRupiah1(belumbayar));
       }
     
    })
   

   // End Form Data Proyek Di Dashboard Admin
   
    
    

})