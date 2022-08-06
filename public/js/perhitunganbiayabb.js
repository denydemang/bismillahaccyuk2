
function bersih(){
    $('.namabahan').removeClass('is-invalid');
    $('.idajuanbb').removeClass('is-invalid');
    $('.jumlahbeli').removeClass('is-invalid');
    $('.harga').removeClass('is-invalid');
    $(".perhitunganbb").trigger('reset'); //jquery
}
$(document).ready(function(){
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
                            bersih()
                           
                    } else {
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'Data gagal Disimpan',
                            showConfirmButton: false,
                            timer: 3000
                            })
                            
                            tablepbb();
                            bersih() 
                    }
                        
                   }
                    
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
            
        } else {
            $.ajax({
                url : base_url+'DashBoardAdmin/updateperhitunganbb/'+id,
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
                            bersih()
                    } else {
                        Swal.fire({
                            position: 'center',
                            icon: 'info',
                            title: 'Data Tidak Ada Yang Diubah',
                            showConfirmButton: false,
                            timer: 3000
                            })
                            
                            tablepbb();
                            $('#btnsimpan').addClass('btnsimpanbb');
                            $('#btnsimpan').html('Simpan');
                            $('#btnsimpan').removeClass('btnubahbb');
                            bersih()
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
    $(this).val(formatRupiahtyping($(this).val()))
    let str = $(this).val();
    str = str.replace(/[^0-9/]/g,'');
    harga = parseInt(str);
    let jumlahbeli = parseInt($('.jumlahbeli').val());
    
    hasil = harga * jumlahbeli
    $('.totalharga').val(formatRupiah1(hasil));
    //    val = val.replace('Rp','');
    //    val = val.replace('.','');
    //    val = val.substr(1);
    //    val = parseInt(val);
       
    //    let hasil = val * jumlahbeli
       
       
       
//    let harga =  parseInt(val.replace('.',''));    
//    
// //    let hasil = harga * jumlahbeli;
// //    $('.totalharga').val(formatRupiah1(9));
        // console.log(val)
    // l
    // harga = parseInt(val.split('Rp ').join('').split('.').join('')); 
    // let hasil = harga * jumlahbeli;
    // let hasilfix
    //  if (isNaN(hasil)){
    //     hasilfix = 0
    // } else {
    //     hasilfix = formatRupiah1(hasil)
    // }

    //

    

})

$('.jumlahbeli').keyup(function(){
    let val = $(this).val();
    let harga = $('.harga').val();
    harga = parseInt(harga.replace(/[^0-9/]/g,''));
    let jumlahbeli = parseInt($(this).val());
    let hasil = harga * jumlahbeli
    
    $('.totalharga').val(formatRupiah1(hasil));
    
    // let jumlahbeli = parseInt(val)
    // let harga = $('.harga').val();
    // harga = parseInt(harga.split('Rp ').join('').split('.').join(''))
    // let hasil = harga * jumlahbeli;
    // let hasilfix ;
    //  if (isNaN(hasil)){
    //     hasilfix =  0
    // } else {
    //     hasilfix = formatRupiah1(hasil)
    // }

    // $('.totalharga').val(String(hasilfix))

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
                        url : base_url+"DashboardAdmin/hapusperhitunganbb/"+id,
                        dataType : "json",
                        success: function(response) {
                            if(response >= 1){
                                $('.namabahan').removeClass('is-invalid');
                                $('.idajuanbb').removeClass('is-invalid');
                                $('.jumlahbeli').removeClass('is-invalid');
                                $('.harga').removeClass('is-invalid');
                                $(".perhitunganbb").trigger('reset'); 
                                tablepbb();
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'Berhasil Dihapus',
                                    text: 'Berikut Id Ajuan '+idajuan+' Nama Proyek '+namaproyek+' Dan Nama Bahan '+namabahan+' Berhasil Dihapus!',
                                    showConfirmButton: true,
                                    })
                            } else {
                                $('.namabahan').removeClass('is-invalid');
                                $('.idajuanbb').removeClass('is-invalid');
                                $('.jumlahbeli').removeClass('is-invalid');
                                $('.harga').removeClass('is-invalid');
                                $(".perhitunganbb").trigger('reset'); 
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
        url: base_url+'DashboardAdmin/getdataperhitunganbb',
        dataType: "json",
        success: function(response) {
        
            $('.namabahan').removeClass('is-invalid');
            $('.idajuanbb').removeClass('is-invalid');
            $('.jumlahbeli').removeClass('is-invalid');
            $('.harga').removeClass('is-invalid');
            $('#btnsimpan').removeClass('btnsimpanbb');
            $('#btnsimpan').addClass('btnubahbb');
            $('#btnsimpan').html('Ubah');
            $('#btnsimpan').data('id', id);
            $('#idajuanbb option[value="'+response[0]['idajuan']+'"]').prop("selected",true);
            $('.user_idbb').val(response[0]['user_id']);
            $('.namaproyekbb').val(response[0]['namaproyek']);
            $('.namabahan').val(response[0]['namabahan']);
            $('.ukuran').val(response[0]['ukuran']);
            $('.tebal').val(response[0]['ketebalan']);
            $('.jenis').val(response[0]['jenis']);
            $('.berat').val(response[0]['berat']);
            $('.kualitas').val(response[0]['kualitas']);
            $('.panjang').val(response[0]['panjang']);
            let harga = parseInt(response[0]['harga'])
            let totalharga = parseInt(response[0]['total_harga']);
            $('.harga').val(formatRupiah1(harga))
            $('.totalharga').val(formatRupiah1(totalharga))
            $('.jumlahbeli').val(response[0]['jumlah_beli']);
           
            
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
    
})
})
