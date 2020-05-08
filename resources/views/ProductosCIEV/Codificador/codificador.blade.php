@extends('layouts.architectui')

@section('page_title', 'Codigos')
)
@section('content')
    @inject('TipoProductos','App\Services\TipoProductos')
    @can('codificador.view')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-0 float-right">
                        @can('codificador.new')
                            <a class="btn btn-primary" href="javascript:void(0)" id="CrearCodigo"><i class="fas fa-plus-circle"></i> Nuevo</a>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped first data-table">
                            <thead>
                                <tr>
                                    <th>CODIGO</th>
                                    <th>DESCRIPCION</th>
                                    <th>TIPO PRODUCTO</th>
                                    <th>LINEA</th>
                                    <th>SUBLINEA</th>
                                    <th>MEDIDA</th>
                                    <th>CARACTERISTICA</th>
                                    <th>MATERIAL</th>
                                    <th>COMENTARIOS</th>
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
    @extends('ProductosCIEV.Codificador.modal')
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
        <script type="text/javascript" src="/JsGlobal/Codificador/Codificador.js"></script>
    @endpush
@endsection
