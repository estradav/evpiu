@extends('layouts.architectui')

@section('page_title', 'Maestros (Sublinea)')

@section('action_recaptcha')
    {!! htmlScriptTagJsApi([ 'action' => 'maestros_sublinea' ]) !!}
@endsection

@section('content')
    @can('aplicaciones.maestros.sublinea.index')
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-plugin icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>Maestros
                        <div class="page-title-subheading">
                            Sublinea
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="main-card mb-3 card">
                    @can('aplicaciones.maestros.sublinea.agregar')
                        <div class="card-header">
                            <button class="btn btn-primary" id="nuevo"><i class="fas fa-plus-circle"></i> Nuevo</button>
                        </div>
                    @endcan
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm" id="table">
                                <thead>
                                    <tr>
                                        <th>COD LINEA</th>
                                        <th>LINEA</th>
                                        <th>CODIGO</th>
                                        <th>NOMBRE</th>
                                        <th>COMENTARIOS</th>
                                        <th>U. DE MEDIDA</th>
                                        <th>CARACTERISTICAS U. DE MEDIDA</th>
                                        <th>ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach( $data as $row)
                                        <tr>
                                            <td>{{ $row->cod_linea }}</td>
                                            <td>{{ $row->linea }}</td>
                                            <td>{{ $row->cod }}</td>
                                            <td>{{ $row->name }}</td>
                                            <td>{{ $row->coment }}</td>
                                            <td>
                                                <button class="btn btn-light btn-sm unidad_medida" id="{{ $row->id }}">Mostrar </button>
                                            </td>
                                            <td>
                                                <button class="btn btn-light btn-sm carac_unidad_medida" id="{{ $row->id }}">Mostrar </button>
                                            </td>
                                            <td>
                                                <div class="btn-group ml-auto">
                                                    @can("aplicaciones.maestros.sublinea.editar")
                                                        <button data-toggle="tooltip" data-original-title="Editar" class="btn btn-light btn-sm edit" id="{{ $row->id }}"><i class="fas fa-edit"></i></button>
                                                    @endcan
                                                    @can("aplicaciones.maestros.sublinea.eliminar")
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
                        <div class="row">
                            <input type="hidden" name="id" id="id">
                            <input type="hidden" name="code" id="code">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="linea" class="col-sm-6 control-label">Linea:</label>
                                    <div class="col-sm-12">
                                        <select class="form-control" name="linea" id="linea">
                                            <option value="" selected>Seleccione...</option>
                                            @foreach( $lineas as $linea)
                                                <option value="{{ $linea->id }}"> {{ $linea->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="cod" class="col-sm-6 control-label">Codigo:</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="cod" name="cod" maxlength="2" minlength="2" onkeyup="this.value=this.value.toUpperCase();" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="hijo" class="col-sm-6 control-label">Hijo:</label>
                                    <a class="right ModalTooltip" rel="tooltip" data-placement="right" data-toggle="tooltip" href="javascript:void(0)" data-original-title="Hace referencia a si un producto lleva o no complemento">
                                        <span style="color: Mediumslateblue;">  <i class="fas fa-info-circle"></i> </span>
                                    </a>
                                    <div class="col-sm-12">
                                        <select name="hijo" id="hijo" class="form-control">
                                            <option value="Y">Si</option>
                                            <option value="N">No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="um_id" class="col-sm-6 control-label">Unidad Medida:</label>
                                    <div class="col-sm-12">
                                        <select class="form-control um_idSelect" name="um_id" id="um_id" multiple="multiple" style="width: 100%">
                                            @foreach( $unidades_medida as $um )
                                                <option value="{{ $um->id }}"> {{ $um->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="car_um_id" class="col-sm-12 control-label">Caracteristica Unidad Medida:</label>
                                    <div class="col-sm-12">
                                        <select class="form-control car_um_idSelect" name="car_um_id" id="car_um_id" multiple="multiple" style="width: 100%">
                                            @foreach( $carac_unidades_medida as $cum )
                                                <option value="{{ $cum->id }}">{{ $cum->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name" class="col-sm-6 control-label">Nombre:</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="name" name="name" value="" onkeyup="this.value=this.value.toUpperCase();">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="abrev" class="col-sm-2 control-label">Abreviatura:</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="abrev" name="abrev" value="" onkeyup="this.value=this.value.toUpperCase();">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="coments" class="col-sm-2 control-label">Comentarios:</label>
                                    <div class="col-sm-12">
                                        <textarea id="coments" name="coments" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="saveBtn" value="Crear">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('javascript')
    <script type="text/javascript" src="{{ asset('aplicaciones/productos/maestros/sublinea.js') }}"></script>
@endpush
