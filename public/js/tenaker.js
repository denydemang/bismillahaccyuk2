const base_url ="http://localhost:8080/"
function bersih(){
    $('.idtenaker').removeClass('is-invalid')
    $('.idproyek').removeClass('is-invalid');
    $('.namatenaker').removeClass('is-invalid');
    $('.almttenaker').removeClass('is-invalid');
    $('.pekerjaan').removeClass('is-invalid');
    $('.gaji').removeClass('is-invalid');
    $('.pekerjaan').removeClass('is-invalid');
    $('.belum_bayar').removeClass('is-invalid');
    $('.sudah_bayar').removeClass('is-invalid');
    $('#btnsimpantenaker').addClass('btnsimpantenaker');
    $('#btnsimpantenaker').html('Tambah');
    $('#TitleLabel').html('Tambah Tenaga Kerja');
    $(".formtenaker").trigger('reset');
    $('#ModalTenaker').modal('hide'); 
}
function resetringan(){
    $('.idtenaker').removeClass('is-invalid')
    $('.idproyek').removeClass('is-invalid');
    $('.namatenaker').removeClass('is-invalid');
    $('.almttenaker').removeClass('is-invalid');
    $('.pekerjaan').removeClass('is-invalid');
    $('.gaji').removeClass('is-invalid');
    $('.pekerjaan').removeClass('is-invalid');
    $('.belum_bayar').removeClass('is-invalid');
    $('.sudah_bayar').removeClass('is-invalid');
    $(".formtenaker").trigger('reset');
}
const formatRupiahtyping = (money) => {
    angka = money.replace(/[^,\d]/g, "");
  if (isNaN(angka)){
    angka = 0;
  }
    return new Intl.NumberFormat('id-ID',
      { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }
    ).format(angka);
 }
const formatRupiah1 = (money) => {
  if (isNaN(money)){
    money = 0;
  }
    return new Intl.NumberFormat('id-ID',
      { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }
    ).format(money);
 }
function tabletenaker(){
    $.ajax({
        url: base_url+'/TampilTable/tabletenaker',
        dataType: "json",
        success: function(response) {
            $('#tampiltabletk').html(response.data);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        },
    });
}
function tampilkodeotomatis(){
    $.ajax({
        url: base_url+"/DashboardKelolaProyek/tampilkodeotomatis",
        dataType: "json",
        success: function(response) {
            $('.idproyek').val(response.idproyek)
            $('.idtenaker').val(response.idtenaker);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        },
    });
}


$(document).ready(function(){
   tabletenaker();
   tampilkodeotomatis();

   $('#sudah_bayar').keyup(function(){
    $(this).val(formatRupiahtyping($(this).val()));
    val = $(this).val()
    let str = val.replace(/[^0-9/]/g,'');
    let sudah_bayar = parseInt(str);
   
    val2 = $('.gaji').val();
    let str2 = val2.replace(/[^0-9/]/g,'');
    let gaji = parseInt(str2);
   
    val3 = $('.belum_bayar').val();
    let str3 = val3.replace(/[^0-9/]/g,'');
    let belum_bayar = parseInt(str3);

    belum_bayar = gaji - sudah_bayar;

    if (gaji < sudah_bayar || gaji < belum_bayar){
        $('.sudah_bayar').val('');
        $('.belum_bayar').val('');
    } else {
        $('.belum_bayar').val(formatRupiah1(belum_bayar))
    }

   })
   $('.gaji').keyup(function(){
    $(this).val(formatRupiahtyping($(this).val()));
    val = $(this).val()
    let str = val.replace(/[^0-9/]/g,'');
    let gaji = parseInt(str);
   
    val2 = $('#sudah_bayar').val();
    let str2 = val2.replace(/[^0-9/]/g,'');
    let sudah_bayar = parseInt(str2);
   
    val3 = $('#belum_bayar').val();
    let str3 = val3.replace(/[^0-9/]/g,'');
    let belum_bayar = parseInt(str3);

    belum_bayar = gaji - sudah_bayar;

    if (gaji < sudah_bayar || gaji < belum_bayar){
        $('.sudah_bayar').val('');
        $('.belum_bayar').val('');
    } else {
        $('.belum_bayar').val(formatRupiah1(belum_bayar))
    }

   })
   $('.belum_bayar').keyup(function(){
    $(this).val(formatRupiahtyping($(this).val()));
    val = $(this).val()
    let str = val.replace(/[^0-9/]/g,'');
    belum_bayar = parseInt(str);
   
    val2 = $('#sudah_bayar').val();
    let str2 = val2.replace(/[^0-9/]/g,'');
    sudah_bayar = parseInt(str2);
   
    val3 = $('#gaji').val();
    let str3 = val3.replace(/[^0-9/]/g,'');
     gaji = parseInt(str3);

    sudah_bayar = gaji - belum_bayar;

    if (gaji < sudah_bayar || gaji < belum_bayar){
        $('.sudah_bayar').val('');
        $('.belum_bayar').val('');
    } else {
        $('.sudah_bayar').val(formatRupiah1(sudah_bayar))
    }

   })
  
   
   $('.close').click(function(){
    bersih(); 
    tampilkodeotomatis()
   })
   $('#btntambahtenaker').click(function(){
    $('.sudah_bayar').attr('readonly',false);
    $('.belum_bayar').attr('readonly',false);
    $('.gaji').attr('readonly',false);
    bersih(); 
    tampilkodeotomatis()
   })
   $('#btnsimpancanceltenaker').click(function(){

    resetringan();
    tampilkodeotomatis()
   })
    $('.formtenaker').submit(function(e){
        e.preventDefault();
        let idtenaker = $('#btnsimpantenaker').data('idtenaker');
       
        if ($('#btnsimpantenaker').hasClass("btnsimpantenaker")){
            $.ajax({
                url :$(this).attr('action'),
                data : $(this).serialize(),
                type: 'post',
                dataType : "json",
                beforeSending: function(){
                    $('#btnsimpantenaker').attr('disable','disabled')
                    $('#btnsimpantenaker').html('Menyimpan..')
                },
                complete :function(){
                    $('#btnsimpantenaker').removeAttr('disable')
                    $('#btnsimpantenaker').html('Tambah')
                },
                
                success: function(response) {
            
                if (response.errors){
                        if (response.errors.namatenaker){
                            $('.namatenaker').addClass('is-invalid')
                            $('.namatenakerinvalid').html(response.errors.namatenaker);
                        } else {
                            $('.namatenaker').removeClass('is-invalid')
                            $('.namatenakerinvalid').html('');
                        }
                        if (response.errors.almttenaker){
                            $('.almttenaker').addClass('is-invalid')
                            $('.almttenakerinvalid').html(response.errors.almttenaker);
                        } else {
                            $('.almttenaker').removeClass('is-invalid')
                            $('.almttenakerinvalid').html('');
                        }
                        if (response.errors.pekerjaan){
                            $('.pekerjaan').addClass('is-invalid')
                            $('.pekerjaaninvalid').html(response.errors.pekerjaan);
                        } else {
                            $('.pekerjaan').removeClass('is-invalid')
                            $('.pekerjaaninvalid').html('');
                        }
                        if (response.errors.gaji){
                            $('.gaji').addClass('is-invalid')
                            $('.gajiinvalid').html(response.errors.gaji);
                        } else {
                            $('.gaji').removeClass('is-invalid')
                            $('.gajiinvalid').html('');
                        }
                        if (response.errors.belum_bayar){
                            $('.belum_bayar').addClass('is-invalid')
                            $('.belum_bayarinvalid').html(response.errors.belum_bayar);
                        } else {
                            $('.belum_bayar').removeClass('is-invalid')
                            $('.belum_bayarinvalid').html('');
                        }
                        if (response.errors.sudah_bayar){
                            $('.sudah_bayar').addClass('is-invalid')
                            $('.sudah_bayarinvalid').html(response.errors.sudah_bayar);
                        } else {
                            $('.sudah_bayar').removeClass('is-invalid')
                            $('.sudah_bayarinvalid').html('');
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
                            tabletenaker()
                            tampilkodeotomatis()
                            bersih()

                    }else {
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'Data gagal Disimpan',
                            showConfirmButton: false,
                            timer: 3000
                            })
                            tabletenaker()
                            tampilkodeotomatis()
                            bersih()
                    }

                  }
                    
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            }); 
        }else {
            $.ajax({
                url :base_url+'DashboardKelolaProyek/updatetenaker/'+idtenaker,
                data : $(this).serialize(),
                type: 'post',
                dataType : "json",
                beforeSending: function(){
                    $('#btnsimpantenaker').attr('disable','disabled')
                    $('#btnsimpantenaker').html('Menyimpan..')
                },
                complete :function(){
                    $('#btnsimpantenaker').removeAttr('disable')
                    $('#btnsimpantenaker').html('Tambah')
                },
                
                success: function(response) {
                    
                if (response.errors){
                        if (response.errors.namatenaker){
                            $('.namatenaker').addClass('is-invalid')
                            $('.namatenakerinvalid').html(response.errors.namatenaker);
                        } else {
                            $('.namatenaker').removeClass('is-invalid')
                            $('.namatenakerinvalid').html('');
                        }
                        if (response.errors.almttenaker){
                            $('.almttenaker').addClass('is-invalid')
                            $('.almttenakerinvalid').html(response.errors.almttenaker);
                        } else {
                            $('.almttenaker').removeClass('is-invalid')
                            $('.almttenakerinvalid').html('');
                        }
                        if (response.errors.pekerjaan){
                            $('.pekerjaan').addClass('is-invalid')
                            $('.pekerjaaninvalid').html(response.errors.pekerjaan);
                        } else {
                            $('.pekerjaan').removeClass('is-invalid')
                            $('.pekerjaaninvalid').html('');
                        }
                        if (response.errors.gaji){
                            $('.gaji').addClass('is-invalid')
                            $('.gajiinvalid').html(response.errors.gaji);
                        } else {
                            $('.gaji').removeClass('is-invalid')
                            $('.gajiinvalid').html('');
                        }
                        if (response.errors.belum_bayar){
                            $('.belum_bayar').addClass('is-invalid')
                            $('.belum_bayarinvalid').html(response.errors.belum_bayar);
                        } else {
                            $('.belum_bayar').removeClass('is-invalid')
                            $('.belum_bayarinvalid').html('');
                        }
                        if (response.errors.sudah_bayar){
                            $('.sudah_bayar').addClass('is-invalid')
                            $('.sudah_bayarinvalid').html(response.errors.sudah_bayar);
                        } else {
                            $('.sudah_bayar').removeClass('is-invalid')
                            $('.sudah_bayarinvalid').html('');
                        }
                  } else {
                    if (response.affected >= 1){
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Berhasil Diupdate',
                            title: 'Id Tenaker '+response.notifidtenaker+' Atas Nama '+response.notifnamatenaker+' Telah Berhasil Diupdate',
                            showConfirmButton: false,
                            timer: 3000
                            })
                            tabletenaker()
                            tampilkodeotomatis()
                            bersih()

                    }else {
                        Swal.fire({
                            position: 'center',
                            title: 'Tidak Data Yang Diubah',
                            showConfirmButton: false,
                            timer: 3000
                            })
                            tabletenaker()
                            tampilkodeotomatis()
                            bersih()
                    }

                  }
                    
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            }); 
        };
        
    })
   
 })
 $(document).on('click', '#btndetailtenaker', function(){
    let idtenaker = $(this).data('id');
    
    $.ajax({
        url : base_url+"DashboardKelolaProyek/detailtenaker/"+idtenaker,
        dataType : "json",
        success: function(response) {
            $('.detailnamatenaker').html(response[0]['namatenaker'])
            $('.detailidproyek').html('('+response[0]['idproyek']+')')
            $('.detailidtenaker').html(response[0]['idtenaker'])
            $('.detailalamat').html(response[0]['almttenaker'])
            $('.detailpekerjaan').html(response[0]['pekerjaan'])
            $('.detailbelumbayar').html(response[0]['belum_bayar'])
            $('.detailgaji').html(response[0]['gaji'])
            $('.detailsudahbayar').html(response[0]['sudah_bayar'])
            if (response[0]['belum_bayar'] ==0) {
                $('.detailstatus').html('<span class="badge badge-success detailstatus">Lunas</span>');
            } else {
                $('.detailstatus').html('<span class="badge badge-danger detailstatus">Belum Lunas</span>');
            }
            
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }

    });
})
 $(document).on('click', '#btnedittenaker', function(){
    let idtenaker = $(this).data('id');
    let namatk =$(this).data('namatk');
   
    $.ajax({
        url : base_url+"DashboardKelolaProyek/detailtenaker/"+idtenaker,
        dataType : "json",
        success: function(response) {
            $('.namatenaker').val(response[0]['namatenaker'])
            $('.idproyek').val(response[0]['idproyek'])
            $('.idtenaker').val(response[0]['idtenaker'])
            $('.almttenaker').val(response[0]['almttenaker'])
            $('.pekerjaan').val(response[0]['pekerjaan'])
            let belum_bayar = response[0]['belum_bayar']
            let gaji = response[0]['gaji']
            let sudah_bayar =response[0]['sudah_bayar']
            $('.belum_bayar').val(formatRupiah1(belum_bayar))
            $('.gaji').val(formatRupiah1(gaji))
            $('.sudah_bayar').val(formatRupiah1(sudah_bayar))
            $('#btnsimpantenaker').removeClass('btnsimpantenaker')
            $('#btnsimpantenaker').html('Ubah');
            $('#btnsimpantenaker').data('idtenaker',idtenaker);
            $('.sudah_bayar').attr('readonly',true);
            $('.belum_bayar').attr('readonly',true);
            $('.gaji').attr('readonly',true);
            $("#TitleLabel").html('Ubah Data Tenaga Kerja')
        }
    });
    
 })
 $(document).on('click', '#btnhapustenaker', function(){
    let idtenaker = $(this).data('id');
    let namatk =$(this).data('namatk');
    Swal.fire({
    position: 'center',
    icon: 'warning',
    title: 'Yakin Hapus?',
    text: 'Id Tenaker '+idtenaker+' Atas nama '+namatk+' Akan Dihapus',
    showConfirmButton: true,
    showCancelButton: true,
    cancelButtonColor: '#d33',
    cancelButtonText: 'Batal',
    confirmButtonColor: '#3085d6',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url : base_url+"DashboardKelolaProyek/hapustenaker/"+idtenaker,
                dataType : "json",
                success: function(response) {
                    if(response.affected >= 1){
                        tabletenaker()
                        tampilkodeotomatis()
                        bersih()

                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Berhasil Dihapus',
                            text: 'Id Tenaker '+idtenaker+' dan atas nama '+namatk+' Berhasil Dihapus',
                            showConfirmButton: true,
                            })
                    } else {
                        tabletenaker()
                        tampilkodeotomatis()
                        bersih()
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'Gagal Dihapus',
                            text: 'Id Tenaker '+idtenaker+' dan atas nama '+namatk+' Gagal Dihapus',
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
 $(document).on('click', '#btnbayartenaker', function(){
    let idtenaker = $(this).data('id');
    let namatk =$(this).data('namatk');
    console.log('ok');
    
    $.ajax({
        url : base_url+"dashboardkelolaproyek/getdatatenaker/"+idtenaker,
        dataType : "json",
        success: function(response) {
            $('.labelbiaya').html('Biaya : Rp '+response[0]['gaji']);
            
            $('.sudah_bayar2').val(formatRupiah1(response[0]['sudah_bayar']))
            $('.belum_bayar2').val(formatRupiah1(response[0]['belum_bayar']))
            
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
 })
