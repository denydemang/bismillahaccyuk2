$(document).ready(function(){
    $('.idajuanbop').change(function(){
        let id = $(this).val();
        $.ajax({
            url : "http://localhost:8080/DashboardAdmin/getuseridajuan",
            type: "post",
            data : {id:id},
            dataType : "json",
            success: function(response) {
                $('.user_idbop').val(response[0]['user_id']);
                $('.namaproyekbop').val(response[0]['namaproyek']);
                
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });

        
    })
    $('.perhitunganbop').submit(function(e){
        let id = $('#btnsimpanbop').data('id');
        e.preventDefault();
        if ($('#btnsimpanbop').hasClass('btnsimpanbop')){
            $.ajax({
                type:'post',
                data: $(this).serialize(),
                url :$(this).attr('action'),
                dataType : "json",
                
                beforeSend: function(){
                    $('.btnsimpanbop').attr('disable','disabled');
                    $('.btnsimpanbop').html('Menyimpan..');
    
                },
                complete: function(){
                    $('.btnsimpanbop').removeAttr('disable');
                    $('.btnsimpanbop').html('Simpan');
    
                },
                success: function(response) {
                    if (response.error){
                            if (response.error.erroridajuan){
                                $('.idajuanbop').addClass('is-invalid');
                                $('.idajuanbopinvalid').html(response.error.erroridajuan);
                            } else {
                                $('.idajuanbop').removeClass('is-invalid');
                                $('.idajuanbopinvalid').html('');
                            }
                            if(response.error.errornamatransaksi){
                                $('.namatransaksi').addClass('is-invalid');
                                $('.namatransaksiinvalid').html(response.error.errornamatransaksi);
                            } else {
                                $('.namatransaksi').removeClass('is-invalid');
                                $('.namatransaksiinvalid').html('');
                            }
                            if(response.error.errortotalbiaya){
                                $('.totalbiaya').addClass('is-invalid');
                                $('.totalbiayainvalid').html(response.error.errortotalbiaya);
                            } else {
                                $('.totalbiaya').removeClass('is-invalid');
                                $('.totalbiayainvalid').html('');
                            }
                        } else {
                            if (response.affected >= 1){
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'Berhasil Disimpan',
                                    showConfirmButton: true,
                                    })
                                    tablepbop();
                                    $('#btnsimpanbop').addClass('btnsimpanbop');
                                    $('#btnsimpanbop').html('Simpan');
                                    $('#btnsimpanbop').removeClass('btnubahbop');
                                    $('.namatransaksi').removeClass('is-invalid');
                                    $('.idajuanbop').removeClass('is-invalid');
                                    $('.totalbiaya').removeClass('is-invalid');
                                    $(".perhitunganbop").trigger('reset'); //jquery
                            } else {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'error',
                                    title: 'Data gagal Disimpan',
                                    showConfirmButton: false,
                                    timer: 3000
                                    })
                                                        
                                    tablepbop();
                                    $('#btnsimpanbop').addClass('btnsimpanbop');
                                    $('#btnsimpanbop').html('Simpan');
                                    $('#btnsimpanbop').removeClass('btnubahbop');
                                    $('.namatransaksi').removeClass('is-invalid');
                                    $('.idajuanbop').removeClass('is-invalid');
                                    $('.totalbiaya').removeClass('is-invalid');
                                    $(".perhitunganbop").trigger('reset'); //jquery
                            }
                        }
                    
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        } else {
            $.ajax({
                type:'post',
                data: $(this).serialize(),
                url :'http://localhost:8080/DashBoardAdmin/updateperhitunganbop/'+id,
                dataType : "json",
                
                beforeSend: function(){
                    $('.btnsimpanbop').attr('disable','disabled');
                    $('.btnsimpanbop').html('Menyimpan..');
    
                },
                complete: function(){
                    $('.btnsimpanbop').removeAttr('disable');
                    $('.btnsimpanbop').html('Simpan');
    
                },
                success: function(response) {
                    if (response.error){
                            if (response.error.erroridajuan){
                                $('.idajuanbop').addClass('is-invalid');
                                $('.idajuanbopinvalid').html(response.error.erroridajuan);
                            } else {
                                $('.idajuanbop').removeClass('is-invalid');
                                $('.idajuanbopinvalid').html('');
                            }
                            if(response.error.errornamatransaksi){
                                $('.namatransaksi').addClass('is-invalid');
                                $('.namatransaksiinvalid').html(response.error.errornamatransaksi);
                            } else {
                                $('.namatransaksi').removeClass('is-invalid');
                                $('.namatransaksiinvalid').html('');
                            }
                            if(response.error.errortotalbiaya){
                                $('.totalbiaya').addClass('is-invalid');
                                $('.totalbiayainvalid').html(response.error.errortotalbiaya);
                            } else {
                                $('.totalbiaya').removeClass('is-invalid');
                                $('.totalbiayainvalid').html('');
                            }
                        } else {
                            if (response.affected >= 1 || response.affected == 0){
                                tablepbop();
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'Berhasil Diupdate',
                                    text: 'Id Ajuan '+response.notifajuan+', Nama Proyek '+response.notifnamaproyek+' Berhasil Diupdate!',
                                    showConfirmButton: true,
                                    })
                                    
                                    $('#btnsimpanbop').addClass('btnsimpanbop');
                                    $('#btnsimpanbop').html('Simpan');
                                    $('#btnsimpanbop').removeClass('btnubahbop');
                                    $('.namatransaksi').removeClass('is-invalid');
                                    $('.idajuanbop').removeClass('is-invalid');
                                    $('.totalbiaya').removeClass('is-invalid');
                                    $(".perhitunganbop").trigger('reset'); //jquery
                            } else {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'error',
                                    title: 'Data gagal Diubah',
                                    showConfirmButton: false,
                                    timer: 3000
                                    })
                                                        
                                    tablepbop();
                                    $('#btnsimpanbop').addClass('btnsimpanbop');
                                    $('#btnsimpanbop').html('Simpan');
                                    $('#btnsimpanbop').removeClass('btnubahbop');
                                    $('.namatransaksi').removeClass('is-invalid');
                                    $('.idajuanbop').removeClass('is-invalid');
                                    $('.totalbiaya').removeClass('is-invalid');
                                    $(".perhitunganbop").trigger('reset'); //jquery
                            }
                        }
                    
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });

        }
        
        // if ($('#btnsimpanbop').hasClass('btnsimpanbop')){
        //     $.ajax({
        //         type: "post",
        //         url : $(this).attr('action'),
        //         data : $(this).serialize(),
        //         dataType : "json",
        //         beforeSend: function(){
        //             $('.btnsimpanbop').attr('disable','disabled');
        //             $('.btnsimpanbop').html('Menyimpan..');
    
        //         },
        //         complete: function(){
        //             $('.btnsimpanbop').removeAttr('disable');
        //             $('.btnsimpanbop').html('Simpan');
    
        //         },
        //         success: function(response) {
        //             if (response.error){
        //                 if (response.error.erroridajuan){
        //                     $('.idajuanbop').addClass('is-invalid');
        //                     $('.idajuanbopinvalid').html(response.error.erroridajuan);
        //                 } else {
        //                     $('.idajuanbop').removeClass('is-invalid');
        //                     $('.idajuanbopinvalid').html('');
        //                 }
        //                 if(response.error.errornamatransaksi){
        //                     $('.namatransaksi').addClass('is-invalid');
        //                     $('.namatransaksiinvalid').html(response.error.errornamatransaksi);
        //                 } else {
        //                     $('.namatransaksi').removeClass('is-invalid');
        //                     $('.namatransaksiinvalid').html('');
        //                 }
        //                 if(response.error.errortotalbiaya){
        //                     $('.totalbiaya').addClass('is-invalid');
        //                     $('.totalbiayainvalid').html(response.error.errortotalbiaya);
        //                 } else {
        //                     $('.totalbiaya').removeClass('is-invalid');
        //                     $('.totalbiayainvalid').html('');
        //                 }
                        
        //            } else {
        //             if (response.affected >= 1){
        //                 Swal.fire({
        //                     position: 'center',
        //                     icon: 'success',
        //                     title: 'Berhasil Disimpan',
        //                     showConfirmButton: true,
        //                     })
        //                     tablepbop();
        //                     $('#btnsimpanbop').addClass('btnsimpanbop');
        //                     $('#btnsimpanbop').html('Simpan');
        //                     $('#btnsimpanbop').removeClass('btnubahbop');
        //                     $('.jenispekerjaan').removeClass('is-invalid');
        //                     $('.idajuantk').removeClass('is-invalid');
        //                     $('.gaji').removeClass('is-invalid');
        //                     $('.totalpekerja').removeClass('is-invalid');
        //                     $(".perhitungantenaker").trigger('reset'); //jquery
        //             } else {
        //                 Swal.fire({
        //                     position: 'center',
        //                     icon: 'error',
        //                     title: 'Data gagal Disimpan',
        //                     showConfirmButton: false,
        //                     timer: 3000
        //                     })
                            
        //                     tableptenaker();
        //                     $('#btnsimpantk').addClass('btnsimpantk');
        //                     $('#btnsimpantk').html('Simpan');
        //                     $('#btnsimpantk').removeClass('btnubahtk');
        //                     $('.namatransaksi').removeClass('is-invalid');
        //                     $('.idajuanbop').removeClass('is-invalid');
        //                     $('.totalbiaya').removeClass('is-invalid');
        //                     $(".perhitunganbop").trigger('reset'); //jquery
        //             }
        //            }
        //         },
        //         error: function(xhr, ajaxOptions, thrownError) {
        //             alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        //         }
        //     });
        // } else {

        // }
        
    })

    $(document).on('click', '.editbop', function(){
        let id = $(this).data('id');
        
        console.log(id);
        $.ajax({
            type: 'post',
            data : {id : id},
            url: 'http://localhost:8080/DashboardAdmin/getdataperhitunganbop',
            dataType: "json",
            success: function(response) {
                $('.namatransaksi').removeClass('is-invalid');
                $('.idajuanbop').removeClass('is-invalid');
                $('.totalbiaya').removeClass('is-invalid');
                $('#btnsimpanbop').removeClass('btnsimpanbop');
                $('#btnsimpanbop').addClass('btnubahbop');
                $('#btnsimpanbop').html('Ubah');
                $('#btnsimpanbop').data('id', id);
                $('.idajuanbop option[value="'+response[0]['idajuan']+'"]').prop("selected",true)
                $('.user_idbop').val(response[0]['user_id']);
                $('.namaproyekbop').val(response[0]['namaproyek']);
                $('.namatransaksi').val(response[0]['namatrans']);
                $('.totalbiaya').val(response[0]['tot_biaya']);
                
                
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
        
    })
    $(document).on('click', '.hapusbop', function(){
        let idajuan =  $(this).data('idajuan')
        let namaproyek = $(this).data('namaproyek')
        let namatrans = $(this).data('namatrans')
        let id  =  $(this).data('id')
        Swal.fire({
            position: 'center',
            icon: 'warning',
            title: 'Yakin Hapus?',
            text: 'Berikut Id Ajuan '+idajuan+' Nama Proyek '+namaproyek+' Dengan Transaksi '+namatrans+' Akan Dihapus!',
            showConfirmButton: true,
            showCancelButton: true,
            cancelButtonColor: '#d33',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#3085d6',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url : "http://localhost:8080/DashboardAdmin/hapusperhitunganbop/"+id,
                        dataType : "json",
                        success: function(response) {
                            if(response >= 1){
                                $('.namatransaksi').removeClass('is-invalid');
                                $('.idajuanbop').removeClass('is-invalid');
                                $('.totalbiaya').removeClass('is-invalid');
                                $(".perhitunganbop").trigger('reset'); //jquer
                                tablepbop();
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'Berhasil Dihapus',
                                    text: 'Berikut Id Ajuan '+idajuan+' Nama Proyek '+namaproyek+' Dengan Transaksaksi '+namatrans+' Berhasil Dihapus!',
                                    showConfirmButton: true,
                                    })
                            } else {
                                $('.namatransaksi').removeClass('is-invalid');
                                $('.idajuanbop').removeClass('is-invalid');
                                $('.totalbiaya').removeClass('is-invalid');
                                $(".perhitunganbop").trigger('reset'); //jquer
                                tablepbop();
                                Swal.fire({
                                    position: 'center',
                                    icon: 'error',
                                    title: 'Gagal Dihapus',
                                    text: 'Berikut Id Ajuan '+idajuan+' Nama Proyek '+namaproyek+' Dan Nama Bahan '+namabahan+' Gagal Dihapus!',
                                    showConfirmButton: true,
                                    })
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