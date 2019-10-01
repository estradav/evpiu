@extends('layouts.dashboard')

@section('page_title', 'Maestros')

@section('module_title', 'Lineas')

@section('subtitle', 'sbutitulo.')

@section('breadcrumbs')
    {{ Breadcrumbs::render('fact_electr_facturas') }}
@stop

@section('content')
    <div class="col-lg-4">
        <div class="form-group">
            <a href="javascript:void(0)" class="btn btn-primary add_item" id="crearLinea">
                Crear Linea
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-responsive table-striped" id="lineas_table">
                            <thead>
                                <tr>
                                    <th>Codigo de linea</th>
                                    <th>Nombre de Linea</th>
                                    <th>Abreviatura</th>
                                    <th>Comentarios</th>
                                    <th>Usuario</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach( $Codlinea as $cod )
                                <tr>
                                    <td>{{ $codl->cod}}</td>
                                    <td>{{ $codl->name}}</td>
                                    <td>{{ $codl->abreviatura}}</td>
                                    <td>{{ $codl->coments}}</td>
                                    <td>{{ $codl->usuario}}</td>
                                    <td>
                                      <div class="btn-group ml-auto float-right">
                                          <button class="btn btn-sm btn-light" disabled>
                                          </button>
                                          <a href="#" class="btn btn-sm btn-outline-light" id="edit-fac" >
                                              <i class="far fa-edit"></i>
                                          </a>
                                          <a href="#" class="btn btn-sm btn-outline-light" id="ver-fac">
                                              <i class="fa fa-eye"></i>
                                          </a>
                                      </div>
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
    <div class="modal fade" id="LineasModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header" id="modalheader">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Agregar Linea</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="lineas_form" name="lineas_form" class="form-horizontal">
                    <input type="hidden" name="lineas_id" id="lineas_id">
                    @csrf
                    <div class="modal-body">
                        <label for="name">Codigo de Linea:</label>
                        <input type="text" class="form-control" id="cod_linea" name="cod" placeholder="Codigo de Linea"><br>
                        <label for="name">Nombre de Linea:</label>
                        <input type="text" class="form-control" id="nom_linea" name="name" placeholder="Nombre de Linea"><br>
                        <label for="name">Abreviatura:</label>
                        <input type="text" class="form-control" id="com_linea" name="abreviatura" placeholder="Abreviatura"><br>
                        <label for="name">Comentarios:</label>
                        <textarea class="form-control" id="coment_linea" name="coments" placeholder="Comentarios"> </textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <input type="submit" class="btn btn-primary " value="Actualizar" id="GuardarLinea">
                    </div>
                </form>
            </div>
        </div>
    </div>


    @push('javascript')
        <script>
            $(document).ready(function () {
                $("#lineas_table").DataTable({
                    order: [],
                    columns: [
                        // permite ordenar columnas y le da el abributo buscar
                        {"orderable": false, "searchable": false},
                        {"orderable": true, "searchable": true},
                        {"orderable": false, "searchable": false},
                        {"orderable": false, "searchable": false},
                        {"orderable": false, "searchable": false},
                        {"orderable": false, "searchable": false},
                    ],

                    columnDefs: [
                        {
                            targets: 0,
                        }
                    ],

                    select: {
                        style: 'multi'
                    },

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
                    }
                });
            });
            $(function () {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });



            $('#crearLinea').click(function () {
                $('#GuardarLinea').val("Crear Lineas");
                $('#lineas_id').val('');
                $('#lineas_form').trigger("reset");
                $('#modalheader').html("Crear nueva Linea");
                $('#LineasModal').modal('show');
            });

            $('#GuardarLinea').click(function (e) {
                e.preventDefault();
                $(this).html('Sending..');

                $.ajax({
                    data: $('#lineas_form').serialize(),
                    url: "{{ route('ProdCievCod.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {

                        $('#lineas_form').trigger("reset");
                        $('#LineasModal').modal('hide');
                       // table.draw();

                    },
                    error: function (data) {
                        console.log('Error:', data);
                        $('#GuardarLinea').html('Guardado');
                    }
                });
            });
            });
        </script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css"/>
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

    @endpush
@endsection

