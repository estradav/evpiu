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
                                    <th>#</th>
                                    <th>Codigo</th>
                                    <th>Descripcion</th>
                                    <th>Tipo Producto</th>
                                    <th>Linea</th>
                                    <th>Sublinea</th>
                                    <th>Medida</th>
                                    <th>Caracteristica</th>
                                    <th>Material</th>
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
                        ajax: "{{ route('ProdCievCodCodigo.index') }}",
                        columns: [
                            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
							{data: 'codigo', name: 'codigo'},
                            {data: 'descripcion', name: 'descripcion'},
                            {data: 'cod_tipo_producto_id', name: 'cod_tipo_producto_id'},
                            {data: 'cod_lineas_id', name: 'cod_lineas_id'},
                            {data: 'cod_sublineas_id', name: 'cod_sublineas_id'},
							{data: 'cod_medidas_id', name: 'cod_medidas_id'},
                            {data: 'cod_caracteristicas_id', name: 'cod_caracteristicas_id'},
                            {data: 'cod_materials_id', name: 'cod_materials_id'},
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

                    $('#CrearCodigo').click(function () {
                        $('#saveBtn').val("create-codigo");
                        $('#Codigo_id').val('');
                        $('#CodigoForm').trigger("reset");
                        $('#modelHeading').html("Crear Nuevo Codigo");
                        $('#Codigomodal').modal('show');
                    });

                    $('body').on('click', '.editCodigo', function () {

                        var codigo_id = $(this).data('id');
                        $.get("{{ route('ProdCievCodCodigo.index') }}" +'/' + codigo_id +'/edit', function (data) {
                            $('#modelHeading').html("Editar Codigo");
                            $('#saveBtn').val("edit-Medida");
                            $('#Codigomodal').modal('show');
                            $('#medida_id').val(data.id);
                            $('#codigo').val(data.codigo);
							$('#descripcion').val(data.descripcion);
							$('#tipoproducto_id').val(data.tipoproducto_id);
                            $('#lineas_id').val(data.lineas_id);
                            $('#sublineas_id').val(data.sublineas_id);
							$('#medida_id').val(data.medida_id);
							$('#caracteristica_id').val(data.caracteristica_id);
                            $('#material_id').val(data.material_id);
                            $('#coments').val(data.coments);
                        })
                    });


                    $('#saveBtn').click(function (e) {
                        e.preventDefault();
                        //$(this).html('Guardando...');
                        $.ajax({
                            data: $('#CodigoForm').serialize(),
                            url: "{{ route('ProdCievCodCodigo.store') }}",
                            type: "POST",
                            dataType: 'json',
                            success: function (data) {

                                $('#CodigoForm').trigger("reset");
                                $('#Codigomodal').modal('hide');
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

                    $('body').on('click', '.deleteCodigo', function () {

                        var codigo_id = $(this).data("id");
                        if(confirm("¿Esta seguro de Eliminar?")) {
                            $.ajax({
                                type: "DELETE",
                                url: "{{ route('ProdCievCodCodigo.store') }}" + '/' + codigo_id,
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

                $('#tipoproducto_id').on('change', function () {
                    var tipoproducto_id = $(this).val();
                    if ($.trim(tipoproducto_id) != ''){
                        $.get('getlineas',{tipoproducto_id: tipoproducto_id}, function(getlineas) {
                            $('#lineas_id').empty();
							$('#sublineas_id').empty();
                            $('#caracteristica_id').empty();
                            $('#material_id').empty();
                            $('#medida_id').empty();

                            $('#lineas_id').append("<option value=''>Seleccione una Linea...</option>");
							$('#sublineas_id').append("<option value=''>Seleccione una Sublinea...</option>");
                            $('#caracteristica_id').append("<option value=''>Seleccione una Caracteristica...</option>");
                            $('#material_id').append("<option value=''>Seleccione un Material...</option>");
                            $('#medida_id').append("<option value=''>Seleccione una Medida...</option>");

                            $.each(getlineas, function (index, value) {
                                $('#lineas_id').append("<option value='" + index + "'>"+ value +"</option>");
                            })
                        });
                        $.get('ctp',{tipoproducto_id: tipoproducto_id}, function(ctp) {
                            $('#ctp-g').empty();
                            $.each(ctp, function (index, value) {
                                document.getElementById("ctp-g").value=index;
                            })
                        });
                    }

                });

                $('#lineas_id').on('change', function () {
                    var lineas_id = $(this).val();
                    if ($.trim(lineas_id) != ''){
                        $.get('getsublineas',{lineas_id: lineas_id}, function(getsublineas) {
                            $('#sublineas_id').empty();
                            $('#caracteristica_id').empty();
                            $('#material_id').empty();
                            $('#medida_id').empty();

                            $('#sublineas_id').append("<option value=''>Seleccione una Sublinea...</option>");
                            $('#caracteristica_id').append("<option value=''>Seleccione una Caracteristica...</option>");
                            $('#material_id').append("<option value=''>Seleccione un Material...</option>");
                            $('#medida_id').append("<option value=''>Seleccione una Medida...</option>");

                            $.each(getsublineas, function (index, value) {
                                $('#sublineas_id').append("<option value='" + index + "'>"+ value +"</option>");
                            })
                        });
                        $.get('lns',{lineas_id: lineas_id}, function(lns) {
                            $('#lin-g').empty();
                            $.each(lns, function (index, value) {
                                document.getElementById("lin-g").value=index;
                                document.getElementById("lin-d").value=value;
                                // $('#codigo')
                            })
                        });
                    }

                });

                $('#sublineas_id').on('change', function () {
                    var car_sublineas_id = $(this).val();
                    if ($.trim(car_sublineas_id) != ''){
                        $.get('getcaracteristica',{car_sublineas_id: car_sublineas_id}, function(getcaracteristica) {
                            $('#caracteristica_id').empty();
                            $('#caracteristica_id').append("<option value=''>Seleccione una Caracteristica...</option>");
                            $.each(getcaracteristica, function (index, value) {
                                $('#caracteristica_id').append("<option value='" + index + "'>"+ value +"</option>");
                            })
                        });
                    }

                    var mat_sublineas_id = $(this).val();
                    if ($.trim(mat_sublineas_id) != ''){
                        $.get('getmaterial',{mat_sublineas_id: mat_sublineas_id}, function(getmaterial) {
                            $('#material_id').empty();
                            $('#material_id').append("<option value=''>Seleccione un Material...</option>");
                            $.each(getmaterial, function (index, value) {
                                $('#material_id').append("<option value='" + index + "'>"+ value +"</option>");
                            })
                        });
                    }

                    var med_sublineas_id = $(this).val();
                    if ($.trim(med_sublineas_id) != ''){
                        $.get('getmedida',{med_sublineas_id: med_sublineas_id}, function(getmedida) {
                            $('#medida_id').empty();
                            $('#medida_id').append("<option value=''>Seleccione una Medida...</option>");
                            $.each(getmedida, function (index, value) {
                                $('#medida_id').append("<option value='" + index + "'>"+ value +"</option>");
                            })
                        });
                    }
                    $.get('sln',{sublineas_id: med_sublineas_id}, function(sln) {
                        $('#sln-g').empty();
                        $.each(sln, function (index, value) {
                            document.getElementById("sln-g").value=index;
                            document.getElementById("sln-d").value=value;
                            // $('#codigo')
                        })
                    });

                    var material_id = $(this).val();
                    if ($.trim(material_id) != '') {
                        $.get('mat', {material_id: material_id}, function (mat) {
                            $('#mat-g').empty();
                            $.each(mat, function (index, value) {
                                document.getElementById("mat-g").value = index;
                                document.getElementById("mat-d").value = value;
                                // $('#codigo')
                            })
                        });
                    }

                    var caracteristica_id = $(this).val();
                    if ($.trim(caracteristica_id) != '') {
                        $.get('car', {caracteristica_id: caracteristica_id}, function (car) {
                            $('#car-d').empty();
                            $.each(car, function (index, value) {
                                document.getElementById("car-d").value = value;
                                // $('#codigo')
                            })
                        });
                    }

                });

                $('#medida_id').on('change', function () {
                    var medida_id = $(this).val();
                    if ($.trim(medida_id) != '') {
                        $.get('med', {medida_id: medida_id}, function (med) {
                            $('#med-d').empty();
                            $.each(med, function (index, value) {
                                document.getElementById("med-d").value = value;
                                // $('#codigo')
                            })
                        });
                    }

                    tipoProducto=document.getElementById('ctp-g').value;
                    Linea=document.getElementById('lin-g').value;
                    Sublinea=document.getElementById('sln-g').value;
                    material=document.getElementById('mat-g').value;
                    final=tipoProducto+Linea+Sublinea+material;
                    document.getElementById('codigo').value=final;


                    DLinea=document.getElementById('lin-d').value;
                    DSublinea=document.getElementById('sln-d').value;
                    Dcaracteristica=document.getElementById('car-d').value;
                    Dmaterial=document.getElementById('mat-d').value;
                    Dmedida=document.getElementById('med-d').value;

                    Dfinal=DLinea+' '+DSublinea+' '+Dcaracteristica+' '+Dmaterial+' '+Dmedida;

                    document.getElementById('descripcion').value=Dfinal;

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
