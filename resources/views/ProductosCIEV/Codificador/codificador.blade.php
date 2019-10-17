@extends('layouts.dashboard')

@section('page_title', 'Codigos')

@section('module_title', 'Lista de Codigos')

@section('subtitle', 'Este modulo permite ver, crear y editar Codigos.')

@section('breadcrumbs')
    {{ Breadcrumbs::render('Prod_ciev_codigos') }}
@stop

@section('content')
    @inject('TipoProductos','App\Services\TipoProductos')
    <div class="col-lg-4">
        <div class="form-group">
            <a class="btn btn-primary" href="javascript:void(0)" id="CrearCodigo">Crear Codigo</a>
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
                                    <th>Codigo</th>
                                    <th>Descripcion</th>
                                    <th>Tipo Producto</th>
                                    <th>Linea</th>
                                    <th>Sublinea</th>
                                    <th>Medida</th>
                                    <th>Caracteristica</th>
                                    <th>Material</th>
                                    <th>Comentarios</th>
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

    <div class="modal fade bd-example-modal-lg" id="Codigomodal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"> </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="CodigoForm" name="CodigoForm" class="form-horizontal">
                        <input type="hidden" name="Codigo_id" id="Codigo_id">

                        <input type="hidden" name="ctp-g" id="ctp-g">
                        <input type="hidden" name="lin-g" id="lin-g">
                        <input type="hidden" name="sln-g" id="sln-g">
                        <input type="hidden" name="mat-g" id="mat-g">
                        <input type="hidden" name="lin-d" id="lin-d">
                        <input type="hidden" name="sln-d" id="sln-d">
                        <input type="hidden" name="car-d" id="car-d">
                        <input type="hidden" name="mat-d" id="mat-d">
                        <input type="hidden" name="med-d" id="med-d">

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name" class="col-sm-6 control-label">Codigo:</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Codigo" value="" maxlength="50" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name" class="col-sm-6 control-label">Descripcion:</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Descripcion" value="" maxlength="50" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name" class="col-sm-6 control-label">Tipo de Producto:</label>
                                    <div class="col-sm-12">
                                        <select class="custom-select" name="tipoproducto_id" id="tipoproducto_id" >
                                            @foreach( $TipoProductos->get() as $index => $TipoProducto)
                                                <option value="{{ $index }}" {{ old('tipoproducto_id') == $index ? 'selected' : ''}}>
                                                    {{ $TipoProducto }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name" class="col-sm-3 control-label">Linea:</label>
                                    <div class="col-sm-12">
                                        <select class="custom-select" name="lineas_id" id="lineas_id"></select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name" class="col-sm-3 control-label">Sublinea:</label>
                                    <div class="col-sm-12">
                                        <select class="custom-select" name="sublineas_id" id="sublineas_id"></select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name" class="col-sm-6 control-label">Caracteristica:</label>
                                    <div class="col-sm-12">
                                        <select class="custom-select" name="caracteristica_id" id="caracteristica_id" ></select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name" class="col-sm-6 control-label">Material:</label>
                                    <div class="col-sm-12">
                                        <select class="custom-select" name="material_id" id="material_id"></select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name" class="col-sm-6 control-label">Medida:</label>
                                    <div class="col-sm-12">
                                        <select class="custom-select" name="medida_id" id="medida_id" ></select>
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">Comentarios:</label>
                                    <div class="col-sm-12">
                                        <textarea id="coments" name="coments" placeholder="Comentarios" class="form-control"> </textarea>
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


    @push('javascript')
        <script type="text/javascript" src="/JsGlobal/Codificador/Codificador.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

    @endpush
@endsection
