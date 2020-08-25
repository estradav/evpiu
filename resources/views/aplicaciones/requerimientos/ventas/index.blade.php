@extends('layouts.architectui')

@section('page_title', 'Mis requerimientos')

@section('content')
    @can('aplicaciones.requerimientos.vendedor')
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-paint icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>Requerimientos
                        <div class="page-title-subheading">
                            Listado de requerimientos
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    @can('aplicaciones.requerimientos.vendedor')
                    <div class="card-header">
                        <div class="col-md-0 float-right">
                            <button class="btn btn-primary" id="nuevo"> <i class="fas fa-plus-circle"></i> Nuevo</button>
                        </div>
                    </div>
                    @endcan
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped" id="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>DESCRIPCION</th>
                                        <th>INFORMACION</th>
                                        <th>VENDEDOR</th>
                                        <th>DISEÑADOR</th>
                                        <th>ESTADO</th>
                                        <th>FECHA CREACION</th>
                                        <th>ULTIMA ACTUALIZACION</th>
                                        <th>ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach( $data as $row )
                                        <tr>
                                            <td>{{ $row->id }}</td>
                                            <td>{{ $row->producto }}</td>
                                            <td>{{ $row->informacion }}</td>
                                            <td>{{ \App\User::find($row->vendedor_id)->name }}</td>
                                            <td>{!! \App\User::find($row->diseñador_id)->name ?? '<span class="badge badge-danger">Sin asignar</span>' !!}</td>
                                            <td>
                                                @if ( $row->estado == 0 )
                                                    <span class="badge badge-danger">Anulado</span>
                                                @elseif( $row->estado == 1 )
                                                    <span class="badge badge-primary">Pendiente revision</span>
                                                @elseif( $row->estado == 2 )
                                                    <span class="badge badge-info">Asignado</span>
                                                @elseif( $row->estado == 3 )
                                                    <span class="badge badge-success">Iniciado</span>
                                                @elseif( $row->estado == 4 )
                                                    <span class="badge badge-success">Finalizado</span>
                                                @elseif( $row->estado == 5 )
                                                    <span class="badge badge-danger">Anulado diseño</span>
                                                @elseif( $row->estado == 6 )
                                                    <span class="badge badge-warning">Rechazado</span>
                                                @endif
                                            </td>
                                            <td>{{ $row->created_at }}</td>
                                            <td>{{ \Carbon\Carbon::parse($row->updated_at )->diffForHumans() }}</td>
                                            <td>
                                                <a href="{{ route('ventas.edit', $row->id) }}" class="btn btn-light btn-sm"><i class="fas fa-eye"></i> VER </a>
                                            </td>
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
    <div class="modal fade" id="nuevo_modal" tabindex="-1" role="dialog" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    Nuevo requerimiento
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form">
                    <div class="modal-body">
                        <div class="row" >
                            <div class="col-sm-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Cliente</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Cliente" aria-label="cliente" name="cliente" id="cliente">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Marca</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Marca" aria-label="Marca" name="marca" id="marca">
                                    <div class="input-group-append">
                                        <button type="button" id="nueva_marca" name="nueva_marca" class="btn btn-success">Crear marca</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Producto</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Escriba al menos 2 caracteres" aria-label="producto" name="producto" id="producto">
                                    <div class="input-group-append">
                                        <button type="button" id="codificar_producto" name="codificar_producto" class="btn btn-success">Codificar producto</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <input type="checkbox" aria-label="render" id="render" name="render">
                                        </div>
                                    </div>
                                    <input class="form-control" value="¿Render 3D?" aria-label="render" disabled>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Vendedor</span>
                                    </div>
                                    <select class="form-control" name="vendedor" id="vendedor" aria-label="vendedor">
                                        <option value="" selected>Seleccione...</option>
                                        @foreach( $vendedores as $v)
                                            <option value="{{ $v->id }}">{{ $v->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Informacion adicional</span>
                                    </div>
                                    <textarea class="form-control" name="info" id="info" aria-label="With textarea"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="crear_requerimiento">Crear</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="marca_modal" tabindex="-1" role="dialog" aria-labelledby="marca_modal" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nueva marca</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="marca_form">
                    <div class="modal-body">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="name" class="control-label">Nombre:</label>
                                <input type="text" class="form-control" name="nombre_marca" id="nombre_marca" style="text-transform:uppercase" onkeyup="this.value = this.value.toUpperCase();">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="tipo_marca">Tipo:</label>
                                <select name="tipo_marca" id="tipo_marca"  class="form-control">
                                    <option value="" selected>Seleccione...</option>
                                    <option value="GL">Generico Liso</option>
                                    <option value="GM">Generico Marcado</option>
                                    <option value="MP">Marca Propia</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="comentario_marca" class="control-label">Comentario:</label>
                                <textarea class="form-control" name="comentario_marca" id="comentario_marca" cols="30" rows="3" style="text-transform:uppercase" onkeyup="this.value = this.value.toUpperCase();"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Crear</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="Cerrar">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('javascript')
    <script type="text/javascript">
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $(document).on('click', '#nuevo', function () {
                $('#nuevo_modal').modal('show');
            });


            $(document).on('click', '#nueva_marca', function() {
                $('#marca_modal').modal('show');
            });


            $('#table').dataTable({
                language: {
                    url: '/Spanish.json'
                },
            });


            let nit_cliente;
            $("#cliente" ).autocomplete({
                appendTo: "#nuevo_modal",
                source: function (request, response) {
                    const query = document.getElementById('cliente').value;
                    $.ajax({
                        url: "/aplicaciones/requerimientos/ventas/listar_clientes",
                        method: "get",
                        data: {
                            query: query,
                        },
                        dataType: "json",
                        success: function (data) {
                            const resp = $.map(data, function (obj) {
                                return obj
                            });
                            response(resp);
                        }
                    })
                },
                focus: function (event, ui) {
                    nit_cliente = ui.item.nit;
                    return true;
                },
                select: function (event, ui) {
                    nit_cliente = ui.item.nit;
                },
                minlength: 2
            });


            let marca_id;
            $("#marca" ).autocomplete({
                appendTo: "#nuevo_modal",
                source: function (request, response) {
                    const query = document.getElementById('marca').value;
                    $.ajax({
                        url: "/aplicaciones/requerimientos/ventas/listar_marcas",
                        method: "get",
                        data: {
                            query: query,
                        },
                        dataType: "json",
                        success: function (data) {
                            const resp = $.map(data, function (obj) {
                                return obj
                            });
                            response(resp);
                        },
                    });
                },
                focus: function (event, ui) {
                    marca_id = ui.item.id;
                    return true;
                },
                select: function (event, ui) {
                    marca_id = ui.item.id;
                },
                minlength: 1
            });


            let producto_id;
            $("#producto").autocomplete({
                appendTo: "#nuevo_modal",
                source: function (request, response) {
                    const query = document.getElementById('producto').value;
                    $.ajax({
                        url: "/aplicaciones/requerimientos/ventas/listar_productos",
                        method: "get",
                        data: {
                            query: query,
                        },
                        dataType: "json",
                        success: function (data) {
                            const resp = $.map(data, function (obj) {
                                return obj
                            });
                            response(resp);
                        }
                    });
                },
                focus: function (event, ui) {
                    producto_id = ui.item.id;
                    return true;
                },
                select: function (event, ui) {
                    producto_id = ui.item.id;
                },
                minlength: 2
            });


            $('#marca_form').validate({
                rules: {
                    nombre_marca: {
                        required: true,
                        regx: /^([A-Z]{1,2})/i,
                        minlength: 5,
                        remote: {
                            url: '/aplicaciones/requerimientos/ventas/validar_marca',
                            type: 'POST',
                            async: false,
                        },
                    },
                    tipo_marca:{
                        select_check: true
                    },
                    comentario_marca: {
                        required: true,
                        minlength: 10
                    }
                },
                submitHandler: function (form) {
                    $.ajax({
                        data: $('#marca_form').serialize(),
                        url: "/aplicaciones/requerimientos/ventas/guardar_marca",
                        type: "POST",
                        dataType: 'json',
                        success: function (data) {
                            $('#marca_form').trigger("reset");
                            $('#marca_modal ').modal('hide');
                            toastr.success(data);
                        },
                        error: function (data) {
                            toastr.error(data.responseText);
                        }
                    });
                    return false;
                },
                highlight: function (element) {
                    $(element).closest('.form-control').removeClass('is-valid').addClass('is-invalid');
                },
                unhighlight: function (element) {
                    $(element).closest('.form-control').removeClass('is-invalid');
                },
            });


            $("#form").validate({
                rules: {
                    cliente:{
                        required: true,
                    },
                    marca:{
                        required: true,
                    },
                    info: {
                        required: true
                    },
                    producto: {
                        required: true
                    },
                    vendedor: {
                        select_check: true
                    }
                },
                errorPlacement: function(error,element) {
                    return true;
                },
                submitHandler: function (form) {
                    $.ajax({
                        data: {
                            producto_id: producto_id,
                            info: document.getElementById('info').value,
                            cliente: document.getElementById('cliente').value,
                            nit: nit_cliente,
                            marca_id: marca_id,
                            render: document.getElementById('render').checked,
                            vendedor_id: document.getElementById('vendedor').value,
                        },
                        url: "/aplicaciones/requerimientos/ventas",
                        type: "POST",
                        dataType: 'json',
                        success: function () {
                            $('#form').trigger("reset");
                            $('#nuevo_modal ').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Guardado!',
                                text: 'Requerimiento creado con exito!',
                                showCancelButton: false,
                                confirmButtonText: 'Guardar!',
                                cancelButtonText: 'Cancelar',
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                            });

                            setTimeout(function() {
                                window.location.reload(true)
                            }, 2000);
                        },
                        error: function (data) {
                            toastr.error(data.responseText);
                        }
                    });
                    return false;
                },
                highlight: function (element) {
                    $(element).closest('.form-control').removeClass('is-valid').addClass('is-invalid');
                },
                unhighlight: function (element) {
                    $(element).closest('.form-control').removeClass('is-invalid');
                },
            });


            jQuery.extend(jQuery.validator.messages, {
                required: "Este campo es obligatorio.",
                remote: "Esta marca ya fue creada...",
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


            $.validator.addMethod("regx", function(value, element, regexpr) {
                return regexpr.test(value);
            }, "El nombre debe empezar con una letra.");
        });
    </script>
@endpush

@push('styles')
@endpush
