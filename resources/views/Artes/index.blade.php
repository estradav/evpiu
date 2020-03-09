@extends('layouts.architectui')

@section('page_title', 'Artes')

{{--
@section('module_title', 'Artes')

@section('subtitle', 'Este módulo permite ver la lista de artes')
--}}

@section('content')
    @can('artes.view')
        <div class="row">
            <div class="col-lg-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <table class="table table-responsive table-striped dataTable" id="table">
                            <thead>
                            <tr>
                                <th>REQUERIMIENTO</th>
                                <th>ARTE</th>
                                <th>PRODUCTO</th>
                                <th>MATERIAL</th>
                                <th>MARCA</th>
                                <th>VENDEDOR</th>
                                <th>DISEÑADOR</th>
                                <th>SOLICITUD</th>
                                <th>CREACION</th>
                                <th style="display: none !important;"></th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('.dataTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                paging: true,
                fixedColumns: false,
                ajax: "/ViewArtes",
                order: [
                	[ 8, "desc" ]
                ],
                columns: [
                    {data: 'idRequerimiento', name:'idRequerimiento'},
                    {data: 'CodigoArte', name: 'idArte', render: function ( data, type, row ) {
                        return '<a href="javascript:void(0)" class=" btn btn-link btn-sm btnArt" id="'+ data +'" >' + data + '</a>';}},
                    {data: 'Producto', name: 'Producto'},
                    {data: 'NombreMaterial', name: 'Material'},
                    {data: 'NombreMarca', name: 'NombreMarca'},
                    {data: 'NombreVendedor', name: 'Vendedor', orderable: false, searchable: false},
                    {data: 'NombreDisenador', name: 'Disenador', orderable: false, searchable: false},
                    {data: 'FechaSolicitud', name: 'FechaSolicitud', orderable: false, searchable: false},
                    {data: 'FechaCreacion', name: 'FechaCreacion', orderable: false, searchable: false},
                    {data: 'CodigoArte', name: 'CodigoArte', visible: false},
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
                }
            });

            $('body').on('click', '.btnArt', function() {
                var Art = $(this).attr("id");
                $('#ViewArtTitle').html('Arte #'+ Art);
                PDFObject.embed('//192.168.1.12/intranet_ci/assets/Artes/'+Art+'.pdf', '#ViewArtPdf');
                $('#ViewArtModal').modal('show');
            });
        </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        {{--    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">--}}
        {{--    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>--}}
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css"/>
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>
        <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/css/dataTables.checkboxes.css" rel="stylesheet" />
        <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.min.js" ></script>
        <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.3.10/dist/sweetalert2.all.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">

        <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    @endpush
@stop
@section('modal')
    <div class="modal fade bd-example-modal-lg" id="ViewArtModal" tabindex="-1" role="dialog" aria-labelledby="ViewArtModal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ViewArtTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="">
                    <div id="ViewArtPdf" style="height:750px;" ></div>
                </div>
                <div class="modal-footer" style="text-align: center !important;">
                    <button class="btn btn-primary" data-dismiss="modal" id="CloseViewArt">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
