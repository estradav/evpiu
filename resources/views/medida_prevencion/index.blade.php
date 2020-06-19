@extends('layouts.architectui')

@section('page_title', 'Ingreso de personal')

@section('content')
    @can('medida_prevencion')
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-like icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>Ingreso de personal
                        <div class="page-title-subheading">
                            Formulario de ingreso del personal por medida de prevencion.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">
                        Registro de personal que ingresa
                    </div>
                    <form id="registry_form" name="registry_form">
                        <div class="card-body">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                                        <label for="">Empleado:</label>
                                        <select name="empleado" id="empleado" class="form-control" autofocus>
                                            <option value="empty" selected>Seleccione...</option>
                                            @foreach($empleados as $empleado)
                                                <option value="{{$empleado}}">{{$empleado}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                                        <label for="">Temperatura:</label>
                                        <input type="number" class="form-control" max="40" min="20" id="temperatura" name="temperatura">
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4" onload="new_clock()">
                                        <label for="">Hora de ingreso:</label>
                                        <div class="input-group">
                                            <input type="text" name="datetime" id="datetime" class="form-control" value="" readonly="readonly">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-danger" type="button" id="stop_time">
                                                    <i id="stop_time_ico" class="fas fa-stop"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>PREGUNTAS</th>
                                            <th class="text-center">SI</th>
                                            <th class="text-center">NO</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <th>¿Fiebre?</th>
                                            <td><input class="form-control" type="radio" name="question_1" id="question_1" value="question_1"></td>
                                            <td><input class="form-control" type="radio" name="question_1" id="question_1" value="question_1" checked></td>
                                        </tr>
                                        <tr>
                                            <th>¿Tos seca?</th>
                                            <td><input class="form-control" type="radio" name="question_2" id="question_2" value="question_2"></td>
                                            <td><input class="form-control" type="radio" name="question_2" id="question_2" value="question_2" checked></td>
                                        </tr>
                                        <tr>
                                            <th>¿Dolor de garganta?</th>
                                            <td><input class="form-control" type="radio" name="question_3" id="question_3" value="question_3"></td>
                                            <td><input class="form-control" type="radio" name="question_3" id="question_3" value="question_3" checked></td>
                                        </tr>
                                        <tr>
                                            <th>¿Dificultad para respirar?</th>
                                            <td><input class="form-control" type="radio" name="question_4" id="question_4" value="question_4"></td>
                                            <td><input class="form-control" type="radio" name="question_4" id="question_4" value="question_4" checked></td>
                                        </tr>
                                        <tr>
                                            <th>¿Pérdida del gusto y/o del olfato?</th>
                                            <td><input class="form-control" type="radio" name="question_5" id="question_5" value="question_5"></td>
                                            <td><input class="form-control" type="radio" name="question_5" id="question_5" value="question_5" checked></td>
                                        </tr>
                                        <tr>
                                            <th>¿Ha tenido Usted contacto durante los últimos 14 días con alguna persona <br> a quien le sospechen o le haya diagnosticado coronavirus?</th>
                                            <td><input class="form-control" type="radio" name="question_6" id="question_6" value="question_6"></td>
                                            <td><input class="form-control" type="radio" name="question_6" id="question_6" value="question_6" checked></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <label for="notas">Notas/Observaciones: </label>
                                        <textarea name="notas" id="notas" cols="10" rows="3" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success btn-block btn-lg" id="save" name="save">REGISTRAR INGRESO</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="main-card mb-3 card">
            <div class="card-header">
                Usuarios trabajando
            </div>
            <div class="card-body">
                <table class="table" id="empleados_table">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">EMPLEADO</th>
                            <th scope="col" class="text-center">TEMPERATURA</th>
                            <th scope="col" class="text-center">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($empleados_registrados as $registros)
                            <tr>
                                <td class="text-center">{{ $registros->employee }}</td>
                                <td class="text-center"><button class="btn btn-success registry_temperature" id="{{ $registros->id }}"><i class="fas fa-thermometer"></i> Temperatura</button></td>
                                <td class="text-center"><button class="btn btn-danger exit" id="{{ $registros->id }}"><i class="fas fa-door-closed"></i> Salida</button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="main-card mb-3 card">
            <div class="card-body text-center">
                <i class="fas fa-exclamation-triangle fa-4x" style="color: red"></i>
                <h3 class="card-title" style="color: red"> ACCESO DENEGADO </h3>
                <h3 class="card-text" style="color: red">No tiene permiso para usar esta aplicación, por favor comuníquese a la ext: 102 o escribanos al correo electrónico: auxsistemas@estradavelasquez.com para obtener acceso.</h3>
            </div>
        </div>
    @endcan
@stop
@push('styles')
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
@endpush

@push('javascript')
    <script type="text/javascript">
        var clock_on = true;
        function new_clock(){
            if(clock_on === true){
                clock = new Date();
                console.log(clock.getDate());
                year = clock.getFullYear();
                month = ("0" + (clock.getMonth() + 1)).slice(-2);
                day =  ("0" + (clock.getDate())).slice(-2);
                hour =   clock.getHours();
                minutes = clock.getMinutes();
                seconds = clock.getSeconds();

                var ampm = hour >= 12 ? 'PM' : 'AM';
                hour = hour % 12;
                hour = hour ? hour : 12; // the hour '0' should be '12'
                minutes = minutes < 10 ? '0'+minutes : minutes;
                var strTime =year+'-'+month+'-'+day+' '+ hour + ':' + minutes + ':' + seconds + ' ' +  ampm;

                $('#datetime').val(strTime);
                $('#exit_clock').val(strTime);
                setTimeout(new_clock, 1000)
            }else{
                return false;
            }
        }
        setTimeout(new_clock, 1000);


        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let table = $('#empleados_table').DataTable({
                language: {
                    url: "/Spanish.json"
                }
            });

            jQuery.validator.addMethod("selectcheck", function(value){
                return (value != 'empty');
            }, "Por favor, seleciona una opcion.");

            $('#registry_form').validate({
                rules:{
                    empleado:{
                        selectcheck: true
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
                }
            });

            $(document).on('click', '.info', function () {
                var id = this.id;
                $.ajax({
                    url: '/get_data_peer_day_medida_prevencion',
                    type: 'get',
                    data: {id: id},
                    success: function (data) {
                        console.log(data);
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
                                                <th scope="col">Acciones</th>
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
                                        <td> <button class="btn btn-info edit_temperature_modal" id="`+data.days[i].temperature[j].id + `,`+ data.days[i].temperature[j].temperature+ `,`+ data.days[i].temperature[j].created_at  +`"> editar</button> </td>
                                    </tr>`);
                            }
                        }
                        $('#info_modal').modal('show');
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });
            $(document).on('click', '.registry_temperature', function () {
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

            $(document).on('click','#stop_time', function () {
                if(clock_on === true){
                    clock_on = false;
                    document.getElementById('datetime').readOnly=false;
                    document.getElementById('stop_time').classList.replace('btn-outline-danger','btn-outline-success')
                    document.getElementById('stop_time_ico').classList.replace('fa-stop','fa-play')
                }
                else if(clock_on === false) {
                    clock_on = true;
                    document.getElementById('datetime').readOnly=true;
                    document.getElementById('stop_time').classList.replace('btn-outline-success','btn-outline-danger')
                    document.getElementById('stop_time_ico').classList.replace('fa-play','fa-stop')
                    setTimeout(new_clock, 1000);
                }
            });
            $(document).on('click','.edit_temperature_modal', function () {
                let data = this.id;
                data = data.split(',');

                $('#id_edit_temperature').val(data[0]);
                $('#temperature_edit_temperature').val(data[1]);
                $('#date_edit_temperature').val(data[2]);
                $('#edit_temperature_modal').modal('show');
            });
            $('#form_edit_temperature').validate({
                rules:{
                    temperature_edit_temperature: {
                        required: true
                    },
                    date_edit_temperature: {
                        required: true
                    }
                },
                submitHandler: function (form) {
                    var data_form = $('#form_edit_temperature').serializeArray();
                    $.ajax({
                        url: '/medida_prevencion_edit_temperature',
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
                            $('#edit_temperature_modal').modal('hide');
                            $('#info_modal').modal('hide');
                        }
                    });
                    return false;
                },
                highlight: function (element) {
                    $(element).closest('.form-control').removeClass('is-valid').addClass('is-invalid');
                },
                unhighlight: function (element) {
                    $(element).closest('.form-control').removeClass('is-invalid');
                }
            });

            moment.locale('es');
            $('#datetime').daterangepicker({
                singleDatePicker: true,
                showWeekNumbers: true,
                showISOWeekNumbers: true,
                timePicker: true,
                timePickerSeconds: true,
                locale: {
                    format: 'YYYY-MM-DD h:mm:ss A'
                }
            }, function(start, end, label) {
                console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
            });

        });
    </script>
@endpush
