@extends('layouts.architectui')

@section('page_title', 'Maestros (Materiales)')

@section('module_title', 'Materiales')

@section('subtitle', 'Definicion de los posibles elementos con los que se puede construir una pieza.')

@section('content')
    @inject('Lineas','App\Services\Lineas')
    @can('maestro.material.view')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-0 float-right">
                        @can('material.new')
                            <a class="btn btn-primary" href="javascript:void(0)" id="CrearMaterial"><i class="fas fa-plus-circle"></i> Nuevo</a>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped first data-table">
                            <thead>
                                <tr>
                                    <th>LINEA</th>
                                    <th>SUBLINEA</th>
                                    <th>CODIGO</th>
                                    <th>NOMBRE</th>
                                    <th>COMENTARIOS</th>
                                    <th>ACTUALIZADO</th>
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
        <script type="text/javascript" src="/JsGlobal/Codificador/Maestros/Materiales.js"></script>
    @endpush
@endsection
@section('modal')
    <div class="modal fade" id="materialmodal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"> </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="materialForm" name="materialForm" class="form-horizontal">
                    <div class="modal-body">
                        <input type="hidden" name="material_id" id="material_id">
                        <div class="form-group">
                            <label for="name" class="col-sm-6 control-label">Linea:</label>
                            <div class="col-sm-12">
                                <select class="form-control" name="mat_lineas_id" id="mat_lineas_id">
                                    @foreach ( $Lineas->get() as $index => $Linea)
                                        <option value="{{ $index }}" {{ old('car_lineas_id') == $index ? 'selected' : ''}}>
                                            {{ $Linea }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-6 control-label">Sublinea:</label>
                            <div class="col-sm-12">
                                <select class="form-control" name="mat_sublineas_id" id="mat_sublineas_id"></select>
                            </div>
                        </div>
                        <div class="form-group" style="display: none !important;">
                            <label for="name" class="col-sm-6 control-label">Codigo:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="codigo" name="codigo" onkeyup="this.value=this.value.toUpperCase();">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-6 control-label">Nombre:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name" name="name" value="" onkeyup="this.value=this.value.toUpperCase();">
                            </div>
                        </div>
                        <div class="form-group" style="display: none !important;">
                            <label for="name" class="col-sm-2 control-label">Abreviatura:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="abreviatura" name="abreviatura"  value="" onkeyup="this.value=this.value.toUpperCase();">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Comentarios:</label>
                            <div class="col-sm-12">
                                <textarea id="coments" name="coments" class="form-control"></textarea>
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
