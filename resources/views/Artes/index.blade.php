@extends('layouts.dashboard')

@section('page_title', 'Artes')

@section('module_title', 'Artes')

@section('subtitle', 'Este módulo permite ver la lista de artes')
{{--
@section('breadcrumbs')
    {{ Breadcrumbs::render('fact_electr_facturas') }}
@stop--}}

@section('content')
    @can('artes.view')
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
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


    @else
        <div class="alert alert-danger" role="alert">
            No tienes permisos para visualizar los artes.
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
                        return '<button  value="'+data+'" class=" btn btn-link btn-sm btnArt" id="'+ data +'" >' + data + '</button>';}},
                    {data: 'Producto', name: 'Producto'},
                    {data: 'NombreMaterial', name: 'Material'},
                    {data: 'NombreMarca', name: 'NombreMarca'},
                    {data: 'NombreVendedor', name: 'Vendedor'},
                    {data: 'NombreDisenador', name: 'Disenador'},
                    {data: 'FechaSolicitud', name: 'FechaSolicitud', orderable: false, searchable: false},
                    {data: 'FechaCreacion', name: 'FechaCreacion'},
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


        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.1.1/pdfobject.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.1.1/pdfobject.js"></script>
        <link href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.css" rel="stylesheet"/>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/js/bootstrap.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    @endpush
@stop
