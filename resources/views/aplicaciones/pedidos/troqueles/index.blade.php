@extends('layouts.architectui')

@section('page_title', 'Pedidos (Troqueles)')

@section('action_recaptcha')
    {!! htmlScriptTagJsApi([ 'action' => 'pedidos_troqueles' ]) !!}
@stop

@section('content')
    @can('aplicaciones.pedidos.troqueles.index')
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-box2 icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>Troqueles
                        <div class="page-title-subheading">
                            Gestion de pedidos
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">
                        Pedidos Pendientes
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm" id="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>OC</th>
                                        <th>COD CLIENTE</th>
                                        <th>CLIENTE</th>
                                        <th>VENDEDOR</th>
                                        <th>CONDICION PAGO</th>
                                        <th>DESCUENTO</th>
                                        <th>IVA</th>
                                        <th>SUB ESTADO</th>
                                        <th>FECHA CREACION</th>
                                        <th style="text-align:center ">ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="main-card mb-3 card">
                    <div class="card-header">
                        Pedidos terminados
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm" id="table_terminados">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>OC</th>
                                        <th>PED MAX</th>
                                        <th>COD CLIENTE</th>
                                        <th>CLIENTE</th>
                                        <th>VENDEDOR</th>
                                        <th>CONDICION PAGO</th>
                                        <th>DESCUENTO</th>
                                        <th>IVA</th>
                                        <th>ESTADO</th>
                                        <th>FECHA CREACION</th>
                                        <th style="text-align:center ">ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
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
    @include('aplicaciones.pedidos.ventas.pdf_modal')


    <div class="modal fade" id="opciones" tabindex="-1" role="dialog" aria-labelledby="opciones" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="opciones_title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form" name="form">
                    <input type="hidden" name="id" id="id">
                    <div class="modal-body">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="estado" class="control-label" ><b>Estado:&nbsp;&nbsp;</b></label>
                                <select name="estado" id="estado" class="form-control">
                                    <option value="" selected>Seleccione...</option>
                                    <option value="12">Rechazar y enviar al vendedor</option>
                                    <option value="10">Finalizar</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="descripcion" class="control-label" ><b>Descripcion:&nbsp;&nbsp;</b></label>
                                <textarea name="descripcion" id="descripcion" cols="30" rows="5" class="form-control" placeholder="Por favor escriba una descripcion"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">GUARDAR</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('javascript')
    <script type="text/javascript" src="{{ asset('aplicaciones/pedidos/ventas/modal.js') }}"></script>
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $('#table').dataTable({
                ajax: {
                    url: '/aplicaciones/pedidos/troqueles'
                },
                columns: [
                    {data: 'id', name: 'id', orderable: false, searchable: false},
                    {data: 'OrdenCompra', name: 'OrdenCompra', orderable: false, searchable: true},
                    {data: 'CodCliente', name: 'CodCliente', orderable: false, searchable: true},
                    {data: 'cliente.RAZON_SOCIAL', name: 'cliente.RAZON_SOCIAL', orderable: false, searchable: true},
                    {data: 'vendedor.name', name: 'vendedor.name', orderable: false, searchable: true},
                    {data: 'cliente.PLAZO', name: 'cliente.PLAZO', orderable: false, searchable: true},
                    {data: 'Descuento', name: 'Descuento', orderable: false, searchable: false, render: $.fn.dataTable.render.number('', '', 0, '% ')},
                    {data: 'Iva', name: 'Iva', orderable: false, searchable: false},
                    {data: 'info_area.Troqueles', name: 'info_area.Troqueles', orderable: false, searchable: true},
                    {data: 'created_at', name: 'created_at', orderable: false, searchable: false},
                    {data: 'opciones', name: 'opciones', orderable: false, searchable: false},
                ],
                language: {
                    url: '/Spanish.json'
                },
                order: [
                    [ 0, "asc" ]
                ],
                rowCallback: function (row, data, index) {
                    if (data.Iva == 'Y') {
                        $(row).find('td:eq(7)').html('<span class="badge badge-success">SI</span>');
                    }
                    else{
                        $(row).find('td:eq(7)').html('<span class="badge badge-danger">NO</span>');
                    }
                    if(data.info_area.Troqueles == 11){
                        $(row).find('td:eq(8)').html('<span class="badge badge-success">Pendiente</span>');
                    }

                    if(data.info_area.Troqueles == 12){
                        $(row).find('td:eq(8)').html('<span class="badge badge-warning">Rechazado</span>');
                    }
                }
            });
            
            
            $('#table_terminados').DataTable({
                ajax: {
                    url:'/aplicaciones/pedidos/produccion/listar_terminados',
                },
                columns: [
                    {data: 'id', name: 'id', orderable: false, searchable: true},
                    {data: 'OrdenCompra', name: 'OrdenCompra', orderable: false, searchable: true},
                    {data: 'Ped_MAX', name: 'Ped_MAX', orderable: false, searchable: true},
                    {data: 'CodCliente', name: 'CodCliente', orderable: false, searchable: true},
                    {data: 'cliente.RAZON_SOCIAL', name: 'cliente.RAZON_SOCIAL', orderable: false, searchable: true},
                    {data: 'vendedor.name', name: 'vendedor.name', orderable: false, searchable: true},
                    {data: 'cliente.PLAZO', name: 'cliente.PLAZO', orderable: false, searchable: false},
                    {data: 'Descuento', name: 'Descuento', orderable: false, searchable: false, render: $.fn.dataTable.render.number('', '', 0, '% ')},
                    {data: 'Iva', name: 'Iva', orderable: false, searchable: false},
                    {data: 'Estado', name: 'Estado', orderable: false, searchable: true},
                    {data: 'created_at', name: 'created_at', orderable: false, searchable: false},
                    {data: 'opciones', name: 'opciones', orderable: false, searchable: false},

                ],
                language: {
                    url: '/Spanish.json'
                },
                order: [
                    [ 0, "desc" ]
                ],
                rowCallback: function (row, data, index) {
                    if (data.Estado == 10) {
                        $(row).find('td:eq(9)').html('<span class="badge badge-success">Finalizado</span>');
                    }else{
                        $(row).find('td:eq(9)').html('<span class="badge badge-danger">Error</span>');
                    }
                    if (data.Iva == 'Y') {
                        $(row).find('td:eq(8)').html('<span class="badge badge-success">SI</span>');
                    } else{
                        $(row).find('td:eq(8)').html('<span class="badge badge-danger">NO</span>');
                    }

                    if (data.Ped_MAX){
                        $(row).find('td:eq(2)').html('<span class="badge badge-success">'+ data.Ped_MAX +'</span>');
                    }else{
                        $(row).find('td:eq(2)').html('<span class="badge badge-danger">N/A</span>');
                    }
                }
            });
            
            


            $(document).on('draw.dt', '#table', function() {
                $('[data-toggle="tooltip"]').tooltip();
            });


            $(document).on('click', '.opciones', function () {
                $('input').closest('.form-control').removeClass('is-invalid');
                $('select').closest('.form-control').removeClass('is-invalid');
                $('.error').remove();
                $('#form').trigger('reset');

                let id = this.id;
                document.getElementById('id').value = id;

                $('#opciones').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $('#opciones_title').html('Pedido #' + id)
            });



            $("#form").validate({
                ignore: "",
                rules: {
                    estado: {
                        select_check: true
                    },
                    descripcion: {
                        required: true,
                        minlength: 10,
                        maxlength: 250
                    }
                },
                highlight: function (element) {
                    $(element).closest('.form-control').removeClass('is-valid').addClass('is-invalid');
                },
                unhighlight: function (element) {
                    $(element).closest('.form-control').removeClass('is-invalid');
                },
                submitHandler: function (form) {
                    let estado = document.getElementById('estado').value;

                    if (estado == 10){
                        Swal.fire({
                            title: '¿Finalizar pedido y subir a MAX?',
                            html: "<span class='badge badge-danger'>ESTA ACCION NO ES REVERSIBLE </span>",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: '¡Si, finalizar!',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    data: $('#form').serialize(),
                                    url: "/aplicaciones/pedidos/troqueles/actualizar_estado",
                                    type: "POST",
                                    dataType: 'json',
                                    success: function (data) {
                                        $('#opciones').modal('hide');
                                        $('#table').DataTable().ajax.reload();
                                        $('#table_terminados').DataTable().ajax.reload();
                                        toastr.success(data);
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
                        })
                    }else{
                        $.ajax({
                            data: $('#form').serialize(),
                            url: "/aplicaciones/pedidos/troqueles/actualizar_estado",
                            type: "POST",
                            dataType: 'json',
                            success: function (data) {
                                $('#opciones').modal('hide');
                                $('#table').DataTable().ajax.reload();
                                $('#table_terminados').DataTable().ajax.reload();
                                toastr.success(data);
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
                    return false;
                }
            });


            jQuery.extend(jQuery.validator.messages, {
                required: "Este campo es obligatorio.",
                remote: "Por favor, rellena este campo.",
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
