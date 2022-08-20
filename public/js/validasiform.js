$.validator.addMethod( "numberonly", function( value, element ) {
	return this.optional( element ) || /^[0-9]*$/i.test( value );
}, "Number only please." );
jQuery.validator.addMethod("hanyahuruf", function(value, element) {
    return this.optional(element) || /^[a-z\s]+$/i.test(value);
    }, "Only alphabetical characters");
jQuery.validator.addMethod("pwlogic", function(value, element) {
    return this.optional(element) || /\d/.test(value) && /[a-z]/i.test(value);
    }, "Harus mengandung angka dan huruf");

    $.validator.addMethod( "hapeindo", function( phone_number, element ) {
        return this.optional( element ) || phone_number.match(/^(\+62|62|0)8[1-9][0-9]{6,9}$/);
    }, 'Nomor Hp Tidak Valid' );
    $.validator.addMethod( "emailbener", function( email, element ) {
        return this.optional( element ) || email.match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/);
    }, 'Email Tidak Valid' );
$.validator.addMethod('filesize', function (value, element,param) {
   
        var size=element.files[0].size;
       
        size=size/1024;
        size=Math.round(size);
        return this.optional(element) || size <=param ;
        
      }, 'File size must be less than {0}');
$.validator.addMethod("nowhitespace", function(value, element) {
        return this.optional(element) || /^\S+$/i.test(value);
    }, "No white space please");
$(document).ready(function(){

    //Validasi Form Registrasi
    $('#formregistrasi').each(function(){
        $(this).validate({
            rules: {
                nama: {
                    required: true,
                    hanyahuruf: true
            },  email: {
                    required: true,
                    emailbener: true,
                    email: true
            },  username: {
                    required: true,
                    minlength: 7,
                    nowhitespace : true,
                    
            }, telpon: {
                    required: true,
                    // minlength: 10,
                    // maxlength: 13,
                    hapeindo: true,
            }, alamat: {
                    required: true,
                    minlength: 4,
            }, password: {
                    required: true,
                    minlength: 5,
                    pwlogic: true
            },  
            konfirpassword: {
                    required: true,
                    equalTo: "#password"
            }

        },
            messages: {
                nama: {
                    required: 'Nama Tidak Boleh Kosong',
                    hanyahuruf: 'Nama Tidak Boleh Mengandung Angka'
            },  email: {
                    required: 'Email Tidak Boleh Kosong',
                   email: 'Email Tidak Valid'
            }, username: {
                    required: 'Username Tidak Boleh Kosong',
                    minlength: 'Username Minimal 7 karakter',
                    nowhitespace: 'Tidak Boleh Ada Spasi'
                    
            },  telpon: {
                    required: 'No. Telp Tidak Boleh Kosong',
                    // minlength: 'No Telp Minimal 10 digit',
                    // maxlength: 'No Telpon Maksimal 13 digit'
            },  alamat: {
                    required: 'Alamat Tidak Boleh Kosong',  
                    minlength: 'Alamat tidak valid', 
                    
            },  password: {
                    required: 'Password Tidak Boleh Kosong',
                    minlength: 'Password min 5 karakter',
          
            },  konfirpassword: {
                    required: 'Ulangi Password',
                    equalTo: 'Password Tidak Sama',
            },   
            
        },  errorElement: "div",
        errorPlacement: function ( error, element ) {

	        // Add the `invalid-feedback` class to the error element
	        error.addClass( "invalid-feedback" );
            error.addClass("pesanerror");
	        if ( element.prop( "type" ) === "checkbox" ) {
	            error.insertAfter(element.next( "label" ));
	        } else {
	            error.insertAfter(element);
	        }
	    },
        highlight: function ( element, errorClass, validClass ) {
	        $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
	    },
	    unhighlight: function (element, errorClass, validClass) {
	        $( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
	    },
            submitHandler: function (form) {
                
                    form.submit();

                }


        
        })
    })
    // End Validasi Form Registrasi

    //Validasi Form Ajuan Proyek
    $('#formajuanproyek').each(function(){
        $(this).validate({
            rules: {
                namaproyek : {
                    required : true,
                },
                jenisproyek : {
                required : true,
                },
                lokasiproyek : {
                required : true,
                },
                anggaran : {
                required : true,
                },
                jadwalproyek : {
                required : true,
                },
                uploadfile : {
                    required : true, 
                    extension: "jpg,jpeg,png,pdf,rar,docx,doc,zip",
                    filesize: 10000,
                }
                
            },
            messages: {
                namaproyek : {
                    required: 'Nama Proyek Wajib Diisi'
                },
                jenisproyek : {
                    required: 'Jenis Proyek Wajib Diisi'
                },
                lokasiproyek : {
                    required: 'Lokasi Proyek Wajib Diisi'
                },   
                anggaran : {
                    required: 'Anggaran Proyek Wajib Diisi'
                },   
                jadwalproyek : {
                    required: 'Jadwal Proyek Wajib Diisi'
                },   
                uploadfile : {
                    required: 'Silakan Upload File Pendukung',
                    extension: 'Masukkan File Gambar, Pdf , Atau rar',
                    filesize: 'File Tidak Boleh Melebihi 10MB'
                },
              
            },
            errorElement: "div",
            errorPlacement: function ( error, element ) {
                // if (element.is(":file")) {
                //     error.appendTo( element.parents('.jeniskelamin') );

                // } else {
                    
	        // Add the `invalid-feedback` class to the error element
                error.addClass( "invalid-feedback" );
                error.insertAfter(element);
    

                // }

	    
	    },
        highlight: function ( element, errorClass, validClass ) {
            $( element ).addClass( "is-invalid" )
            
        },
        unhighlight: function (element, errorClass, validClass) {
	        $( element ).removeClass( "is-invalid" );
	    },
        submitHandler: function (form) {
            form.submit();

            }

        })
    })

    //Validasi Form Buat Proyek
    $('#buatproyek').each(function(){
        $(this).validate({
            rules: {
                idajuan : {
                    required : true,
                },
                user_id : {
                required : true,
                },
                namaproyek : {
                required : true,
                },
                jenisproyek : {
                required : true,
                },
                nama : {
                required : true,
                },
                biaya : {
                required : true,
                },
                sudahbayar : {
                required : true,
                },
                belumbayar : {
                required : true,
                },
                
            },
            messages: {
                idajuan : {
                    required: 'Id Ajuan Proyek Wajib Diisi'
                },
                user_id : {
                    required: 'Id Klien Proyek Wajib Diisi'
                },
                namaproyek : {
                    required: 'Nama Proyek Wajib Diisi'
                },
                jenisproyek : {
                    required: 'Jenis Proyek Diisi'
                },
                nama : {
                    required: 'Nama Wajib Diisi'
                },
                biaya : {
                    required: 'Tidak Boleh Kosong'
                },
                sudahbayar : {
                    required: 'Tidak Boleh Kosong'
                },
                belumbayar : {
                    required: 'Tidak Boleh Kosong',
                },
            },
            errorElement: "div",
            errorPlacement: function ( error, element ) {

	        // Add the `invalid-feedback` class to the error element
	        error.addClass( "invalid-feedback" );
	        error.insertAfter(element);
    
	    
	    },
        highlight: function ( element, errorClass, validClass ) {
            $( element ).addClass( "is-invalid" )
        },
        unhighlight: function (element, errorClass, validClass) {
	        $( element ).removeClass( "is-invalid" );
	    },
        submitHandler: function (form) {
            form.submit();

            }

        })
    })

    //Validasi Kirim Email
    $('#formkirimemail').each(function(){
        $(this).validate({
            rules: {
                penerimaemail : {
                    required : true,
                },
                subjectemail : {
                required : true,
                },
                pesanemail : {
                required : true,
                },
                uploadfileemail: {
                required : true,
                extension: "jpg,jpeg,png,pdf,rar,docx,doc,zip",
                filesize: 5000,
                },
                
            },
            messages: {
                penerimaemail : {
                    required: 'Penerima Email Wajib Diisi'
                },
                subjectemail : {
                    required: 'Subject Email Wajib Diisi'
                },
                pesanemail : {
                    required: 'Silakan Tulis Pesan Ke Klien'
                },
                uploadfileemail : {
                    required: 'Silakan Upload File',
                    extension: "Masukkan File Gambar atau Pdf",
                    filesize: 'File maksimal 5mb',
                },
            },
            errorElement: "div",
            errorPlacement: function ( error, element ) {
                

	        // Add the `invalid-feedback` class to the error element
	        error.addClass( "invalid-feedback" );
	        error.insertAfter(element);
                

    
	    
	    },
        highlight: function ( element, errorClass, validClass ) {
            $( element ).addClass( "is-invalid" )
        },
        unhighlight: function (element, errorClass, validClass) {
	        $( element ).removeClass( "is-invalid" );
	    },
        submitHandler: function (form) {
            form.submit();

            }

        })
    })
    $('.formpermintaanmeeting').each(function(){
        $(this).validate({
            rules: {
                namameeting : {
                    required : true,
                },
                tanggalmeeting : {
                required : true,
                },
                lokasimeeting : {
                required : true,
                },
                
                
            },
            messages: {
                namameeting : {
                    required: 'Silakan Isi Nama Meeting'
                },
                tanggalmeeting : {
                    required: 'Tanggal Meeting Wajib Diisi'
                },
                lokasimeeting : {
                    required: 'Lokasi Meeting Wajib Diisi'
                },
             
            },
            errorElement: "div",
            errorPlacement: function ( error, element ) {
                

	        // Add the `invalid-feedback` class to the error element
	        error.addClass( "invalid-feedback" );
	        error.insertAfter(element);
                

    
	    
	    },
        highlight: function ( element, errorClass, validClass ) {
            $( element ).addClass( "is-invalid" )
        },
        unhighlight: function (element, errorClass, validClass) {
	        $( element ).removeClass( "is-invalid" );
	    },
        submitHandler: function (form) {
            form.submit();

            }

        })
    })
    $('.formmaterial').each(function(){
        $(this).validate({
            rules: {
                idajuan : {
                    required : true,
                },
                jenismaterial : {
                required : true,
                },
                namamaterial : {
                required : true,
                },
                satuanmaterial : {
                required : true,
                },
                qtymaterial : {
                required : true,
                },

            },
            messages: {
                idajuan : {
                    required: 'Id Ajuan Tidak Boleh Kosong'
                },
                jenismaterial: {
                    required: 'Jenis Material Wajib Diisi'
                },
                namamaterial: {
                    required: 'Nama Material Wajib Diisi'
                },
                satuanmaterial: {
                    required: 'Satuan Material Wajib Diisi'
                },
                qtymaterial: {
                    required: 'Silakan Masukkan Jumlah Material'
                },
             
            },
            errorElement: "div",
            errorPlacement: function ( error, element ) {
                

	        // Add the `invalid-feedback` class to the error element
	        error.addClass( "invalid-feedback" );
	        error.insertAfter(element);
                

    
	    
	    },
        highlight: function ( element, errorClass, validClass ) {
            $( element ).addClass( "is-invalid" )
        },
        unhighlight: function (element, errorClass, validClass) {
	        $( element ).removeClass( "is-invalid" );
	    },
        submitHandler: function (form) {
            form.submit();

            }

        })
    })
    $('.formmaterialpenyusun').each(function(){
        $(this).validate({
            rules: {
                namamp : {
                    required : true,
                },
                spesifikasimp : {
                required : true,
                },
                satuanmp : {
                required : true,
                },
                jumlahmp : {
                required : true,
                },
                hargamp : {
                required : true,
                },

            },
            messages: {
                namamp : {
                    required: 'Nama Material Wajib Diisi'
                },
                spesifikasimp: {
                    required: 'Spesifikasi Wajib Diisi'
                },
                satuanmp: {
                    required: 'Satuan Wajib Diisi'
                },
                jumlahmp: {
                    required: 'Quantitiy Wajib Diisi'
                },
                hargamp: {
                    required: 'Silakan Masukkan Harga Material'
                },
             
            },
            errorElement: "div",
            errorPlacement: function ( error, element ) {
                

	        // Add the `invalid-feedback` class to the error element
	        error.addClass( "invalid-feedback" );
	        error.insertAfter(element);
                

    
	    
	    },
        highlight: function ( element, errorClass, validClass ) {
            $( element ).addClass( "is-invalid" )
        },
        unhighlight: function (element, errorClass, validClass) {
	        $( element ).removeClass( "is-invalid" );
	    },
        submitHandler: function (form) {
            let namamp = $('.namamp').data('namamp')
            let spesifikasimp = $('.spesifikasimp').data('spesifikasimp')
            let satuanmp= $('.satuanmp').data('satuanmp')
            let jumlahmp = $('.jumlahmp').data('jumlahmp')
            let hargamp = $('.hargamp').data('hargamp')

            let namampval = $('.namamp').val()
            let namampvalnospace = namampval.trim()
            let spesifikasimpval = $('.spesifikasimp').val()
            let spesifikasimpvalnospace = spesifikasimpval.trim()
            let satuanmpval= $('.satuanmp').val()
            let satuanmpmpvalnospace = satuanmpval.trim()
            let jumlahmpval = $('.jumlahmp').val()
            let jumlahmpvalnospace = jumlahmpval.trim()
            let hargampval = $('.hargamp').val()
            let hargampvalnospace = hargampval.trim()
            
            if (
                namampvalnospace == namamp.trim() &&            
                spesifikasimpvalnospace == spesifikasimp.trim() &&            
                satuanmpmpvalnospace== satuanmp.trim() &&            
                jumlahmpvalnospace == jumlahmp.trim() &&            
                hargampvalnospace == hargamp.trim()            
            ){
                Swal.fire({
                    position: 'center',
                    icon: 'warning',
                    title: 'Silakan Ubah Data !',
                    showConfirmButton: false,
                    timer: 4000
                    })
                }
             else{
                form.submit();
            }
            
            }

        })
    })
    $('.formmpr').each(function(){
        $(this).validate({
            rules: {
                namampr : {
                    required : true,
                },
                spesifikasimpr : {
                required : true,
                },
                satuanmpr : {
                required : true,
                },
                jumlahmpr: {
                required : true,
                },
                hargampr : {
                required : true,
                },

            },
            messages: {
                namampr : {
                    required: 'Nama Material Wajib Diisi'
                },
                spesifikasimpr: {
                    required: 'Spesifikasi Wajib Diisi'
                },
                satuanmpr: {
                    required: 'Satuan Wajib Diisi'
                },
                jumlahmpr: {
                    required: 'Quantitiy Wajib Diisi'
                },
                hargampr: {
                    required: 'Silakan Masukkan Harga Material'
                },
             
            },
            errorElement: "div",
            errorPlacement: function ( error, element ) {
                

	        // Add the `invalid-feedback` class to the error element
	        error.addClass( "invalid-feedback" );
	        error.insertAfter(element);
                

    
	    
	    },
        highlight: function ( element, errorClass, validClass ) {
            $( element ).addClass( "is-invalid" )
        },
        unhighlight: function (element, errorClass, validClass) {
	        $( element ).removeClass( "is-invalid" );
	    },
        submitHandler: function (form) {
            let namampr = $('.namampr').data('namampr')
            let spesifikasimpr = $('.spesifikasimpr').data('spesifikasimpr')
            let satuanmpr= $('.satuanmpr').data('satuanmpr')
            let jumlahmpr = $('.jumlahmpr').data('jumlahmpr')
            let hargampr = $('.hargampr').data('hargampr')

            let namampval = $('.namampr').val()
            let namampvalnospace = namampval.trim()
            let spesifikasimpval = $('.spesifikasimpr').val()
            let spesifikasimpvalnospace = spesifikasimpval.trim()
            let satuanmpval= $('.satuanmpr').val()
            let satuanmpmpvalnospace = satuanmpval.trim()
            let jumlahmpval = $('.jumlahmpr').val()
            let jumlahmpvalnospace = jumlahmpval.trim()
            let hargampval = $('.hargampr').val()
            let hargampvalnospace = hargampval.trim()
            
            if (
                namampvalnospace == namampr.trim() &&            
                spesifikasimpvalnospace == spesifikasimpr.trim() &&            
                satuanmpmpvalnospace== satuanmpr.trim() &&            
                jumlahmpvalnospace == jumlahmpr.trim() &&            
                hargampvalnospace == hargampr.trim()            
            ){
                Swal.fire({
                    position: 'center',
                    icon: 'warning',
                    title: 'Silakan Ubah Data !',
                    showConfirmButton: false,
                    timer: 4000
                    })
                }
             else{
                form.submit();
            }
            
            }

        })
    })
    $('.formtenaker').each(function(){
        $(this).validate({
            rules: {
                idajuan: {
                    required: true,
            },  jobdesk: {
                    required: true,
            },  statuspekerjaan: {
                    required: true,
                    
            }, gaji: {
                    required: true,
            }, total_pekerja: {
                    required: true,
            },
           

        },
            messages: {
                idajuan: {
                    required: 'Id Ajuan Tidak Boleh Kosong',
            },  jobdesk: {
                    required: 'Job Desk Tidak Boleh Kosong',
            },  statuspekerjaan: {
                    required: 'Status Pekerjaan Tidak Boleh Kosong',
                    
            }, gaji: {
                    required: 'Gaji Tidak Boleh Kosong',
            }, total_pekerja: {
                    required: 'Total Pekerja Tidak Boleh Kosong',
            },
          
        },  errorElement: "div",
        errorPlacement: function ( error, element ) {

	        // Add the `invalid-feedback` class to the error element
	        error.addClass( "invalid-feedback" );
            error.addClass("pesanerror");
	        if ( element.prop( "type" ) === "checkbox" ) {
	            error.insertAfter(element.next( "label" ));
	        } else {
	            error.insertAfter(element);
	        }
	    },
        highlight: function ( element, errorClass, validClass ) {
	        $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
	    },
	    unhighlight: function (element, errorClass, validClass) {
	        $( element ).removeClass( "is-invalid" );
	    },
            submitHandler: function (form) {
                form.submit();

                }


        
        })
    })
    $('.formbop').each(function(){
        $(this).validate({
            rules: {
                idajuan : {
                    required : true,
                },
                namatrans : {
                    required : true,
                },
                quantity : {
                required : true,
                },
                harga : {
                required : true,
                },
            },
            messages: {
                idajuan : {
                    required: 'Nama Material Wajib Diisi'
                },
                namatrans: {
                    required: 'Spesifikasi Wajib Diisi'
                },
                quantity: {
                    required: 'Satuan Wajib Diisi'
                },
                harga: {
                    required: 'Quantitiy Wajib Diisi'
                },
                
             
            },
            errorElement: "div",
            errorPlacement: function ( error, element ) {
                

	        // Add the `invalid-feedback` class to the error element
	        error.addClass( "invalid-feedback" );
	        error.insertAfter(element);
                

    
	    
	    },
        highlight: function ( element, errorClass, validClass ) {
            $( element ).addClass( "is-invalid" )
        },
        unhighlight: function (element, errorClass, validClass) {
	        $( element ).removeClass( "is-invalid" );
	    },
        submitHandler: function (form) {
            form.submit();

            }

        })
    })
})