const base_url ='http://localhost:8080/'
function reset(){
        $('.judulmodal').html('Tambah Material'),
        $('.simpan').html('Simpan') ;
        $('.formmaterial').attr('action',base_url+'DashboardAdmin/simpanmaterial') ;
        $('.pilihajuan').show() ;
        $('.formmaterial').trigger('reset') ;
        $('.idajuan').removeClass('is-invalid')
        $('.namamaterial').removeClass('is-invalid')
        $('.jenismaterial').removeClass('is-invalid')
        $('.satuanmaterial').removeClass('is-invalid')
        $('.qtymaterial').removeClass('is-invalid')
}
$(document).ready(function(){
        let pesan = $('.pesanmaterial').data('pesanmaterial')
        if (pesan == 'Berhasil Disimpan'){
                Swal.fire({
                position: 'center',
                icon: 'success',
                title: pesan,
                showConfirmButton: false,
                timer: 4000
                })
        } else if(pesan == 'Data Berhasil Diupdate'){
                Swal.fire({
                position: 'center',
                icon: 'success',
                title: pesan,
                showConfirmButton: false,
                timer: 4000
                })
                
        }
        else if(pesan == 'Tidak Ada Data Yang Diubah'){
                Swal.fire({
                position: 'center',
                icon: 'info',
                title: pesan,
                showConfirmButton: false,
                timer: 4000
                })
                
        } else if(pesan == 'Berhasil DiHapus'){
                Swal.fire({
                position: 'center',
                icon: 'success',
                title: pesan,
                showConfirmButton: false,
                timer: 4000
                })
                
        } else if (pesan =="Data Gagal Diupdate"){
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: pesan,
                    showConfirmButton: false,
                    timer: 4000
                    })
                }
          else if (pesan =='Gagal Disimpan'){
                Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: pesan,
                        showConfirmButton: false,
                        timer: 4000
                        })
                    
          }       
       

        $('.btndetailmaterial').click(function(){
                let idmaterial = $(this).data('id')
                console.log(idmaterial);
                
                $.ajax({
                url : base_url+"DashboardAdmin/getmaterialdanpenyusun/"+idmaterial,
                dataType : "json",
                success: function(response) {
                        let totalmp = response.totalmp[0]['totalmp'];
                     
                        
                       $('.nm').html(response.datamaterial['namamaterial'])
                       $('.jm').html(response.datamaterial['jenismaterial'])
                       $('.ia').html(response.datamaterial['idajuan'])
                       $('.sm').html(response.datamaterial['satuanmaterial'])
                       $('.qty').html(response.datamaterial['qtymaterial'])
                       $('.gt').html(totalmp)

                      
                      let tot = parseInt(response.datamaterial['qtymaterial']) * parseInt(response.datamaterial['hargamaterial']);
                      (tot) ? $('.tot').html(tot) : $('.tot').html('Belum Dihitung');
                      (response.datamaterial['hargamaterial']== '0') ? $('.hg').html('Belum Dihitung') : $('.hg').html(response.datamaterial['hargamaterial']) ;
                       
                      if(response.datapenyusun.length == 0){
                        $('.kosong').remove();
                        $('.ada').remove();
                        var html = 
                               '<tr class="kosong">'+
                                    '<td>Tidak Ada Data</td>' +
                                    '<td>TIdak Ada Data</td>' +
                                    '<td>Tidak Ada Data</td>' +
                                    '<td>Tidak Ada Data</td>' +
                                    '<td>Tidak Ada Data</td>' +
                                    '<td>Tidak Ada Data</td>' +
                                '</tr>';   

                                $('.bahanpenyusun tr').first().after(html);
                      } else {
                        $.each(response.datapenyusun, function(key, value) {
                                $('.kosong').remove();
                                var html = '<tr class="ada">'+
                                    '<td>' + value.namamp + '</td>' +
                                    '<td>' + value.spesifikasimp + '</td>' +
                                    '<td>' + value.jumlahmp + '</td>' +
                                    '<td>' + value.satuanmp + '</td>' +
                                    '<td>' + value.hargamp + '</td>' +
                                    '<td>' + value.totalmp + '</td>' +
                                '</tr>';   
                            
                                $('.bahanpenyusun tr').first().after(html);
                            });
                      }
                       
                        
                },
                error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
                
                
        }) 
       
        $('.hapusmaterial').click(function(){
                let idmaterial = $(this).data('id');
                Swal.fire({
                        position: 'center',
                        icon: 'question',
                        title: 'Yakin Hapus ID: '+idmaterial,
                        showConfirmButton: true,
                        showCancelButton: true,
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#3085d6',
                        }).then((result) => {
                        if (result.isConfirmed) {
                                window.location.href = base_url+'DashboardAdmin/hapusmaterial/' + idmaterial;
                        }
                         })
        // 
        })
        $('.daftarajuan').DataTable({
                "lengthChange": false,
                "fixedHeader": true,
                "info": false,
                "paging": false,
                "scrollY": '150px',
                "scrollCollapse": true,
        })
        $('.btntambah').click(function(){
                reset();    
        })
        $('.btnidajuan').click(function(){
        let idajuan = $(this).data('id');
                $('.idajuan').val(idajuan);
        })
        $('.close').click(function(){
                reset();         
        })
        $('.btncancel').click(function(){
                reset();         
        })

        $('.btneditmaterial').click(function(){
                let idmaterial = $(this).data('id')
                
                $.ajax({
                url : base_url+"DashboardAdmin/getmaterialdanpenyusun/"+idmaterial,
                dataType : "json",
                success: function(response) {
                $('.judulmodal').html('Edit Material'),
                $('.simpan').html('Edit') ;
                $('.formmaterial').attr('action',base_url+'DashboardAdmin/updatematerial') ;
                $('.pilihajuan').hide() ;
                $('.namamaterial').val(response.datamaterial['namamaterial'])
                $('.idajuan').val(response.datamaterial['idajuan']) 
                $('.idmaterial').val(response.datamaterial['idmaterial'])  
                $('.jenismaterial').val(response.datamaterial['jenismaterial'])
                $('.qtymaterial').val( response.datamaterial['qtymaterial'])     
                $('.satuanmaterial').val( response.datamaterial['satuanmaterial'])     
                $('.hargamaterial').val(response.datamaterial['hargamaterial']);     
                let demang =$('.formmaterial').attr('action')
                console.log(demang);
                     
                }
                });
                
        })

        $('.tablematerial').DataTable({
        "fixedColumns": {
                leftColumns: 1,
                rightColumns: 1
                },
        });
})