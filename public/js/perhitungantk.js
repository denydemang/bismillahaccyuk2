const base_url ='http://localhost:8080/'
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
function reset(){
    $('.judulmodal').html('Tambah Tenaga Kerja'),
    $('.simpan').html('Simpan') ;
    $('.formtenaker').attr('action',base_url+'DashboardAdmin/simpantenaker') ;
    $('.pilihajuan').show() ;
    $('.formtenaker').trigger('reset') ;
    $('.idajuan').removeClass('is-invalid')
    $('.jobdesk').removeClass('is-invalid')
    $('.statuspekerjaan').removeClass('is-invalid')
    $('.gaji').removeClass('is-invalid')
    $('.total_pekerja').removeClass('is-invalid')
    $('.total_gaji').removeClass('is-invalid')
}
$(document).ready(function(){
    let berhasil = $('.pesantenaker').data('berhasil')
    let gagal = $('.pesantenaker').data('gagal')
    if (berhasil){
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: berhasil,
            showConfirmButton: false,
            timer: 4000
            })
    } else if(gagal){
        Swal.fire({
            position: 'center',
            icon: 'error',
            title: gagal,
            showConfirmButton: false,
            timer: 4000
            })
    }
    $('.hapusmaterial').click(function(){
        let idmaterial = $(this).data('id');
        Swal.fire({
                position: 'center',
                icon: 'question',
                title: 'Yakin Hapus ID: '+idmaterial,
                showConfirmButton: true,
                showCancelButton: true,
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#3085d6',
                }).then((result) => {
                if (result.isConfirmed) {
                        window.location.href = base_url+'DashboardAdmin/hapustenaker/' + idmaterial;
                }
                 })
// 
})
$('.daftarajuan').DataTable({
        "lengthChange": false,
        "fixedHeader": true,
        "info": false,
        "paging": false,
        "scrollY": '150px',
        "scrollCollapse": true,
})
$('.btntambah').click(function(){
        reset();    
})
$('.btnidajuan').click(function(){
let idajuan = $(this).data('id');
        $('.idajuan').val(idajuan);
})
$('.close').click(function(){
        reset();         
})
$('.btncancel').click(function(){
        reset();         
})
$('.btnedittenaker').click(function(){
    let id_pbtenaker= $(this).data('id')
    
    $.ajax({
    url : base_url+"DashboardAdmin/getdatatenaker/"+id_pbtenaker,
    dataType : "json",
    success: function(response) {
        console.log(response);
        
    $('.judulmodal').html('Edit Tenaga Kerja'),
    $('.pilihajuan').hide(),
    $('.simpan').html('Edit') ;
    $('.formtenaker').attr('action',base_url+'DashboardAdmin/updatetenaker');
    $('.idajuan').val(response[0]['idajuan'])
    $('.id_pbtenaker').val(response[0]['id_pbtenaker'])
    $('.jobdesk').val(response[0]['jobdesk'])
    $('.statuspekerjaan').val(response[0]['statuspekerjaan'])
    $('.gaji').val(formatRupiah1(parseInt(response[0]['gaji'])))
    $('.total_pekerja').val(response[0]['total_pekerja'])
    $('.total_gaji').val(formatRupiah1(parseInt(response[0]['total_gaji'])))
    // $('.idmaterialpenyusun').val(response[0]['idmaterialpenyusun'])
    // $('.idmaterial').val(response[0]['idmaterial'])
    // $('.idajuan').val(response[0]['idajuan'])
    // $('.namamp').val(response[0]['namamp'])
    // $('.spesifikasimp').val(response[0]['spesifikasimp']) 
    // $('.satuanmp').val(response[0]['satuanmp']) 
    // $('.jumlahmp').val(response[0]['jumlahmp']) 
    // $('.hargamp').val(formatRupiah1(parseInt(response[0]['hargamp']))) 
    // $('.totalmp').val(formatRupiah1(response[0]['totalmp'])) 
         
    }
    });
    
})
$('.tabletenaker').DataTable({
    "fixedColumns": {
            leftColumns: 1,
            rightColumns: 1
            },
    });
$('.gaji').keyup(function(){
    $(this).val(formatRupiahtyping($(this).val()))
    let val = $(this).val()
    let gaji = parseInt(val.replace(/[^0-9/]/g,''));
    let totalpekerja = $('.total_pekerja').val();
    let total = gaji * totalpekerja
    
    $('.total_gaji').val(formatRupiah1(total));
})
$('.total_pekerja').keyup(function(){
   
    let total_pekerja = $(this).val()
    let val = $('.gaji').val()
    let gaji = parseInt(val.replace(/[^0-9/]/g,''));
    let total = gaji * total_pekerja
    
    $('.total_gaji').val(formatRupiah1(total));
})
$('.hapustenaker').click(function(){
    let idtk = $(this).data('id');
    Swal.fire({
            position: 'center',
            icon: 'question',
            title: 'Yakin Hapus ID: '+idtk,
            showConfirmButton: true,
            showCancelButton: true,
            cancelButtonColor: '#d33',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#3085d6',
            }).then((result) => {
            if (result.isConfirmed) {
                    window.location.href = base_url+'DashboardAdmin/hapustenaker/' + idtk;
            }
             })
// 
})





})