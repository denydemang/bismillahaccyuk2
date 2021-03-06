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
                catatan : {
                required : true,
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
                catatan : {
                    required: 'Catatan Wajib Diisi'
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
                numberonly :true,
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
                    numberonly: 'Input Tidak Valid'
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