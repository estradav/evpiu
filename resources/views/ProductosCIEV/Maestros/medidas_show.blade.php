@extends('layouts.dashboard')

@section('page_title', 'Maestros')

@section('module_title', 'Medidas')

@section('subtitle', 'Este modulo permite ver, crear y editar Medidas.')

@section('breadcrumbs')
    {{ Breadcrumbs::render('Prod_ciev_maestros_medidas') }}
@stop

@section('content')
    @inject('Lineas','App\Services\Lineas')
    <div class="col-lg-4">
        <div class="form-group">
            <a class="btn btn-primary" href="javascript:void(0)" id="CrearMedida">Crear Nueva Medida</a>
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
                                    <th>#</th>
                                    <th>Codigo de linea</th>
                                    <th>Codigo de Sublinea</th>
                                    <th>Codigo</th>
                                    <th>Nombre Medida</th>
                                    <th>Denominacion</th>
                                    <th>Interior</th>
                                    <th>Exterior</th>
                                    <th>Lado 1</th>
                                    <th>Lado 2</th>
                                    <th>Comentarios</th>
                                    <th width="280px">Opciones</th>
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
                                        <select class="custom-select" name="med_lineas_id" id="med_lineas_id">
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
                                        <select class="custom-select" name="med_sublineas_id" id="med_sublineas_id"></select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name" class="col-sm-6 control-label">Codigo de Medida:</label>
                                    <div class="col-sm-12">
                                        <input type="number" class="form-control" id="cod" name="cod" placeholder="Enter Name" value="" maxlength="50" required="required">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name" class="col-sm-6 control-label">Nombre de la Medida:</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Nombre de la medida" value="" maxlength="50" required="required">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name" class="col-sm-6 control-label">Interior:</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="interior" name="interior" placeholder="Medida interior" value="" maxlength="50" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name" class="col-sm-6 control-label">Exterior:</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="exterior" name="exterior" placeholder="Medida exterior" value="" maxlength="50" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name" class="col-sm-6 control-label">Lado 1:</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="lado_1" name="lado_1" placeholder="Lado 1" value="" maxlength="50" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name" class="col-sm-6 control-label">Lado 2:</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="lado_2" name="lado_2" placeholder="Lado 2" value="" maxlength="50" required="required">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name" class="col-sm-6 control-label">Largo:</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="largo" name="largo" placeholder="Largo" value="" maxlength="50" required="required">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name" class="col-sm-6 control-label">Denominacion:</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="denominacion" name="denominacion" placeholder="Denominacion" value="" maxlength="50" required="required">
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
        <script type="text/javascript">
            $(document).ready(function(){
                $(function () {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    var table = $('.data-table').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: "{{ route('ProdCievCodMedida.index') }}",
                        columns: [
                            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                            {data: 'med_lineas_id', name: 'med_lineas_id'},
                            {data: 'med_sublineas_id', name: 'med_sublineas_id'},
                            {data: 'cod', name: 'cod'},
                            {data: 'name', name: 'name'},
                            {data: 'denominacion', name: 'denominacion'},
                            {data: 'interior', name: 'interior'},
							{data: 'exterior', name: 'exterior'},
                            {data: 'lado_1', name: 'lado_1'},
                            {data: 'lado_2', name: 'lado_2'},
                            {data: 'coments', name: 'coments'},
                            {data: 'Opciones', name: 'Opciones', orderable: false, searchable: false},
                        ],
                        language: {
                            // traduccion de datatables
                            processing: "Procesando...",
                            search: "Buscar&nbsp;:",
                            lengthMenu: "Mostrar _MENU_ registros",
                            info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
                            infoFiltered: "(filtrado de un total de _MAX_ registros)",
                            infoPostFix: "",
                            loadingRecords: "Cargando...",
                            zeroRecords: "No se encontraron resultados",
                            emptyTable: "Ningún registro disponible en esta tabla :C",
                            paginate: {
                                first: "Primero",
                                previous: "Anterior",
                                next: "Siguiente",
                                last: "Ultimo"
                            },
                            aria: {
                                sortAscending: ": Activar para ordenar la columna de manera ascendente",
                                sortDescending: ": Activar para ordenar la columna de manera descendente"
                            }
                        }
                    });

                    $('#CrearMedida').click(function () {
                        $('#saveBtn').val("create-medida");
                        $('#medida_id').val('');
                        $('#medidaForm').trigger("reset");
                        $('#modelHeading').html("Crear Nueva Medida");
                        $('#medidamodal').modal('show');
                    });

                    $('body').on('click', '.editmedida', function () {

                        var medida_id = $(this).data('id');
                        $.get("{{ route('ProdCievCodMedida.index') }}" +'/' + medida_id +'/edit', function (data) {
                            $('#modelHeading').html("Editar Medida");
                            $('#saveBtn').val("edit-Medida");
                            $('#medidamodal').modal('show');
                            $('#medida_id').val(data.id);
                            $('#cod').val(data.cod);
                            $('#interior').val(data.interior);
							$('#exterior').val(data.exterior);
							$('#lado_1').val(data.lado_1);
							$('#lado_2').val(data.lado_2);
							$('#denominacion').val(data.denominacion);
							$('#largo').val(data.largo);
                            $('#med_lineas_id').val(data.med_lineas_id);
                            $('#med_sublineas_id').val(data.med_sublineas_id);
                            $('#name').val(data.name);
                            $('#coments').val(data.coments);
                        })
                    });


                    $('#saveBtn').click(function (e) {
                        e.preventDefault();
                        //$(this).html('Guardando...');
                        $.ajax({
                            data: $('#medidaForm').serialize(),
                            url: "{{ route('ProdCievCodMedida.store') }}",
                            type: "POST",
                            dataType: 'json',
                            success: function (data) {

                                $('#medidaForm').trigger("reset");
                                $('#medidamodal').modal('hide');
                                table.draw();
                                toastr.success("Registro Guardado con Exito!");
                                //   $(this).html('Crear');
                            },
                            error: function (data) {
                                console.log('Error:', data);
                                $('#saveBtn').html('Guardar Cambios');
                            }
                        });
                    });

                    $('body').on('click', '.deletemedida', function () {

                        var medida_id = $(this).data("id");
                        if(confirm("¿Esta seguro de Eliminar?")) {
                            $.ajax({
                                type: "DELETE",
                                url: "{{ route('ProdCievCodMedida.store') }}" + '/' + medida_id,
                                success: function (data) {
                                    table.draw();
                                    toastr.success("Registro eliminado con exito");
                                },
                                error: function (data) {
                                    console.log('Error:', data);
                                    toastr.danger("Error al eliminar el registro");
                                }
                            });
                        }
                    });
                });

                $('#med_lineas_id').on('change', function () {
                    var lineas_id = $(this).val();
                    if ($.trim(lineas_id) != ''){
                        $.get('getsublineas',{lineas_id: lineas_id}, function(getsublineas) {
                            $('#med_sublineas_id').empty();
                            $('#med_sublineas_id').append("<option value=''>Seleccionar una sublinea</option>");
                            $.each(getsublineas, function (index, value) {
                                $('#med_sublineas_id').append("<option value='" + index + "'>"+ value +"</option>");
                            })
                        });
                    }
                });
            });
        </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

    @endpush
@endsection
