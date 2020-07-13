@extends('layouts.architectui')

@section('page_title', 'Maestros (Linea)')

@section('content')
    @can('aplicaciones.maestros.linea.index')
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-plugin icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>Maestros
                        <div class="page-title-subheading">
                            Linea
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="main-card mb-3 card">
                    @can('aplicaciones.maestros.linea.agregar')
                        <div class="card-header">
                            <button class="btn btn-primary" id="nuevo"><i class="fas fa-plus-circle"></i> Nuevo</button>
                        </div>
                    @endcan
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm" id="table">
                                <thead>
                                    <tr>
                                        <th>TIPO DE PRODUCTO</th>
                                        <th>CODIGO</th>
                                        <th>NOMBRE</th>
                                        <th>ABREVIATURA</th>
                                        <th>COMENTARIOS</th>
                                        <th>ACTUALIZADO</th>
                                        <th>ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach( $data as $row)
                                        <tr>
                                            <td>{{ $row->tp }}</td>
                                            <td>{{ $row->cod }}</td>
                                            <td>{{ $row->name }}</td>
                                            <td>{{ $row->abrev }}</td>
                                            <td>{{ $row->coment }}</td>
                                            <td>{{ \Carbon\Carbon::parse($row->update)->diffForHumans() }}</td>
                                            <td>
                                                <div class="btn-group ml-auto">
                                                    @can("aplicaciones.maestros.linea.editar")
                                                        <button data-toggle="tooltip" data-original-title="Editar" class="btn btn-light btn-sm edit" id="{{ $row->id }}"><i class="fas fa-edit"></i></button>
                                                    @endcan
                                                    @can("aplicaciones.maestros.linea.eliminar")
                                                        <button data-toggle="tooltip" data-original-title="Eliminar" class="btn btn-light btn-sm delete" id="{{ $row->id }}"><i class="fas fa-trash"></i></button>
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
@stop

@section('modal')
    <div class="modal fade" id="modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" id="heading">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form" name="form" class="form-horizontal">
                    <div class="modal-body">
                        <input type="hidden" id="id" name="id">
                        <input type="hidden" id="code" name="code">
                        <div class="form-group">
                            <label for="tipo_producto" class="col-sm-6 control-label">Tipo de producto:</label>
                            <div class="col-sm-12">
                                <select class="form-control" name="tipo_producto" id="tipo_producto" >
                                    <option value="" selected disabled>Seleccione...</option>
                                    @foreach( $tipo_productos as $tipo_producto)
                                        <option value="{{ $tipo_producto->id }}" {{ old('tipo_producto') == $tipo_producto->id ? 'selected' : ''}}>
                                            {{ $tipo_producto->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cod" class="col-sm-6 control-label">Codigo:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="cod" name="cod" disabled onkeyup="this.value=this.value.toUpperCase();">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Nombre:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name" name="name" onkeyup="this.value=this.value.toUpperCase();">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="abrev" class="col-sm-2 control-label">Abreviatura:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="abrev" name="abrev" onkeyup="this.value=this.value.toUpperCase();">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="comments" class="col-sm-2 control-label">Comentarios:</label>
                            <div class="col-sm-12">
                                <textarea id="comments" name="comments"  class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="guardar">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('javascript')
    <script type="text/javascript" src="{{ asset('aplicaciones/productos/maestros/linea.js') }}"> </script>
@endpush
