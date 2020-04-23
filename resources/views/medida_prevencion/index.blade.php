@extends('layouts.architectui')

@section('page_title', 'Ingreso de personal')

@section('content')
<div class="container-fluid">
    <div class="card card-shadow-dark">
        <div class="card-header">
            Registro de personal que ingresa
        </div>
        <form id="registry_form" name="registry_form">
            <div class="card-body">

                <div class="col-12">
                    <div class="row">
                        <div class="col-4">
                            <label for="">Empleado:</label>
                            <select name="empleado" id="empleado" class="form-control" autofocus>
                                <option value="empty" selected>Seleccione...</option>
                                @foreach($empleados as $empleado)
                                    <option value="{{$empleado}}">{{$empleado}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="">Temperatura:</label>
                            <input type="number" class="form-control" max="40" min="20" id="temperatura" name="temperatura">
                        </div>
                        <div class="col-4" onload="new_clock()">
                            <label for="">Hora de ingreso:</label>
                            <input type="text" name="datetime" id="datetime" class="form-control" value="" readonly="readonly">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <label for="">Notas/Observaciones: </label>
                            <textarea name="notas" id="notas" cols="10" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success" id="save" name="save">Registrar ingreso</button>
            </div>
        </form>
    </div>
</div>
<br>
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            Usuarios trabajando
        </div>
        <div class="card-body">
            <table class="table" id="empleados_table">
                <thead>
                    <tr>
                        <th scope="col" class="text-center">EMPLEADO</th>
                        <th scope="col" class="text-center">INFO</th>
                        <th scope="col" class="text-center">TEMPERATURA</th>
                        <th scope="col" class="text-center">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($empleados_registrados as $registros)
                        <tr>
                            <td class="text-center">{{ $registros->employee }}</td>
                            <td class="text-center"><button class="btn btn-primary info" id="{{ $registros->id }}"><i class="fas fa-eye"></i> Info</button> </td>
                            <td class="text-center"><button class="btn btn-success registry_temperature" id="{{ $registros->id }}"><i class="fas fa-thermometer"></i> Temperatura</button></td>
                            <td class="text-center"><button class="btn btn-danger exit" id="{{ $registros->id }}"><i class="fas fa-door-closed"></i> Salida</button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop
@section('modal')
    <div class="modal modal-danger fade" tabindex="-1" id="info_modal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="info_modal_title">Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="info_modal_body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <style>
        .select2-selection__rendered {
            line-height: 31px !important;
        }
        .select2-container .select2-selection--single {
            height: 35px !important;
        }
        .select2-selection__arrow {
            height: 34px !important;
        }
    </style>
@endsection
@push('javascript')
    <script>
        function new_clock(){
            clock = new Date();
            hour =   clock.getHours();
            minutes = clock.getMinutes();
            seconds = clock.getSeconds();

            var ampm = hour >= 12 ? 'pm' : 'am';
            hour = hour % 12;
            hour = hour ? hour : 12; // the hour '0' should be '12'
            minutes = minutes < 10 ? '0'+minutes : minutes;
            var strTime = hour + ':' + minutes + ':' + seconds + ' ' +  ampm;

            $('#datetime').val(strTime);
            $('#exit_clock').val(strTime);
            setTimeout(new_clock, 1000)
        }
        setTimeout(new_clock, 1000);

        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#empleados_table').DataTable();


            jQuery.validator.addMethod("selectcheck", function(value){
                return (value != 'empty');
            }, "Por favor, seleciona una opcion.");

            $('#registry_form').validate({
                rules:{
                    empleado:{
                        selectcheck: true,
                        remote:{
                            url: '/validate_exist_employee',
                            type: 'POST',
                            async: true,
                        },
                    },
                    temperatura: {
                        required: true,
                        min: 20,
                        max: 40
                    },
                },
                submitHandler: function (form) {
                    var data_form = $('#registry_form').serializeArray();
                    $.ajax({
                        url: '/medida_prevencion',
                        method: 'post',
                        type: 'post',
                        data: data_form,
                        success: function (data) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Completado',
                                text: data,
                                showCancelButton: false,
                                confirmButtonText: 'Aceptar',
                                cancelButtonText: 'Cancelar',
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                            });
                            $('#registry_form').trigger("reset");
                            table.draw();
                            window.location.reload();

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

            $('body').on('click', '.info', function () {

                var id = this.id;
                $.ajax({
                    url: '/get_data_peer_day_medida_prevencion',
                    type: 'get',
                    data: {id: id},
                    success: function (data) {
                        $('#info_modal_body').html('');
                        for (var i = 0; i <= data.days.length -1; i++){
                            $('#info_modal_body').append(`
                            <hr>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12">
                                        <b>Fecha: </b> `+ data.days[i].created_at +` <br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <b>Hora de entrada: </b> `+ data.days[i].time_enter +`
                                    </div>
                                    <div class="col-6 text-right">
                                        <b>Hora de salida: </b> `+ data.days[i].time_exit +`
                                    </div>
                                </div>
                                <div class="row">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">Temperatura registrada</th>
                                                <th scope="col">Hora de registro</th>
                                            </tr>
                                        </thead>
                                        <tbody id="temperatures_`+ i +`" >
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <hr>
                            <br>
                            `)

                            for (var j = 0; j <= data.days[i].temperature.length -1; j++){
                                $('#temperatures_'+i).append(`
                                    <tr>
                                        <th scope="row">`+data.days[i].temperature[j].temperature +`</th>
                                        <td>`+data.days[i].temperature[j].created_at +`</td>
                                    </tr>`);
                            }
                        }
                        $('#info_modal').modal('show');
                    },
                    error: function () {

                    }
                });
            });
            $('body').on('click', '.registry_temperature', function () {
                var id = this.id
                swal.mixin({
                    icon: 'info',
                    title: 'Registrar temperatura',
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    buttonsStyling: true,
                    showCancelButton: true,
                    input: 'text',
                }).queue([
                    {
                        html:' <input type="number" class="form-control" id="temperatura_input" min="20" max="40">',
                            inputValidator: () => {
                            if (document.getElementById('temperatura_input').value == '') {
                                return 'Este campo no puede ir en blanco';
                            }

                        },
                        preConfirm: function () {
                            var array = {
                                'id': id,
                                'temperatura_input': document.getElementById("temperatura_input").value,
                            };
                            return array;
                        },
                        onBeforeOpen: function (dom) {
                            swal.getInput().style.display = 'none';
                        }
                    },
                ]).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: '/registry_temperature_in_day',
                            type: 'post',
                            data: {
                                result: result.value[0]
                            },
                            success: function () {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Guardardo',
                                    text: 'Datos guardados con exito!',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Aceptar',
                                })
                            },
                            error: function () {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'La solicitud no pudo ser procesada!',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Aceptar',
                                })
                            }
                        });
                    } else {
                        result.dismiss === Swal.DismissReason.cancel
                    }
                })
            });
            $('body').on('click', '.exit', function () {
                var id = this.id
                swal.mixin({
                    icon: 'question',
                    title: 'Salida de empleado',
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    buttonsStyling: true,
                    showCancelButton: true,
                    input: 'text',
                }).queue([
                    {
                        html:'<label>Temperatura: </label>' +
                            '<input type="number" class="form-control" id="temperatura_input1" min="20" max="40">' +
                            '<br>' +
                            '<label>Hora de salida: </label>' +
                            '<input type="text" class="form-control" id="exit_clock" readonly="readonly">',

                        inputValidator: () => {
                            if (document.getElementById('temperatura_input1').value == '') {
                                return 'Este campo no puede ir en blanco';
                            }

                        },
                        preConfirm: function () {
                            var array = {
                                'id': id,
                                'temperatura_input': document.getElementById("temperatura_input1").value,
                                'hora_salida': document.getElementById("exit_clock").value

                            };
                            return array;
                        },
                        onBeforeOpen: function (dom) {
                            swal.getInput().style.display = 'none';
                        }
                    },
                ]).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: '/exit_employee_in_day',
                            type: 'post',
                            data: {
                                result: result.value[0]
                            },
                            success: function () {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Guardardo',
                                    text: 'Datos guardados con exito!',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Aceptar',
                                });
                            },
                            error: function () {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'La solicitud no pudo ser procesada!',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Aceptar',
                                })
                            }
                        });
                    } else {
                        result.dismiss === Swal.DismissReason.cancel
                    }
                })
            });

            $('#empleado').select2();

        });
    </script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.3.10/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.min.js" ></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
@endpush
