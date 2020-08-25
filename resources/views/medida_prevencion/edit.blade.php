@extends('layouts.architectui')

@section('page_title','editar empleado')

@section('action_recaptcha')
    {!! htmlScriptTagJsApi([ 'action' => 'medida_prevencion_editar_empleado' ]) !!}
@endsection

@section('content')
    @can('admin_medida_prevencion')
        <div class="container-fluid">
            <div class="card card-shadow-dark">
                <div class="card-header">
                    <div class="text-left col-6">
                        {{$employee[0]->employee}}
                    </div>

                    <div class="text-right col-6" >
                        @if ($employee[0]->state == 1)
                            <span class="badge badge-primary change_status" id="{{$employee[0]->id}}" style="cursor: pointer !important;">trabajando</span>
                        @else
                            <span class="badge badge-success change_status" id="{{$employee[0]->id}}" style="cursor: pointer !important;">en casa</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @foreach($days as $day)
                        <hr>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12">
                                    <h5><b>Fecha: </b>{{date('d-m-Y', strtotime($day->created_at))}} <a href="javascript:void(0)" id="{{$day->created_at.','. $day->id}}" class="edit_created_at"><i class="fas fa-pen-square"></i></a></h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 text-left">
                                    <h5><b> Hora de entrada: </b> {{$day->time_enter}}  <a href="javascript:void(0)" id="{{$day->time_enter.','. $day->id}}" class="edit_time_enter"><i class="fas fa-pen-square"></i></a></h5>
                                </div>
                                <div class="col-6 text-right">
                                    <h5><b> Hora de salida: </b> {{$day->time_exit}} <a href="javascript:void(0)" id="{{$day->time_exit.','. $day->id}}" class="edit_time_exit"><i class="fas fa-pen-square"></i></a></h5>
                                </div>
                            </div>
                            <div class="row">
                                <table class="table table-bordered text-center">
                                    <thead>
                                    <tr>
                                        <th scope="col">TEMPERATURA</th>
                                        <th scope="col">HORA DE REGISTRO</th>
                                        <th scope="col">ACCIONES</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($day->temperature as $temperature)
                                            <tr>
                                                <th scope="row">{{ $temperature->temperature }}</th>
                                                <td>{{ date('g:i A', strtotime($temperature->created_at))}}</td>
                                                <td> <button class="btn btn-info edit_temperature_modal" id="{{$temperature->id.','. $temperature->temperature.','.$temperature->created_at }}"> Editar</button> </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr>
                    @endforeach
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
@endsection

@push('javascript')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click','.edit_time_enter', function () {
                let id = this.id;
                id = id.split(',');

                swal.mixin({
                    icon: 'info',
                    title: 'Hora de entrada',
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    buttonsStyling: true,
                    showCancelButton: true,
                    input: 'text',
                }).queue([
                    {
                        html:' <input type="text" class="form-control" id="time_enter_edit" value="'+id[0]+'">',
                        inputValidator: () => {
                            var valid_time = document.getElementById('time_enter_edit').value.match(/^[\d]{4}[-][\d]{2}[-][\d]{2} (0?[1-9]|1[012])(:[0-5]\d) [APap][mM]$/)
                            if (document.getElementById('time_enter_edit').value == '') {
                                return 'Este campo no puede ir en blanco';
                            }
                            if(!valid_time){
                                return 'la hora debe estar en formato Y-M-D H:M am/pm';
                            }
                        },
                        preConfirm: function () {
                            var array = {
                                'id': id[1],
                                'time_enter': document.getElementById("time_enter_edit").value,
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
                            url: '/edit_medida_prevencion_edit_time_enter',
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
                                window.location.reload(true)
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

            $(document).on('click', '.edit_time_exit', function () {
                let id = this.id;
                id = id.split(',')

                swal.mixin({
                    icon: 'info',
                    title: 'Hora de salida',
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    buttonsStyling: true,
                    showCancelButton: true,
                    input: 'text',
                }).queue([
                    {
                        html:' <input type="text" class="form-control" id="time_exit_edit" value="'+id[0]+'">',
                        inputValidator: () => {
                            var valid_time = document.getElementById('time_exit_edit').value.match(/^[\d]{4}[-][\d]{2}[-][\d]{2} (0?[1-9]|1[012])(:[0-5]\d) [APap][mM]$/)
                            if (document.getElementById('time_exit_edit').value == '') {
                                return 'Este campo no puede ir en blanco';
                            }
                            if(!valid_time){
                                return 'la hora debe estar en formato Y-M-D H:M am/pm';
                            }
                        },
                        preConfirm: function () {
                            var array = {
                                'id': id[1],
                                'time_exit': document.getElementById("time_exit_edit").value,
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
                            url: '/edit_medida_prevencion_edit_time_exit',
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
                                window.location.reload(true)
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
            $(document).on('click', '.edit_temperature_modal', function () {
                let id = this.id;
                id = id.split(',')

                swal.mixin({
                    icon: 'info',
                    title: 'Temperatura',
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    buttonsStyling: true,
                    showCancelButton: true,
                    input: 'text',
                }).queue([
                    {
                        html:' <input type="text" class="form-control" id="temperature_edit" value="'+id[1]+'" placeholder="temperatura" > <br>' +
                            '<label for="">Fecha y hora:</label>' +
                            '<input type="text" class="form-control" id="time_edit" value="'+ id[2]+'" placeholder="fecha y hora">',
                        inputValidator: () => {
                            if (document.getElementById('temperature_edit').value == '') {
                                return 'Este campo no puede ir en blanco';
                            }
                            if (document.getElementById('time_edit').value == '') {
                                return 'Este campo no puede ir en blanco';
                            }
                        },
                        preConfirm: function () {
                            var array = {
                                'id': id[0],
                                'temperature': document.getElementById("temperature_edit").value,
                                'time': document.getElementById("time_edit").value

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
                            url: '/edit_medida_prevencion_edit_temperature',
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
                                window.location.reload(true)
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

            $(document).on('click','.edit_created_at', function () {
                let id = this.id;
                id = id.split(',')


                var date = id[0];

                function GetFormattedDate(date) {
                    var todayTime = new Date(date);

                    var month   = ("0" + (todayTime.getMonth() + 1)).slice(-2)
                    var day     = ("0" + todayTime.getDate()).slice(-2);
                    var year    = todayTime.getFullYear();
                    return day + "-" + month + "-" + year;
                }

                swal.mixin({
                    icon: 'info',
                    title: 'Fecha de registro',
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    buttonsStyling: true,
                    showCancelButton: true,
                    input: 'text',
                }).queue([
                    {
                        html:' <input type="text" class="form-control" id="created_at" value="'+  GetFormattedDate(date) +'">',
                        inputValidator: () => {
                            if (document.getElementById('created_at').value == '') {
                                return 'Este campo no puede ir en blanco';
                            }

                        },
                        preConfirm: function () {
                            var array = {
                                'id': id[1],
                                'created_at': document.getElementById("created_at").value,
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
                            url: '/edit_medida_prevencion_edit_created_at',
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
                                window.location.reload(true)
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

            $(document).on('click', '.change_status', function () {
                Swal.fire({
                    title: '¿Cambiar estado?',
                    text: "Se cambiara el estado del empleado",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Cambiar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: '/edit_medida_prevencion_edit_status',
                            type: 'post',
                            data: {
                                id: this.id
                            },
                            success: function (data) {
                                window.location.reload();
                            },
                            error: function (data) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: data,
                                })
                            }
                        })
                    }
                })

            });
        });
    </script>
@endpush
