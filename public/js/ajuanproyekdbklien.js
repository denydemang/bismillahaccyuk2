// const formatRupiahtyping = (money) => {
//     angka = money.replace(/[^,\d]/g, "");
//   if (isNaN(angka)){
//     angka = 0;
//   }
//     return new Intl.NumberFormat('id-ID',
//       { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }
//     ).format(angka);
//  }
// const formatRupiah1 = (money) => {
//     if (isNaN(money)){
//       money = 0;
//     }
//       return new Intl.NumberFormat('id-ID',
//         { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }
//       ).format(money);
//    }
$(document).ready(function(){
   
    // notif ajuan 
    let pesanrab =$('.pesanrab').data('pesanrab');
    let maxrab =$('.pesanrab').data('maxrab');
    
    if (pesanrab == 'disetujui') {
        Swal.fire({
            title: 'Rab Telah Disetujui',
            icon: 'success',
        })
    } else if ( pesanrab == 'ditolak'){
        Swal.fire({
            title: 'Rab Telah Ditolak',
            icon: 'success',
        })
        

    }else if ( pesanrab == 'permintaanmeeting'){
        Swal.fire({
            title: 'Permintaan Meeting Berhasil Diajukan',
            icon: 'success',
        })
    } else if ( pesanrab == 'editanggaran'){
        Swal.fire({
            title: 'Anggaran Berhasil Diperbarui',
            icon: 'success',
        })
    }
     else if ( pesanrab == 'naikkananggaran'){
        Swal.fire({
            title: 'Anggaran Anda Lebih Rendah dari RAB !',
            text: 'Naikkan Anggaran Anda Minimal '+formatRupiah1(maxrab),
            icon: 'error',
        })
    }
    
    //Aksi Ajuan
$('.detailtolakrab').click(function(){
    let idajuan = $(this).data('ajuan');
    $('.idajuan').val(idajuan);
    
})
$('.editanggaran').click(function(){
    let idajuan = $(this).data('ajuan');
    $('.idajuan').val(idajuan);
    
})
$('.anggaran').keyup(function(){
    $(this).val(formatRupiahtyping($(this).val()));

})
$('#closeanggaran').click(function(){
    $('.formeditanggaran').trigger('reset');
})
    //Aksi Ajuan
$('.tanggalmeeting').daterangepicker({
    autoUpdateInput: false,
    timePicker: true,
    singleDatePicker: true,
    showDropdowns: true,
    startDate: moment().startOf('HH'),
    locale: {
      format: 'YYYY-MM-DD HH:mm'
    },
    
});
$('.tanggalmeeting').on('apply.daterangepicker', function(ev, picker) {
    $(this).val(picker.startDate.format('YYYY-MM-DD')+' '+picker.startDate.format('HH:mm'));
});

$('.tanggalmeeting').on('cancel.daterangepicker', function(ev, picker) {
    $(this).val('');
});
$('.detailmeeting').click(function(){
    let idajuan = $(this).data('ajuan');
    $('.idajuan').val(idajuan);
    
})
$('.meetingdetail').click(function(){
    let idajuan = $(this).data('id');
    $.ajax({
        url : base_url+"DashboardKlien/getmeeting/"+idajuan,
        dataType : "json",
        success: function(response) {
           $('.namameeting').html(response.namameeting)
           $('.lokasimeeting').html(response.lokasimeeting)
           $('.tanggalmeeting').html(tglmeeting(response.tanggalmeeting))
            
        }
    })
    });
$('.tolakrab').submit(function(e){
    e.preventDefault();
    Swal.fire({
        title: 'Tolak RAB Terlampir?',
        icon: 'question',
        showCancelButton: true,
        cancelButtonText: 'Batal',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url : $(this).attr('action'),
                data : $(this).serialize(),
                dataType : "json",
                beforeSend: function(){
                 $('.tbltolak').html('Memproses..');
                 $('.tbltolak').attr('disable','disabled');
         
                },
                complete : function(){
                 $('.tbltolak').html('Tolak');
                 $('.tbltolak').removeAttr('disable');
                },
                success: function(response) {
                    if(response){
                     if(response.error){
                         $('#alasantolak').addClass('is-invalid');
                         $('.alasantolakinvalid').html(response.error);
                     } 
                     if (response.redirect){
                       let idajuan =response.redirect.idajuan
                       window.location.href=base_url+"klien/tolakRAB/"+idajuan
                     }
                    }
                    
                }
            });
        }
    })
  
    
})


    $('.terimarab').click(function(){
       let idajuan = $(this).data('ajuan')
        Swal.fire({
            title: 'Setujui RAB Terlampir?',
            icon: 'question',
            showCancelButton: true,
            cancelButtonText: 'Batal',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya'
        }).then((result) => {
            if (result.isConfirmed) {
                location.href = base_url+'klien/terimaRAB/'+idajuan
            }
        })
        
       }) 
})