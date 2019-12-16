@extends('layouts.dashboard')

@section('page_title', 'Requerimientos')

@section('module_title', 'Requerimientos')

@section('subtitle', 'Este modulo permite ver el estado de los requerimientos y crear nuevos.')
{{--
@section('breadcrumbs')
    {{ Breadcrumbs::render('fact_electr_facturas') }}
@stop--}}

@section('content')
    @can('requerimientos.view')
        <div class="col-lg-12">
            <div class="form-group">
                <span><input type="button" class="btn btn-primary btn-sm NewRequerimiento" id="NewRequerimiento" value="Crear requerimiento"></span>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-responsive table-striped dataTable" id="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Descripcion</th>
                                        <th>Informacion</th>
                                        <th>Creado por</th>
                                        <th>Diseñador asignado</th>
                                        <th>Estado</th>
                                        <th>Fecha Creacion</th>
                                        <th>Ultima Actualizacion</th>
                                        <th>Opciones</th>
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
        <div class="modal fade bd-example-modal-lg" id="NewRequerimientoModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="overflow-y: scroll;">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="NewRequerimientoTitle"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" id="NewRequerimentForm">
                        <div class="modal-body">
                            <div class="row" >
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label for="name" class="control-label">Cliente:</label>
                                        </div>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" name="NewRequirementNameClient" id="NewRequirementNameClient" placeholder="Buscar cliente...">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label for="name" class="control-label">Marca:</label>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="NewRequirementNameMarca" id="NewRequirementNameMarca" placeholder="Buscar marca...">
                                                <input type="button" id="Nueva_marca" name="Nueva_marca" class="btn-success" value="Nuevo">
                                                {{--<a href="javascript:void(0)" class="btn-success" id="Nueva_marca" name="Nueva_marca">x</a>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="name" class="col-sm-6 control-label">Producto:</label>
                                        <div class="col-sm-12">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="CodReqDescription" id="CodReqDescription" placeholder="Buscar un producto existente...">
                                                <input type="button" id="NewRequirementNewDescription" name="NewRequirementNewDescription" class="btn-success" value="Codificar producto">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="name" class="col-sm-12 control-label">¿Render 3D?:</label>
                                        <div class="col-sm-12">
                                            <div class="input-group">
                                                <input type="checkbox" name="Render" checked>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               {{-- <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="name" class="col-sm-12 control-label">¿Planos?:</label>
                                        <div class="col-sm-12">
                                            <div class="input-group">
                                                <input type="checkbox" name="Plano" checked>
                                            </div>
                                        </div>
                                    </div>
                                </div>--}}
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label for="name" class="control-label">Vendedor:</label>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="input-group">
                                                <select name="NewRequirementVendedor" id="NewRequirementVendedor" class="form-control"></select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="name" class="col-sm-6 control-label">Informacion adicional:</label>
                                        <div class="col-sm-12">
                                            <textarea name="NewRequirementNewInfo" id="NewRequirementNewInfo" cols="30" rows="5" class="form-control" placeholder="Escribe toda la informacion relevante para el area de diseño" style="text-transform:uppercase" onkeyup="this.value = this.value.toUpperCase();" ></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label for="exampleInputFile">Archivos:</label>
                                        </div>
                                        <div class="col-sm-12">
                                            <input type="file" class="custom-file" multiple id="archivos[]" name="archivos[]">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary fileinput-upload-button" id="NewRequerimientoSave">Crear</button>
                            <button type="button" class="btn btn-secondary Cerrar" data-dismiss="modal" id="Cerrar">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade bd-example-modal-sm" id="CreateMedidaModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nueva Marca</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="name" class="control-label">Nombre:</label>
                                <input type="text" class="form-control" name="NewRequirementNewMarcaName" id="NewRequirementNewMarcaName" style="text-transform:uppercase">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="name" class="control-label">Descripcion:</label>
                                <textarea class="form-control" name="NewRequirementNewMarcaDescription" id="NewRequirementNewMarcaDescription" cols="30" rows="3" style="text-transform:uppercase">
                                </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary NewRequerimientoMedidaSave" id="NewRequerimientoMedidaSave">Crear</button>
                        <button type="button" class="btn btn-secondary Cerrar" data-dismiss="modal" id="Cerrar">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade bd-example-modal-sm" id="CodificadorModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Codificar producto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="name" class="control-label">Linea:</label>
                                <select name="CodLinea" id="CodLinea" class="form-control"></select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="name" class="control-label">Sublinea:</label>
                                <select name="CodSubLinea" id="CodSubLinea" class="form-control"></select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="name" class="control-label">Caracteristica:</label>
                                <select name="CodCaracteristica" id="CodCaracteristica" class="form-control"></select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="name" class="control-label">Material:</label>
                                <select name="CodMaterial" id="CodMaterial" class="form-control"></select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="name" class="control-label">Medida:</label>
                                <select name="CodMedida" id="CodMedida" class="form-control"></select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary NewCode" id="NewCode">Aceptar</button>
                        <button type="button" class="btn btn-secondary Cerrar" data-dismiss="modal" id="Cerrar">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" id="timelinemodal" name="timelinemodal" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="text-align: right !important; margin-top: 10px; margin-right: 12px">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <br>
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header text-center">
                                <b>INFORMACION GENERAL</b>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label for="name" class="control-label"><b>Cliente:</b></label>
                                                <label id="InfoCliente"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label for="name" class="control-label">Descripcion:</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <label id="InfoDescripcion"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label for="name" class="control-label">Informacion Adicional:</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <label id="InfoInfo"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label for="name" class="control-label">Diseñador Asignado:</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <label id="InfoDiseño"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label for="name" class="control-label">Marca:</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <label id="InfoMarca"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-muted">
                                <label id="InfoDate"></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header text-center">
                                <b></b>
                                <button class="btn btn-default btn-sm" type="button" data-toggle="collapse" data-target="#collapseComents" aria-expanded="false" aria-controls="collapseExample" >
                                    COMENTARIOS <i class="far fa-eye"></i>
                                </button>
                            </div>
                            <div class="collapse" id="collapseComents">
                                <div class="card-body">
                                    <div class="container py-2" id="DetallesComentariosReque">

                                    </div>
                                </div>
                                <div class="card-footer text-muted">
                                    Comentarios generales
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header text-center">
                                <b></b>
                                <button class="btn btn-default btn-sm" type="button" data-toggle="collapse" data-target="#collapsePropuestas" aria-expanded="false" aria-controls="collapseExample" >
                                    PROPUESTAS <i class="far fa-eye"></i>
                                </button>
                            </div>
                            <div class="collapse" id="collapsePropuestas">
                                <div class="card-body" id="PropuestasDiv">

                                </div>
                                <div class="card-footer text-muted">
                                    Propuestas de requerimientos
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-danger" role="alert">
            No tienes permisos para visualizar requerimientos.
        </div>
    @endcan

    @push('javascript')
        <script>
            $(document).ready(function () {
                var Username = @json( Auth::user()->username );

            	var table = $('#table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    autoWidth: true,
                    scrollY: false,
                    scrollX: false,
                    scrollCollapse: true,
                    paging: true,
                    fixedColumns: true,
                    ajax: {
                        url: '/misrequerimientos',
                        data: {
                            Username: Username
                        }
                    },
                    columns: [
                        {data: 'id', name: 'id', orderable: false, searchable: true},
                        {data: 'producto', name: 'producto', orderable: false, searchable: true},
                        {data: 'informacion', name: 'informacion', orderable: false, searchable: false},
                        {data: 'usuario', name: 'usuario', orderable: false, searchable: false},
                        {data: 'name', name: 'name', orderable: false, searchable: false},
                        {data: 'estado', name: 'estado', orderable: false, searchable: false},
                        {data: 'created_at', name: 'created_at', orderable: false, searchable: false},
                        {data: 'updated_at', name: 'updated_at', orderable: false, searchable: false},
                        {data: 'opciones', name: 'opciones', orderable: false, searchable: false},
                    ],
                    language: {
                        // traduccion de datatables
                        processing: "Procesando...",
                        search: "Buscar&nbsp;:",
                        lengthMenu: "Mostrar _MENU_ registros",
                        info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                        infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
                        infoFiltered: "(filtrado de un total de _MAX_ registros)",
                        infoPostFix: "",
                        loadingRecords: "Cargando...",
                        zeroRecords: "No se encontraron resultados",
                        emptyTable: "Ningún registro disponible en esta tabla :C",
                        paginate: {
                            first: "Primero",
                            previous: "Anterior",
                            next: "Siguiente",
                            last: "Ultimo"
                        },
                        aria: {
                            sortAscending: ": Activar para ordenar la columna de manera ascendente",
                            sortDescending: ": Activar para ordenar la columna de manera descendente"
                        }
                    },
                    rowCallback: function (row, data, index) {
                        if (data.name == null) {
                            $(row).find('td:eq(4)').html('<label class="alert-light">Sin asingar</label>');
                        }
                        if (data.estado == '1') {
                            $(row).find('td:eq(5)').html('<label class="alert-light">Pendiente por plano</label>');
                        }
                        if (data.estado == '2') {
                            $(row).find('td:eq(5)').html('<label class="alert-light">Por revisar</label>');
                        }
                        if (data.estado == '3') {
                            $(row).find('td:eq(5)').html('<label class="alert-light">Asignado, pendiente propuestas</label>');
                        }
                    }
                });

                $('#NewRequerimiento').on('click', function () {
                    $('#NewRequerimientoTitle').html('Nuevo Requerimiento');
                    $('#NewRequerimientoModal').modal({
                        backdrop: 'static',
                        keyboard: false,
                    });
                    getUsers();
                });

                function getUsers(){
                    $.ajax({
                        type: "get",
                        url: '/PedidosGetUsers',
                        success: function (data) {
                            var i = 0;
                            $(data).each(function () {
                                $('#NewRequirementVendedor').append('<option value="'+data[i].codvendedor +'">'+data[i].name+' - '+ data[i].codvendedor +'</option>');
                                i++;
                            });
                        }
                    })
                }

                $("#NewRequirementNameClient" ).autocomplete({
                    appendTo: "#NewRequerimientoModal",
                    source: function (request, response) {
                        var client = $("#NewRequirementNameClient").val();
                        $.ajax({
                            url: "/SearchClients",
                            method: "get",
                            data: {
                                query: client,
                            },
                            dataType: "json",
                            success: function (data) {
                                var resp = $.map(data, function (obj) {
                                    return obj
                                });
                                console.log(data);
                                response(resp);
                            }
                        })
                    },
                    minlength: 2
                });

                $("#NewRequirementNameMarca" ).autocomplete({
                    appendTo: "#NewRequerimientoModal",
                    source: function (request, response) {
                        var client = $("#NewRequirementNameMarca").val();
                        $.ajax({
                            url: "/SearchMarcas",
                            method: "get",
                            data: {
                                query: client,
                            },
                            dataType: "json",
                            success: function (data) {
                                var resp = $.map(data, function (obj) {
                                    return obj
                                });
                                console.log(data);
                                response(resp);
                            }
                        })
                    },
                    minlength: 1
                });

                $('body').on('click', '#Nueva_marca', function() {
                    $('#CreateMedidaModal').modal('show');
                });

                $("#CodReqDescription").autocomplete({
                    appendTo: "#NewRequerimientoModal",
                    source: function (request, response) {
                        var Product = $("#CodReqDescription").val();
                        $.ajax({
                            url: "/RequerimientosSearchProductsMax",
                            method: "get",
                            data: {
                                query: Product,
                            },
                            dataType: "json",
                            success: function (data) {
                                var resp = $.map(data, function (obj) {
                                    return obj
                                });
                                response(resp);
                            }
                        })
                    },
                    minlength: 2
                });

                $('#NewCode').on('click',function () {
                    $('#CodReqDescription').val('');
                    var linea = $('#CodLinea').val();
                    var sublinea = $('#CodSubLinea').val();
                    var caracteristica = $('#CodCaracteristica').val();
                    var material = $('#CodMaterial').val();
                    var medida = $('#CodMedida').val();

                    $.ajax({
                        url: "/GetDescription",
                        method: 'get',
                        data: {
                            linea: linea,
                            sublinea: sublinea,
                            caracteristica: caracteristica,
                            material: material,
                            medida: medida
                        },
                        success: function (data) {
                            console.log(data);
                            $('#CodReqDescription').val(data);
                            $('#CodificadorModal').modal('hide');
                        }
                    })
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

                jQuery.validator.addMethod("selectcheck", function(value){
                    return (value != '');
                }, "Por favor, seleciona una opcion.");

                $("#NewRequerimentForm").validate({
                    rules: {
                        NewRequirementNameClient:{
                            required: true,
                        },
                        NewRequirementNameMarca:{
                            required: true,
                        },
                        NewRequirementNewInfo: {
                            required: true
                        },
                    },
                    messages: {
                        NewRequirementNameMarca: " "
                    },
                    submitHandler: function (form) {
                        $('#NewRequerimientoSave').html('Guardando...');
                        var cliente = $('#NewRequirementNameClient').val();
                        var marca = $('#NewRequirementNameMarca').val();
                        var producto = $('#CodReqDescription').val();
                        var vendedor = $('#NewRequirementVendedor').val();
                        var informacion = $('#NewRequirementNewInfo').val();

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            data: {
                                Cliente: cliente,
                                Marca: marca,
                                Producto: producto,
                                Vendedor: vendedor,
                                Informacion: informacion,
                                Render: render,
                                Creado: Username
                            },
                            url: "/NewRequerimiento",
                            type: "POST",
                            dataType: 'json',
                            success: function (data) {
                                $('#NewRequerimientoSave').trigger("reset");
                                $('#NewRequerimientoModal').modal('hide');
                                table.draw();
                                toastr.success("Registro Guardado con Exito!");
                                $(this).html('Crear');
                            },
                            error: function (data) {
                                console.log('Error:', data);
                                $('#NewRequerimientoSave').html('Reintentar');
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

                $('body').on('click', '#NewRequirementNewDescription', function() {
                    $('#CodificadorModal').modal('show');
                    $.get('Requerimientosgetlineas', function(getlineas) {
                        $('#CodLinea').empty();
                        $('#CodLinea').append("<option value=''>Seleccione una linea...</option>");
                        $.each(getlineas, function (index, value) {
                            $('#CodLinea').append("<option value='" + index + "'>"+ value +"</option>");
                        })
                    });
                });

                $('#CodLinea').on('change', function () {
                    var lineas_id =  $(this).val().substring(0,);
                    if ($.trim(lineas_id) != '') {
                        $.get('getsublineas', {lineas_id: lineas_id}, function (getsublineas) {
                            $('#CodSubLinea').empty();
                            $('#CodSubLinea').append("<option value=''>Seleccione una sublinea...</option>");
                            $.each(getsublineas, function (index, value) {
                                $('#CodSubLinea').append("<option value='" + index + "'>" + value + "</option>");
                            })
                        });
                    }else{
                        $('#CodSubLinea').empty();
                        $('#CodSubLinea').append("<option value=''>Seleccione una sublinea...</option>");
                        $('#CodCaracteristica').empty();
                        $('#CodCaracteristica').append("<option value=''>Seleccione una caracteristica...</option>");
                    }
                });

                $('#CodSubLinea').on('change', function () {
                    var  sublineas_id = $(this).val();
                    if ($.trim(sublineas_id) != '') {
                        $.get('getcaracteristica', {car_sublineas_id: sublineas_id}, function (getcaracteristica) {
                            $('#CodCaracteristica').empty();
                            $('#CodCaracteristica').append("<option value=''>Seleccione una caracteristica...</option>");
                            $.each(getcaracteristica, function (index, value) {
                                $('#CodCaracteristica').append("<option value='" + index + "'>" + value + "</option>");
                            })
                        });
                    }else{
                        $('#CodCaracteristica').empty();
                        $('#CodCaracteristica').append("<option value=''>Seleccione una caracteristica...</option>");
                    }

                    if ($.trim(sublineas_id) != ''){
                        $.get('getmaterial',{mat_sublineas_id: sublineas_id}, function(getmaterial) {
                            $('#CodMaterial').empty();
                            $('#CodMaterial').append("<option value=''>Seleccione un material...</option>");
                            $.each(getmaterial, function (index, value) {
                                $('#CodMaterial').append("<option value='" + index + "'>"+ value +"</option>");
                            })
                        });
                    }else{
                        $('#CodMaterial').empty();
                        $('#CodMaterial').append("<option value=''>Seleccione una caracteristica...</option>");
                    }

                    if ($.trim(sublineas_id) != ''){
                        $.get('getmedida',{med_sublineas_id: sublineas_id}, function(getmedida) {
                            $('#CodMedida').empty();
                            $('#CodMedida').append("<option value=''>Seleccione una medida...</option>");
                            $.each(getmedida, function (index, value) {
                                $('#CodMedida').append("<option value='" + index + "'>"+ value +"</option>");
                            })
                        });
                    }else{
                        $('#CodMedida').empty();
                        $('#CodMedida').append("<option value=''>Seleccione una caracteristica...</option>");
                    }
                });

                var render = 1;
                $("[name='Render']").bootstrapSwitch({
                    animate: true,
                    onColor: 'success',
                    offColor: 'danger',
                    onText: 'SI',
                    offText: 'NO',
                    size: 'large'
                }).on('switchChange.bootstrapSwitch', function (event, state) {
                    if(state === true){
                        render = 1;
                    }else{
                        render = 0;
                    }
                });

        /*        var plano = 1;
                $("[name='Plano']").bootstrapSwitch({
                    animate: true,
                    onColor: 'success',
                    offColor: 'danger',
                    onText: 'SI',
                    offText: 'NO',
                    size: 'large'
                }).on('switchChange.bootstrapSwitch', function (event, state) {
                    if(state === true){
                        plano = 1;
                    }else{
                        plano = 0;
                    }
                });*/


                $('body').on('click','.addComment',function () {
                    var id = $(this).attr('id');
                    Swal.fire({
                        title: 'Requerimiento # ' + id,
                        html: '<label for="">Añade comentarios o informacion que pueda ser importante para este requerimiento</label> ',
                        input: 'textarea',
                        icon: 'info',
                        inputAttributes: {
                            autocapitalize: 'off'
                        },
                        showCancelButton: true,
                        confirmButtonText: 'Guardar!',
                        cancelButtonText: 'Cancelar',
                        showLoaderOnConfirm: true,
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if (result.value) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                type: "post",
                                url: '/MisRequerimientosAddComent',
                                data: {
                                	idReq: id,
                                    coments: result.value,
                                    user: Username
                                },
                                success: function () {
                                    Swal.fire({
                                       icon: 'success',
                                       title: 'Guardado!',
                                       text: 'Tu comentario fue enviado con exito!',
                                       confirmButtonText: 'Aceptar',
                                    })
                                }
                            });
                        } else {
                            result.dismiss === Swal.DismissReason.cancel
                        }
                    })
                });

                $('body').on('click','.Anular',function () {
                    var id = $(this).attr('id');
                    console.log(id);
                    Swal.fire({
                        title: '¿Esta seguro de anular el requerimiento # '+ id +'?',
                        text: "¡Esta accion no se puede revertir!",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, anular!',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.value) {
                            $.ajax({
                                type: "post",
                                url: "/MisRequerimientosAnular",
                                data: {
                                    numeroReq: id,
                                    user: Username
                                },
                                success: function (data) {
                                    Swal.fire({
                                        title: 'Anulado!',
                                        text: 'El requerimiento '+ id +'ha sido anulado.',
                                        icon: 'success',
                                    });
                                    table.draw();
                                },
                                error: function (data) {
                                    Swal.fire(
                                        'Error al anular!',
                                        'Hubo un error al anular.',
                                        'error'
                                    )
                                }
                            });
                        }else {
                           /* Read more about handling dismissals below */
                           result.dismiss === Swal.DismissReason.cancel
                        }
                    })

                });

                $('body').on('click', '.Coments', function () {
                    var id = $(this).attr('id');
                    $.ajax({
                        type: 'get',
                        url: '/RequerimientosComentariosDetalles',
                        data: {
                       	   id: id
                        },
                        success: function (data) {
                           console.log(data);
                        	var i = 0;
                        	$('#InfoCliente').html(data.encabezado[0].cliente);
                            $('#InfoDescripcion').html(data.encabezado[0].producto);
                            $('#InfoInfo').html(data.encabezado[0].informacion);
                            $('#InfoMarca').html(data.encabezado[0].marca);
                            $('#InfoDate').html(data.encabezado[0].created_at);

                            $(data.Datos).each(function () {
                                if (i % 2 == 0)
                                {
                                    $('#DetallesComentariosReque').append('<div class="row no-gutters">' +
                                         '<div class="col-sm"></div>' +
                                         '<div class="col-sm-1 text-center flex-column d-none d-sm-flex">' +
                                         '<div class="row h-50">' +
                                         '<div class="col border-right">&nbsp;</div>' +
                                         '<div class="col">&nbsp;</div>' +
                                         '</div>' +
                                         '<h5 class="m-2">' +
                                         '<span class="badge badge-pill bg-primary-light" style="height: 25px; line-height: 25px; border-radius: 25px ; width: 25px;">&nbsp;</span>' +
                                         '</h5>' +
                                         '<div class="row h-50">' +
                                         '<div class="col border-right">&nbsp;</div>' +
                                         '<div class="col">&nbsp;</div>' +
                                         '</div>' +
                                         '</div>' +
                                         '<div class="col-sm py-2">' +
                                         '<div class="card border-success shadow">' +
                                         '<div class="card-body">' +
                                         '<div class="float-right text-primary small">'+ data.Datos[i].created_at +'</div>' +
                                         '<h4 class="card-title text-primary">'+ data.Datos[i].usuario +'</h4>' +
                                         '<p class="card-text">'+ data.Datos[i].descripcion +'</p>' +
                                         '</div></div>' +
                                         '</div></div>'
                                    )
                                }
                                else{
                                	$('#DetallesComentariosReque').append('<div class="row no-gutters">' +
                                          '<div class="col-sm py-2">' +
                                          '<div class="card border-success shadow">' +
                                          '<div class="card-body">' +
                                          '<div class="float-right text-primary small">'+ data.Datos[i].created_at +'</div>' +
                                          '<h4 class="card-title text-primary">'+ data.Datos[i].usuario +'</h4>' +
                                          '<p class="card-text">'+ data.Datos[i].descripcion +'</p>' +
                                          '</div>' +
                                          '</div>' +
                                          '</div>' +
                                          '<div class="col-sm-1 text-center flex-column d-none d-sm-flex">' +
                                          '<div class="row h-50">' +
                                          '<div class="col border-right">&nbsp;</div><' +
                                          'div class="col">&nbsp;</div>' +
                                          '</div>' +
                                          '<h5 class="m-2">' +
                                          '<span class="badge badge-pill bg-primary-light" style="height: 25px; line-height: 25px; border-radius: 25px ; width: 25px;">&nbsp;</span>' +
                                          '</h5>' +
                                          '<div class="row h-50">' +
                                          '<div class="col border-right">&nbsp;</div>' +
                                          '<div class="col">&nbsp;</div>' +
                                          '</div>' +
                                          '</div>' +
                                          '<div class="col-sm">' +
                                          '</div></div>'
                                    )
                                }
                           	 i++;
                            });

                            var tes = 1;

                            console.log(data.propuestas.length);

                            if(data.propuestas.length == 0){
                                $('#PropuestasDiv').append('<div class="alert alert-danger" role="alert">ESTE REQUERIMIENTO AUN NO TIENE PROPUESTAS...</div>');

                            }else{
                               var ii = 0;
                               $(data.propuestas).each(function () {

                               	ii++;
                               });
                            }

                            $('#timelinemodal').modal('show');
                        }
                    })
                });

                $('#timelinemodal').on('hide.bs.modal', function () {
                    $('#DetallesComentariosReque').html('');
                })

            })
        </script>
        <link href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.css" rel="stylesheet"/>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/js/bootstrap.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://adminlte.io/themes/dev/AdminLTE/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/css/bootstrap3/bootstrap-switch.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.3.10/dist/sweetalert2.all.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">

    @endpush
@stop
