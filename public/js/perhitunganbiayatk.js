    $(document).ready(function(){
//Perhitungna Tenaga Kerja
$('.idajuantk').change(function(){
    let id = $(this).val();
    $.ajax({
        url : base_url+"DashboardAdmin/getuseridajuan",
        type: "post",
        data : {id:id},
        dataType : "json",
        success: function(response) {
            $('.user_idtk').val(response[0]['user_id']);
            $('.namaproyektk').val(response[0]['namaproyek']);
            
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });

    
})
$('.perhitungantenaker').submit(function(e){
        e.preventDefault(); 
        let id = $('#btnsimpantk').data('id');

    if ($('#btnsimpantk').hasClass('btnsimpantk')){
                    
        $.ajax({
            type: "post",
            url : $(this).attr('action'),
            data : $(this).serialize(),
            dataType : "json",
            beforeSend: function(){
                $('.btnsimpantk').attr('disable','disabled');
                $('.btnsimpantk').html('Menyimpan..');

            },
            complete: function(){
                $('.btnsimpantk').removeAttr('disable');
                $('.btnsimpantk').html('Simpan');

            },
            success: function(response) {
                if (response.error){
                    if (response.error.erroridajuan){
                        $('.idajuantk').addClass('is-invalid');
                        $('.idajuantkinvalid').html(response.error.erroridajuan);
                    } else {
                        $('.idajuantk').removeClass('is-invalid');
                        $('.idajuantkinvalid').html('');
                    }
                    if(response.error.errorjenispekerjaan){
                        $('.jenispekerjaan').addClass('is-invalid');
                        $('.jenispekerjaaninvalid').html(response.error.errorjenispekerjaan);
                    } else {
                        $('.jenispekerjaan').removeClass('is-invalid');
                        $('.jenispekerjaaninvalid').html('');
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
                        title: 'Berhasil Disimpan',
                        showConfirmButton: true,
                        })
                        tableptenaker();
                        $('#btnsimpantk').addClass('btnsimpantk');
                        $('#btnsimpantk').html('Simpan');
                        $('#btnsimpantk').removeClass('btnubahtk');
                        $('.jenispekerjaan').removeClass('is-invalid');
                        $('.idajuantk').removeClass('is-invalid');
                        $('.gaji').removeClass('is-invalid');
                        $('.hari').removeClass('is-invalid');
                        $('.totalpekerja').removeClass('is-invalid');
                        $(".perhitungantenaker").trigger('reset'); //jquery
                } else {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Data gagal Disimpan',
                        showConfirmButton: false,
                        timer: 3000
                        })
                        
                        tableptenaker();
                        $('#btnsimpantk').addClass('btnsimpantk');
                        $('#btnsimpantk').html('Simpan');
                        $('#btnsimpantk').removeClass('btnubahtk');
                        $('.jenispekerjaan').removeClass('is-invalid');
                        $('.idajuantk').removeClass('is-invalid');
                        $('.gaji').removeClass('is-invalid');
                        $('.hari').removeClass('is-invalid');
                        $('.totalpekerja').removeClass('is-invalid');
                        $(".perhitungantenaker").trigger('reset'); //jquery
                }
               }
            }
        });
            
    } 
    else {
        $.ajax({
            url : base_url+'DashBoardAdmin/updateperhitungantk/'+id,
            type: "post",
            data : $(this).serialize(),
            dataType : "json",
            beforeSend: function(){
                $('.btnubahtk').attr('disable','disabled');
                $('.btnubahtk').html('Mengupdate..');

            },
            complete: function(){
                $('.btnubahtk').removeAttr('disable');
                $('.btnubahtk').html('Ubah');

            },
            success: function(response) {
        
            if (response.error){
                    if (response.error.erroridajuan){
                        $('.idajuantk').addClass('is-invalid');
                        $('.idajuantkinvalid').html(response.error.erroridajuan);
                    } else {
                        $('.idajuantk').removeClass('is-invalid');
                        $('.idajuantkinvalid').html('');
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
                        tableptenaker();
                        $('#btnsimpantk').addClass('btnsimpantk');
                        $('#btnsimpantk').html('Simpan');
                        $('#btnsimpantk').removeClass('btnubahtk');
                        $('.idajuantk').removeClass('is-invalid');
                        $('.jenispekerjaan').removeClass('is-invalid');
                        $('.gaji').removeClass('is-invalid');
                        $('.hari').removeClass('is-invalid');
                        $('.totalpekerja').removeClass('is-invalid');
                        $(".perhitungantenaker").trigger('reset'); //jquery
                } else {
                    Swal.fire({
                        position: 'center',
                        icon: 'info',
                        title: 'Tidak Ada Data Yang Diubah',
                        showConfirmButton: false,
                        timer: 3000
                        })
                        tableptenaker();
                        $('#btnsimpantk').addClass('btnsimpantk');
                        $('#btnsimpantk').html('Simpan');
                        $('#btnsimpantk').removeClass('btnubahtk');
                        $('.idajuantk').removeClass('is-invalid');
                        $('.jenispekerjaan').removeClass('is-invalid');
                        $('.gaji').removeClass('is-invalid');
                        $('.hari').removeClass('is-invalid');
                        $('.totalpekerja').removeClass('is-invalid');
                        $(".perhitungantenaker").trigger('reset'); //jquery
                       
                }
                    
                }
                
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
        
    }
        
      
})
$('.gaji').keyup(function(){
    $(this).val(formatRupiahtyping($(this).val()))
    let val = $(this).val();
    val = val.replace(/[^0-9/]/g,'');
    harga = parseInt(val);
    let totalpekerja = parseInt($('.totalpekerja').val());
    let hasil = harga * totalpekerja;
    
    $('.totalgaji').val(formatRupiah1(hasil));
})
$('.totalpekerja').keyup(function(){
    let hari  = $('.hari').val();
    hari = parseInt(hari.replace(/[^0-9/]/g,''))
    let gaji = $('.gaji').val();
    gaji = parseInt(gaji.replace(/[^0-9/]/g,''))
    let totalpekerja = parseInt($(this).val())
    let hasil = gaji * totalpekerja * hari;
    $('.totalgaji').val(formatRupiah1(hasil));
})
$('.hari').keyup(function(){
    let hari = $(this).val();
    hari =  parseInt(hari.replace(/[^0-9/]/g,''))
    let gaji = $('.gaji').val();
    gaji = parseInt(gaji.replace(/[^0-9/]/g,''))
    let totalpekerja = parseInt($(this).val())
    let hasil = gaji * totalpekerja * hari;
    $('.totalgaji').val(formatRupiah1(hasil));
})
$(document).on('click', '.edittk', function(){
    let id = $(this).data('id');
    
    $.ajax({
        type: 'post',
        data : {id : id},
        url: base_url+'DashboardAdmin/getdataperhitungantk',
        dataType: "json",
        success: function(response) {
            $('.idajuantk').removeClass('is-invalid');
            $('.jenispekerjaan').removeClass('is-invalid');
            $('.gaji').removeClass('is-invalid');
            $('.totalpekerja').removeClass('is-invalid');
            $('#btnsimpantk').removeClass('btnsimpantk');
            $('#btnsimpantk').addClass('btnubahtk');
            $('#btnsimpantk').html('Ubah');
            $('#btnsimpantk').data('id', id);
            $('.idajuantk option[value="'+response[0]['idajuan']+'"]').prop("selected",true)
            $('.user_idtk').val(response[0]['user_id'])
            $('.namaproyektk').val(response[0]['namaproyek'])
            $('.jenispekerjaan').val(response[0]['jenispekerjaan'])
            let gaji =response[0]['gaji']
            let totalgaji =response[0]['total_gaji']
            $('.gaji').val(formatRupiah1(gaji));
            $('.totalgaji').val(formatRupiah1(totalgaji));
            $('.hari').val(response[0]['hari'])
            $('.totalpekerja').val(response[0]['total_pekerja'])
            
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
    
})
$(document).on('click', '.hapustk', function(){
    let idajuan =  $(this).data('idajuan')
    let jenispekerjaan =  $(this).data('jenispekerjaan')
    let namaproyek = $(this).data('namaproyek');
    let id  =  $(this).data('id')
    Swal.fire({
        position: 'center',
        icon: 'warning',
        title: 'Yakin Hapus?',
        text: 'Berikut Id Ajuan '+idajuan+' Nama Proyek '+namaproyek+' Dan Jenis Pekerjaan '+jenispekerjaan+' Akan Dihapus!',
        showConfirmButton: true,
        showCancelButton: true,
        cancelButtonColor: '#d33',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#3085d6',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url : base_url+"DashboardAdmin/hapusperhitungantk/"+id,
                    dataType : "json",
                    success: function(response) {
                        if(response >= 1){
                            $('.jenispekerjaan').removeClass('is-invalid');
                            $('.idajuantk').removeClass('is-invalid');
                            $('.gaji').removeClass('is-invalid');
                            $('.totalpekerja').removeClass('is-invalid');
                            $(".perhitungantenaker").trigger('reset'); //jquery
                            tableptenaker();
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Berhasil Dihapus',
                                text: 'Berikut Id Ajuan '+idajuan+' Nama Proyek '+namaproyek+' Dan Jenis Pekerjaan '+jenispekerjaan+' Berhasil Dihapus!',
                                showConfirmButton: true,
                                })
                        } else {
                            $('.jenispekerjaan').removeClass('is-invalid');
                            $('.idajuantk').removeClass('is-invalid');
                            $('.gaji').removeClass('is-invalid');
                            $('.totalpekerja').removeClass('is-invalid');
                            $(".perhitungantenaker").trigger('reset'); //jquery
                            tableptenaker();
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: 'Gagal Dihapus',
                                text: 'Berikut Id Ajuan '+idajuan+' Nama Proyek '+namaproyek+' Dan Jenis Pekerjaan '+jenispekerjaan+' Gagal Dihapus!',
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
    