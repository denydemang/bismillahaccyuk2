//   Cek Type Variabel
var getType = (function() {

    var objToString = ({}).toString ,
        typeMap     = {},
        types = [ 
          "Boolean", 
          "Number", 
          "String",                
          "Function", 
          "Array", 
          "Date",
          "RegExp", 
          "Object", 
          "Error"
        ];

    for ( var i = 0; i < types.length ; i++ ){
        typeMap[ "[object " + types[i] + "]" ] = types[i].toLowerCase();
    };    

    return function( obj ){
        if ( obj == null ) {
            return String( obj );
        }
        // Support: Safari <= 5.1 (functionish RegExp)
        return typeof obj === "object" || typeof obj === "function" ?
            typeMap[ objToString.call(obj) ] || "object" :
            typeof obj;
    }
}());
  
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
    /* Fungsi formatRupiah */
    // function formatRupiah(angka, prefix) {
    //     var number_string = angka.replace(/[^,\d]/g, "").toString(),
    //         split = number_string.split(","),
    //         sisa = split[0].length % 3,
    //         rupiah = split[0].substr(0, sisa),
    //         ribuan = split[0].substr(sisa).match(/\d{3}/gi);
      
    //     // tambahkan titik jika yang di input sudah menjadi angka ribuan
    //     if (ribuan) {
    //       separator = sisa ? "." : "";
    //       rupiah += separator + ribuan.join(".");
    //     }
      
    //     rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    //     return prefix == undefined ? rupiah : rupiah ? "Rp " + rupiah : "";
    //   }
      

function tablepbb() {
    //Perhitungan BB
    $.ajax({
        url: 'http://localhost:8080/TampilTable/tableperhitunganbb',
        dataType: "json",
        success: function(response) {
            $('.tampilbahanbaku').html(response.data);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}

function tablepbop() {
    //Perhitungan BOP
    $.ajax({
        url: 'http://localhost:8080/TampilTable/tableperhitunganbop',
        dataType: "json",
        success: function(response) {
            $('.tampilbop').html(response.data);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}

function tableptenaker() {
    //Perhitungan Tenaker
    $.ajax({
        url: 'http://localhost:8080/TampilTable/tableperhitungantenaker',
        dataType: "json",
        success: function(response) {
            $('.tampiltenaker').html(response.data);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}

$(document).ready(function() {
 

    $('#totalsemua').change(function(){
        let idajuan = $(this).val();
        $.ajax({
            url : "http://localhost:8080/DashboardAdmin/tampiltotal/"+idajuan,
            dataType : "json",
            success: function(response) {
                $('.sumbiaya').val('Rp. '+response+' ,-')
                
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    })
    
    
    tablepbb();
    tablepbop();
    tableptenaker()

    //End Perhitungan Tenaga Kerja 

$('.btncancel1').click(function(e){
    e.preventDefault();
        $('#btnsimpan').addClass('btnsimpanbb');
        $('#btnsimpan').html('Simpan');
        $('#btnsimpan').removeClass('btnubahbb');
        $('.namabahan').removeClass('is-invalid');
        $('.idajuanbb').removeClass('is-invalid');
        $('.jumlahbeli').removeClass('is-invalid');
        $('.harga').removeClass('is-invalid');
        $(".perhitunganbb").trigger('reset'); //jquery
     })
 $('.btncancel2').click(function(e){
    e.preventDefault();
    $('#btnsimpantk').addClass('btnsimpantk');
    $('#btnsimpantk').html('Simpan');
    $('#btnsimpantk').removeClass('btnubahtk');
    $('.jenispekerjaan').removeClass('is-invalid');
    $('.idajuantk').removeClass('is-invalid');
    $('.gaji').removeClass('is-invalid');
    $('.totalpekerja').removeClass('is-invalid');
    $(".perhitungantenaker").trigger('reset'); //jquery
 })
 $('.btncancel3').click(function(e){
    e.preventDefault();
    $('#btnsimpanbop').addClass('btnsimpanbop');
    $('#btnsimpanbop').html('Simpan');
    $('#btnsimpanbop').removeClass('btnubahbop');
    $('.namatransaksi').removeClass('is-invalid');
    $('.idajuanbop').removeClass('is-invalid');
    $('.totalbiaya').removeClass('is-invalid');
    $(".perhitunganbop").trigger('reset'); //jquer
 })

})
