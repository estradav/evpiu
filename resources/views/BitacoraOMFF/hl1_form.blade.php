@extends('layouts.architectui')

@section('page_title', 'Bitacora OMFF')

@section('content')
    @can('bitacoraomff.create')
        <div class="card">
            <div class="card-header">
                Registro de lingotes
            </div>
            <form id="new_registry_form">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <b class="control-label">HORA INICIO:</b>
                                </div>
                                <div class="col-sm-12">
                                    <select name="start" id="start" class="form-control">
                                        <option value="" selected>Seleccione...</option>
                                        <option value="1:00 am">1:00 a.m</option>
                                        <option value="2:00 am">2:00 a.m</option>
                                        <option value="3:00 am">3:00 a.m</option>
                                        <option value="4:00 am">4:00 a.m</option>
                                        <option value="5:00 am">5:00 a.m</option>
                                        <option value="6:00 am">6:00 a.m</option>
                                        <option value="7:00 am">7:00 a.m</option>
                                        <option value="8:00 am">8:00 a.m</option>
                                        <option value="9:00 am">9:00 a.m</option>
                                        <option value="10:00 am">10:00 a.m</option>
                                        <option value="11:00 am">11:00 a.m</option>
                                        <option value="12:00 pm">12:00 p.m</option>
                                        <option value="1:00 pm">1:00 p.m</option>
                                        <option value="2:00 pm">2:00 p.m</option>
                                        <option value="3:00 pm">3:00 p.m</option>
                                        <option value="4:00 pm">4:00 p.m</option>
                                        <option value="6:00 pm">6:00 p.m</option>
                                        <option value="6:00 pm">6:00 p.m</option>
                                        <option value="7:00 pm">7:00 p.m</option>
                                        <option value="8:00 pm">8:00 p.m</option>
                                        <option value="9:00 pm">9:00 p.m</option>
                                        <option value="10:00 pm">10:00 p.m</option>
                                        <option value="11:00 pm">11:00 p.m</option>
                                        <option value="12:00 am">12:00 a.m</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <b class="control-label">HORA FIN:</b>
                                </div>
                                <div class="col-sm-12">
                                    <select name="end" id="end" class="form-control">
                                        <option value="" selected>Seleccione...</option>
                                        <option value="1:00 am">1:00 a.m</option>
                                        <option value="2:00 am">2:00 a.m</option>
                                        <option value="3:00 am">3:00 a.m</option>
                                        <option value="4:00 am">4:00 a.m</option>
                                        <option value="5:00 am">5:00 a.m</option>
                                        <option value="6:00 am">6:00 a.m</option>
                                        <option value="7:00 am">7:00 a.m</option>
                                        <option value="8:00 am">8:00 a.m</option>
                                        <option value="9:00 am">9:00 a.m</option>
                                        <option value="10:00 am">10:00 a.m</option>
                                        <option value="11:00 am">11:00 a.m</option>
                                        <option value="12:00 pm">12:00 p.m</option>
                                        <option value="1:00 pm">1:00 p.m</option>
                                        <option value="2:00 pm">2:00 p.m</option>
                                        <option value="3:00 pm">3:00 p.m</option>
                                        <option value="4:00 pm">4:00 p.m</option>
                                        <option value="6:00 pm">6:00 p.m</option>
                                        <option value="6:00 pm">6:00 p.m</option>
                                        <option value="7:00 pm">7:00 p.m</option>
                                        <option value="8:00 pm">8:00 p.m</option>
                                        <option value="9:00 pm">9:00 p.m</option>
                                        <option value="10:00 pm">10:00 p.m</option>
                                        <option value="11:00 pm">11:00 p.m</option>
                                        <option value="12:00 am">12:00 a.m</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <b class="control-label">OPERARIO:</b>
                                </div>
                                <div class="col-sm-12">
                                    <select name="operario" id="operario" class="form-control">
                                        <option value="" selected>Seleccione...</option>
                                        <option value="Jahider Farley Yali Calle">Jahider Farley Yali Calle</option>
                                        <option value="Otro">Otro</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <b class="control-label">LINGOTES:</b>
                                </div>
                                <div class="col-sm-12">
                                    <input type="text" id="lingotes" name="lingotes" class="form-control">
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
                        start:{
                            selectcheck: true
                        },
                        end: {
                            selectcheck: true,
                        },
                        operario: {
                            selectcheck: true,
                        },
                        lingotes:{
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

                        console.log(data_form);
                        $.ajax({
                            url: '/save_bitacoraomff_hl1',
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
                            },
                            error: function () {
                                alert('error');
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
