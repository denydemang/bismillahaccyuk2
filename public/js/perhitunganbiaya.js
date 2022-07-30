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

    //BAHAN BAKU
    //jika memilih id ajuan field user id dan nama proyek otomatis terisi
    $('.idajuanbb').change(function(){
        let id = $(this).val();
        $.ajax({
            url : "http://localhost:8080/DashboardAdmin/getuseridajuan",
            type: "post",
            data : {id:id},
            dataType : "json",
            success: function(response) {
                $('.user_idbb').val(response[0]['user_id']);
                $('.namaproyekbb').val(response[0]['namaproyek']);
                
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });

        
    })
    $('.perhitunganbb').submit(function(e){
            e.preventDefault();
            $.ajax({
                url : $(this).attr('action'),
                type: "post",
                data : $(this).serialize(),
                dataType : "json",
                beforeSend: function(){
                    $('.btnsimpanbb').attr('disable','disabled');
                    $('.btnsimpanbb').html('Menyimpan..');

                },
                complete: function(){
                    $('.btnsimpanbb').removeAttr('disable');
                    $('.btnsimpanbb').html('Simpan');

                },
                success: function(response) {
                   
                   if (response.error){
                        if (response.error.erroridajuan){
                            $('.idajuanbb').addClass('is-invalid');
                            $('.idajuanbbinvalid').html(response.error.erroridajuan);
                        } else {
                            $('.idajuanbb').removeClass('is-invalid');
                            $('.idajuanbbinvalid').html('');
                        }
                        if(response.error.errorharga){
                            $('.harga').addClass('is-invalid');
                            $('.hargainvalid').html(response.error.errorharga);
                        } else {
                            $('.harga').removeClass('is-invalid');
                            $('.hargainvalid').html('');
                        }
                        if(response.error.errorjumlahbeli){
                            $('.jumlahbeli').addClass('is-invalid');
                            $('.jumlahbeliinvalid').html(response.error.errorjumlahbeli);
                        } else {
                            $('.jumlahbeli').removeClass('is-invalid');
                            $('.jumlahbeliinvalid').html('');
                        }
                        if(response.error.errornamabahan){
                            $('.namabahan').addClass('is-invalid');
                            $('.namabahaninvalid').html(response.error.errornamabahan);
                        } else {
                            $('.namabahan').removeClass('is-invalid');
                            $('.namabahaninvalid').html('');
                        }
                        
                       
                   } else {
                    if (response.affected >= 1){
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Berhasil Disimpan',
                            showConfirmButton: false,
                            timer: 3000
                            })
                            tablepbb();
                            $('.namabahan').removeClass('is-invalid');
                            $('.idajuanbb').removeClass('is-invalid');
                            $('.jumlahbeli').removeClass('is-invalid');
                            $('.harga').removeClass('is-invalid');
                            $(".perhitunganbb").trigger('reset'); //jquery
                    } else {
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'Data gagal Disimpan',
                            showConfirmButton: false,
                            timer: 3000
                            })
                            
                            tablepbb();
                            $('.namabahan').removeClass('is-invalid');
                            $('.idajuanbb').removeClass('is-invalid');
                            $('.jumlahbeli').removeClass('is-invalid');
                            $('.harga').removeClass('is-invalid');
                            $(".perhitunganbb").trigger('reset'); 
                    }
                        
                   }
                    
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
            
    })
    $('.harga').keyup(function(){
        let harga = parseInt($(this).val());
        let jumlahbeli = parseInt($('.jumlahbeli').val())
        let hasil = harga * jumlahbeli;
        $('.totalharga').val(hasil);
    })
    $('.jumlahbeli').keyup(function(){
        let harga = parseInt($('.harga').val());
        let jumlahbeli = parseInt($(this).val())
        let hasil = harga * jumlahbeli;
        $('.totalharga').val(hasil);
    })
    $("#editbb").on("click", function() {
     
        console.log('asu');
    });
   
    
    //END BAHANBAKU



})
