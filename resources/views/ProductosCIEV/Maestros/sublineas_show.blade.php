@extends('layouts.architectui')

@section('page_title', 'Maestros (Sublineas)')

@section('module_title', 'Sublineas')

@section('subtitle', 'División de las lineas que permiten granularizar las características de las piezas.')

@section('content')
    @inject('Lineas','App\Services\Lineas')
    @inject('UnidadesMedidas','App\Services\UnidadesMedidas')
    @can('maestro.sublinea.view')
    <div class="col-lg-4">
        <div class="form-group">
            @can('sublinea.new')
            @endcan
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-0 float-right">
                        <a class="btn btn-primary" href="javascript:void(0)" id="CrearSubLineas"><i class="fas fa-plus-circle"></i> Nuevo</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped first data-table" id="Subtable">
                            <thead>
                                <tr>
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
        <script type="text/javascript" src="/JsGlobal/Codificador/Maestros/Sublineas.js"></script>
    @endpush
@endsection

@section('modal')
    <div class="modal fade" id="sublineamodal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"> </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="sublineaForm" name="sublineaForm" class="form-horizontal">
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="sublinea_id" id="sublinea_id">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="lineas_id" class="col-sm-6 control-label">Linea:</label>
                                    <div class="col-sm-12">
                                        <select class="form-control" name="lineas_id" id="lineas_id">
                                            @foreach( $Lineas->get() as $index => $Lineas)
                                                <option value="{{ $index }}" {{ old('lineas_id') == $index ? 'selected' : ''}}> {{ trim($Lineas) }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">Codigo:</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="codigo" name="codigo" maxlength="2" minlength="2" onkeyup="this.value=this.value.toUpperCase();" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name" class="col-sm-6 control-label">Hijo:</label>
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
                                        <select class="js-example-basic-multiple form-control um_idSelect" name="um_id" id="um_id" multiple="multiple" style="width: 100%">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="car_um_id" class="col-sm-12 control-label">Caracteristica Unidad Medida:</label>
                                    <div class="col-sm-12">
                                        <select class="js-example-basic-multiple form-control car_um_idSelect" name="car_um_id" id="car_um_id" multiple="multiple" style="width: 100%">
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
                                    <label for="name" class="col-sm-2 control-label">Abreviatura:</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="abreviatura" name="abreviatura" value="" onkeyup="this.value=this.value.toUpperCase();">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Comentarios:</label>
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
