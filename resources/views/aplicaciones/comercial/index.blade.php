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
                            <div class="btn-group btn-lg special" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-outline-primary btn-lg">EVENTOS</button>
                                <button type="button" class="btn btn-outline-primary btn-lg">ACTIVIDADES</button>
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
                                        <button  class="list-group-item list-group-item-action idx_{{ $idx }} active" id="{{ $cliente->NIT }}">
                                            <b>{{ $cliente->RAZON_SOCIAL }} </b>  <br>
                                            <b class="text-success"> Meta : $0 </b>
                                        </button>
                                    @else
                                        <button  class="list-group-item list-group-item-action idx_{{ $idx }}" id="{{ $cliente->NIT }}">
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
                            <h6 class="text-center" id="type_data"><b>EVENTOS</b></h6>
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
    <script src="{{ asset('fullcalendar/main.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function (){
            var client_nit = 0;
            var items = document.getElementsByClassName("list-group-item-action active");
            for (let i = 0; i < items.length; i++) {
                console.log(items[i].id);
                client_nit = items[i].id;
            }



            var calendarEl = document.getElementById('calendary');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                timeZone: 'America/Bogota',
                themeSystem: 'bootstrap',
                buttonText: {
                    prev:     "Anterior",
                    next:     "Siguiente",
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
                    url: '/aplicaciones/comercial/obtener_eventos',
                    method: 'get',
                    extraParams: {
                        client: client_nit,
                        type: 1
                    },
                    failure: function() {
                        alert('there was an error while fetching events!');
                    },
                }


            });
            calendar.setOption('locale', 'es');
            calendar.render();

            setTimeout(function() {
                var altura = $('.calendario_card').height();
                console.log(altura)
                $('.igualar').css('height', altura);
                $('.list-group').css('height', altura-200);
            }, 3000);



        });



    </script>
@endpush

@push('styles')
    <link href="{{ asset('fullcalendar/main.css') }}" rel='stylesheet' />
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
