const base_url = "http://localhost:8080/"
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
 function tablepbb() {
    //Perhitungan BB
    $.ajax({
        url: base_url+'TampilTable/tableperhitunganbbrevisi',
        dataType: "json",
        success: function(response) {
            $('.tampilbahanbakurevisi').html(response.data);
            
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}



function tablepbop() {
    //Perhitungan BOP
    $.ajax({
        url: base_url+'TampilTable/tableperhitunganboprevisi',
        dataType: "json",
        success: function(response) {
            $('.tampilboprevisi').html(response.data);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}

function tableptenaker() {
    //Perhitungan Tenaker
    $.ajax({
        url: base_url+'TampilTable/tableperhitungantenakerrevisi',
        dataType: "json",
        success: function(response) {
            $('.tampiltenakerrevisi').html(response.data);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}
$(document).ready(function(){
    tablepbb()
    tablepbop()
    tableptenaker()
    $('.id_pbb').change(function(){
        let id = $(this).val();
        $.ajax({
            url : "http://localhost:8080/DashboardAdmin/getdatapbb",
            type: "post",
            data : {id:id},
            dataType : "json",
            success: function(response) {
                console.log(response);
                $('.idajuanbb').val(response[0]['idajuan'])
                $('.user_idbb').val(response[0]['user_id'])
                $('.namaproyekbb').val(response[0]['namaproyek'])
                $('.namabahan').val(response[0]['namabahan'])
                $('.ukuran').val(response[0]['ukuran'])
                $('.tebal').val(response[0]['ketebalan'])
                $('.jenis').val(response[0]['jenis'])
                $('.berat').val(response[0]['berat'])
                $('.kualitas').val(response[0]['kualitas'])
                $('.panjang').val(response[0]['panjang'])
                $('.harga').val(formatRupiah1(response[0]['harga']))
                $('.jumlahbeli').val(response[0]['jumlah_beli'])
                $('.totalharga').val(formatRupiah1(response[0]['total_harga']))
                
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
        
    })

    $('.id_pbtenaker').change(function(){
        let id = $(this).val();
        $.ajax({
            url : "http://localhost:8080/DashboardAdmin/getdatapbtk",
            type: "post",
            data : {id:id},
            dataType : "json",
            success: function(response) {
                   
                $('.idajuantk').val(response[0]['idajuan'])
                $('.user_idtk').val(response[0]['user_id'])
                $('.namaproyektk').val(response[0]['namaproyek'])
                $('.jenispekerjaan').val(response[0]['jenispekerjaan'])
                $('.gaji').val(formatRupiah1(parseInt(response[0]['gaji'])))
                $('.hari').val(response[0]['hari'])
                $('.totalpekerja').val(response[0]['total_pekerja'])
                $('.totalgaji').val(formatRupiah1(parseInt(response[0]['total_gaji'])));
                
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
        
    })

    $('.id_pbop').change(function(){
        let id = $(this).val();
        $.ajax({
            url : "http://localhost:8080/DashboardAdmin/getdatapbop",
            type: "post",
            data : {id:id},
            dataType : "json",
            success: function(response) {
                   
                $('.idajuanbop').val(response[0]['idajuan'])
                $('.user_idbop').val(response[0]['user_id'])
                $('.namaproyekbop').val(response[0]['namaproyek'])
                $('.namatransaksi').val(response[0]['namatrans'])
                $('.totalbiaya').val(formatRupiah1(parseInt(response[0]['tot_biaya'])))
               
                
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
        
    })

})