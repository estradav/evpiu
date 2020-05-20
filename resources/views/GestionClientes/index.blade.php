@extends('layouts.architectui')

@section('page_title', 'Gestion de Terceros')

@section('content')
    @can('gestion_clientes.view')
        <div class="card">
            <div class="card-header">
                @can('gestion_clientes.crear_cliente')
                    <a href="{{url('clientes/nuevo_cliente')}}" class="btn btn-primary btn-lg" style="align-items: flex-end">
                        <i class="fas fa-user-plus"> </i>  Nuevo Cliente
                    </a>
                @endcan
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-responsive table-striped CustomerTable" id="CustomerTable">
                        <thead>
                            <tr>
                                <th>CODIGO CLIENTE</th>
                                <th>RAZON SOCIAL</th>
                                <th>NIT / CC</th>
                                <th>ESTADO</th>
                                <th>OPCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <br>
        @can('gestion_clientes.clientes_sin_sincronizar')
        <div class="row">
            <div class="col-sm-12 ">
                <div class="card">
                    <div class="card-header">
                        Clientes MAX
                        <a class="right InfoCustomersTooltip" title="" data-placement="right" data-toggle="tooltip" href="javascript:void(0)" data-original-title="Esta tabla muestra los clientes que solo existen en MAX">
                            <span style="color: Mediumslateblue;">  <i class="fas fa-info-circle"></i> </span>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-responsive table-striped ClientsMax" id="ClientsMax">
                                <thead>
                                    <tr>
                                        <th>CODIGO CLIENTE</th>
                                        <th>RAZON SOCIAL</th>
                                        <th>NIT / CC</th>
                                        <th>ESTADO</th>
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
        @endcan
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
                var Username =  @json(Auth::user()->username);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $('.CustomerTable').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: false,
                    autoWidth: false,
                    width:"100%",
                    ajax: {
                        url: '/GestionClientes_Index'
                    },
                    columns: [
                        {data:'CodigoMAX', name:'CodigoMAX'},
                        {data:'NombreMAX', name:'NombreMAX'},
                        {data:'NITMAX', name:'NITMAX'},
                        {data:'EstadoMAX', name:'EstadoMAX', orderable:false, searchable:false},
                        {data:'opciones', name:'opciones', orderable:false, searchable:false},
                    ],
                    columnDefs: [
                        {
                        	width: "25%",
                            targets: 0
                        }
                    ],
                    language: {
                       url: '/Spanish.json'
                    },
                    rowCallback: function (row, data, index) {
                        if(data.estado == 'R'){
                            $(row).find('td:eq(3)').html('<label class="text-danger">Retenido</label>');
                        }else{
                            $(row).find('td:eq(3)').html('<label class="text-success">Liberado</label>');
                        }
                    }
                });
            });
        </script>
    @endpush
@stop

