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

const base_url = 'http://localhost:8080/'
$(document).ready(function(){
       $('.btndetail').click(function(){
        let id = $(this).data('id');
        $('.ada').remove();
        $('.kosong').remove();
        $('#kosong').remove();
        $('.gtbb').html('');
        $('.gtbr').html('');
        $('.gt').html('');
        $.ajax({
            url : base_url+"DashboardKelolaProyek/getdetailmaterial/"+id,
            dataType : "json",
            success: function(response) {
                console.log(response);
                $('.nm').html(response.datamaterial['namamaterial'])
                $('.jm').html(response.datamaterial['jenismaterial'])
                $('.ia').html(response.datamaterial['idajuan'])
                $('.sm').html(response.datamaterial['satuanmaterial'])
                $('.qty').html(response.datamaterial['qtymaterial'])
                $('.hg').html(formatRupiah1(response.totalrevisi))
                $('.tot').html(formatRupiah1(parseInt(response.datamaterial['qtymaterial'])*parseInt(response.totalrevisi)))
                // $('.gtbr').html(formatRupiah1(response.gtbr))

                $('.gtbb').html(formatRupiah1(response.totalrevisi))
                // let tot = parseInt(response.datamaterial['qtymaterial']) * parseInt(response.datamaterial['hargamaterial']);
                // (tot) ? $('.tot').html(tot) : $('.tot').html('Belum Dihitung');
                // // $('.gtbr').html(response.totalbahanrevisi)
                // // $('.gt').html(response.grandtotal)
                // // let tot = parseInt(response.datamaterial['qtymaterial']) * parseInt(response.datamaterial['']);
                // // (tot) ? $('.tot').html(tot) : $('.tot').html('Belum Dihitung');
                // // (response.datamaterial['hargamaterial']== '0') ? $('.hg').html('Belum Dihitung') : $('.hg').html(response.datamaterial['hargamaterial']) ;
                if(response.datapenyusun.length != 0){
                      
                    $.each(response.datapenyusun, function(key, value) {
                           
                            html = '<tr class="ada">'+
                                '<td>' + value.namamp + '</td>' +
                                '<td>' + value.spesifikasimp + '</td>' +
                                '<td>' + value.jumlahmp + '</td>' +
                                '<td>' + value.satuanmp + '</td>' +
                                '<td>' + formatRupiah1(value.harga_beli) + '</td>' +
                                '<td>' + formatRupiah1(value.totalharga) + '</td>' +
                            '</tr>';   
                        
                            $('.bahanpenyusun tr').first().after(html);
                        });
                    
                           
                  } else {
                    html = 
                    '<tr id="kosong">'+
                         '<td>Tidak Ada Data</td>' +
                         '<td>TIdak Ada Data</td>' +
                         '<td>Tidak Ada Data</td>' +
                         '<td>Tidak Ada Data</td>' +
                         '<td>Tidak Ada Data</td>' +
                         '<td>Tidak Ada Data</td>' +
                     '</tr>';   
                     $('.bahanpenyusun tr').first().after(html);

                    
                  }
                  // if(response.datarevisi.length != 0){
                  //   $.each(response.datarevisi, function(key, value) {
                           
                  //           html = '<tr class="ada">'+
                  //               '<td>' + value.namamp + '</td>' +
                  //               '<td>' + value.spesifikasimp + '</td>' +
                  //               '<td>' + value.jumlahmp + '</td>' +
                  //               '<td>' + value.satuanmp + '</td>' +
                  //               '<td>' + formatRupiah1(value.hargamp) + '</td>' +
                  //               '<td>' + formatRupiah1(value.totalmp) + '</td>' +
                  //           '</tr>';   
                        
                  //           $('.bahanpenyusunrevisi tr').first().after(html);
                  //       });

                  // }else {
                  //   html = 
                  //   '<tr id="kosong">'+
                  //        '<td>Tidak Ada Data</td>' +
                  //        '<td>TIdak Ada Data</td>' +
                  //        '<td>Tidak Ada Data</td>' +
                  //        '<td>Tidak Ada Data</td>' +
                  //        '<td>Tidak Ada Data</td>' +
                  //        '<td>Tidak Ada Data</td>' +
                  //    '</tr>';   
                  //    $('.bahanpenyusunrevisi tr').first().after(html);

                  // }
                   
                
            }
        });
        
       }) 
})