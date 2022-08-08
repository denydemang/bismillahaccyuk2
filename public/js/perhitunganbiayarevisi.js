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
})