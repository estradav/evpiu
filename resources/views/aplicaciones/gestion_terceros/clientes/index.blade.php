@extends('layouts.architectui')

@section('page_title', 'Clientes ')

@section('action_recaptcha')
    {!! htmlScriptTagJsApi([ 'action' => 'gestion_terceros_clientes' ]) !!}
@stop

@section('content')
    @can('aplicaciones.gestion_terceros.clientes.index')
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-users icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>Clientes
                        <div class="page-title-subheading">
                            Listado de clientes.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">
                        @can('aplicaciones.gestion_terceros.clientes.index.btn_nuevo_cliente')
                            <a href="{{ url('aplicaciones/terceros/cliente/nuevo') }}" class="btn btn-primary btn-lg" style="align-items: flex-end">
                                <i class="fas fa-user-plus"> </i>  Crear Cliente
                            </a>
                        @endcan
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table">
                                <thead>
                                    <tr>
                                        <th>Codigo cliente</th>
                                        <th>Razon social</th>
                                        <th>NIT/CC</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
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
    <script type="text/javascript" src="{{ asset('aplicaciones/gestion_terceros/clientes/index.js') }}"></script>
@endpush
