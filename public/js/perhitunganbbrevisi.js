function bersihbb(){
    $('.id_pbb').removeClass('is-invalid');
    $('.harga').removeClass('is-invalid');
    $('.jumlahbeli').removeClass('is-invalid');
    $('.id_pbb').val('');
    $('.idajuanbb').val('');
    $('.namaproyekbb').val('');
    $('.namabahan').val('');
    $('.user_idbb').val('');
    $('.ukuran').val('');
    $('.tebal').val('');
    $('.jenis').val('');
    $('.harga').val('');
    $('.berat').val('');
    $('.kualitas').val('');
    $('.panjang').val('');
    $('.jumlahbeli').val('');
    $('.totalharga').val('');
    $('#btnsimpan').addClass('btnsimpanbb');
    $('#btnsimpan').html('Revisi');

}

$(document).ready(function(){
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
    $('.perhitunganbbrevisi').submit(function(e){
        e.preventDefault();
       
        let tebal = $('.tebal').data('tebal');
        let ukuran = $('.ukuran').data('ukuran');
        let jenis = $('.jenis').data('jenis');
        let berat = $('.berat').data('berat');
        let kualitas =  $('.kualitas').data('kualitas');
        let panjang = $('.panjang').data('panjang')
        let harga = $('.harga').data('harga');
        let valharga = $('.harga').val();
        valharga = parseInt(valharga.replace(/[^0-9/]/g,''));
        let jumlahbeli = $('.jumlahbeli').data('jumlahbeli')
        if (
            tebal == $('.tebal').val() &&
            harga == valharga &&
            ukuran ==  $('.ukuran').val() &&
            jenis ==   $('.jenis').val() &&
            berat == $('.berat').val() &&
            kualitas == $('.kualitas').val() &&
            panjang == $('.panjang').val() && 
            jumlahbeli == $('.jumlahbeli').val() 
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
            let id = $('#btnsimpan').data('id');
         if ( $('#btnsimpan').hasClass('btnsimpanbb')){
            $.ajax({
                url : $(this).attr('action'),
                type: "post",
                data : $(this).serialize(),
                dataType : "json",
                beforeSend: function(){
                    $('.btnsimpanbb').attr('disable','disabled');
                    $('.btnsimpanbb').html('Merevisi..');

                },
                complete: function(){
                    $('.btnsimpanbb').removeAttr('disable');
                    $('.btnsimpanbb').html('Revisi');

                },
                success: function(response) {
                    
                    if (response.error){
                        if (response.error.errorid_pbb){
                            $('.id_pbb').addClass('is-invalid');
                            $('.id_pbbinvalid').html(response.error.errorid_pbb);
                        } else {
                            $('.id_pbb').removeClass('is-invalid');
                            $('.id_pbbinvalid').html('');
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

                    } else {
                    if (response.affected >= 1){
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Nama Bahan <em>'+response.notifnamabahan+'</em> Dengan Id bahan <em>'+response.notifid_pbb+'</em> Berhasil Direvisi',                            showConfirmButton: true
                            })
                            tablepbb();
                            bersihbb()
                    } else {
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'Data gagal Disimpan',
                            showConfirmButton: false,
                            timer: 3000
                            })
                            tablepbb();
                            bersihbb()
                        
                    }
                        
                    }
                    
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
            
        } else {
            $.ajax({
                url : base_url+'DashBoardAdmin/updaterevisibb/'+id,
                type: "post",
                data : $(this).serialize(),
                dataType : "json",
                beforeSend: function(){
                    $('.btnubahbb').attr('disable','disabled');
                    $('.btnubahbb').html('Merevisi Ulang..');

                },
                complete: function(){
                    $('.btnubahbb').removeAttr('disable');
                    $('.btnubahbb').html('Revisi Lagi');

                },
                success: function(response) {
                   if (response.error){
                        if (response.error.erroridajuan){
                            $('.idajuanbb').addClass('is-invalid');
                            $('.idajuanbbinvalid').html(response.error.erroridajuan);
                        } else {
                            $('.idajuanbb').removeClass('is-invalid');
                            $('.idajuanbbinvalid').html('');
                        }  if (response.error.errorid_pbb){
                            $('.id_pbb').addClass('is-invalid');
                            $('.id_pbbinvalid').html(response.error.errorid_pbb);
                        } else {
                            $('.id_pbb').removeClass('is-invalid');
                            $('.id_pbbinvalid').html('');
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
                            bersihbb()
                           
                    } else {
                        Swal.fire({
                            position: 'center',
                            icon: 'info',
                            title: 'Data Tidak Ada Yang Diubah',
                            showConfirmButton: false,
                            timer: 3000
                            })
                            
                            tablepbb();
                            bersihbb()
                            $('#btnsimpan').addClass('btnsimpanbb');
                            $('#btnsimpan').html('Simpan');
                            $('#btnsimpan').removeClass('btnubahbb');
                            tablepbb();
                            bersihbb()
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
$(document).on('click', '.hapusbb', function(){
    
    
    let id_pbbr=  $(this).data('id')
    id_pbbr =  parseInt(id_pbbr.replace(/[^0-9/]/g,''))
    let idfix = $(this).data('id');
    let id_pbb = $(this).data('idbiaya')
    let namaproyek = $(this).data('namaproyek')
    let namabahan = $(this).data('namabahan')
    Swal.fire({
        position: 'center',
        icon: 'warning',
        title: 'Yakin Hapus?',
        text: 'Nama Bahan '+namabahan+' dengan Id Biaya '+id_pbb+' Akan Dihapus',
        showConfirmButton: true,
        showCancelButton: true,
        cancelButtonColor: '#d33',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#3085d6',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url : base_url+"DashboardAdmin/hapuspbbrevisi/"+id_pbb,
                    dataType : "json",
                    success: function(response) {
                         if(response >= 1){
                            bersihbb()
                            tablepbb();
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: ' Berhasil Dihapus!',
                                text: 'Nama Bahan '+namabahan+' dengan Id Biaya '+id_pbb+' Berhasil Dihapus',
                                showConfirmButton: true,
                                })
                        } else {
                            bersihbb()
                            tablepbb();
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: 'Gagal Dihapus',
                                text: 'Nama Bahan '+namabahan+' dengan Id Biaya '+id_pbb+' Gagal Dihapus',
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
        url: base_url+'DashboardAdmin/getdataperhitunganbbrevisi',
        dataType: "json",
        success: function(response) {
        
            $('.namabahan').removeClass('is-invalid');
            $('.idajuanbb').removeClass('is-invalid');
            $('.id_pbb').removeClass('is-invalid');
            $('.jumlahbeli').removeClass('is-invalid');
            $('.harga').removeClass('is-invalid');
            $('#btnsimpan').removeClass('btnsimpanbb');
            $('#btnsimpan').html('Revisi Lagi');
            $('#btnsimpan').data('id', id);
            $('.user_idbb').val(response[0]['user_id']);
            $('.id_pbb').val(response[0]['id_pbb']);
            $('.idajuanbb').val(response[0]['idajuan']);
            $('.namaproyekbb').val(response[0]['namaproyek']);
            $('.namabahan').val(response[0]['namabahan']);
            $('.ukuran').val(response[0]['ukuran']);
            $('.ukuran').data('ukuran',response[0]['ukuran']);
            $('.tebal').val(response[0]['ketebalan']);
            $('.tebal').data('tebal',response[0]['ketebalan']);
            $('.jenis').val(response[0]['jenis']);
            $('.jenis').data('jenis',response[0]['jenis']);
            $('.berat').val(response[0]['berat']);
            $('.berat').data('berat',response[0]['berat']);
            $('.kualitas').val(response[0]['kualitas']);
            $('.kualitas').data('kualitas',response[0]['kualitas']);
            $('.panjang').val(response[0]['panjang']);
            $('.panjang').data('panjang',response[0]['panjang']);
            let harga = parseInt(response[0]['harga'])
            let totalharga = parseInt(response[0]['total_harga']);
            $('.harga').val(formatRupiah1(harga))
            $('.harga').data('harga', response[0]['harga'])
            $('.totalharga').val(formatRupiah1(totalharga))
            $('.jumlahbeli').val(response[0]['jumlah_beli']);
            $('.jumlahbeli').data('jumlahbeli',response[0]['jumlah_beli']);
           
            
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
    
})

})