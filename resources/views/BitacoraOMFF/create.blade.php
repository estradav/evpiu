@extends('layouts.architectui')

@section('page_title', 'Bitacora OMFF')

@section('action_recaptcha')
    {!! htmlScriptTagJsApi([ 'action' => 'bitacora_omff_nuevo' ]) !!}
@endsection

@section('content')
    @can('bitacoraomff.create')
        <div class="card">
            <div class="card-header">
                Registro de lingotes
            </div>
            <form id="new_registry_form">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <b class="control-label">TURNO:</b>
                                </div>
                                <div class="col-sm-12">
                                    <select name="turno" id="turno" class="form-control">
                                        <option value="" selected>Seleccione...</option>
                                        <option value="1">6 a.m - 2 p.m</option>
                                        <option value="2">2 p.m - 10 p.m</option>
                                        <option value="2">10 p.m - 6 a.m</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <b class="control-label">MAQUINA:</b>
                                </div>
                                <div class="col-sm-12">
                                    <select name="machine" id="machine" class="form-control">
                                        <option value="" selected>Seleccione...</option>
                                        <option value="P200">P200</option>
                                        <option value="P300">P300</option>
                                        <option value="P301">P301</option>
                                        <option value="P302">P302</option>
                                        <option value="P303">P303</option>
                                        <option value="P304">P304</option>
                                        <option value="P305">P305</option>
                                        <option value="P306">P306</option>
                                        <option value="P307">P307</option>
                                        <option value="P308">P308</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <b class="control-label">OPERARIO:</b>
                                </div>
                                <div class="col-sm-12">
                                    <select name="operario" id="operario" class="form-control">
                                        <option value="" selected>Seleccione...</option>
                                        <option value="Carlos Morales Cordoba">Carlos Morales Cordoba</option>
                                        <option value="Edwin Querubin Mejia">Edwin Querubin Mejia</option>
                                        <option value="Elio Escudero Alejos">Elio Escudero Alejos</option>
                                        <option value="Fabio Salinas Sanchez">Fabio Salinas Sanchez</option>
                                        <option value="Jimmy Guerra Betancur">Jimmy Guerra Betancur</option>
                                        <option value="Jorge Luis Lora Salazar">Jorge Luis Lora Salazar</option>
                                        <option value="Jose Murillo Sanchez">Jose Murillo Sanchez</option>
                                        <option value="Julio Sanchez Martinez">Julio Sanchez Martinez</option>
                                        <option value="Wiston Mosquera Murillo">Wiston Mosquera Murillo</option>
                                        <option value="Otro">Otro</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="col-12">
                        <fieldset>
                            <legend style="color: #3085d6"> <i class="fas fa-info-circle"></i> Numero de lingotes por referencia</legend>
                        </fieldset>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <b class="control-label">TB - TAPA BOTON:</b>
                                </div>
                                <div class="col-sm-12">
                                    <input type="text" id="TB" name="TB" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <b class="control-label">RZ - REMACHE ZAMAC:</b>
                                </div>
                                <div class="col-sm-12">
                                    <input type="text" id="RZ" name="RZ" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <b class="control-label">VZ - VARIOS ZAMAC:</b>
                                </div>
                                <div class="col-sm-12">
                                    <input type="text" id="VZ" name="VZ" class="form-control" >
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <b class="control-label">Z - BOTONES CAMISERO:</b>
                                </div>
                                <div class="col-sm-12">
                                    <input type="text" id="Z" name="Z" class="form-control" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="col-12">
                        <fieldset>
                            <legend style="color: #3085d6"> <i class="fas fa-info-circle"></i> Mantenimento realizado (opcional)</legend>
                        </fieldset>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <b class="control-label">MANTENIMIENTO:</b>
                                </div>
                                <div class="col-sm-12">
                                    <select name="maintenance" id="maintenance" class="form-control">
                                        <option value="" selected>Seleccione...</option>
                                        <option value="P">PREVENTIVO</option>
                                        <option value="C">CORRECTIVO</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <b class="control-label">TIPO DE MANTENIMIENTO:</b>
                                </div>
                                <div class="col-sm-12">
                                    <select name="type_maintenance" id="type_maintenance" class="form-control">
                                        <option value="" selected>Seleccione...</option>
                                        <option value="M">Mecanico</option>
                                        <option value="H">Hidraulico</option>
                                        <option value="N">Neumatico</option>
                                        <option value="E">Electrico</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <b class="control-label">OPERARIO:</b>
                                </div>
                                <div class="col-sm-12">
                                    <select name="operator_maintenance" id="operator_maintenance" class="form-control">
                                        <option value="" selected>Seleccione...</option>
                                        <option value="Carlos Morales Cordoba">Carlos Morales Cordoba</option>
                                        <option value="Edwin Querubin Mejia">Edwin Querubin Mejia</option>
                                        <option value="Elio Escudero Alejos">Elio Escudero Alejos</option>
                                        <option value="Fabio Salinas Sanchez">Fabio Salinas Sanchez</option>
                                        <option value="Jimmy Guerra Betancur">Jimmy Guerra Betancur</option>
                                        <option value="Jorge Luis Lora Salazar">Jorge Luis Lora Salazar</option>
                                        <option value="Jose Murillo Sanchez">Jose Murillo Sanchez</option>
                                        <option value="Julio Sanchez Martinez">Julio Sanchez Martinez</option>
                                        <option value="Wiston Mosquera Murillo">Wiston Mosquera Murillo</option>
                                        <option value="Otro">Otro</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <b class="control-label">OBSERVACIONES:</b>
                                </div>
                                <div class="col-sm-12">
                                    <textarea name="observations" id="observations" cols="30" rows="5" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <button class="btn btn-primary btn-lg" type="submit" id="save">GUARDAR REGISTRO</button>
                </div>
            </form>
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
        <script>
            $(document).ready(function () {
                let Username =  @json(Auth::user()->name);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                jQuery.extend(jQuery.validator.messages, {
                    required: "Este campo es obligatorio.",
                    remote: "Esta marca ya fue creada...",
                    email: "Por favor, escribe una dirección de correo válida",
                    url: "Por favor, escribe una URL válida.",
                    date: "Por favor, escribe una fecha válida.",
                    dateISO: "Por favor, escribe una fecha (ISO) válida.",
                    number: "Por favor, escribe un número entero válido.",
                    digits: "Por favor, escribe sólo dígitos.",
                    creditcard: "Por favor, escribe un número de tarjeta válido.",
                    equalTo: "Por favor, escribe el mismo valor de nuevo.",
                    accept: "Por favor, escribe un valor con una extensión aceptada.",
                    maxlength: jQuery.validator.format("Por favor, no escribas más de {0} caracteres."),
                    minlength: jQuery.validator.format("Por favor, no escribas menos de {0} caracteres."),
                    rangelength: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1} caracteres."),
                    range: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1}."),
                    max: jQuery.validator.format("Por favor, escribe un valor menor o igual a {0}."),
                    min: jQuery.validator.format("Por favor, escribe un valor mayor o igual a {0}."),
                    selectcheck: "Por favor seleccione una opcion!"
                });

                jQuery.validator.addMethod("selectcheck", function(value){
                    return (value != '');
                }, "Por favor, seleciona una opcion.");

                $('#new_registry_form').validate({
                    rules: {
                        turno:{
                            selectcheck: true
                        },
                        machine: {
                            selectcheck: true,
                        },
                        operario: {
                            selectcheck: true,
                        },
                        TB:{
                            min: 0,
                            max: 300,
                            required: true
                        },
                        RZ:{
                            min: 0,
                            max: 300,
                            required: true
                        },
                        VZ:{
                            min: 0,
                            max: 300,
                            required: true
                        },
                        Z:{
                            min: 0,
                            max: 300,
                            required: true
                        },

                    },
                    submitHandler: function (form) {
                        var data_form = $('#new_registry_form').serializeArray();

                        const created_by = {
                            name: 'created_by',
                            value: Username
                        };
                        data_form.push(created_by);

                        $.ajax({
                            url: '/save_bitacoraomff',
                            type: 'post',
                            data: data_form,
                            success: function () {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Guardado!',
                                    text: 'Registro guardado con exito!',
                                    showCancelButton: false,
                                    confirmButtonText: 'Aceptar',
                                    cancelButtonText: 'Cancelar',
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                });
                                $('#new_registry_form').trigger("reset");
                            }
                        });
                        return false;
                    },
                    highlight: function (element) {
                        $(element).closest('.form-control').removeClass('is-valid').addClass('is-invalid');
                    },
                    unhighlight: function (element) {
                        $(element).closest('.form-control').removeClass('is-invalid');
                    },
                });
            });
        </script>
    @endpush
@endsection
