function bersihbop(){
    $('.id_pbop').removeClass('is-invalid');
    $('.totalbiaya').removeClass('is-invalid');
    $('.perhitunganboprevisi').trigger('reset');
}
$(document).ready(function(){
    $('.totalbiaya').keyup(function(){
        $(this).val(formatRupiahtyping($(this).val()))
    })
    $('.perhitunganboprevisi').submit(function(e){
        e.preventDefault();
       
        let totalbiaya = parseInt($('.totalbiaya').data('totalbiaya'))
        
        let valtotalbiaya =  $('.totalbiaya').val();
        valtotalbiaya = parseInt(valtotalbiaya.replace(/[^0-9/]/g,''));
        if (
            totalbiaya ==  valtotalbiaya
            )
        {
            Swal.fire({
                position: 'center',
                icon: 'warning',
                title: 'Silakan lakukan Perubahan Data!',
                showConfirmButton: false,
                timer: 3500
                })
            
        } else {
        //     let id = $('#btnsimpan').data('id');
        // if ( $('#btnsimpan').hasClass('btnsimpanbb')){
            $.ajax({
                type:'post',
                data: $(this).serialize(),
                url :$(this).attr('action'),
                dataType : "json",
                
                beforeSend: function(){
                    $('.btnsimpanbop').attr('disable','disabled');
                    $('.btnsimpanbop').html('Merevisi...');
    
                },
                complete: function(){
                    $('.btnsimpanbop').removeAttr('disable');
                    $('.btnsimpanbop').html('Revisi');
    
                },
                success: function(response) {
                    console.log(response);
                    
                    if (response.error){
                            if (response.error.errorid_pbop){
                                $('.id_pbop').addClass('is-invalid');
                                $('.id_pbopinvalid').html(response.error.errorid_pbop);
                            } else {
                                $('.id_bpop').removeClass('is-invalid');
                                $('.id_bpopinvalid').html('');
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
                                    title: 'Nama transaksi <em>'+response.notifnamatrans+'</em> Dan Id Biaya <em>'+response.notifid_pbop+'</em> Berhasil Direvisi',
                                    showConfirmButton: true,
                                    })
                                    bersihbop();
                                    tablepbop()
                                
                            } else {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'error',
                                    title: 'Data gagal Disimpan',
                                    showConfirmButton: false,
                                    timer: 3000
                                    })
                                    bersihbop();
                                    tablepbop()
                                
                                
                            }
                        }
                    
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
            
        // } else {
        //     $.ajax({
        //         url : base_url+'DashBoardAdmin/updaterevisibb/'+id,
        //         type: "post",
        //         data : $(this).serialize(),
        //         dataType : "json",
        //         beforeSend: function(){
        //             $('.btnubahbb').attr('disable','disabled');
        //             $('.btnubahbb').html('Mengupdate..');

        //         },
        //         complete: function(){
        //             $('.btnubahbb').removeAttr('disable');
        //             $('.btnubahbb').html('Ubah');

        //         },
        //         success: function(response) {
        //            if (response.error){
        //                 if (response.error.erroridajuan){
        //                     $('.idajuanbb').addClass('is-invalid');
        //                     $('.idajuanbbinvalid').html(response.error.erroridajuan);
        //                 } else {
        //                     $('.idajuanbb').removeClass('is-invalid');
        //                     $('.idajuanbbinvalid').html('');
        //                 }
        //                 if(response.error.errorharga){
        //                     $('.harga').addClass('is-invalid');
        //                     $('.hargainvalid').html(response.error.errorharga);
        //                 } else {
        //                     $('.harga').removeClass('is-invalid');
        //                     $('.hargainvalid').html('');
        //                 }
        //                 if(response.error.errorjumlahbeli){
        //                     $('.jumlahbeli').addClass('is-invalid');
        //                     $('.jumlahbeliinvalid').html(response.error.errorjumlahbeli);
        //                 } else {
        //                     $('.jumlahbeli').removeClass('is-invalid');
        //                     $('.jumlahbeliinvalid').html('');
        //                 }
        //                 if(response.error.errornamabahan){
        //                     $('.namabahan').addClass('is-invalid');
        //                     $('.namabahaninvalid').html(response.error.errornamabahan);
        //                 } else {
        //                     $('.namabahan').removeClass('is-invalid');
        //                     $('.namabahaninvalid').html('');
        //                 }
                        
                       
        //            } else {
        //             if (response.affected >= 1){
        //                 Swal.fire({
        //                     position: 'center',
        //                     icon: 'success',
        //                     title: 'Berhasil Diupdate',
        //                     text: 'Id Ajuan '+response.notifajuan+', Nama Proyek '+response.notifnamaproyek+' Berhasil Diupdate!',
        //                     showConfirmButton: true,
        //                     })
        //                     tablepbb();
        //                     $('#btnsimpan').addClass('btnsimpanbb');
        //                     $('#btnsimpan').html('Simpan');
        //                     $('#btnsimpan').removeClass('btnubahbb');
        //                     bersih()
        //             } else {
        //                 Swal.fire({
        //                     position: 'center',
        //                     icon: 'info',
        //                     title: 'Data Tidak Ada Yang Diubah',
        //                     showConfirmButton: false,
        //                     timer: 3000
        //                     })
                            
        //                     tablepbb();
        //                     $('#btnsimpan').addClass('btnsimpanbb');
        //                     $('#btnsimpan').html('Simpan');
        //                     $('#btnsimpan').removeClass('btnubahbb');
        //                     bersih()
        //             }
                        
        //                  }
                    
        //         },
        //         error: function(xhr, ajaxOptions, thrownError) {
        //             alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        //         }
        //     });
            
        // }
            
        }
        

}) 
$(document).on('click', '.hapusbop', function(){
    let id_pbopr=  $(this).data('id')
    id_pbopr =  parseInt(id_pbopr.replace(/[^0-9/]/g,''))
    let idfix = $(this).data('id');
    let namatrans = $(this).data('namatrans');
    let id_pbop=  $(this).data('idbiaya')
    Swal.fire({
        position: 'center',
        icon: 'warning',
        title: 'Yakin Hapus?',
        text: 'Nama Transaksi '+namatrans+' dengan Id Biaya '+id_pbop+' Akan Dihapus!',
        showConfirmButton: true,
        showCancelButton: true,
        cancelButtonColor: '#d33',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#3085d6',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url : base_url+"DashboardAdmin/hapuspboprevisi/"+idfix,
                    dataType : "json",
                    success: function(response) {
                        if(response >= 1){
                          
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Berhasil Dihapus',
                                text: 'Nama Transaksi '+namatrans+' dengan Id Biaya '+id_pbop+' Berhasil Dihapus!',
                                showConfirmButton: true,
                                })
                                bersihbop();
                                tablepbop()
                                
                        } else {
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: 'Gagal Dihapus',
                                showConfirmButton: true,
                                })
                                bersihbop();
                                tablepbop()
                                
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