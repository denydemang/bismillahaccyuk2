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
            let id = $('#btnsimpan').data('id');
            if ( $('#btnsimpan').hasClass('btnsimpanbb')){
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
                
            } else {
                $.ajax({
                    url : 'http://localhost:8080/DashBoardAdmin/updateperhitunganbb/'+id,
                    type: "post",
                    data : $(this).serialize(),
                    dataType : "json",
                    beforeSend: function(){
                        $('.btnubahbb').attr('disable','disabled');
                        $('.btnubahbb').html('Mengupdate..');
    
                    },
                    complete: function(){
                        $('.btnubahbb').removeAttr('disable');
                        $('.btnubahbb').html('Ubah');
    
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
                                title: 'Berhasil Diupdate',
                                text: 'Id Ajuan '+response.notifajuan+', Nama Proyek '+response.notifnamaproyek+' Berhasil Diupdate!',
                                showConfirmButton: true,
                                })
                                tablepbb();
                                $('#btnsimpan').addClass('btnsimpanbb');
                                $('#btnsimpan').html('Simpan');
                                $('#btnsimpan').removeClass('btnubahbb');
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
                
            }
            
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
    $(document).on('click', '.hapusbb', function(){
            let idajuan =  $(this).data('idajuan')
            let namaproyek = $(this).data('namaproyek')
            let namabahan = $(this).data('namabahan')
            let id  =  $(this).data('id')
            Swal.fire({
                position: 'center',
                icon: 'warning',
                title: 'Yakin Hapus?',
                text: 'Berikut Id Ajuan '+idajuan+' Nama Proyek '+namaproyek+' Dan Nama Bahan '+namabahan+' Akan Dihapus!',
                showConfirmButton: true,
                showCancelButton: true,
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#3085d6',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url : "http://localhost:8080/DashboardAdmin/hapusperhitunganbb/"+id,
                            dataType : "json",
                            success: function(response) {
                                if(response >= 1){
                                    tablepbb();
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'success',
                                        title: 'Berhasil Dihapus',
                                        text: 'Berikut Id Ajuan '+idajuan+' Nama Proyek '+namaproyek+' Dan Nama Bahan '+namabahan+' Berhasil Dihapus!',
                                        showConfirmButton: true,
                                        })
                                } else {
                                    tablepbb();
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
    $(document).on('click', '.editbb', function(){
        let id = $(this).data('id');
        $.ajax({
            type: 'post',
            data : {id : id},
            url: 'http://localhost:8080/DashboardAdmin/getdataperhitunganbb',
            dataType: "json",
            success: function(response) {
                $('#btnsimpan').removeClass('btnsimpanbb');
                $('#btnsimpan').addClass('btnubahbb');
                $('#btnsimpan').html('Ubah');
                $('#btnsimpan').data('id', id);
                $('#idajuanbb option[value="'+response[0]['idajuan']+'"]').prop("selected",true);
                $('.user_idbb').val(response[0]['user_id']);
                $('.namaproyekbb').val(response[0]['namaproyek']);
                $('.namabahan').val(response[0]['namabahan']);
                $('.ukuran').val(response[0]['ukuran']);
                $('.tebal').val(response[0]['tebal']);
                $('.jenis').val(response[0]['jenis']);
                $('.berat').val(response[0]['berat']);
                $('.kualitas').val(response[0]['kualitas']);
                $('.panjang').val(response[0]['panjang']);
                $('.harga').val(response[0]['harga']);
                $('.jumlahbeli').val(response[0]['jumlah_beli']);
                $('.totalharga').val(response[0]['total_harga']);
                
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
        
    })
    
    //END BAHANBAKU

    //Perhitungna Tenaga Kerja
    $('.idajuantk').change(function(){
        let id = $(this).val();
        $.ajax({
            url : "http://localhost:8080/DashboardAdmin/getuseridajuan",
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
                            $('.totalpekerja').removeClass('is-invalid');
                            $(".perhitungantenaker").trigger('reset'); //jquery
                    }
                   }
                }
            });
                
        } 
        else {
            $.ajax({
                url : 'http://localhost:8080/DashBoardAdmin/updateperhitungantk/'+id,
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
                        
                       
                   } else {
                    if (response.affected >= 1 || response.affected == 0){
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
                            $('.totalpekerja').removeClass('is-invalid');
                            $(".perhitungantenaker").trigger('reset'); //jquery
                    } else {
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'Data gagal DiUpdate',
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
        let gaji = parseInt($(this).val());
        let totalpekerja = parseInt($('.totalpekerja').val())
        let hasil = gaji * totalpekerja;
        $('.totalgaji').val(hasil);
    })
    $('.totalpekerja').keyup(function(){
        let gaji = parseInt($('.gaji').val());
        let totalpekerja = parseInt($(this).val())
        let hasil = gaji * totalpekerja;
        $('.totalgaji').val(hasil);
    })
    $(document).on('click', '.edittk', function(){
        let id = $(this).data('id');
        
        $.ajax({
            type: 'post',
            data : {id : id},
            url: 'http://localhost:8080/DashboardAdmin/getdataperhitungantk',
            dataType: "json",
            success: function(response) {
                $('#btnsimpantk').removeClass('btnsimpantk');
                $('#btnsimpantk').addClass('btnubahtk');
                $('#btnsimpantk').html('Ubah');
                $('#btnsimpantk').data('id', id);
                $('.idajuantk option[value="'+response[0]['idajuan']+'"]').prop("selected",true)
                $('.user_idtk').val(response[0]['user_id'])
                $('.namaproyektk').val(response[0]['namaproyek'])
                $('.jenispekerjaan').val(response[0]['jenispekerjaan'])
                $('.gaji').val(response[0]['gaji'])
                $('.hari').val(response[0]['hari'])
                $('.totalpekerja').val(response[0]['total_pekerja'])
                $('.totalgaji').val(response[0]['total_gaji'])
                
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
        
    })
    $(document).on('click', '.hapustk', function(){
        let idajuan =  $(this).data('idajuan')
        let jenispekerjaan =  $(this).data('jenispekerjaan')
        let namaproyek = $(this).data('namaproyek')
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
                        url : "http://localhost:8080/DashboardAdmin/hapusperhitungantk/"+id,
                        dataType : "json",
                        success: function(response) {
                            if(response >= 1){
                                tableptenaker();
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'Berhasil Dihapus',
                                    text: 'Berikut Id Ajuan '+idajuan+' Nama Proyek '+namaproyek+' Dan Jenis Pekerjaan '+jenispekerjaan+' Berhasil Dihapus!',
                                    showConfirmButton: true,
                                    })
                            } else {
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
    $('#btnsimpantk').addClass('btnsimpantk');
    $('#btnsimpantk').html('Simpan');
    $('#btnsimpantk').removeClass('btnubahtk');
    $('.jenispekerjaan').removeClass('is-invalid');
    $('.idajuantk').removeClass('is-invalid');
    $('.gaji').removeClass('is-invalid');
    $('.totalpekerja').removeClass('is-invalid');
    $(".perhitungantenaker").trigger('reset'); //jquery
 })

})
