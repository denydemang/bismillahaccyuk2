const base_url = 'http://localhost:8080/'

function resetawal() {
    $('.namabahan').removeClass('is-invalid')
    $('.harga').removeClass('is-invalid');
    $('.jumlah_beli').removeClass('is-invalid');
    $(".formbbproses").trigger('reset');
    $('#modalbb').modal('hide');
}

function reset() {
    $('.namabahan').removeClass('is-invalid')
    $('.harga').removeClass('is-invalid');
    $('.jumlah_beli').removeClass('is-invalid');
    $(".formbbproses").trigger('reset');
}

function tampiltableproses() {
    $.ajax({
        url: base_url + 'TampilTable/tablebbproses',
        dataType: "json",
        success: function (response) {
            $('#tampiltablebb').html(response.databb);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
};
const formatRupiahtyping = (money) => {
    angka = money.replace(/[^,\d]/g, "");
    if (isNaN(angka)) {
        angka = 0;
    }
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(angka);
}
const formatRupiah1 = (money) => {
    if (isNaN(money)) {
        money = 0;
    }
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(money);
}

function tampilkodeotomatis() {
    $.ajax({
        url: base_url + "/DashboardKelolaProyek/tampilkodeotomatis",
        dataType: "json",
        success: function (response) {
            $('.idproyek').val(response.idproyek)
            $('.idbelibahan').val(response.idbeli);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        },
    });
}
$(document).ready(function () {
    tampiltableproses();
    tampilkodeotomatis();
    $('#harga').keyup(function () {
        console.log('ok');

        $(this).val(formatRupiahtyping($(this).val()));
        val = $(this).val()
        let str = val.replace(/[^0-9/]/g, '');
        let harga = parseInt(str);

        val2 = $('#jumlah_beli').val();
        let str2 = val2.replace(/[^0-9/]/g, '');
        let jumlah_beli = parseInt(str2);

        let total = harga * jumlah_beli;

        $('#totalharga').val(formatRupiah1(total));

    })
    $('#jumlah_beli').keyup(function () {

        val = $(this).val()
        let jumlah_beli = parseInt(val);

        val2 = $('#harga').val();
        let str2 = val2.replace(/[^0-9/]/g, '');
        let harga = parseInt(str2);

        total = jumlah_beli * harga;
        $('#totalharga').val(formatRupiah1(total));


    })
    $('.belum_bayar').keyup(function () {
        $(this).val(formatRupiahtyping($(this).val()));
        val = $(this).val()
        let str = val.replace(/[^0-9/]/g, '');
        belum_bayar = parseInt(str);

        val2 = $('#sudah_bayar').val();
        let str2 = val2.replace(/[^0-9/]/g, '');
        sudah_bayar = parseInt(str2);

        val3 = $('#gaji').val();
        let str3 = val3.replace(/[^0-9/]/g, '');
        gaji = parseInt(str3);

        sudah_bayar = gaji - belum_bayar;

        if (gaji < sudah_bayar || gaji < belum_bayar) {
            $('.sudah_bayar').val('');
            $('.belum_bayar').val('');
        } else {
            $('.sudah_bayar').val(formatRupiah1(sudah_bayar))
        }

    })


    //agar field tgl tidak bisa diisi manual
    $(".tgl_beli").on('keydown paste focus mousedown', function (e) {
        if (e.keyCode != 9) // ignore tab
            e.preventDefault();
    });

    $('.tgl_beli').dtDateTime();
    $('.close').click(function () {
        resetawal()
    })

    $('#btntambahbahanbaku').click(function () {
        resetawal();
        tampilkodeotomatis()
    })
    $('.btnclear').click(function () {
        reset();
        tampilkodeotomatis();

    })

    $('#formbbproses').submit(function (e) {
        e.preventDefault();
        let Id_pbb = $('#btnsimpanbbproses').data('id_pbb')
        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'post',
            dataType: "json",
            beforeSending: function () {
                $('#btnsimpanbbproses').attr('disable', 'disabled')
                $('#btnsimpanbbproses').html('Memproses..')
            },
            complete: function () {
                $('#btnsimpanbbproses').removeAttr('disable')
                $('#btnsimpanbbproses').html('<i class="fas fa-money-bill mr-2"></i> Beli')
            },

            success: function (response) {
                if (response.errors) {
                    if (response.errors.jumlah_beli) {
                        $('.jumlah_beli').addClass('is-invalid')
                        $('.jumlah_beliinvalid').html(response.errors.jumlah_beli);
                    } else {
                        $('.jumlah_beli').removeClass('is-invalid')
                        $('.jumlah_beliinvalid').html('');
                    }
                    if (response.errors.tgl_beli) {
                        $('.tgl_beli').addClass('is-invalid')
                        $('.tgl_beliinvalid').html(response.errors.tgl_beli);
                    } else {
                        $('.tgl_beli').removeClass('is-invalid')
                        $('.tgl_beliinvalid').html('');
                    }
                } else {
                    if (response.affected >= 1) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'ID Bahan Baku '+Id_pbb+' Berhasil Dibeli',
                            showConfirmButton: false,
                            timer: 3000
                        })
                        tampiltableproses();
                        tampilkodeotomatis();
                        resetawal()
                        // bersih()

                    } else {
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'gagal dibeli',
                            showConfirmButton: false,
                            timer: 3000
                        })
                        tampiltableproses();
                        tampilkodeotomatis();
                        resetawal()
                        // bersih()
                    }

                }
            

            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
        

    })
    $(document).on('click', '.belibb', function () {
        let id_pbb = $(this).data('id_pbb');
        $.ajax({
            url: base_url + "DashboardKelolaProyek/getdatabahanbaku/" + id_pbb,
            dataType: "json",
            success: function (response) {
                $('.namabahan').val(response[0]['namabahan'])
                $('.harga').val(formatRupiah1(parseInt(response[0]['harga'])))
                $('.jumlah_beliawal').val(response[0]['jumlah_beli'])
                $('.id_pbb').val(response[0]['id_pbb'])
                $('#btnsimpanbbproses').data('id_pbb' , id_pbb)
                tampilkodeotomatis()
                // $('.namabahan').val(response[0]['namabahan'])
                // $('.tgl_beli').val(response[0]['tgl_beli'])
                // $('.ukuran').val(response[0]['ukuran'])
                // $('.kualitas').val(response[0]['kualitas'])
                // $('.jenis').val(response[0]['jenis'])
                // $('.berat').val(response[0]['berat'])
                // $('.ketebalan').val(response[0]['ketebalan'])
                // $('.panjang').val(response[0]['panjang'])
                // $('.harga').val(formatRupiah1(parseInt(response[0]['harga'])))
                // $('.jumlah_beli').val(response[0]['jumlah_beli'])
                // let totalharga = (parseInt(response[0]['harga']) * parseInt(response[0]['jumlah_beli']))
                // $('.totalharga').val(formatRupiah1(parseInt(totalharga)))
                // $('#btnsimpanbbproses').removeClass('btnsimpanbbproses')
                // $('#btnsimpanbbproses').html('Ubah');
                // $('#btnsimpanbbproses').data('idbelibahan', idbelibahan);
                // $('.judulmodal').html('Edit Bahan Baku');


            }
        });

    });

    $(document).on('click', '.hapusbbproses', function () {
        let idbeli = $(this).data('id');
        let namabahan = $(this).data('namabahan');
        Swal.fire({
            position: 'center',
            icon: 'warning',
            title: 'Yakin Hapus?',
            text: 'Id Beli ' + idbeli + ' Atas nama ' + namabahan + ' Akan Dihapus',
            showConfirmButton: true,
            showCancelButton: true,
            cancelButtonColor: '#d33',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#3085d6',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: base_url + "DashboardKelolaProyek/hapusbbproses/" + idbeli,
                    dataType: "json",
                    success: function (response) {
                        if (response.affected >= 1) {
                            tampiltableproses();
                            tampilkodeotomatis();
                            resetawal()

                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Berhasil Dihapus',
                                text: 'Id Beli ' + idbeli + ' dan Nama Bahan ' + namabahan + ' Berhasil Dihapus',
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
                                text: 'Id Beli ' + idbeli + ' dan Nama Bahan ' + namabahan + ' Gagal Dihapus',
                                showConfirmButton: true,
                            })
                        }

                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            }
        })
    })

    $(document).on('click', '.detailbbproses', function () {
        console.log('ok');
        let idbelibahan = $(this).data('id');
        $.ajax({
            url: base_url + "DashboardKelolaProyek/detailbbproses/" + idbelibahan,
            dataType: "json",
            success: function (response) {

                console.log(response);

                $('.detailnamabahan').html(response[0]['namabahan'])
                $('.detailidbelibahan').html("(" + response[0]['idbelibahan'] + ")")
                $('.detailnamaproyek').html(response[0]['namaproyek'])
                $('.detailidproyek').html('(' + response[0]['idproyek'] + ")")
                $('.detailtgl_beli').html(response[0]['tgl_beli'])
                $('.detailukuran').html(response[0]['ukuran'])
                $('.detailkualitas').html(response[0]['kualitas'])
                $('.detailjenis').html(response[0]['jenis'])
                $('.detailberat').html(response[0]['berat'])
                $('.detailketebalan').html(response[0]['ketebalan'])
                $('.detailpanjang').html(response[0]['panjang'])
                $('.detailharga').html(formatRupiah1(parseInt(response[0]['harga'])))
                $('.detailjumlah_beli').html(response[0]['jumlah_beli'])
                let totalharga = (parseInt(response[0]['harga']) * parseInt(response[0]['jumlah_beli']))
                $('.detailtotal').html(formatRupiah1(parseInt(totalharga)))
                // $('#btnsimpanbbproses').removeClass('btnsimpanbbproses')
                // $('#btnsimpanbbproses').html('Ubah');
                // $('#btnsimpanbbproses').data('idbelibahan',idbelibahan);
                // $('.judulmodal').html('Edit Bahan Baku');


            }
        });
    })



})