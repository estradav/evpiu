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
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="input-group mb-3">
                                <select class="form-control" name="clients[]" multiple="multiple" id="clients">
                                    @foreach($clientes as $cliente)
                                        <option value="{{ trim($cliente->NIT)}}">{{trim($cliente->RAZON_SOCIAL)}}</option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-light" id="filter">FILTRAR DATOS</button>
                                    <button class="btn btn-light" id="show_all">MOSTRAR TODO</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
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
        $(document).ready(function () {
            $('#clients').select2({
                placeholder: 'Seleccione...'
            });
        });

        $(document).on('click', '#filter', function () {
            const client_list = $("#clients").val()
            if (typeof client_list !== 'undefined' && client_list.length > 0){
                calendar.removeAllEventSources();
                calendar.addEventSource({
                    url: '/aplicaciones/CRM/comercial/get_events_and_activities',
                    type: 'get',
                    extraParams: function() {
                        return {
                            client_list: client_list
                        }
                    },
                    beforeSend: function(){
                        calendar.render();
                    },
                    success: function( json ){
                        calendar.render();
                    }
                });


            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops',
                    text: 'Debes seleccionar al menos un cliente'
                });

            }
        });



        const calendarEl = document.getElementById('calendary');
        const calendar = new FullCalendar.Calendar(calendarEl, {
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
            navLinks: true,
            weekNumbers: true,
            weekText: 'S',
            events: {
                url: '/aplicaciones/CRM/comercial/get_all_events_and_activities',
                method: 'get',
                failure: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops',
                        text: '¡Hubo un error al recuperar eventos!'
                    });
                },
            },
            selectable: true,
            dateClick: function(info) {
                document.getElementById('new_event_modal_title').innerHTML = info.dateStr;
                date = info.dateStr;
                $('#new_event_modal').modal('show');
                $('#modal_form').trigger('reset');
            },
            eventColor: '#378006',



            eventClick: function(info) {
                const eventObj = info.event;

                Swal.fire({
                    icon: 'info',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    footer: '<a href>Why do I have this issue?</a>'
                });

                console.log(info.event);
            },

        });
        calendar.setOption('locale', 'es');
        calendar.render();




        $('#show_all').on('click', function () {
            calendar.removeAllEventSources();
            calendar.addEventSource({
                url: '/aplicaciones/CRM/comercial/get_all_events_and_activities',
                type: 'get',
                beforeSend: function(){
                    calendar.render();
                },
                success: function( json ){
                    calendar.render();
                }
            })
        });
    </script>
@endpush

@push('styles')
    <link href="{{ asset('librerias_javascript/fullcalendar/main.css') }}" rel='stylesheet' />
@endpush
