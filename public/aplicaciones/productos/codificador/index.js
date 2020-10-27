$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#table').dataTable({
        language: {
            url: '/Spanish.json'
        }
    });


    $(document).on('click', '#nuevo', function () {
        $('input').closest('.form-control').removeClass('is-invalid');
        $('select').closest('.form-control').removeClass('is-invalid');
        $('.error').remove();
        $('#form').trigger('reset');
        $('#modal').modal('show');
    });

    $(document).on('change', '#tipo_producto', function () {
        obtener_data_cod_desc();
        let id = this.value;
        $.ajax({
            url: '/aplicaciones/productos/codificado/listar_lineas',
            type: 'get',
            data:{
                id:id
            },
            success:function (data) {
                $('#linea').empty().append('<option value="" selected>Seleccione...</option>');
                $('#sublinea').empty().append('<option value="" selected>Seleccione...</option>');
                $('#caracteristica').empty().append('<option value="" selected>Seleccione...</option>');
                $('#material').empty().append('<option value="" selected>Seleccione...</option>');
                $('#medida').empty().append('<option value="" selected>Seleccione...</option>');


                for (let i = 0; i < data.length; i++) {
                    $('#linea').append('<option value="'+ data[i].id +'">'+ data[i].name +'</option>')
                }
            },
            error:function (data) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops',
                    text: data.responseText
                });
            }
        });
    });


    $(document).on('change', '#linea', function () {
        obtener_data_cod_desc();
        let id = this.value;
        $.ajax({
            url: '/aplicaciones/productos/codificado/listar_sublineas',
            type: 'get',
            data:{
                id:id
            },
            success:function (data) {

                $('#sublinea').empty().append('<option value="" selected>Seleccione...</option>');
                $('#caracteristica').empty().append('<option value="" selected>Seleccione...</option>');
                $('#material').empty().append('<option value="" selected>Seleccione...</option>');
                $('#medida').empty().append('<option value="" selected>Seleccione...</option>');


                for (let i = 0; i < data.length; i++) {
                    $('#sublinea').append('<option value="'+ data[i].id +'">'+ data[i].name +'</option>')
                }
            },
            error:function (data) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops',
                    text: data.responseText
                });
            }
        });
    });


    $(document).on('change', '#sublinea', function () {
        obtener_data_cod_desc();
        let linea_id = document.getElementById('linea').value;
        let sublinea_id = this.value;
        $.ajax({
            url: '/aplicaciones/productos/codificado/listar_caracteristicas_materiales_medidas',
            type: 'get',
            data:{
                linea_id:linea_id,
                sublinea_id:sublinea_id
            },
            success: function(data){

                $('#caracteristica').empty().append('<option value="" selected>Seleccione...</option>');
                $('#material').empty().append('<option value="" selected>Seleccione...</option>');
                $('#medida').empty().append('<option value="" selected>Seleccione...</option>');

                const caracteristicas = data.caracteristicas;
                const materiales = data.materiales;
                const medidas = data.medidas;

                for (let i = 0; i < caracteristicas.length; i++) {
                    $('#caracteristica').append('<option value="'+ caracteristicas[i].id +'" >'+ caracteristicas[i].name +'</option>')
                }

                for (let j = 0; j < materiales.length; j++) {
                    $('#material').append('<option value="'+ materiales[j].id +'" >'+ materiales[j].materiales.name +'</option>')
                }

                for (let k = 0; k < medidas.length; k++) {
                    $('#medida').append('<option value="'+ medidas[k].id +'" >'+ medidas[k].denominacion +'</option>')
                }
            },
            error:function (data) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops',
                    text: data.responseText
                });
            }
        })
    });


    $(document).on('change', '#caracteristica', function () {
        obtener_data_cod_desc();
    });


    $(document).on('change', '#material', function () {
        obtener_data_cod_desc();
    });


    $(document).on('change', '#medida', function () {
        obtener_data_cod_desc();
    });


    function obtener_data_cod_desc(){
        let tipo_producto   = document.getElementById('tipo_producto').value;
        let linea           = document.getElementById('linea').value;
        let sublinea        = document.getElementById('sublinea').value;
        let caracteristica  = document.getElementById('caracteristica').value;
        let material        = document.getElementById('material').value;
        let medida          = document.getElementById('medida').value;

        let codigo = '';
        let descripcion = '';

        $.ajax({
            url: '/aplicaciones/productos/codificado/obtener_datos_generacion_cod_desc',
            type: 'get',
            data: {
                tipo_producto:tipo_producto,
                linea:linea,
                sublinea:sublinea,
                caracteristica:caracteristica,
                material:material,
                medida: medida
            },
            success:function (data) {
                let tipo_producto_cod;
                let linea_cod;
                let sublinea_cod;
                let material_cod;

                let linea_abrev;
                let sublinea_abrev;
                let caracteristica_abrev;
                let material_abrev;
                let medida_denom;

                if(data.tipo_producto == null) {
                    tipo_producto_cod = '';
                }else{
                    tipo_producto_cod = data.tipo_producto;
                }

                if (data.linea == null){
                    linea_cod   = '';
                    linea_abrev = '';
                }else{
                    linea_cod   = data.linea.cod;
                    linea_abrev = ' '+data.linea.abreviatura
                }

                if (data.sublinea == null){
                    sublinea_cod    = '';
                    sublinea_abrev  = '';
                }else{
                    sublinea_cod    = data.sublinea.cod;
                    sublinea_abrev  = ' '+data.sublinea.abreviatura;
                }

                if (data.caracteristica == null){
                    caracteristica_abrev = '';
                }else{
                    caracteristica_abrev = ' '+data.caracteristica.abreviatura;
                }

                if (data.material == null){
                    material_cod    = '';
                    material_abrev  = '';
                }else {
                    material_cod    = data.material.cod;
                    material_abrev  = ' '+data.material.abreviatura
                }

                if (data.medida == null){
                    medida_denom = '';
                }else{
                    medida_denom = ' '+data.medida.denominacion;
                }

                codigo = tipo_producto_cod + linea_cod  + sublinea_cod +  material_cod;
                descripcion = linea_abrev + sublinea_abrev + caracteristica_abrev + material_abrev + medida_denom;

                generar_codigo(data.lista_codigos, codigo);
                document.getElementById('descripcion').value = descripcion;
            },
            error:function (data) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops',
                    text: data.responseText
                });
            }
        })
    }


    $(document).on('click', '.delete', function () {
        let id = this.id;
        Swal.fire({
            title: '¿Eliminar producto?',
            html: "¡Esta accion <b class='text-danger'>NO</b> se puede revertir!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "DELETE",
                    url: "/aplicaciones/productos/codificado/" + id,
                    success: function (data) {
                        Swal.fire({
                            title: 'Eliminado!',
                            text: "El registro ha sido eliminado.",
                            icon: 'success',
                        });
                        setTimeout(function() {
                            window.location.reload(true);
                        }, 3000);
                    },
                    error: function (data) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops',
                            text: data.responseText
                        })
                    }
                });
            }else{
                result.dismiss === Swal.DismissReason.cancel
            }
        })
    });


    $("#form").validate({
        ignore: "",
        rules: {
            codigo:{
                required: true,
                remote: {
                    url: '/aplicaciones/productos/codificado/validar_codigo',
                    type: 'POST',
                    async: true,
                },
                minlength: 10,
                maxlength: 10,
            },
            descripcion: {
                required: true,
                remote: {
                    url: '/aplicaciones/productos/codificado/validar_descripcion',
                    type: 'POST',
                    async: true
                }
            },
            tipo_producto: {
                select_check: true
            },
            linea: {
                select_check: true
            },
            sublinea: {
                select_check: true
            },
            caracteristica: {
                select_check: true
            },
            material: {
                select_check: true
            },
            medida: {
                select_check: true
            },

        },
        submitHandler: function (form) {
            $.ajax({
                data: $('#form').serialize(),
                url: "/aplicaciones/productos/codificado",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Guardado!',
                        text: "El registro ha sido guardado.",
                    });
                    $('#Form').trigger("reset");
                    $('#modal').modal('hide');
                    setTimeout(function() {
                        window.location.reload(true);
                    }, 3000);
                },
                error: function (data) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops',
                        text: data.responseText
                    });
                }
            });
            return false; // required to block normal submit since you used ajax
        },
        highlight: function (element) {
            $(element).closest('.form-control').removeClass('is-valid').addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).closest('.form-control').removeClass('is-invalid');
        },
    });



    function generar_codigo(lista_codigos, codigo) {
        var incremental     = 0;
        var charStringRange = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        var vectorc         = [];
        var t1              = 0;
        var numerof         = 0;
        var OriginalProductCodes = lista_codigos;

        for (var f = 0; f < OriginalProductCodes.length; f++) {
            if (codigo  == OriginalProductCodes[f].substring(0,6) && OriginalProductCodes[f].length==10){
                var cadena = OriginalProductCodes[f].substring(6);
                var text2  = cadena.split('').reverse().join('');
                text2      = text2.split('');

                for (var v2 = 0; v2 < 4; v2++) {
                    for (var i = 0; i < 36; i++) {
                        if (text2[v2] == charStringRange[i]) {
                            break;
                        }
                    }
                    numerof += i*Math.pow(36,v2);
                }
                vectorc[t1] = numerof;
                t1++;
                numerof = 0;
            }
        }

        let maxvector = Math.max.apply(Math, vectorc); //saca el valor maximo de un arreglo
        if (maxvector >= 0) {
            incremental = maxvector + 1;
        }
        var text = '';
        var incretemp = incremental;
        for (var i = 0; i < 4; i++){
            incretemp = Math.floor(incretemp)/36;
            text += charStringRange.charAt(Math.round((incretemp - Math.floor(incretemp))*36));
        }
        text = text.split('').reverse().join('');

        $('#codigo').val(codigo + text);
    }


    jQuery.extend(jQuery.validator.messages, {
        required: "Este campo es obligatorio.",
        remote: "Este Codigo ya existe...",
        email: "Por favor, escribe una dirección de correo válida",
        url: "Por favor, escribe una URL válida.",
        date: "Por favor, escribe una fecha válida.",
        dateISO: "Por favor, escribe una fecha (ISO) válida.",
        number: "Por favor, escribe un número entero válido.",
        digits: "Por favor, escribe sólo dígitos.",
        creditcard: "Por favor, escribe un número de tarjeta válido.",
        equalTo: "Por favor, escribe el mismo valor de nuevo.",
        accept: "Por favor, escribe un valor con una extensión aceptada.",
        maxlength: jQuery.validator.format("Por favor, no escribas más de {0} caracteres."),
        minlength: jQuery.validator.format("Por favor, no escribas menos de {0} caracteres."),
        rangelength: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1} caracteres."),
        range: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1}."),
        max: jQuery.validator.format("Por favor, escribe un valor menor o igual a {0}."),
        min: jQuery.validator.format("Por favor, escribe un valor mayor o igual a {0}."),
        selectcheck: "Por favor seleccione una opcion!"
    });


    jQuery.validator.addMethod("select_check", function(value){
        return (value != '');
    }, "Por favor, seleciona una opcion.");
});
