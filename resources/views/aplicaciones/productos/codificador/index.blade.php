@extends('layouts.architectui')

@section('page_title', 'Codificador')

@section('action_recaptcha')
    {!! htmlScriptTagJsApi([ 'action' => 'productos_codificador' ]) !!}
@stop

@section('content')
    @can('aplicaciones.productos.codificador.index')
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-plugin icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>Codificador
                        <div class="page-title-subheading">
                            Codificador de productos
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="main-card mb-3 card">
                    @can('aplicaciones.productos.codificador.nuevo')
                        <div class="card-header">
                            <button class="btn btn-primary" id="nuevo"><i class="fas fa-plus-circle"></i> Nuevo</button>
                        </div>
                    @endcan
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm" id="table">
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
                                    @foreach( $data as $row)
                                        <tr>
                                            <td>{{ $row->codigo }}</td>
                                            <td>{{ $row->descripcion }}</td>
                                            <td>{{ $row->tipo_producto->name }}</td>
                                            <td>{{ $row->linea->name }}</td>
                                            <td>{{ $row->sublinea->name }}</td>
                                            <td>{{ $row->medida->denominacion }}</td>
                                            <td>{{ $row->caracteristica->name }}</td>
                                            <td>{{ $row->material->materiales->name }}</td>
                                            <td>{{ $row->coments }}</td>
                                            <td>
                                                <div class="btn-group ml-auto">
                                                    @can("aplicaciones.codificador.eliminar")
                                                        <button class="btn btn-light btn-sm delete" id="{{ $row->id }}"><i class="fas fa-trash"></i> Eliminar</button>
                                                    @endcan
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

@section('modal')
    @include('aplicaciones.productos.codificador.modal')
@endsection

@push('javascript')
    <script type="text/javascript" src="{{ asset('aplicaciones/productos/codificador/index.js') }}"></script>
@endpush
