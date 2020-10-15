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


@push('javascript')
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
                    {data: 'NombreVendedor', name: 'NombreVendedor', orderable: false, searchable: true},
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
        });
    </script>
@endpush
