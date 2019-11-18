@extends('layouts.dashboard')

@section('page_title', 'Maestros (Medidas)')

@section('module_title', 'Medidas')

@section('subtitle', 'Definición de las diferentes dimensiones en las que se puede elaborar una pieza.')

@section('breadcrumbs')
    {{ Breadcrumbs::render('Prod_ciev_maestros_medidas') }}
@stop

@section('content')
    @inject('Lineas','App\Services\Lineas')
    @can('maestro.medida.view')
    <div class="col-lg-4">
        <div class="form-group">
            @can('medida.new')
            <a class="btn btn-primary" href="javascript:void(0)" id="CrearMedida">Nuevo</a>
            @endcan
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped first data-table">
                            <thead>
                                <tr>
                                    <th>Linea</th>
                                    <th>Sublinea</th>
                                    <th>Codigo</th>
                                    <th>Medida</th>
                                    <th>Denominacion</th>
                                    <th>Interior</th>
                                    <th>Exterior</th>
                                    <th>Lado 1</th>
                                    <th>Lado 2</th>
                                    <th>Comentarios</th>
                                    <th>Ultima Actualizacion</th>
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

    <div class="modal fade bd-example-modal-lg" id="medidamodal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"> </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="medidaForm" name="medidaForm" class="form-horizontal">
                        <input type="hidden" name="medida_id" id="medida_id">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name" class="col-sm-6 control-label">Linea:</label>
                                    <div class="col-sm-12">
                                        <select class="form-control" name="med_lineas_id" id="med_lineas_id">
                                            @foreach ( $Lineas->get() as $index => $Linea)
                                                <option value="{{ $index }}" {{ old('med_lineas_id') == $index ? 'selected' : ''}}>
                                                    {{ $Linea }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name" class="col-sm-3 control-label">Sublinea:</label>
                                    <div class="col-sm-12">
                                        <select class="form-control" name="med_sublineas_id" id="med_sublineas_id"></select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name" class="col-sm-6 control-label">Codigo:</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="cod" name="cod" value=""  onkeyup="this.value=this.value.toUpperCase();">
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
                                    <label for="name" class="col-sm-6 control-label">Interior:</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="interior" name="interior"  value="" onkeyup="this.value=this.value.toUpperCase();">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name" class="col-sm-6 control-label">Exterior:</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="exterior" name="exterior" value="" onkeyup="this.value=this.value.toUpperCase();">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name" class="col-sm-6 control-label">Lado 1:</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="lado_1" name="lado_1" value="" onkeyup="this.value=this.value.toUpperCase();">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name" class="col-sm-6 control-label">Lado 2:</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="lado_2" name="lado_2" value="" onkeyup="this.value=this.value.toUpperCase();">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name" class="col-sm-6 control-label">Largo:</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="largo" name="largo" value="" onkeyup="this.value=this.value.toUpperCase();">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name" class="col-sm-6 control-label">Denominacion:</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="denominacion" name="denominacion" value="" onkeyup="this.value=this.value.toUpperCase();">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">Comentarios:</label>
                                    <div class="col-sm-12">
                                        <textarea id="coments" name="coments" placeholder="Comentarios" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary" id="saveBtn" value="Crear">Guardar</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @else
        <div class="alert alert-danger" role="alert">
            No tienes permisos para visualizar las medidas.
        </div>
    @endcan

    @push('javascript')
        <script type="text/javascript" src="/JsGlobal/Codificador/Maestros/Medidas.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.3.10/dist/sweetalert2.all.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
    @endpush
@endsection
