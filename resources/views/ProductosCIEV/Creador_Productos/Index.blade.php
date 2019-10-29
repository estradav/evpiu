@extends('layouts.dashboard')

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
{{--    <div class="col-lg-4">
        <div class="form-group">
            <div class="text-left">

            </div>
        </div>
    </div>--}}
    <div class="row">
        <div class="col-6">
            <div class="text-left">
                <a class="btn btn-primary" href="javascript:void(0)" id="New">Crear ò Clonar</a>
            </div>
        </div>
        <div class="col-6">
            <div class="text-right">
                <a class="btn btn-primary" href="javascript:void(0)" id="CrearCodigo">Codificador</a>
            </div>
        </div>
    </div>

    <br>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped first data-table">
                            <thead>
                                <tr>
                                    <th>Numero</th>
                                    <th>Descripcion</th>
                                    <th>Fecha de Creacion</th>
                                    <th>Ultima Actualizacion</th>
                                    <th>Modificado Por</th>
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
    @extends('ProductosCIEV.Creador_Productos.Modal')
    @extends('ProductosCIEV.Codificador.modal')
    <style>
        /*Este Style me permite crear un borde cuadradado en los campos fielfset */
        legend.scheduler-border {
            width:inherit; /* Or auto */
            padding:0 10px; /* To give a bit of padding on the left and right */
            border-bottom:none;
        }


    </style>
    @push('javascript')
        <script type="text/javascript" src="/JsGlobal/ClonadorDeProductos/Codificador.js"></script>
        <script type="text/javascript" src="/JsGlobal/ClonadorDeProductos/Clonador-Creador.js"></script>
        <link href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.css" rel="stylesheet"/>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/js/bootstrap.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    @endpush
@endsection
