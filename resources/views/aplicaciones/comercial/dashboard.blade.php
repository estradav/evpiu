@extends('layouts.architectui')

@section('page_title', 'Dashboard')

@section('action_recaptcha')
    {!! htmlScriptTagJsApi([ 'action' => 'registro_eventos_actividades_dashboard' ]) !!}
@endsection

@section('content')
    @can('aplicaciones.comercial.dashboard')
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-compass icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>Dashboard
                        <div class="page-title-subheading">
                            Visualizacion de eventos y actividades realizados por el area de ventas
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text b-radius-0">VENDEDOR</span>
                                        </div>
                                        <select name="vendedor" id="vendedor" class="form-control b-radius-0" aria-label="vendedor" aria-describedby="vendedor">
                                            <option value="" selected>Seleccione...</option>
                                            @foreach($vendedores as $vendedor)
                                                <option value="{{$vendedor->codvendedor}}">{{$vendedor->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text b-radius-0"  >CLIENTE</span>
                                        </div>
                                        <select name="cliente" id="cliente" class="form-control b-radius-0" aria-label="cliente" aria-describedby="cliente">
                                            <option value="" selected>Seleccione...</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                                    <button class="btn btn-primary b-radius-0 btn-block btn-lg" id="consultar">CONSULTAR</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="main-card mb-3 card">
                        <div class="card-header">
                            Agenda
                        </div>
                        <div class="card-body" id="agenda">
                            <div class="text-center">
                                <i class="fas fa-info-circle fa-4x text-info" ></i>
                                <h4 class="card-title text-info"> Por favor realice una consulta para ver la agenda </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-exclamation-triangle fa-4x" style="color: red"></i>
                <h3 class="card-title" style="color: #ff0000"> ACCESO DENEGADO </h3>
                <h3 class="card-text" style="color: red">No tiene permiso para usar esta aplicación, por favor comuníquese a la ext: 102 o escribanos al correo electrónico: auxsistemas@estradavelasquez.com para obtener acceso.</h3>
            </div>
        </div>
    @endcan
@endsection

@section('modal')
    <div class="modal fade" id="new_event_modal" tabindex="-1" aria-labelledby="new_event_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="new_event_modal_title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="modal_form">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="inicio">Hora de inicio</label>
                            <input class="form-control" type="time" name="inicio" id="inicio">
                        </div>
                        <div class="form-group">
                            <label for="final">Hora final</label>
                            <input class="form-control" type="time" name="final" id="final">
                        </div>
                        <div class="form-group">
                            <label for="titulo">Descripcion</label>
                            <input class="form-control" type="text" name="titulo" id="titulo">
                        </div>
                        <div class="form-group">
                            <label for="tipo">Tipo</label>
                            <select name="tipo" id="tipo" class="form-control">
                                <option value="" selected>Seleccione...</option>
                                <option value="1">Visita</option>
                                <option value="0">Actividad</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('javascript')
    <script src="{{ asset('fullcalendar/main.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function (){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let date = '';

            $(document).on('change', '#vendedor', function (){
                let id = document.getElementById('vendedor').value;
                $.ajax({
                    url: '/aplicaciones/terceros/comercial/dashboard/consultar_clientes',
                    type: 'get',
                    data: {
                        id: id
                    },
                    success: function (data){
                        $('#cliente').html('').append('<option value="" selected>Seleccione...</option>');
                        for (let i = 0; i < data.length; i++) {
                            $('#cliente').append(`
                                <option value="`+  data[i].NIT.trim() +`">`+ data[i].RAZON_SOCIAL.trim() +`</option>
                            `);
                        }
                    },
                    error: function (data) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops',
                            text: data.responseText
                        });
                    }
                })
            });

            let calendar;

            $(document).on('click', '#consultar', function () {
                const vendedor = document.getElementById('vendedor').value;
                const cliente = document.getElementById('cliente').value;

                if (vendedor === '' || cliente === ''){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops',
                        text: 'Debes seleccionar un vendedor y un cliente para poder realizar la consulta'
                    });
                }else{
                    $.ajax({
                        url: '/aplicaciones/terceros/comercial/dashboard/consultar_info_cliente',
                        type: 'get',
                        data: {
                            vendedor: vendedor,
                            cliente: cliente
                        },
                        success: function (data) {
                            $('#agenda').html('').append(`
                                <div class="text-center">
                                    <h5><i class="fas fa-circle" style="color: #DB4437"></i> VISITAS  -  <i class="fas fa-circle" style="color: #4285F4"></i> ACTIVIDADES</h5>
                                    <hr>
                                </div>
                                <div id="dashboard_calendar"></div>
                            `);

                            const eventos_visitas = {
                                events: data.eventos_visitas,
                                color: '#DB4437',   // a non-ajax option
                                textColor: '#000000' // a non-ajax option
                            };

                            const eventos_actividades = {
                                events: data.eventos_actividades,
                                color: '#4285F4',   // a non-ajax option
                                textColor: '#000000' // a non-ajax option
                            }

                            const calendarEl = document.getElementById('dashboard_calendar');
                            calendar = new FullCalendar.Calendar(calendarEl, {
                                initialView: 'dayGridMonth',
                                timeZone: 'America/Bogota',
                                buttonText: {
                                    prev:     "Ant",
                                    next:     "Sig",
                                    today:    'Hoy',
                                    month:    'Mes',
                                    week:     'Semana',
                                    day:      'Día',
                                    list:     'Agenda'
                                },
                                headerToolbar: {
                                    left: 'prev,next today',
                                    center: 'title',
                                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                                },
                                weekNumbers: true,
                                weekText: 'S',
                                navLinks: true,
                                eventSources: [
                                    eventos_visitas,
                                    eventos_actividades
                                ],
                                selectable: true,
                                dateClick: function(info) {
                                    document.getElementById('new_event_modal_title').innerHTML = info.dateStr;
                                    date = info.dateStr;
                                    $('#new_event_modal').modal('show');
                                    $('#modal_form').trigger('reset');
                                }
                            });
                            calendar.setOption('locale', 'es');
                            calendar.render();
                        },
                        error: function (data) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops',
                                text: data.responseText
                            });
                        }
                    });
                }
            });


            $('#modal_form').validate({
                ignore: "",
                rules: {
                    inicio: {
                        required: true
                    },
                    final: {
                        required: true
                    },
                    titulo: {
                        required: true
                    },
                    tipo: {
                        select_check: true
                    }
                },
                highlight: function (element) {
                    $(element).closest('.form-control').removeClass('is-valid').addClass('is-invalid');
                },
                unhighlight: function (element) {
                    $(element).closest('.form-control').removeClass('is-invalid');
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: '/aplicaciones/terceros/comercial/dashboard/guardar_evento',
                        type: 'post',
                        data: {
                            nit: document.getElementById('cliente').value,
                            type: document.getElementById('tipo').value,
                            start: document.getElementById('inicio').value,
                            end: document.getElementById('final').value,
                            title: document.getElementById('titulo').value,
                            vendedor: document.getElementById('vendedor').value,
                            date: date
                        },
                        dataType: 'json',
                        success: function(data){
                            $("#consultar").click()
                            $('#new_event_modal').modal('hide');
                        },
                        error: function (data) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops',
                                text: data.responseText
                            });
                        }
                    });
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


            jQuery.validator.addMethod("select_check", function(value){
                return (value != '');
            }, "Por favor, seleciona una opcion.");
        });
    </script>
@endpush

@push('styles')
    <link href="{{ asset('fullcalendar/main.css') }}" rel='stylesheet' />

@endpush
