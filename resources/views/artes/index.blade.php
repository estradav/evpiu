@extends('layouts.architectui')

@section('page_title', 'Artes')

@section('content')
    @can('artes.view')
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
            $(document).ready(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('.dataTable').DataTable({
                    ajax: "/ViewArtes",
                    scrollY: true,
                    order: [
                        [8, "desc"]
                    ],
                    columns: [
                        {data: 'idRequerimiento', name: 'idRequerimiento'},
                        {data: 'CodigoArte', name: 'idArte', render: function (data, type, row) {
                                return '<a href="javascript:void(0)" class=" btn btn-link btn-sm btnArt" id="' + data + '" >' + data + '</a>';
                            }},
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
                        url: "/Spanish.json"
                    }
                });

                $(document).on('click', '.btnArt', function() {
                    let Art = this.id;
                    $('#ViewArtTitle').html('Arte #'+ Art);
                    PDFObject.embed("http://192.168.1.12/intranet_ci/assets/Artes/"+Art+".pdf", "#ViewArtPdf");
                    $('#ViewArtModal').modal('show');
                });
            });
        </script>
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
                <div class="modal-body">
                    <div id="ViewArtPdf" name="ViewArtPdf" style="height:750px !important;" ></div>
                </div>
                <div class="modal-footer" style="text-align: center !important;">
                    <button class="btn btn-primary btn-lg" data-dismiss="modal" id="CloseViewArt">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
