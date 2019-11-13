@extends('layouts.dashboard')

@section('page_title', 'Maestros (Sublineas)')

@section('module_title', 'Sublineas')

@section('subtitle', 'División de las lineas que permiten granularizar las características de las piezas.')

@section('breadcrumbs')
    {{ Breadcrumbs::render('Prod_ciev_maestros_sublineas') }}
@stop

@section('content')
    @inject('Lineas','App\Services\Lineas')
    @can('maestro.sublinea.view')
    <div class="col-lg-4">
        <div class="form-group">
            @can('sublinea.new')
            <a class="btn btn-primary" href="javascript:void(0)" id="CrearSubLineas">Nuevo</a>
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
                                    <th>Codigo</th>
                                    <th>Nombre Sublinea</th>
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

    <div class="modal fade" id="sublineamodal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"> </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="sublineaForm" name="sublineaForm" class="form-horizontal">
                        <input type="hidden" name="sublinea_id" id="sublinea_id">
                        <div class="form-group">
                            <label for="lineas_id" class="col-sm-6 control-label">Linea:</label>
                            <div class="col-sm-12">
                                <select class="form-control" name="lineas_id" id="lineas_id">
                                    @foreach( $Lineas->get() as $index => $Lineas)
                                        <option value="{{ $index }}" {{ old('lineas_id') == $index ? 'selected' : ''}}>
                                            {{ $Lineas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-6 control-label">Codigo:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="cod" name="cod"  value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-6 control-label">Nombre:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name" name="name" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Abreviatura:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="abreviatura" name="abreviatura" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Comentarios:</label>
                            <div class="col-sm-12">
                                <textarea id="coments" name="coments" required="" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="saveBtn" value="Crear">Guardar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @else
        <div class="alert alert-danger" role="alert">
            No tienes permisos para visualizar las sublineas.
        </div>
    @endcan
    @push('javascript')
        <script type="text/javascript" src="/JsGlobal/Codificador/Maestros/Sublineas.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    @endpush
@endsection
