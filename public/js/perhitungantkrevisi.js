
function bersihtk(){
    $('.hari').removeClass('is-invalid');
    $('.gaji').removeClass('is-invalid');
    $('.id_pbtenaker').removeClass('is-invalid');
    $('.totalpekerja').removeClass('is-invalid');
    $('.perhitungantenakerrevisi').trigger('reset');
}
$(document).ready(function(){

    $('.gaji').keyup(function(){
    
        $(this).val(formatRupiahtyping($(this).val()))
        var  val = $(this).val();
        gaji = parseInt(val.replace(/[^0-9/]/g,''))
        let hari  = $('.hari').val();
        hari = parseInt(hari)
        let totalpekerja = parseInt($('.totalpekerja').val())
        let hasil = (hari * totalpekerja  * gaji ) ;
        
        $('.totalgaji').val(formatRupiah1(hasil));
    })
    
    $('.totalpekerja').keyup(function(){
        let hari  = $('.hari').val();
        hari = parseInt(hari)
        let val = $('.gaji').val();
        gaji = parseInt(val.replace(/[^0-9/]/g,''))
        let totalpekerja = parseInt($(this).val())
        let hasil = (gaji * totalpekerja * hari);
        $('.totalgaji').val(formatRupiah1(hasil));
    })
    $('.hari').keyup(function(){
        let hari = $(this).val();
        hari =  parseInt(hari)
        let val = $('.gaji').val();
        gaji = parseInt(val.replace(/[^0-9/]/g,''))
        let totalpekerja = parseInt($('.totalpekerja').val())
        let hasil = (gaji * totalpekerja * hari);
        $('.totalgaji').val(formatRupiah1(hasil));
    })
    $('.perhitungantenakerrevisi').submit(function(e){
        e.preventDefault();
        gaji = parseInt($('.gaji').data('gaji'))
        hari = parseInt($('.hari').data('hari'))
        totalpekerja = parseInt($('.totalpekerja').data('totalpekerja'))

        valgaji = $('.gaji').val();
        valgaji = parseInt(valgaji.replace(/[^0-9/]/g,''));
        valhari =  parseInt($('.hari').val())
        valtotalpekerja =  parseInt($('.totalpekerja').val())
        if (
            gaji ==  valgaji &&
            hari ==  valhari &&
            valtotalpekerja == totalpekerja

        ){
            Swal.fire({
                position: 'center',
                icon: 'warning',
                title: 'Silakan lakukan Perubahan Data!',
                showConfirmButton: false,
                timer: 3500
                })
            
        } else {
            $.ajax({
                type: "post",
                url : $(this).attr('action'),
                data : $(this).serialize(),
                dataType : "json",
                beforeSend: function(){
                    $('.btnsimpantk').attr('disable','disabled');
                    $('.btnsimpantk').html('Merevisi..');
    
                },
                complete: function(){
                    $('.btnsimpantk').removeAttr('disable');
                    $('.btnsimpantk').html('Revisi');
    
                },
                success: function(response) {     
                    if (response.error){
                        if (response.error.errorid_pbtenaker){
                            $('.id_pbtenaker').addClass('is-invalid');
                            $('.id_pbtenakerinvalid').html(response.error.errorid_pbtenaker);
                        } else {
                            $('.id_pbtenaker').removeClass('is-invalid');
                            $('.id_pbtenakerinvalid').html('');
                        }
                        if(response.error.errortotalpekerja){
                            $('.totalpekerja').addClass('is-invalid');
                            $('.totalpekerjainvalid').html(response.error.errortotalpekerja);
                        } else {
                            $('.totalpekerja').removeClass('is-invalid');
                            $('.totalpekerjainvalid').html('');
                        }
                        if(response.error.errorgaji){
                            $('.gaji').addClass('is-invalid');
                            $('.gajiinvalid').html(response.error.errorgaji);
                        } else {
                            $('.gaji').removeClass('is-invalid');
                            $('.gaji').html('');
                        }
                        if(response.error.errorhari){
                            $('.hari').addClass('is-invalid');
                            $('.hariinvalid').html(response.error.errorhari);
                        } else {
                            $('.hari').removeClass('is-invalid');
                            $('.hari').html('');
                        }
                        
                   } else {
                    if (response.affected >= 1){
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Jenis pekerjaan <em>'+response.notifjenispekerjaan+'</em> Dengan Id Biaya <em>'+response.notifid_pbtenaker+'</em> Berhasil Direvisi',
                            showConfirmButton: true,
                            })
                            bersihtk()
                            tableptenaker()
                          
                    } else {
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'Data gagal Disimpan',
                            showConfirmButton: false,
                            timer: 3000
                            })
                            bersihtk()
                            tableptenaker()
                        
                    }
                   }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
            
        }
        
    })

    $(document).on('click', '.hapustk', function(){
        let id_ptenakerr=  $(this).data('id')
        id_ptenakerr =  parseInt(id_ptenakerr.replace(/[^0-9/]/g,''))
        let idfix = $(this).data('id');
        let jenispekerjaan = $(this).data('jenispekerjaan');
        let id_pbtenaker=  $(this).data('idtenaker')
        Swal.fire({
            position: 'center',
            icon: 'warning',
            title: 'Yakin Hapus?',
            text: 'Jenis Pekerjaan '+jenispekerjaan+' dengan Id Biaya '+id_pbtenaker+' Akan Dihapus!',
            showConfirmButton: true,
            showCancelButton: true,
            cancelButtonColor: '#d33',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#3085d6',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url : base_url+"DashboardAdmin/hapusptkrevisi/"+idfix,
                        dataType : "json",
                        success: function(response) {
                            if(response >= 1){
                               
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'Berhasil Dihapus',
                                    text: 'Nama Transaksi '+jenispekerjaan+' dengan Id Biaya '+id_pbtenaker+' Berhasil Dihapus!',
                                    showConfirmButton: true,
                                    })
                                    bersihtk()
                                    tableptenaker()
                            } else {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'error',
                                    title: 'Gagal Dihapus',
                                    showConfirmButton: true,
                                    })
                                    bersihtk()
                                    tableptenaker()
                            }
                            
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                        }
                    });
                }
            })
        
    })
})