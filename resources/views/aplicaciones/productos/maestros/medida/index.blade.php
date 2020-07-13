@extends('layouts.architectui')

@section('page_title', 'Maestros (Medida)')

@section('content')
    @can('aplicaciones.maestros.medida.index')
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-plugin icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>Maestros
                        <div class="page-title-subheading">
                            Medida
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="main-card mb-3 card">
                    @can('aplicaciones.maestros.medida.agregar')
                        <div class="card-header">
                            <button class="btn btn-primary" id="nuevo"><i class="fas fa-plus-circle"></i> Nuevo</button>
                        </div>
                    @endcan
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm" id="table">
                                <thead>
                                    <tr>
                                        <th>LINEA</th>
                                        <th>SUBLINEA</th>
                                        <th>COD</th>
                                        <th>DENOMINACION</th>
                                        <th>DIAMETRO</th>
                                        <th>PESTAÑA</th>
                                        <th>ESPESOR</th>
                                        <th>BASE</th>
                                        <th>ALTURA</th>
                                        <th>PERF</th>
                                        <th>MM²</th>
                                        <th>COMENTARIOS</th>
                                        <th>ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach( $data as $row )
                                        <tr>
                                            <td>{{ $row->linea }}</td>
                                            <td>{{ $row->sublinea }}</td>
                                            <td>{{ $row->cod }}</td>
                                            <td>{{ $row->denm }}</td>
                                            <td>{{ $row->diametro }}</td>
                                            <td>{{ $row->pestana }}</td>
                                            <td>{{ $row->espesor }}</td>
                                            <td>{{ $row->base }}</td>
                                            <td>{{ $row->altura }}</td>
                                            <td>{{ $row->perforacion }}</td>
                                            <td>{{ $row->mm2 }}</td>
                                            <td>{{ $row->coment }}</td>
                                            <td>
                                                <div class="btn-group ml-auto">
                                                    @can("aplicaciones.maestros.medida.editar")
                                                        <button data-toggle="tooltip" data-original-title="Editar" class="btn btn-light btn-sm edit" id="{{ $row->id }}"><i class="fas fa-edit"></i></button>
                                                    @endcan
                                                    @can("aplicaciones.maestros.medida.eliminar")
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
    <div class="modal fade bd-example-modal-lg" id="modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" id="heading">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form" name="form" class="form-horizontal">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="cod" class="col-sm-6 control-label">Codigo:</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="cod" name="cod" onkeyup="this.value=this.value.toUpperCase();">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="mm2" class="col-sm-6 control-label">Milimetros²:</label>
                                    <div class="col-sm-12">
                                        <input type="number" class="form-control" id="mm2" name="mm2"  onkeyup="this.value=this.value.toUpperCase();">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="denominacion" class="col-sm-6 control-label">Denominacion:</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="denominacion" name="denominacion">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="linea" class="col-sm-6 control-label">Linea:</label>
                                    <div class="col-sm-12">
                                        <select class="form-control" name="linea" id="linea">
                                            <option value="">Seleccione... </option>
                                            @foreach ( $lineas as $linea)
                                                <option value="{{ $linea->id }}"> {{ $linea->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="sublinea" class="col-sm-3 control-label">Sublinea:</label>
                                    <div class="col-sm-12">
                                        <select class="form-control" name="sublinea" id="sublinea"></select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="UndMedida" class="col-sm-12 control-label">Unidad Medida:</label>
                                    <div class="col-sm-12">
                                        <select name="UndMedida" id="UndMedida" class="form-control UndMedida">

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="campos" name="campos">

                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="coments" class="col-sm-12 control-label">Comentarios:</label>
                                    <div class="col-sm-12">
                                        <textarea id="coments" name="coments" placeholder="Comentarios" class="form-control"></textarea>
                                    </div>
                                </div>
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
    <script type="text/javascript" src="{{ asset('aplicaciones/productos/maestros/medida.js') }}"></script>
@endpush


