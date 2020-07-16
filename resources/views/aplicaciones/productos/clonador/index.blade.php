@extends('layouts.architectui')

@section('page_title', 'Clonador / Creador')

@section('content')
    @can('aplicaciones.productos.clonador.index')
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-repeat icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>Clonador - Creador
                        <div class="page-title-subheading">
                            Clonador / Creador de productos
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">
                        <div class="col-6">
                            <div class="text-left">
                                @can('aplicaciones.productos.clonador.nuevo')
                                    <a class="btn btn-primary" href="javascript:void(0)" id="clonar_producto">Crear / Clonar</a>
                                @endcan
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-right">
                                @can('aplicaciones.productos.codificador.nuevo')
                                    <a class="btn btn-primary" href="javascript:void(0)" id="nuevo_codigo">Codificador</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm" id="table">
                                <thead>
                                    <tr>
                                        <th>NUMERO</th>
                                        <th>DESCRIPCION</th>
                                        <th>CREADO</th>
                                        <th>ULTIMA ACTUALIZACION</th>
                                        <th>MODIFICADO POR</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $row)
                                        <tr>
                                            <td>{{ $row->id }}</td>
                                            <td>{{ $row->desc }}</td>
                                            <td>{{ $row->Creado }}</td>
                                            <td>{{ $row->update }}</td>
                                            <td>{{ $row->Creado }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-exclamation-triangle fa-4x" style="color: red"></i>
                <h3 class="card-title" style="color: red"> ACCESO DENEGADO </h3>
                <h3 class="card-text" style="color: red">No tiene permiso para usar esta aplicación, por favor comuníquese a la ext: 102 o escribanos al correo electrónico: auxsistemas@estradavelasquez.com para obtener acceso.</h3>
            </div>
        </div>
    @endcan
@endsection

@section('modal')
    @include('aplicaciones.productos.codificador.modal')
    @include('aplicaciones.productos.clonador.modal')
@endsection

@push('javascript')
    <script>
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
                    const query = this.value;
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
                    });
                },
                focus: function (event, ui) {
                    console.log(ui);
                    return true;
                },
                select: function(event, ui){

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








                    console.log(ui);
                },
                minLength: 2
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
    </script>

@endpush
