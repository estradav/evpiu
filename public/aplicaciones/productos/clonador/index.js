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


    $(document).on('click', '#nuevo_codigo', function () {
        $('input').closest('.form-control').removeClass('is-invalid');
        $('select').closest('.form-control').removeClass('is-invalid');
        $('.error').remove();
        $('#form').trigger('reset');
        $('#modal').modal('show');
    });


    $(document).on('change', '#tipo_producto', function () {
        obtener_data_cod_desc();
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
                    $('#material').append('<option value="'+ materiales[j].id +'" >'+ materiales[j].name +'</option>')
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


    $(document).on('click', '#clonar_producto', function () {
        $('input').closest('.form-control').removeClass('is-invalid');
        $('select').closest('.form-control').removeClass('is-invalid');
        $('.error').remove();
        $('#modal_clonador').modal('show');
        $('#clonador_form').trigger('reset');
    });



    $('#producto_clonar').autocomplete({
        appendTo: "#modal_clonador",
        source: function(request, response) {
            const query = document.getElementById('producto_clonar').value;
            $.ajax({
                url: "/aplicaciones/productos/clonado/obtener_info_producto_clonar",
                type: "get",
                data: {
                    query:query
                },
                success: function(data){
                    const resp = $.map(data, function (obj) {
                        return obj
                    });
                    response(resp);
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });
        },
        focus: function (event, ui) {
            return true;
        },
        select: function(event, ui){
            let cod = document.getElementById('maestro_id_pieza').value;
            let descr = document.getElementById('maestro_descripcion').value;

            $('#clonador_form').trigger('reset');

            document.getElementById('maestro_id_pieza').value = cod;
            document.getElementById('maestro_descripcion').value = descr;


            /*Campos maestro*/
            document.getElementById('maestro_tipo_pieza').value = ui.item.maestro_tipo_pieza;
            document.getElementById('maestro_comprador').value = ui.item.maestro_comprador;
            document.getElementById('maestro_planificador').value = ui.item.maestro_planificador;
            document.getElementById('maestro_almacen_preferido').value = ui.item.maestro_almacen_prefe;
            document.getElementById('maestro_umd_ldm').value = ui.item.maestro_umd_ldm;
            document.getElementById('maestro_umd_costo').value = ui.item.maestro_umd_costo;
            document.getElementById('maestro_codigo_clase').value = ui.item.maestro_cod_clase;
            document.getElementById('maestro_codigo_comodidad').value = ui.item.maestro_cod_comodidad;
            document.getElementById('maestro_inventario').value = ui.item.maestro_inventario;
            document.getElementById('maestro_costo_unit').value = ui.item.maestro_costo_unit;
            document.getElementById('maestro_zona').value = ui.item.maestro_zona;
            document.getElementById('maestro_nivel_rev').value = ui.item.maestro_nivel_revision;
            document.getElementById('maestro_tc_compras').value = ui.item.maestro_tc_compras;
            document.getElementById('maestro_tc_manufactura').value = ui.item.maestro_tc_manufactura;


            /*campos ingenieria*/
            document.getElementById('ingenieria_numero_plano').value = ui.item.ingenieria_numero_plano;
            document.getElementById('ingenieria_rendimiento').value = ui.item.ingenieria_rendimiento;
            document.getElementById('ingenieria_desecho').value = ui.item.ingenieria_desecho;
            document.getElementById('ingenieria_estado_ingenieria').value = ui.item.ingenieria_estado_ingenieria;
            document.getElementById('ingenieria_cbn').value = ui.item.ingenieria_cbn;


            /*campos contabilidad*/
            document.getElementById('contabilidad_tipo_cuenta_contable').value = ui.item.contabilidad_tipo_cuenta;


            /*campos planificador*/
            document.getElementById('planificador_politica_orden').value = ui.item.planificador_politica_orden;
            document.getElementById('planificador_programa').value = ui.item.planificador_programa;
            document.getElementById('planificador_tc_critico').value = ui.item.planificador_tc_critico;
            document.getElementById('planificador_pdr').value = ui.item.planificador_pdr;
            document.getElementById('planificador_cdr').value = ui.item.planificador_cdr;
            document.getElementById('planificador_inventario_seguridad').value = ui.item.planificador_inv_seguridad;
            document.getElementById('planificador_plan_firme').checked = ui.item.planificador_plan_firme === 'Y';
            document.getElementById('planificador_ncnd').checked = ui.item.planificador_ncnd === 'Y';
            document.getElementById('planificador_rump').checked = ui.item.planificador_rump === 'Y';
            document.getElementById('planificador_pieza_critica').checked = ui.item.planificador_pieza_critica === 'Y';


            /*campos fabricacion*/
            document.getElementById('fabricacion_tiempo_ciclo').value = ui.item.fabricacion_tiempo_ciclo;
            document.getElementById('fabricacion_planear').value = ui.item.fabricacion_planear;
            document.getElementById('fabricacion_fabricar').value = ui.item.fabricacion_fabricar;
            document.getElementById('fabricacion_almacenar').value = ui.item.fabricacion_almacenar;


            /*campos compras*/
            document.getElementById('compras_tiempo_ciclo').value = ui.item.compras_tiempo_ciclo;
            document.getElementById('compras_planear').value = ui.item.compras_planear;
            document.getElementById('compras_comprar').value = ui.item.compras_comprar;
            document.getElementById('compras_almacenar').value = ui.item.compras_almacenar;


            /*campos cantidad de orden*/
            document.getElementById('cantidad_orden_promedio').value = ui.item.cantidad_orden_promedio;
            document.getElementById('cantidad_orden_minima').value = ui.item.cantidad_orden_minima;
            document.getElementById('cantidad_orden_maxima').value = ui.item.cantidad_orden_maxima;
            document.getElementById('cantidad_orden_multiple').value = ui.item.cantidad_orden_multiple;


            /*campos inventario*/
            document.getElementById('inventario_requiere_inspeccion').checked = ui.item.inventario_requiere_inspeccion === 'Y';
            document.getElementById('inventario_exceso_entrada').value = ui.item.inventario_exceso_entrada;
            document.getElementById('inventario_peso_promedio').value = ui.item.inventario_peso_promedio;
            document.getElementById('inventario_udm_peso').value = ui.item.inventario_udm_peso;


            /*campos seguimiento lotes/serial*/
            document.getElementById('seguimiento_lote_dias_vence').value = ui.item.seguimiento_lote_dias_vence;
            document.getElementById('seguimiento_lote_control_lote').checked = ui.item.seguimiento_lote_control_lote === 'Y';
            document.getElementById('seguimiento_lote_control_ns').checked = ui.item.seguimiento_lote_control_ns === 'Y';
            document.getElementById('seguimiento_lote_multi_entradas').checked = ui.item.seguimiento_lote_multi_entradas === 'Y';
            document.getElementById('seguimiento_lote_lote_cdp').checked = ui.item.seguimiento_lote_lote_cdp === 'Y';
            document.getElementById('seguimiento_lote_ns_cdp').checked = ui.item.seguimiento_lote_ns_cdp === 'Y';


            /*campos recuento ciclico*/
            document.getElementById('recuento_ciclico_codigo').value = ui.item.recuento_ciclico_codigo;
            document.getElementById('recuento_ciclico_tolerancia').value = ui.item.recuento_ciclico_tolerancia;
            document.getElementById('recuento_ciclico_tolerancia_porcentaje').valcue = ui.item.recuento_ciclico_tolerancia_porcentaje;


            /*otros campos (son necesarios para el insert)*/
            document.getElementById('CSTTYP_01').value = ui.item.CSTTYP_01;
            document.getElementById('LABOR_01').value = ui.item.LABOR_01;
            document.getElementById('VOH_01').value = ui.item.VOH_01;
            document.getElementById('FOH_01').value = ui.item.FOH_01;
            document.getElementById('QUMMAT_01').value = ui.item.QUMMAT_01;
            document.getElementById('QUMLAB_01').value = ui.item.QUMLAB_01;
            document.getElementById('QUMVOH_01').value = ui.item.QUMVOH_01;
            document.getElementById('HRS_01').value = ui.item.HRS_01;
            document.getElementById('QUMHRS_01').value = ui.item.QUMHRS_01;
            document.getElementById('PURUOM_01').value = ui.item.PURUOM_01;
            document.getElementById('PERDAY_01').value = ui.item.PERDAY_01;
            document.getElementById('PURCNV_01').value = ui.item.PURCNV_01;
            document.getElementById('TNXDTE_01').value = ui.item.TNXDTE_01;
            document.getElementById('CYCDTE_01').value = ui.item.CYCDTE_01;
            document.getElementById('PURUOM_01').value = ui.item.PURUOM_01;
            document.getElementById('cod_product_original').value = ui.item.id;
            console.log(ui);
        },
        minLength: 2
    });


    $( "#producto_nuevo" ).autocomplete({
        appendTo: "#modal_clonador",
        source: function (request, response) {
            const query = document.getElementById('producto_nuevo').value;
            console.log(query);
            $.ajax({
                url: "/aplicaciones/productos/clonado/obtener_producto_codificador",
                method: "get",
                data: {
                    query: query
                },
                dataType: "json",
                success: function (data) {
                    const resp = $.map(data, function (obj) {
                        return obj
                    });
                    response(resp);
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });
        },
        focus: function(event, ui) {
            $("#maestro_id_pieza").val([ui.item.codigo]);
            $("#maestro_descripcion").val([ui.item.descripcion]);

            return true;
        },
        select: function(event, ui)	{
            $("#maestro_id_pieza").val([ui.item.codigo]);
            $("#maestro_descripcion").val([ui.item.descripcion]);
        },
        minLength: 2
    });


    $("#clonador_form").validate({
        ignore: "",
        rules: {
            maestro_id_pieza:{
                required: true,
                minlength: 10,
                maxlength: 10,
                digits: false
            },
            maestro_descripcion: 'required',
            maestro_tipo_pieza:{
                select_check: true
            },
            maestro_comprador: {
                select_check: true
            },
            maestro_planificador: {
                select_check: true
            },
            maestro_almacen_preferido:{
                select_check: true
            },
            maestro_umd_ldm:{
                select_check: true
            },
            maestro_umd_costo:{
                select_check: true
            },
            maestro_codigo_clase:{
                select_check: true
            },
            maestro_codigo_comodidad:{
                select_check: true
            },
            maestro_costo_unit:{
                required: true
            },

            ingenieria_rendimiento:{
                required: true,
                digits: true,
                minlength: 0,
                maxlength: 100
            },
            ingenieria_desecho:{
                required: true,
                digits: true,
                minlength: 0,
                maxlength: 100
            },
            ingenieria_estado_ingenieria:{
                select_check: true
            },
            ingenieria_cbn:{
                required: true,
                digits: true
            },

            /*contabilidad*/
            contabilidad_tipo_cuenta_contable:{
                select_check: true
            },

            /*planificador*/
            planificador_politica_orden:{
                select_check: true
            },
            planificador_programa:{
                select_check: true
            },
            planificador_tc_critico:{
                required: true,
                digits: true
            },
            planificador_pdr:{
                required: true,
                digits: true
            },
            planificador_cdr:{
                required: true,
                digits: true
            },
            planificador_inventario_seguridad:{
                required: true,
                digits: true
            },


            /*fabricacion*/
            fabricacion_tiempo_ciclo:{
                required: true,
                digits: true
            },
            fabricacion_planear:{
                required: true,
                digits: true
            },
            fabricacion_fabricar:{
                required: true,
                digits: true
            },
            fabricacion_almacenar:{
                required: true,
                digits: true
            },

            /*compras*/
            compras_tiempo_ciclo:{
                required: true,
                digits: true
            },
            compras_planear:{
                required: true,
                digits: true
            },
            compras_comprar:{
                required: true,
                digits: true
            },
            compras_almacenar:{
                required: true,
                digits: true
            },

            /*cantidad orden*/
            cantidad_orden_promedio:{
                required: true,
                digits: true
            },
            cantidad_orden_minima:{
                required: true,
                digits: true
            },
            cantidad_orden_maxima:{
                required: true,
                digits: true
            },
            cantidad_orden_multiple:{
                required: true,
                digits: true
            },

            /*inventario*/
            inventario_peso_promedio:{
                required: true,
            },
            inventario_udm_peso:{
                select_check: true
            },

            /*recuerto ciclico*/
            recuento_ciclico_codigo:{
                select_check: true
            },
            recuento_ciclico_tolerancia:{
                required: true,
            },
            recuento_ciclico_tolerancia_porcentaje:{
                required: true,
                digits: true,
                minlength: 0,
                maxlength: 100,
            }
        },
        errorPlacement: function(error,element) {
            return true;
        },
        highlight: function (element) {
            $(element).closest('.form-control').removeClass('is-valid').addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).closest('.form-control').removeClass('is-invalid');
        },
        submitHandler: function (form) {
            $.ajax({
                data: $('#clonador_form').serialize(),
                url: "/aplicaciones/productos/clonado",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $('#clonador_form').trigger("reset");
                    $('#modal_clonador').modal('hide');
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops',
                        text: data
                    });
                },
                error: function (data) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops',
                        text: data.responseText
                    });
                }
            });
            return false;
        },
    });



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
