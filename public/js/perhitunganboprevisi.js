function bersihbop(){
    $('.id_pbop').removeClass('is-invalid');
    $('.totalbiaya').removeClass('is-invalid');
    $('.totalbiaya').val('');
    $('.totalbiaya').val('');
    $('.idajuanbop').val('');
    $('.id_pbop').val('');
    $('.user_idbop').val('');
    $('.namaproyekbop').val('');
    $('.namatransaksi').val('');
    $('.totalbiaya').val('');
    
    
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
        } else {
            $.ajax({
                type:'post',
                data: $(this).serialize(),
                url :base_url+'DashBoardAdmin/updaterevisibop/'+id,
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
                                tablepbop();
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'Berhasil Diupdate',
                                    text: 'Id Ajuan '+response.notifajuan+', Nama Proyek '+response.notifnamaproyek+' Berhasil Diupdate!',
                                    showConfirmButton: true,
                                    })
                                    bersihbop();
                                    tablepbop()
                                    
                            } else {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'info',
                                    title: 'Data Tidak Ada Yang Diubah',
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

            }
            
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
                    url : base_url+"DashboardAdmin/hapuspboprevisi/"+id_pbop,
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

$(document).on('click', '.editbop', function(){
    let id = $(this).data('id');
    
    console.log(id);
    $.ajax({
        type: 'post',
        data : {id : id},
        url: base_url+'DashboardAdmin/getdataperhitunganboprevisi',
        dataType: "json",
        success: function(response) {
            $('.namatransaksi').removeClass('is-invalid');
            $('.idajuanbop').removeClass('is-invalid');
            $('.totalbiaya').removeClass('is-invalid');
            $('#btnsimpanbop').removeClass('btnsimpanbop');
            $('#btnsimpanbop').html('Revisi lagi');
            $('#btnsimpanbop').data('id', id);
            $('.id_pbop').val(response[0]['id_pbop']);
            $('.idajuanbop').val(response[0]['idajuan']);
            $('.user_idbop').val(response[0]['user_id']);
            $('.namaproyekbop').val(response[0]['namaproyek']);
            $('.namatransaksi').val(response[0]['namatrans']);
            let totbiaya = response[0]['tot_biaya'] 
            $('.totalbiaya').val(formatRupiah1(totbiaya));
            $('.totalbiaya').data('totalbiaya', totbiaya);
            
            
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
    
})

})