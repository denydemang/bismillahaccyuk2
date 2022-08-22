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
const base_url ='http://localhost:8080/'
$(document).ready(function(){
    $("#modalbb").on('shown.bs.modal', function(){
        $('.harga').focus();
        console.log('demang');
        
    });
    $('#tgl_beli').datepicker();
    $('.btnbeli').click(function(){
        let id = $(this).data('id');
        $('.harga').focus()
        console.log('ok');
        console.log(id);
        $.ajax({
            url : base_url+"DashboardKelolaProyek/getdatamp/"+id,
            dataType : "json",
            success: function(response) {
                console.log(response);
                $('.idmaterialpenyusun').val(response.idmaterialpenyusun)
                $('.idmaterial').val(response.idmaterial)
                $('.namamp').val(response.namamp)
                $('.jumlahmp').val(response.jumlahmp)
                $('.hargamp').val(formatRupiah1(response.hargamp))
                
            }
        });
    })
   $('.harga').keyup(function(){
    $(this).val(formatRupiahtyping($(this).val()))
    let val = $(this).val()
    let harga= parseInt(val.replace(/[^0-9/]/g,''))
    let val2 = $('.jumlahmp').val();
    let qty = parseInt(val2.replace(/[^0-9/]/g,''));
    let total = qty * harga

    $('.totalharga').val(formatRupiah1(total));

   })
 
       
        
})