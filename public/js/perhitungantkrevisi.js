
function bersihtk(){
    $('.hari').removeClass('is-invalid');
    $('.gaji').removeClass('is-invalid');
    $('.id_pbtenaker').removeClass('is-invalid');
    $('.totalpekerja').removeClass('is-invalid');
    $('#btnsimpantk').addClass('btnsimpantk');
    $('#btnsimpantk').html('Revisi');
    $('.hari').val('');
    $('.gaji').val('');
    $('.id_pbtenaker').val('');
    $('.totalpekerja').val('');
    $('.idajuantk').val('');
    $('.user_idtk').val('');
    $('.namaproyektk').val('');
    $('.jenispekerjaan').val('');
    $('.totalpekerja').val('');
    $('.totalgaji').val('');
    
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
            let id = $('#btnsimpantk').data('id');
            if ($('#btnsimpantk').hasClass('btnsimpantk')){
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
            } else {
                $.ajax({
                    url : base_url+'DashBoardAdmin/updaterevisitk/'+id,
                    type: "post",
                    data : $(this).serialize(),
                    dataType : "json",
                    beforeSend: function(){
                        $('.btnubahtk').attr('disable','disabled');
                        $('.btnubahtk').html('Merevisi..');
        
                    },
                    complete: function(){
                        $('.btnubahtk').removeAttr('disable');
                        $('.btnubahtk').html('Revisi Lagi');
        
                    },
                    success: function(response) {
                
                    if (response.error){
                            if (response.error.erroridajuan){
                                $('.idajuantk').addClass('is-invalid');
                                $('.idajuantkinvalid').html(response.error.erroridajuan);
                            } else {
                                $('.idajuantk').removeClass('is-invalid');
                                $('.idajuantkinvalid').html('');
                            } if (response.error.erroridtenaker){
                                $('.id_pbtenaker').addClass('is-invalid');
                                $('.idpbtenakerinvalid').html(response.error.erroridtenaker);
                            } else {
                                $('.id_pbtenaker').removeClass('is-invalid');
                                $('.idpbtenakerinvalid').html('');
                            }
                            if(response.error.errorjenispekerjaan){
                                $('.jenispekerjaan').addClass('is-invalid');
                                $('.jenispekerjaaninvalid').html(response.error.errorjenispekerjaan);
                            } else {
                                $('.jenispekerjaan').removeClass('is-invalid');
                                $('.jenispekerjaan').html('');
                            }
                            if(response.error.errorgaji){
                                $('.gaji').addClass('is-invalid');
                                $('.gajiinvalid').html(response.error.errorgaji);
                            } else {
                                $('.gaji').removeClass('is-invalid');
                                $('.gajiinvalid').html('');
                            }
                            if(response.error.errortotalpekerja){
                                $('.totalpekerja').addClass('is-invalid');
                                $('.totalpekerjainvalid').html(response.error.errortotalpekerja);
                            } else {
                                $('.totalpekerja').removeClass('is-invalid');
                                $('.totalpekerja').html('');
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
                                title: 'Berhasil Diupdate',
                                text: 'Id Ajuan '+response.notifajuan+', Nama Proyek '+response.notifnamaproyek+' Berhasil Diupdate!',
                                showConfirmButton: true,
                                })
                                bersihtk()
                                tableptenaker()
                                
                        } else {
                            Swal.fire({
                                position: 'center',
                                icon: 'info',
                                title: 'Tidak Ada Data Yang Diubah',
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
                        url : base_url+"DashboardAdmin/hapusptkrevisi/"+id_pbtenaker,
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
    $(document).on('click', '.edittk', function(){
        let id = $(this).data('id');
        
        $.ajax({
            type: 'post',
            data : {id : id},
            url: base_url+'DashboardAdmin/getdataperhitungantkrevisi',
            dataType: "json",
            success: function(response) {
                bersihtk();
                $('#btnsimpantk').data('id', id); 
                $('#btnsimpantk').removeClass('btnsimpantk');
                $('#btnsimpantk').html('Revisi Lagi');
                $('.user_idtk').val(response[0]['user_id'])
                $('.idajuantk').val(response[0]['idajuan'])
                $('.id_pbtenaker').val(response[0]['id_pbtenaker'])
                $('.namaproyektk').val(response[0]['namaproyek'])
                $('.jenispekerjaan').val(response[0]['jenispekerjaan'])
                let gaji =response[0]['gaji']
                let totalgaji =response[0]['total_gaji']
                $('.gaji').val(formatRupiah1(gaji));
                $('.gaji').data('gaji',gaji);
                $('.totalgaji').val(formatRupiah1(totalgaji));
                $('.totalgaji').data('totalgaji',response[0]['total_gaji']);
                $('.hari').val(response[0]['hari'])
                $('.hari').data('hari',response[0]['hari'])
                $('.totalpekerja').val(response[0]['total_pekerja'])
                $('.totalpekerja').data('totalpekerja',response[0]['total_pekerja'])
                
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
        
    })
})