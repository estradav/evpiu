 @extends('layouts.architectui')

@section('page_title', 'Creador de Productos')

@section('module_title', 'Creador de Productos')

@section('subtitle', 'Este modulo permite Crear y Clonar productos de MAX.')

{{--@section('breadcrumbs')
    {{ Breadcrumbs::render('Prod_ciev_maestros_lineas') }}
@stop--}}
@section('content')
    @inject('CodigoClase','App\Services\CodigoClase')
    @inject('AlmacenPreferido','App\Services\AlmacenPreferido')
    @inject('Planificador','App\Services\Planificador')
    @inject('CodigoComodidad','App\Services\CodigoComodidad')
    @inject('Comprador','App\Services\Comprador')
    @inject('TipoCuenta','App\Services\TipoCuenta')
    @inject('TipoProductos','App\Services\TipoProductos')
@can('clonador.view')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-6">
                        <div class="text-left">
                            @can('clonador.new')
                                <a class="btn btn-primary" href="javascript:void(0)" id="New">Crear ò Clonar</a>
                            @endcan
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-right">
                            @can('codificador.new')
                                <a class="btn btn-primary" href="javascript:void(0)" id="CrearCodigo">Codificador</a>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped first data-table">
                            <thead>
                                <tr>
                                    <th>NUMERO</th>
                                    <th>DESCRIPCION</th>
                                    <th>CREADO</th>
                                    <th>ULTIMA ACTUALIZACION</th>
                                    <th>MODIFICADO POR</th>
                                    <th>ACCIONES</th>
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

    <style>
        legend.scheduler-border {
            width:inherit;
            padding:0 10px;
            border-bottom:none;
        }
    </style>
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
        <script type="text/javascript" src="/JsGlobal/ClonadorDeProductos/Codificador.js"></script>
        <script type="text/javascript" src="/JsGlobal/ClonadorDeProductos/Clonador-Creador.js"></script>
    @endpush
@endsection
 @extends('ProductosCIEV.Creador_Productos.Modal')
 @extends('ProductosCIEV.Codificador.modal')
