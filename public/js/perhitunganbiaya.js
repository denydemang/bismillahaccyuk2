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
