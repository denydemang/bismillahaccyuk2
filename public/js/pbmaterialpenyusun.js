const base_url ='http://localhost:8080/'
function reset(){
        $('.judulmodal').html('Tambah Material'),
        $('.simpan').html('Simpan') ;
        $('.formmaterialpeyusun').attr('action',base_url+'DashboardAdmin/simpanmaterialpenyusun');
        $('.formmaterialpenyusun').trigger('reset') ;
        $('.idajuan').removeClass('is-invalid')
        $('.namamp').removeClass('is-invalid')
        $('.namamp').attr('readonly', false)
        $('.spesifikasimp').removeClass('is-invalid')
        $('.satuanmp').removeClass('is-invalid')
        $('.jumlahmp').removeClass('is-invalid')
        $('.hargamp').removeClass('is-invalid')
        $('.satuanmp').removeClass('is-invalid')
        $('.totalmp').removeClass('is-invalid')
}function resetmmpr(){
        $('.formmpr').trigger('reset') ;
        $('.namampr').removeClass('is-invalid')
        $('.spesifikasimpr').removeClass('is-invalid')
        $('.satuanmpr').removeClass('is-invalid')
        $('.jumlahmpr').removeClass('is-invalid')
        $('.hargampr').removeClass('is-invalid')
        $('.satuanmpr').removeClass('is-invalid')
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
$(document).ready(function(){
        let berhasil = $('.pesanmaterialpenyusun').data('berhasil')
        let gagal = $('.pesanmaterialpenyusun').data('gagal')
        if (berhasil){
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: berhasil,
                showConfirmButton: false,
                timer: 4000
                })
        } else if(gagal){
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: gagal,
                showConfirmButton: false,
                timer: 4000
                })
        }
    
        $('.hapusmaterial').click(function(){
                let idmaterialpenyusun = $(this).data('id');
                let idmaterial = $(this).data('id2');
                Swal.fire({
                        position: 'center',
                        icon: 'question',
                        title: 'Yakin Hapus ID: '+idmaterialpenyusun,
                        showConfirmButton: true,
                        showCancelButton: true,
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#3085d6',
                        }).then((result) => {
                        if (result.isConfirmed) {
                                window.location.href = base_url+'DashboardAdmin/hapusmaterialpenyusun/' + idmaterialpenyusun+'/'+idmaterial;
                        }
                         })
        // 
        })
        $('.hapusmpr').click(function(){
                let id = $(this).data('id');
                let idmaterial = $(this).data('id2');
                Swal.fire({
                        position: 'center',
                        icon: 'question',
                        title: 'Yakin Hapus ID: '+id,
                        showConfirmButton: true,
                        showCancelButton: true,
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#3085d6',
                        }).then((result) => {
                        if (result.isConfirmed) {
                                window.location.href = base_url+'DashboardAdmin/hapusmpr/' + id+'/'+idmaterial
                        }
                         })
        // 
        })
        $(document).on('submit', '.formmaterialpenyusun', function(e){
                e.preventDefault();
                return false;
        })
        $(document).on('submit', '.formmpr', function(e){
                e.preventDefault();
                return false;
        })
  
        $('.btntambah').click(function(){
                reset();    
        })
        $('#close').click(function(){
                reset();         
        }) 
        $('#closempr').click(function(){
                resetmmpr();         
        })
        $('.btncancel').click(function(){
                reset();         
        }) 
         $('#btncancelmpr').click(function(){
                resetmmpr();         
        })
        $('.btneditmaterial').click(function(){
                let idmaterialpenyusun = $(this).data('id')
                
                $.ajax({
                url : base_url+"DashboardAdmin/getdatampjoin/"+idmaterialpenyusun,
                dataType : "json",
                success: function(response) {
                 console.log(response);
                 
                $('.namamp').attr('readonly',true)
                $('.judulmodal').html('Revisi Material'),
                $('.simpan').html('Revisi') ;
                $('.formmaterialpenyusun').attr('action',base_url+'DashboardAdmin/revisimaterialpenyusun') ;
                $('.idmaterialpenyusun').val(response[0]['idmaterialpenyusun'])
                $('.idmaterial').val(response[0]['idmaterial'])
                $('.idajuan').val(response[0]['idajuan'])
                $('.namamp').val(response[0]['namamp'])
                $('.spesifikasimp').val(response[0]['spesifikasimp']) 
                $('.satuanmp').val(response[0]['satuanmp']) 
                $('.jumlahmp').val(response[0]['jumlahmp']) 
                $('.hargamp').val(formatRupiah1(parseInt(response[0]['hargamp']))) 
                $('.totalmp').val(formatRupiah1(response[0]['totalmp'])) 

                $('.namamp').data('namamp',response[0]['namamp'] )
                $('.spesifikasimp').data('spesifikasimp',response[0]['spesifikasimp'])
                $('.satuanmp').data('satuanmp',response[0]['satuanmp'] )
                $('.jumlahmp').data('jumlahmp',response[0]['jumlahmp'] )
                $('.hargamp').data('hargamp',formatRupiah1(parseInt(response[0]['hargamp'])))
                
                }
                });
                
        })
        $('.btneditmpr').click(function(){
                let id = $(this).data('id')
                
                $.ajax({
                url : base_url+"DashboardAdmin/getdatampr/"+id,
                dataType : "json",
                success: function(response) {
                        console.log(response);
                        
                
                $('.judulmodal').html('Edit Revisi MP')
                $('.idmaterial').val(response['idmaterial'])
                $('.idmaterialpenyusun').val(response['idmaterialpenyusun'])
                $('.namampr').val(response['namamp'])
                $('.spesifikasimpr').val(response['spesifikasimp']) 
                $('.satuanmpr').val(response['satuanmp']) 
                $('.jumlahmpr').val(response['jumlahmp']) 
                $('.hargampr').val(formatRupiah1(parseInt(response['hargamp']))) 
                $('.totalmpr').val(formatRupiah1(response['totalmp'])) 

                $('.namampr').data('namampr',response['namamp'] )
                $('.spesifikasimpr').data('spesifikasimpr',response['spesifikasimp'])
                $('.satuanmpr').data('satuanmpr',response['satuanmp'] )
                $('.jumlahmpr').data('jumlahmpr',response['jumlahmp'] )
                $('.hargampr').data('hargampr',formatRupiah1(parseInt(response['hargamp'])))
                
                },
                error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
                
        })
        $('.btntambah').click(function(){
                $('.namamp').data('namamp','' )
                $('.spesifikasimp').data('spesifikasimp','')
                $('.satuanmp').data('satuanmp','')
                $('.jumlahmp').data('jumlahmp','')
                $('.hargamp').data('hargamp','')
                
        })
        $('.jumlahmp').keyup(function(){
            let qty = parseInt($(this).val());
            let val = $('.hargamp').val();
            let harga = parseInt(val.replace(/[^0-9/]/g,''));
            let total = qty * harga
            
            $('.totalmp').val(formatRupiah1(total));
        })
         $('.jumlahmpr').keyup(function(){
            let qty = parseInt($(this).val());
            let val = $('.hargampr').val();
            let harga = parseInt(val.replace(/[^0-9/]/g,''));
            let total = qty * harga
            
            $('.totalmpr').val(formatRupiah1(total));
        })
        $('.hargamp').keyup(function(){
            $(this).val(formatRupiahtyping($(this).val()))
            let val = $(this).val();
            let harga = parseInt(val.replace(/[^0-9/]/g,''))
            let qty = $('.jumlahmp').val();
            let total = qty * harga
            
            $('.totalmp').val(formatRupiah1(total));
        })
        $('.hargampr').keyup(function(){
            $(this).val(formatRupiahtyping($(this).val()))
            let val = $(this).val();
            let harga = parseInt(val.replace(/[^0-9/]/g,''))
            let qty = $('.jumlahmpr').val();
            let total = qty * harga
            
            $('.totalmpr').val(formatRupiah1(total));
        })
        $('.tablematerial').DataTable({
        "pageLength": 5,
        "fixedColumns": {
                leftColumns: 1,
                rightColumns: 1
                },
        "lengthChange": false
        });
})