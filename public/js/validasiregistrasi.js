

jQuery.validator.addMethod("hanyahuruf", function(value, element) {
    return this.optional(element) || /^[a-z\s]+$/i.test(value);
    }, "Only alphabetical characters");
jQuery.validator.addMethod("pwlogic", function(value, element) {
    return this.optional(element) || /\d/.test(value) && /[a-z]/i.test(value);
    }, "Harus mengandung angka dan huruf");

$(document).ready(function(){
    $('#formregistrasi').each(function(){
        $(this).validate({
            rules: {
                nama: {
                    required: true,
                    hanyahuruf: true
            },  email: {
                    required: true,
                    email: true
            },  username: {
                    required: true,
                    minlength: 7,
                    nowhitespace : true,
                    
            }, telpon: {
                    required: true,
                    minlength: 10,
                    maxlength: 13
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
                    minlength: 'No Telp Minimal 10 digit',
                    maxlength: 'No Telpon Maksimal 13 digit'
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
})