$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.extend($.validator.messages, {
        required: "Este campo es obligatorio.",
        remote: "Por favor, rellena este campo.",
        email: "Por favor, escribe una dirección de correo válida.",
        url: "Por favor, escribe una URL válida.",
        date: "Por favor, escribe una fecha válida.",
        dateISO: "Por favor, escribe una fecha (ISO) válida.",
        number: "Por favor, escribe un número válido.",
        digits: "Por favor, escribe sólo dígitos.",
        creditcard: "Por favor, escribe un número de tarjeta válido.",
        equalTo: "Por favor, escribe el mismo valor de nuevo.",
        extension: "Por favor, escribe un valor con una extensión aceptada.",
        maxlength: $.validator.format( "Por favor, no escribas más de {0} caracteres." ),
        minlength: $.validator.format( "Por favor, no escribas menos de {0} caracteres." ),
        rangelength: $.validator.format( "Por favor, escribe un valor entre {0} y {1} caracteres." ),
        range: $.validator.format( "Por favor, escribe un valor entre {0} y {1}." ),
        max: $.validator.format( "Por favor, escribe un valor menor o igual a {0}." ),
        min: $.validator.format( "Por favor, escribe un valor mayor o igual a {0}." ),
        nifES: "Por favor, escribe un NIF válido.",
        nieES: "Por favor, escribe un NIE válido.",
        cifES: "Por favor, escribe un CIF válido."
    });

    form.steps({
        labels: {
            next: "Siguiente",
            previous: "Anterior",
            loading: "Cargando...",
            finish: "Guardar Cliente"
        },
        headerTag: "h3",
        bodyTag: "fieldset",
        transitionEffect: "fade",
        onStepChanging: function (event, currentIndex, newIndex)
        {
            if (currentIndex > newIndex)
            {   return true;    }
            if (newIndex === 3 && Number($("#age-2").val()) < 18)
            {   return false;   }

            if (currentIndex < newIndex) {
                form.find(".body:eq(" + newIndex + ") label.error").remove();
                form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
            }
            form.validate().settings.ignore = ":disabled,:hidden";
            return form.valid();
        },
        onStepChanged: function (event, currentIndex, priorIndex) {
            if (currentIndex === 2 && Number($("#age-2").val()) >= 18)
            {   form.steps("next"); }
            if (currentIndex === 2 && priorIndex === 3)
            {   form.steps("previous"); }
        },
        onFinishing: function (event, currentIndex) {
            form.validate().settings.ignore = ":disabled";
            return form.valid();
        },
        onFinished: function (event, currentIndex) {
            var data = new FormData($("#create-form")[0]);

            data.append("archivo_rut", document.getElementById("document_rut").files[0]);
            data.append("Correos_copia", $('#M_correos_copia').val());
            data.append("pais", $('select[name="M_Pais"] option:selected').text());
            data.append("departamento", $('select[name="M_Departamento"] option:selected').text());
            data.append("ciudad", $('select[name="M_Ciudad"] option:selected').text());

            $.ajax({
                url: '/aplicaciones/terceros/cliente/guardar_cliente',
                type: 'post',
                data: data,
                processData: false,
                contentType: false,
                success: function () {
                    Swal.fire({
                        icon: 'success',
                        title: 'Guardardo',
                        text: 'El cliente fue creado con exito!',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Aceptar',
                    });
                    $('#create-form').trigger("reset");
                    setTimeout(function() {
                        window.location.reload(true);
                    }, 3000);
                },
                error: function(jqXHR, textStatus, err){
                    console.log('text status '+textStatus+', err '+err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: err,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Aceptar',
                    })
                }
            });

        }
    }).validate({
        errorPlacement: function errorPlacement(error, element)
        { element.after(error); },
        rules: {
            M_primer_nombre: {
                required: true,
                minlength: 4,
                maxlength: 60,
                especial_chars_name: true
            },
            M_Razon_comercial: {
                required: false,
                minlength: 4,
                maxlength: 60,
                especial_chars_razon_social: true
            },
            M_direccion1: {
                required: true,
                minlength: 8,
                maxlength: 60
            },
            M_direccion2: {
                required: false,
                minlength: 8,
                maxlength: 60
            },
            M_Codigo_postal: {
                required: false,
                minlength: 4,
                maxlength: 9
            },
            M_Pais: {
                selectcheck: true
            },
            M_Departamento: {
                selectcheck: true
            },
            M_Ciudad: {
                selectcheck: true
            },
            M_tipo_doc: {
                selectcheck: true
            },
            M_tipo_tercero_dms: {
                selectcheck: true
            },
            M_tipo_client_dms: {
                selectcheck: true
            },
            M_tipo_regimen_dms: {
                selectcheck: true
            },
            M_Contacto: {
                required: true,
                minlength: 4,
                maxlength: 20,
            },
            M_Telefono: {
                required: true,
                minlength: 4,
                maxlength: 20,
                digits: true
            },
            M_Telefono2: {
                required: false,
                minlength: 4,
                maxlength: 20,
                digits: true
            },
            M_Celular: {
                required: false,
                minlength: 4,
                maxlength: 20,
                digits: true
            },
            M_Email_contacto: {
                Emailcheck: true
            },
            M_Email_facturacion: {
                Emailcheck: true
            },
            M_Porcentaje_descuento: {
                digits: true,
                max: 100,
                min: 0
            },
            M_actividad_principal: {
                required: false,
                selectcheck: true
            },
            M_Codigo_fiscal_2: {
                required: false,
                maxlength: 7,
                minlength: 3
            },
            M_Nit_cc: {
                minlength: 5,
                required: true
            },
            M_Forma_envio: {
                selectcheck: true
            },
            M_Plazo: {
                selectcheck: true
            },
            M_Gravado: {
                selectcheck: true
            },
            M_Moneda: {
                selectcheck: true
            },
            M_Tipo_cliente: {
                selectcheck: true
            }
        },
        messages:{
            M_Nit_cc: "",
            M_Nit_cc_dg: "",
            acceptTerms: "",
            M_actividad_principal: ""
        },
        errorElement: 'label',
        errorLabelContainer: '.errorTxt'
    });


    function validateEmail(email) {
        var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }

    jQuery.validator.addMethod("selectcheck", function(value){
        return (value !== '');
    }, "Por favor, seleciona una opcion.");

    jQuery.validator.addMethod("Emailcheck", function (value) {
        var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(value);
    }, "Por favor, escribe una dirección de correo válida.");

    jQuery.validator.addMethod("especial_chars_name", function (value){
        var re = /^[a-zA-Z]{4,60}$/;
        return re.test(value);
    }, "Ingrese un nombre valido!");


    jQuery.validator.addMethod("especial_chars_razon_social", function (value){
        var re = /^[a-zA-Z0-9@& ]{4,60}$/;
        return re.test(value);
    }, "La razon social no debe tener caracteres especial excepto (@, &)");



    $('#M_Pais').on( "change", function() {
        $('#M_Departamento').html('');
        $('#M_Ciudad').html('');
        const id_pais = $('#M_Pais').val();
        $.ajax({
            type: "get",
            url: '/aplicaciones/terceros/listar_departamentos',
            data: {id_pais: id_pais},
            success: function (data) {
                $('#M_Departamento').append('<option value="">Seleccione...</option>');
                for (let j = 0; j <= data.length -1 ; j++) {
                    $('#M_Departamento').append('<option value="'+data[j].departamento +'">'+data[j].descripcion+'</option>');
                }
            }
        })
    });

    $('#M_Departamento').on("change", function () {
        $('#M_Ciudad').html('');
        var id_pais = $('#M_Pais').val();
        var id_departamento = $('#M_Departamento').val();
        $.ajax({
            type: "get",
            url: '/aplicaciones/terceros/listar_ciudades',
            data: {
                id_pais: id_pais, id_departamento: id_departamento
            },
            success: function (data) {
                $('#M_Ciudad').append('<option value="">Seleccione...</option>');
                for (let j = 0; j <= data.length -1; j++) {
                    $('#M_Ciudad').append('<option value="'+data[j].ciudad +'">'+data[j].descripcion+'</option>');
                }
            }
        })
    });

    $('#M_correos_copia').select2({
        createTag: function(term, data) {
            const value = term.term;
            if(validateEmail(value)) {
                return {
                    id: value, text: value
                };
            }
            return null;
        },
        placeholder: "Escribe uno o varios email..",
        tags: true,
        tokenSeparators: [',', ' ',';'],
        width: '100%',
    });

    $('#M_Nit_cc').on('blur',function () {
        calcular();
    });

    function  calcularDigitoVerificacion ( myNit )  {
        var vpri, x, y, z;

        myNit = myNit.replace ( /\s/g, "" ) ; // Espacios
        myNit = myNit.replace ( /,/g,  "" ) ; // Comas
        myNit = myNit.replace ( /\./g, "" ) ; // Puntos
        myNit = myNit.replace ( /-/g,  "" ) ; // Guiones

        if  ( isNaN ( myNit ) )  {
            return "" ;
        }

        vpri = new Array(16) ;
        z = myNit.length ;

        vpri[1]  =  3 ;
        vpri[2]  =  7 ;
        vpri[3]  = 13 ;
        vpri[4]  = 17 ;
        vpri[5]  = 19 ;
        vpri[6]  = 23 ;
        vpri[7]  = 29 ;
        vpri[8]  = 37 ;
        vpri[9]  = 41 ;
        vpri[10] = 43 ;
        vpri[11] = 47 ;
        vpri[12] = 53 ;
        vpri[13] = 59 ;
        vpri[14] = 67 ;
        vpri[15] = 71 ;

        x = 0 ;
        y = 0 ;
        for  ( var i = 0; i < z; i++ )  {
            y = ( myNit.substr (i, 1 ) ) ;
            x += ( y * vpri [z-i] ) ;
        }
        y = x % 11 ;
        return ( y > 1 ) ? 11 - y : y ;
    }

    function calcular() {
        let nit = document.getElementById("M_Nit_cc").value;
        let isNitValid = nit >>> 0 === parseFloat(nit);

        if ( isNitValid ) {
            let inputDigVerificacion = document.getElementById("M_Nit_cc_dg");
            inputDigVerificacion.value = calcularDigitoVerificacion(nit);
        }
    }

    $('#search_client_max_dms').keyup(function () {
        const datos = this.value;
        $.ajax({
            url:'/aplicaciones/terceros/cliente/buscar_cliente',
            type:'get',
            data: {
                query: datos
            },
            success:function (data) {
                if(data.max >= 1 ){
                    document.getElementById('max_status').className="input-group-text text-success";
                }else{
                    document.getElementById('max_status').className="input-group-text text-danger";
                }
                if(data.dms >= 1){
                    document.getElementById('dms_status').className="input-group-text text-success";
                }else{
                    document.getElementById('dms_status').className="input-group-text text-danger";
                }
            },
            error: function (data) {
                console.log(data)
            }
        })
    });

    var field;

    $(document).on('click', '#M_direccion1', function () {
        $('#direccion_modal').modal('show');
        field = 'M_direccion1';
    });


    $(document).on('click', '#M_direccion2', function () {
        $('#direccion_modal').modal('show');
        field = 'M_direccion2';
    });

    var direccion_final_1;
    $(document).on('blur', '.ddr_m', function () {
        const tipo_via      = $('#tipo_via').val();
        const numero_1      = $('#numero1').val();
        const letra_1       = $('#letra').val();
        const complemento_1 = $('#complemento1').val();
        const numero_2      = $('#numero2').val();
        const letra_2       = $('#letra2').val();
        const complemento_2 = $('#complemento2').val();
        const numero_3      = $('#numero3').val();
        const complemnto_3  = $('#complemento3').val();
        const numero_4      = $('#numero4').val();

        direccion_final_1 = generar_direccion(tipo_via, numero_1, letra_1, complemento_1, numero_2, letra_2, complemento_2, numero_3, complemnto_3, numero_4);

        $('#direccion_final').val(direccion_final_1);
    });



    $(document).on('click', '#add_direccion', function () {
        document.getElementById(field).setAttribute('value', direccion_final_1);
        $('#direccion_modal').modal('hide');
        $('.ddr_m').val('');
        $('#direccion_final').val('');
    });


    $(document).on('click', '#agregar_actividad_economica', function (){
        $('#modal_actividad_economica').modal('show');
    });


    $('#actividad_economica_form').validate({
        ignore: "",
        rules: {
            codigo: {
                required: true,
                minlength: 4,
                maxlength: 4,
                digits: true
            },
            descripcion: {
                required: true
            }
        },
        highlight: function (element) {
            $(element).closest('.form-control').removeClass('is-valid').addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).closest('.form-control').removeClass('is-invalid');
        },
        submitHandler: function (form) {
            $.ajax({
                data: $('#actividad_economica_form').serialize(),
                url: "/aplicaciones/terceros/cliente/crear_actividad_economica",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Guardado!',
                        text: "Actividad economica guardada, refresque la pagina para visualizar la opcion en el grid.",
                    });
                    $('#actividad_economica_form').trigger("reset");
                    $('#modal_actividad_economica').modal('hide');
                },
                error: function (data) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops',
                        text: data.responseText
                    });
                }
            });
        }
    });



    function generar_direccion(tipo_via, numero_1, letra_1, complemento_1, numero_2, letra_2, complemento_2, numero_3, complemnto_3, numero_4) {
        return [tipo_via, numero_1, letra_1, complemento_1, numero_2, letra_2, complemento_2, numero_3, complemnto_3, numero_4].filter(Boolean).join(' ');
    }


});
