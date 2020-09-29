@extends('layouts.architectui')

@section('page_title', 'Registro de eventos y actividades')

@section('action_recaptcha')
    {!! htmlScriptTagJsApi([ 'action' => 'registro_eventos_actividades' ]) !!}
@endsection

@section('content')
    @can('aplicaciones.comercial.eventos_actividades')
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-calculator icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>Calendario de actividades y visitas
                        <div class="page-title-subheading">
                            Registre todos los eventos y actividades de sus clientes
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                    <div class="card igualar">
                        <div class="card-body">
                            <div class="btn-group btn-lg special" role="group">
                                <button type="button" class="btn btn-outline-primary btn-lg active" id="type_event">VISITAS</button> {{--// BOOL 1--}}
                                <button type="button" class="btn btn-outline-primary btn-lg" id="type_activies">ACTIVIDADES</button>
                            </div>
                            <hr>
                            <h6 class="text-center">CLIENTES</h6>
                            <hr>
                            <div class="list-group" style="overflow-y: auto" >
                                @php
                                    $idx = 0
                                @endphp
                                @foreach($clientes as $cliente)
                                    @if ($idx == 0)
                                        <button  class="list-group-item list-group-item-action idx_{{ $idx }} client  active" id="{{ trim($cliente->NIT) }}">
                                            <b>{{ $cliente->RAZON_SOCIAL }} </b>  <br>
                                            <b class="text-success"> Meta : $0 </b>
                                        </button>
                                    @else
                                        <button  class="list-group-item list-group-item-action idx_{{ $idx }} client" id="{{ trim($cliente->NIT) }}">
                                            <b>{{ $cliente->RAZON_SOCIAL }} </b>  <br>
                                            <b class="text-success"> Meta : $0 </b>
                                        </button>
                                    @endif

                                    @php
                                        $idx++;
                                    @endphp
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-8">
                    <div class="card calendario_card">
                        <div class="card-body">
                            <h5 class="text-center"><b id="type_data">VISITAS</b></h5>
                            <hr>
                            <div id='calendary'></div>
                        </div>
                    </div>
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
    <script src="{{ asset('librerias_javascript/fullcalendar/main.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function (){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let client_nit = 0;
            let type = 1;
            let date = '';
            const items = document.getElementsByClassName("list-group-item-action active");
            for (let i = 0; i < items.length; i++) {
                client_nit = items[i].id;
            }

            $(document).on('click', '.client', function() {
                document.getElementById(client_nit).classList.remove('active');
                client_nit = this.id;
                document.getElementById(client_nit).classList.add('active');
                calendar.refetchEvents();
            });

            $(document).on('click', '#type_event', function() {
                type = 1;
                document.getElementById('type_activies').classList.remove('active');
                document.getElementById('type_event').classList.add('active');
                calendar.refetchEvents();
                document.getElementById('type_data').innerText = 'VISITAS'
            });

            $(document).on('click', '#type_activies', function() {
                type = 0;
                document.getElementById('type_event').classList.remove('active');
                document.getElementById('type_activies').classList.add('active');
                calendar.refetchEvents();
                document.getElementById('type_data').innerText = 'ACTIVIDADES'
            });


            const calendarEl = document.getElementById('calendary');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                timeZone: 'America/Bogota',
                themeSystem: 'bootstrap',
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
                navLinks: true,
                weekNumbers: true,
                weekText: 'S',
                events: {
                    url: '/aplicaciones/terceros/comercial/obtener_eventos',
                    method: 'get',
                    extraParams: function() {
                        return {
                            client: client_nit,
                            type: type
                        };
                    },
                    failure: function() {
                        alert('there was an error while fetching events!');
                    },
                },
                eventColor: '#12a9c1',
                eventBackgroundColor: '#ffffff',
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

            setTimeout(function() {
                const altura = $('.calendario_card').height();
                $('.igualar').css('height', altura);
                $('.list-group').css('height', altura-200);
            }, 2000);


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
                        url: '/aplicaciones/terceros/comercial/guardar_evento',
                        type: 'post',
                        data: {
                            nit: client_nit,
                            type: type,
                            start: document.getElementById('inicio').value,
                            end: document.getElementById('final').value,
                            title: document.getElementById('titulo').value,
                            date: date
                        },
                        dataType: 'json',
                        success: function(data){
                            calendar.refetchEvents();
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
    </script>
@endpush

@push('styles')
    <link href="{{ asset('librerias_javascript/fullcalendar/main.css') }}" rel='stylesheet' />
    <style>

        .btn-group.special {
            display: flex;
        }

        .special .btn {
            flex: 1;
            border-radius: 0;
        }
    </style>
@endpush

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
                        <b>Hora de inicio</b>
                        <input class="form-control" type="time" name="inicio" id="inicio">
                    </div>
                    <div class="form-group">
                        <b>Hora final</b>
                        <input class="form-control" type="time" name="final" id="final">
                    </div>
                    <div class="form-group">
                        <b>Descripcion</b>
                        <input class="form-control" type="text" name="titulo" id="titulo">
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
