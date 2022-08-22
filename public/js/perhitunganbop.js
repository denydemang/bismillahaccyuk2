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
    $('.judulmodal').html('Tambah Biaya Operasional'),
    $('.simpan').html('Simpan') ;
    $('.formbop').attr('action',base_url+'DashboardAdmin/simpanbop') ;
    $('.pilihajuan').show() ;
    $('.formbop').trigger('reset') ;
    $('.idajuan').removeClass('is-invalid')
    $('.namatrans').attr('readonly',false)
    $('.namatrans').removeClass('is-invalid')
    $('.quantity').removeClass('is-invalid')
    $('.harga').removeClass('is-invalid')
    $('.tot_biaya').removeClass('is-invalid')
    $('.satuan').data('satuan','')
    $('.quantity').data('quantity','')
    $('.harga').data('harga','')
}
$(document).ready(function(){
    let berhasil = $('.pesanbop').data('berhasil')
    let gagal = $('.pesanbop').data('gagal')
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
    $('.hapusbop').click(function(){
        let idbop = $(this).data('id');
        Swal.fire({
                position: 'center',
                icon: 'question',
                title: 'Yakin Hapus ID: '+idbop,
                showConfirmButton: true,
                showCancelButton: true,
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#3085d6',
                }).then((result) => {
                if (result.isConfirmed) {
                        window.location.href = base_url+'DashboardAdmin/hapusbop/' + idbop;
                }
                 })
// 
})
$('.hapusbopr').click(function(){
        let idbop = $(this).data('id');
        Swal.fire({
                position: 'center',
                icon: 'question',
                title: 'Yakin Hapus ID: '+idbop,
                showConfirmButton: true,
                showCancelButton: true,
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#3085d6',
                }).then((result) => {
                if (result.isConfirmed) {
                        window.location.href = base_url+'DashboardAdmin/hapusbopr/' + idbop;
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
      window.location.href="http://localhost:8080/admin/perhitunganbiayalain/"+idajuan
})
$('.close').click(function(){
        reset();         
})
$('.btncancel').click(function(){
        reset();         
})

$('.tablebop').DataTable()

$('.quantity').keyup(function(){
    let qty = $(this).val()
    let val = $('.harga').val()
    let harga = parseInt(val.replace(/[^0-9/]/g,''));
    let total = qty * harga
    
    $('.tot_biaya').val(formatRupiah1(total));
})
$('.harga').keyup(function(){
    $(this).val(formatRupiahtyping($(this).val()))
    let val = $(this).val()
    let harga = parseInt(val.replace(/[^0-9/]/g,''))
    let qty = $('.quantity').val()
    let total = harga * qty
    
    $('.tot_biaya').val(formatRupiah1(total));
})

$(document).on('click','.btneditbop',function(){
    let idpbop =$(this).data('id');
    // console.log(idpbop);
    
    $.ajax({
        url : base_url+"DashboardAdmin/getbop/"+idpbop,
        dataType : "json",
        success: function(response) {
            console.log(response);
            
        $('.judulmodal').html('Revisi Biaya Operasional'),
        $('.pilihajuan').hide(),
        $('.simpan').html('Revisi') ;
        $('.bungkusidpbopr').hide();
        $('.formbop').attr('action',base_url+'DashboardAdmin/revisibop');
        $('.idajuan').val(response[0]['idajuan'])
        $('.id_pbop').val(response[0]['id_pbop'])
        $('.namatrans').val(response[0]['namatrans'])
        $('.namatrans').attr('readonly',true)
        $('.satuan').val(response[0]['satuan'])
        $('.quantity').val(parseInt(response[0]['quantity']))
        $('.harga').val(formatRupiah1(parseInt(response[0]['harga'])))
        $('.tot_biaya').val(formatRupiah1(parseInt(response[0]['tot_biaya'])))
        $('.namatrans').data('namatrans',response[0]['namatrans'])
        $('.satuan').data('satuan',response[0]['satuan'])
        $('.quantity').data('quantity',response[0]['quantity'])
        $('.harga').data('harga',formatRupiah1(parseInt(response[0]['harga'])))
             
        }
        });
})
$('.formbop').submit(function(e){
        e.preventDefault();
        return false
})
$(document).on('click','.btneditbopr',function(){
        let idpbopr =$(this).data('id');
        $.ajax({
            url : base_url+"DashboardAdmin/getbopr/"+idpbopr,
            dataType : "json",
            success: function(response) {
                console.log(response);
                
            $('.judulmodal').html('Revisi Biaya Operasional')
            $('.idajuan').val(response['idajuan'])
            $('.bungkusidpbor').show()
            $('.simpan').html('Revisi') ;
            $('.formbop').attr('action',base_url+'DashboardAdmin/editrevisibop');
            $('.id_pbop').val(response['id_pbop'])
            $('.namatrans').val(response['namatrans'])
            $('.satuan').val(response['satuan'])
            $('.quantity').val(parseInt(response['quantity']))
            $('.harga').val(formatRupiah1(parseInt(response['harga'])))
            $('.tot_biaya').val(formatRupiah1(parseInt(response['tot_biaya'])))

            $('.namatrans').data('namatrans',response['namatrans'])
            $('.satuan').data('satuan',response['satuan'])
            $('.quantity').data('quantity',response['quantity'])
            $('.harga').data('harga',formatRupiah1(parseInt(response['harga'])))
                 
            }
            });
    })




})