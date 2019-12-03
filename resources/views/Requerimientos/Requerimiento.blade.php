@extends('layouts.dashboard')

@section('page_title', 'Requerimientos')

@section('module_title', 'Requerimientos')

@section('subtitle', 'Modulo de administracion de requerimientos.')
{{--
@section('breadcrumbs')
    {{ Breadcrumbs::render('fact_electr_facturas') }}
@stop--}}

@section('content')
    @can('requerimientos.view')


        <div class="col-lg-12">
            <div class="form-group">
                <span><input type="button" class="btn btn-primary btn-sm NewRequerimiento" id="NewRequerimiento" value="Crear requerimiento"></span>
                <span><input type="button" class="btn btn-primary btn-sm ViewRequerimiento" id="ViewRequerimiento" value="Panel de estadisticas"></span>
            </div>
        </div>
        <br>

        <div class="col-lg-12">
            <div class="form-group">
                <ul class="nav nav-tabs " id="nav">
                    <li class="nav-item">
                        <a class="nav-link Por_revisar active" href="javascript:void(0)" id="1">Por revisar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link Rediligenciar" href="javascript:void(0)" id="2">Rediligenciar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link Por_Plano" href="javascript:void(0)" id="3">Por Plano</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link Asignados" href="javascript:void(0)" id="4">Asignados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link Iniciados" href="javascript:void(0)" id="5">Iniciados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link Renderizando" href="javascript:void(0)" id="6">Renderizando</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link Por_Aprobar" href="javascript:void(0)" id="7">Por aprobar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link Por_Corregir" href="javascript:void(0)" id="8">Por corregir</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link Aprobados" href="javascript:void(0)" id="9">Aprobados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link Cerrados" href="javascript:void(0)" id="10">Cerrados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link Anulado" href="javascript:void(0)" id="11">Anulados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link Sin_Aprobar" href="javascript:void(0)" id="12">Sin aprobar</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-responsive table-striped dataTable" id="table">
                                <thead>
                                    <tr>
                                        <th>Numero</th>
                                        <th>Descripcion</th>
                                        <th>Informacion</th>
                                        <th>Creado por</th>
                                        <th>Diseñador</th>
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
                                        <label for="name" class="col-sm-12 control-label">¿El requerimiento necesita Render 3D?:</label>
                                        <div class="col-sm-12">
                                            <div class="input-group">
                                                <input type="checkbox" name="my-checkbox" checked>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                                            <textarea name="NewRequirementNewInfo" id="NewRequirementNewInfo" cols="30" rows="5" class="form-control" placeholder="Escribe toda la informacion relevante para el area de diseño"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label for="exampleInputFile">Archivos:</label>
                                        </div>
                                        <div class="col-sm-12">
                                            {!!csrf_field() !!}
                                            <div class="file-loading">
                                                <input id="file-loader" type="file" name="file" multiple>
                                            </div>
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
                                <input type="text" class="form-control" name="NewRequirementNewMarcaName" id="NewRequirementNewMarcaName">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="name" class="control-label">Descripcion:</label>
                                <textarea class="form-control" name="NewRequirementNewMarcaDescription" id="NewRequirementNewMarcaDescription" cols="30" rows="3">
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


    @else
        <div class="alert alert-danger" role="alert">
            No tienes permisos para visualizar requerimientos.
        </div>
    @endcan
    @push('javascript')
        <script>
            $(document).ready(function() {
                var table;
                var Estado = 1;

                var idDiseno =  @json( Auth::user()->diseñador);
                var Username = @json( Auth::user()->username );

                load_data(Estado, idDiseno, Username);
                function load_data(Estado = '', idDiseno = '', Username = '') {
                    table = $('#table').DataTable({
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
                            url: '/RequerimientosIndex',
                            data: {
                            	estado: Estado,
                                perfil: idDiseno,
                                asignado: Username
                            }
                        },
                        columns: [
                            {data: 'id', name: 'id', orderable: false, searchable: true},
                            {data: 'descripcion', name: 'descripcion', orderable: false, searchable: true},
                            {data: 'informacion', name: 'informacion', orderable: false, searchable: false},
                            {data: 'usuario', name: 'usuario', orderable: false, searchable: false},
                            {data: 'diseñador', name: 'diseñador', orderable: false, searchable: false},
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
                            /*if (data.estado == 5) {
                                $(row).find('td:eq(9)').html('<label class="alert-danger">Cancelado</label>');
                            }*/
                        }
                    })
                }

                $('.Por_revisar').click(function () {
                    Estado = $(this).attr("id");

                    if (Estado != '') {
                        $('.dataTable').DataTable().destroy();
                        load_data(Estado, idDiseno);
                    } else {
                        toastr.error("Error al consultar los pronosticos Cerrados.");
                    }
                });

                $('.Rediligenciar').click(function () {
                    Estado = $(this).attr("id");

                    if (Estado != '') {
                        $('.dataTable').DataTable().destroy();
                        load_data(Estado, idDiseno);
                    } else {
                        toastr.error("Error al consultar Requerimientos.");
                    }
                });

                $('.Por_Plano').click(function () {
                    Estado = $(this).attr("id");
                    if (Estado != '') {
                        $('.dataTable').DataTable().destroy();
                        load_data(Estado, idDiseno);
                    } else {
                        toastr.error("Error al consultar los Requerimientos.");
                    }
                });

                $('.Asignados').click(function () {
                    Estado = $(this).attr("id");
                    if (Estado != '') {
                        $('.dataTable').DataTable().destroy();
                        load_data(Estado, idDiseno);
                    } else {
                        toastr.error("Error al consultar los Requerimientos.");
                    }
                });

                $('.Iniciados').click(function () {
                    Estado = $(this).attr("id");
                    if (Estado != '') {
                        $('.dataTable').DataTable().destroy();
                        load_data(Estado, idDiseno);
                    } else {
                        toastr.error("Error al consultar los Requerimientos.");
                    }
                });

                $('.Renderizando').click(function () {
                    Estado = $(this).attr("id");
                    if (Estado != '') {
                        $('.dataTable').DataTable().destroy();
                        load_data(Estado, idDiseno);
                    } else {
                        toastr.error("Error al consultar los Requerimientos.");
                    }
                });

                $('.Por_Aprobar').click(function () {
                    Estado = $(this).attr("id");
                    if (Estado != '') {
                        $('.dataTable').DataTable().destroy();
                        load_data(Estado, idDiseno);
                    } else {
                        toastr.error("Error al consultar los Requerimientos.");
                    }
                });

                $('.Por_Corregir').click(function () {
                    Estado = $(this).attr("id");
                    if (Estado != '') {
                        $('.dataTable').DataTable().destroy();
                        load_data(Estado, idDiseno);
                    } else {
                        toastr.error("Error al consultar los Requerimientos.");
                    }
                });

                $('.Aprobados').click(function () {
                    Estado = $(this).attr("id");
                    if (Estado != '') {
                        $('.dataTable').DataTable().destroy();
                        load_data(Estado, idDiseno);
                    } else {
                        toastr.error("Error al consultar los Requerimientos.");
                    }
                });

                $('.Cerrados').click(function () {
                    Estado = $(this).attr("id");
                    if (Estado != '') {
                        $('.dataTable').DataTable().destroy();
                        load_data(Estado, idDiseno);
                    } else {
                        toastr.error("Error al consultar los Requerimientos.");
                    }
                });

                $('.Anulado').click(function () {
                    Estado = $(this).attr("id");
                    if (Estado != '') {
                        $('.dataTable').DataTable().destroy();
                        load_data(Estado, idDiseno);
                    } else {
                        toastr.error("Error al consultar los Requerimientos.");
                    }
                });

                $('.Sin_Aprobar').click(function () {
                    Estado = $(this).attr("id");
                    if (Estado != '') {
                        $('.dataTable').DataTable().destroy();
                        load_data(Estado, idDiseno);
                    } else {
                        toastr.error("Error al consultar los Requerimientos.");
                    }
                });

                $('#nav').on('click','.nav-link', function ( e ) {
                    e.preventDefault();
                    $(this).parents('#nav').find('.active').removeClass('active').end().end().addClass('active');
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

                $('#NewRequerimiento').on('click', function () {
                    $('#NewRequerimientoTitle').html('Nuevo Requerimiento');
                    $('#NewRequerimientoModal').modal({
                        backdrop: 'static',
                        keyboard: false,
                    });
                    getUsers();
                });

                var render = 1;
                $("[name='my-checkbox']").bootstrapSwitch({
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

                /*var fileinput = $("#input-24");*/

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
                            },
                            url: "/NewRequerimiento",
                            type: "POST",
                            dataType: 'json',
                            success: function (data) {
                            	if (data == 'ok'){
                                    $('.fileinput-upload-button').click();
                                }

                                /*$('#NewRequerimientoSave').trigger("reset");
                                $('#NewRequerimientoModal').modal('hide');
                                table.draw();
                                toastr.success("Registro Guardado con Exito!");
                                $(this).html('Crear');*/

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


                var fileinput = $("#file-loader");
                 fileinput.fileinput({
                     theme: 'fas',
                     previewFileType: 'any',
                     language: 'es',
                     showCaption: false,
                     uploadUrl: '/RequerimientoSaveFile',
                     maxFileSize: 5000,
                     maxFileCount: 5,
                     browseClass: "btn btn-primary",
                     showRemove: true,
                     showUpload: true,
                     allowedFileExtensions: ['jpg','png','gif'],
                     allowedFileTypes: ['image'],
                     allowedPreviewTypes: ['image'],
                     uploadExtraData: function () {
                        return{
                            _token: $("input[name='_token']").val()
                        }
                     },
                     previewFileIconSettings: {
                         'doc': '<i class="fa fa-file-word-o text-primary"></i>',
                         'xls': '<i class="fa fa-file-excel-o text-success"></i>',
                         'ppt': '<i class="fa fa-file-powerpoint-o text-danger"></i>',
                         'jpg': '<i class="fa fa-file-photo-o text-warning"></i>',
                         'pdf': '<i class="fa fa-file-pdf-o text-danger"></i>',
                         'zip': '<i class="fa fa-file-archive-o text-muted"></i>',
                     },
                     slugCallback: function (filename) {
                        return filename.replace('(', '_').replace(']','_')
                     }
                });
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
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.6/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
    {{--<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.6/css/fileinput-rtl.min.css" media="all" rel="stylesheet" type="text/css"/>--}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.6/js/plugins/piexif.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.6/js/plugins/sortable.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.6/js/plugins/purify.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.6/js/fileinput.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.6/themes/fas/theme.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.6/js/locales/es.js"></script>
    @endpush
@stop
