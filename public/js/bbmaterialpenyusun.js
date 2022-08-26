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
const base_url ='http://localhost:8080/'
$(document).ready(function(){
    $("#modalbb").on('shown.bs.modal', function(){
        $('.harga').focus();
        console.log('demang');
        
    });
    $('.btnviewmp').click(function(){
      let id = $(this).data('id');
      console.log(id);
        
      $.ajax({
        
          url : base_url+"DashboardKelolaProyek/getdetailmp/"+id,
          dataType : "json",
          success: function(response) {
            console.log(response);
            
            $('.nm').html(response[0]['namamp'])
            $('.sm').html(response[0]['satuanmp'])
            $('.qty').html(response[0]['jumlahmp'])
            $('.hg').html(formatRupiah1(response[0]['hargamp']))
            $('.tot').html(formatRupiah1(parseInt(response[0]['totalmp'])))

            $('.nm1').html(response[0]['namamp'])
            $('.sm1').html(response[0]['satuanmp'])
            $('.qty1').html(response[0]['jumlahmp'])
            $('.hg1').html(formatRupiah1(response[0]['harga_beli']))
            $('.tot1').html(formatRupiah1(parseInt(response[0]['totalharga'])))

            let selisih= parseInt(response[0]['totalmp'])-parseInt(response[0]['totalharga'])
            $('.selisih').html(formatRupiah1(selisih))
           
            // $('.gtbr').html(formatRupiah1(response.gtbr))
    
            // $('.gtbb').html(formatRupiah1(response.totalrevisi))
            // // let tot = parseInt(response.datamaterial['qtymaterial']) * parseInt(response.datamaterial['hargamaterial']);
            // // (tot) ? $('.tot').html(tot) : $('.tot').html('Belum Dihitung');
            // // // $('.gtbr').html(response.totalbahanrevisi)
            // // // $('.gt').html(response.grandtotal)
            // // // let tot = parseInt(response.datamaterial['qtymaterial']) * parseInt(response.datamaterial['']);
            // // // (tot) ? $('.tot').html(tot) : $('.tot').html('Belum Dihitung');
            // // // (response.datamaterial['hargamaterial']== '0') ? $('.hg').html('Belum Dihitung') : $('.hg').html(response.datamaterial['hargamaterial']) ;
            // if(response.datapenyusun.length != 0){
                  
            //     $.each(response.datapenyusun, function(key, value) {
                       
            //             html = '<tr class="ada">'+
            //                 '<td>' + value.namamp + '</td>' +
            //                 '<td>' + value.spesifikasimp + '</td>' +
            //                 '<td>' + value.jumlahmp + '</td>' +
            //                 '<td>' + value.satuanmp + '</td>' +
            //                 '<td>' + formatRupiah1(value.harga_beli) + '</td>' +
            //                 '<td>' + formatRupiah1(value.totalharga) + '</td>' +
            //             '</tr>';   
                    
            //             $('.bahanpenyusun tr').first().after(html);
            //         });
                
                       
            //   } else {
            //     html = 
            //     '<tr id="kosong">'+
            //          '<td>Tidak Ada Data</td>' +
            //          '<td>TIdak Ada Data</td>' +
            //          '<td>Tidak Ada Data</td>' +
            //          '<td>Tidak Ada Data</td>' +
            //          '<td>Tidak Ada Data</td>' +
            //          '<td>Tidak Ada Data</td>' +
            //      '</tr>';   
            //      $('.bahanpenyusun tr').first().after(html);
      
                
            //   }
          }
      });
     
    })
    $('#tgl_beli').datepicker();
    $('.btnbeli').click(function(){
        let id = $(this).data('id');
        $('.harga').focus()
        console.log('ok');
        console.log(id);
        $.ajax({
            url : base_url+"DashboardKelolaProyek/getdatamp/"+id,
            dataType : "json",
            success: function(response) {
                console.log(response);
                $('.idmaterialpenyusun').val(response.idmaterialpenyusun)
                $('.idmaterial').val(response.idmaterial)
                $('.namamp').val(response.namamp)
                $('.jumlahmp').val(response.jumlahmp)
                $('.hargamp').val(formatRupiah1(response.hargamp))
                
            }
        });
    })
   $('.harga').keyup(function(){
    $(this).val(formatRupiahtyping($(this).val()))
    let val = $(this).val()
    let harga= parseInt(val.replace(/[^0-9/]/g,''))
    let val2 = $('.jumlahmp').val();
    let qty = parseInt(val2.replace(/[^0-9/]/g,''));
    let total = qty * harga

    $('.totalharga').val(formatRupiah1(total));

   })
   $('.btnview').click(function(){
    let id = $(this).data('id');
    $('.ada').remove();
    $('.kosong').remove();
    $('#kosong').remove();
    $('.gtbb').html('');
    $('.gtbr').html('');
    $('.gt').html('');
    $.ajax({
        url : base_url+"DashboardKelolaProyek/getdetailmaterialpenyusun/"+id,
        dataType : "json",
        success: function(response) {
          console.log(response);
          
          let namamp= response.datampasli[0]['namamp']
          let spsifikasimp =response.datampasli[0]['spesifikasimp']
          let satuanmp= response.datampasli[0]['satuanmp']
          let jumlahmp= response.datampasli[0]['jumlahmp']
          let hargamprab =response.datampasli[0]['hargamp']
          let totalmprab  =response.datampasli[0]['totalmp']

          let hargampasli =response.datampasli[0]['harga_beli']
          let totalmpasli  =response.datampasli[0]['totalharga']

          let keuntungan = totalmprab - totalmpasli
          
       
            $('.namamaterialdetail').html(namamp)
            $('.spesifikasidetail').html(spsifikasimp)
            $('.satuandetail').html(satuanmp)
            $('.qtydetail').html(jumlahmp)
            $('.hgdetail').html(formatRupiah1(parseInt(hargamprab)))
            $('.totdetail').html(formatRupiah1(parseInt(totalmprab)))
  
                
            $('.namamaterials').html(namamp)
            $('.spesifikasis').html(spsifikasimp)
            $('.satuans').html(satuanmp)
            $('.qtys').html(jumlahmp)
            $('.hgs').html(formatRupiah1(parseInt(hargampasli)))
            $('.tots').html(formatRupiah1(parseInt(totalmpasli)))
        

            $('.keuntungan').html(formatRupiah1(parseInt(keuntungan)))

        }
    });
    
   }) 
 
       
        
})