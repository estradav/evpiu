@extends('layouts.architectui')

@section('page_title', 'Requerimientos')

@section('module_title', 'Requerimientos')

@section('subtitle', 'Modulo de administracion de requerimientos.')
{{--
@section('breadcrumbs')
    {{ Breadcrumbs::render('fact_electr_facturas') }}
@stop--}}

@section('content')
    @can('gestion_requerimientos.view')
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav" id="nav">
                            <li class="nav-item">
                                <a class="nav-link Por_Plano" href="javascript:void(0)" id="1">
                                    <span>RENDER</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link Por_revisar active" href="javascript:void(0)" id="2">
                                    <span>POR REVISAR</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link Rediligenciar" href="javascript:void(0)" id="3">
                                    <span>ASIGNADO</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link Asignados" href="javascript:void(0)" id="4">
                                    <span>INICIADO</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link Iniciados" href="javascript:void(0)" id="5">
                                    <span>FINALIZADO</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link Renderizando" href="javascript:void(0)" id="6">
                                    <span>ANULADO DISEÑO</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link Por_Aprobar" href="javascript:void(0)" id="7">
                                    <span>SIN APROBAR</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link Por_Corregir" href="javascript:void(0)" id="0">
                                    <span>ANULADO VENDEDOR</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-responsive table-striped dataTable" id="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>DESCRIPCION</th>
                                        <th>INFORMACION</th>
                                        <th>CREADO POR</th>
                                        <th>DISEÑADOR</th>
                                        <th>MARCA</th>
                                        <th>FECHA CREACION</th>
                                        <th>ULTIMA ACTUALIZACION</th>
                                        <th>OPCIONES</th>
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
        <div class="modal fade bd-example-modal-sm " id="AsignarADiseñador" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Asignar requerimiento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label for="SelectDiseñador">Diseñador:</label>
                        <select name="SelectDiseñador" id="SelectDiseñador" class="form-control">
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success btn-sm" id="AsignaADiseñador" name="AsignaADiseñador">Asignar</button>
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
    @push('javascript')
        <script>
            $(document).ready(function() {
                var table;
                var Estado = 2;

                var idDiseno =  @json( Auth::user()->cod_designer);
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
                            {data: 'producto', name: 'producto', orderable: false, searchable: true},
                            {data: 'informacion', name: 'informacion', orderable: false, searchable: true},
                            {data: 'usuario', name: 'usuario', orderable: false, searchable: true},
                            {data: 'diseñador_id', name: 'diseñador_id', orderable: false, searchable: false},
                            {data: 'marca', name: 'marca', orderable: true, searchable: true},
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
                        	console.log(data);
                            if (data.diseñador_id == null) {
                                $(row).find('td:eq(4)').html('<label class="text-dark">SIN ASIGNAR</label>');
                            }
                            /*if (data.estado == '1') {
                                $(row).find('td:eq(5)').html('<label class="text-dark">RENDER</label>');
                            }
                            if (data.estado == '2') {
                                $(row).find('td:eq(5)').html('<label class="text-dark">POR REVISAR</label>');
                            }
                            if (data.estado == '3') {
                                $(row).find('td:eq(5)').html('<label class="text-dark">ASIGNADO</label>');
                            }
                            if(data.estado == '5') {
                                $(row).find('td:eq(5)').html('<label class="text-dark">FINALIZADO</label>');
                            }

                            if (data.estado == '6') {
                                $(row).find('td:eq(5)').html('<label class="text-dark">ANULADO DISEÑO</label>');
                            }
                            if (data.estado == '7') {
                                $(row).find('td:eq(5)').html('<label class="text-dark">SIN APROBAR</label>');
                            }*/
                        }
                    })
                }

                $('.Por_revisar').click(function () {
                    Estado = $(this).attr("id");

                    if (Estado != '') {
                        $('.dataTable').DataTable().destroy();
                        load_data(Estado);
                    } else {
                        toastr.error("Error al consultar los pronosticos Cerrados.");
                    }
                });

                $('.Rediligenciar').click(function () {
                    Estado = $(this).attr("id");

                    if (Estado != '') {
                        $('.dataTable').DataTable().destroy();
                        load_data(Estado);
                    } else {
                        toastr.error("Error al consultar Requerimientos.");
                    }
                });

                $('.Por_Plano').click(function () {
                    Estado = $(this).attr("id");
                    if (Estado != '') {
                        $('.dataTable').DataTable().destroy();
                        load_data(Estado);
                    } else {
                        toastr.error("Error al consultar los Requerimientos.");
                    }
                });

                $('.Asignados').click(function () {
                    Estado = $(this).attr("id");
                    if (Estado != '') {
                        $('.dataTable').DataTable().destroy();
                        load_data(Estado);
                    } else {
                        toastr.error("Error al consultar los Requerimientos.");
                    }
                });

                $('.Iniciados').click(function () {
                    Estado = $(this).attr("id");
                    if (Estado != '') {
                        $('.dataTable').DataTable().destroy();
                        load_data(Estado);
                    } else {
                        toastr.error("Error al consultar los Requerimientos.");
                    }
                });

                $('.Renderizando').click(function () {
                    Estado = $(this).attr("id");
                    if (Estado != '') {
                        $('.dataTable').DataTable().destroy();
                        load_data(Estado);
                    } else {
                        toastr.error("Error al consultar los Requerimientos.");
                    }
                });

                $('.Por_Aprobar').click(function () {
                    Estado = $(this).attr("id");
                    if (Estado != '') {
                        $('.dataTable').DataTable().destroy();
                        load_data(Estado);
                    } else {
                        toastr.error("Error al consultar los Requerimientos.");
                    }
                });

                $('.Por_Corregir').click(function () {
                    Estado = $(this).attr("id");
                    if (Estado != '') {
                        $('.dataTable').DataTable().destroy();
                        load_data(Estado);
                    } else {
                        toastr.error("Error al consultar los Requerimientos.");
                    }
                });

                $('.Aprobados').click(function () {
                    Estado = $(this).attr("id");
                    if (Estado != '') {
                        $('.dataTable').DataTable().destroy();
                        load_data(Estado);
                    } else {
                        toastr.error("Error al consultar los Requerimientos.");
                    }
                });

                $('.Cerrados').click(function () {
                    Estado = $(this).attr("id");
                    if (Estado != '') {
                        $('.dataTable').DataTable().destroy();
                        load_data(Estado);
                    } else {
                        toastr.error("Error al consultar los Requerimientos.");
                    }
                });

                $('.Anulado').click(function () {
                    Estado = $(this).attr("id");
                    if (Estado != '') {
                        $('.dataTable').DataTable().destroy();
                        load_data(Estado);
                    } else {
                        toastr.error("Error al consultar los Requerimientos.");
                    }
                });

                $('.Sin_Aprobar').click(function () {
                    Estado = $(this).attr("id");
                    if (Estado != '') {
                        $('.dataTable').DataTable().destroy();
                        load_data(Estado);
                    } else {
                        toastr.error("Error al consultar los Requerimientos.");
                    }
                });

                $('#nav').on('click','.nav-link', function ( e ) {
                    e.preventDefault();
                    $(this).parents('#nav').find('.active').removeClass('active').end().end().addClass('active');
                });

                $("#archivos").change(function() {
                    var file = this.files[0];
                    var imagefile = file.type;
                    var match= ["image/jpeg","image/png","image/jpg"];
                    if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2]))){
                        alert('Please select a valid image file (JPEG/JPG/PNG).');
                        $("#archivos").val('');
                        return false;
                    }
                });

                var Numero_requerimiento;

                $('body').on('click','.Asignar', function () {
                	 Numero_requerimiento = $(this).attr("id");
                    $.ajax({
                        type: "get",
                        url: '/GetDisenador',
                        success: function (data) {
                            var i = 0;
                            $(data).each(function () {
                                $('#SelectDiseñador').append('<option value="'+data[i].cod_designer +'">'+data[i].name+'</option>');
                                i++;
                            });
                        }
                    });
                    $('#AsignarADiseñador').modal('show');
                });

                $('#AsignaADiseñador').on('click',function () {
                	var Usuario_diseñador = $('#SelectDiseñador').val();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: '/AsignarDisenador',
                        data:{
                            Usuario_diseñador: Usuario_diseñador,
                            id_requerimiento: Numero_requerimiento,
                            User: Username
                        },
                        success: function () {
                            $('#AsignarADiseñador').modal('hide');
                                $('.dataTable').DataTable().destroy();
                                load_data(Estado, idDiseno);
                        }
                    })
                })
            });
        </script>

    @endpush
@stop
