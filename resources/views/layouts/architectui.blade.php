<!DOCTYPE html>
<html lang="es">
    <head>
        <title>@yield('page_title') - {{ config('app.name') }}</title>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="cache-control" content="no-cache">
        <link rel="shortcut icon" type="image/png" href="{{ asset('/img/favicon_192x192.png') }}">
        <link rel="shortcut icon" sizes="192x192" href="{{ asset('/img/favicon_192x192.png') }}">
        <link rel="stylesheet" href="{{ asset('architectui/main.css') }}">


        {{--Select2--}}
        <link rel="stylesheet" href="{{ asset('librerias_javascript/select2/select2.min.css ') }}" />


        {{--Datatables--}}
        <link rel="stylesheet" type="text/css" href="{{ asset('librerias_javascript/DataTables/datatables.min.css') }}"/>


        {{--Jqueryui--}}
        <link rel="stylesheet" href="{{ asset('librerias_javascript/jquery-ui-1.12.1/jquery-ui.min.css') }}" />


        {{--Animate CSS--}}
        <link rel="stylesheet" href="{{ asset('librerias_javascript/animate-css/animate.min.css') }}">


        {{--ChartJs--}}
       {{-- <script type="text/css" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.css"></script>
        <script type="text/css" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css"></script>--}}


        {{--Toastr Alerts--}}
        <script type="text/css" src="{{ asset('librerias_javascript/toastr/toastr.min.css') }}"></script>


        {{--DateRange Picker--}}
        <link rel="stylesheet" type="text/css" href="{{ asset('librerias_javascript/daterangepicker/daterangepicker.css') }}" />


        {{--Pe7 Stroke icons--}}
        <link rel="stylesheet" href="{{ asset('librerias_javascript/pe7icons/pe-icon-7-stroke/css/pe-icon-7-stroke.css') }}">


        @yield('action_recaptcha')

        <style>
            .scrollbar-sidebar{
                overflow: hidden;
            }

            .app-sidebar__inner {
                overflow: auto;

                /* Make sure the inner div is not larger than the container
                 * so that we have room to scroll.
                 */
                max-height: 100% !important;

                /* Pick an arbitrary margin/padding that should be bigger
                 * than the max width of all the scroll bars across
                 * the devices you are targeting.
                 * padding = -margin
                 */
                margin-right: -100px !important;
                padding-right: 100px !important;
            }
            .grecaptcha-badge {
                bottom:65px !important;
                z-index:999;
            }
        </style>
        @stack('styles')
    </head>
    <body>
        <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
            <div class="app-header header-shadow">
                <div class="app-header__logo">
                    <img src="{{ asset('architectui/assets/images/logo_ev.png') }}" class="logo-src">
                    <div class="header__pane ml-auto">
                        <div>
                            <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="app-header__mobile-menu">
                    <div>
                        <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="app-header__menu">
                    <span>
                        <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                            <span class="btn-icon-wrapper">
                                <i class="fa fa-ellipsis-v fa-w-6"></i>
                            </span>
                        </button>
                    </span>
                </div>


                <div class="app-header__content">
                    <div class="app-header-left">
                        <div class="search-wrapper">
                            <div class="input-holder">
                                <input type="text" class="search-input" placeholder="Buscar...">
                                <button class="search-icon"><span></span></button>
                            </div>
                            <button class="close"></button>
                        </div>
                    </div>
                    <div class="app-header-right">
                        <div class="header-btn-lg pr-0">
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="btn-group">
                                            <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn drop_user">
                                                <img width="42" class="rounded-circle" src="{{asset('img/favicon_192x192.png')}}" alt="">
                                                <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                            </a>
                                            <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                                <button type="button" tabindex="0" class="dropdown-item">Cuenta</button>
                                                <button type="button" tabindex="0" class="dropdown-item">Configuracion</button>
                                                <div tabindex="-1" class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();"><i class="fas fa-power-off mr-2"></i>{{ __('Cerrar sesión') }}</a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                    @csrf
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-content-left  ml-3 header-user-info">
                                        <div class="widget-heading">
                                           {{ auth()->user()->name  }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="app-main">
                <div class="app-sidebar sidebar-shadow">
                    <div class="app-header__logo">
                        <div class="logo-src"></div>
                        <div class="header__pane ml-auto">
                            <div>
                                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                                    <span class="hamburger-box">
                                        <span class="hamburger-inner"></span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="app-header__mobile-menu">
                        <div>
                            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="app-header__menu">
                        <span>
                            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                                <span class="btn-icon-wrapper">
                                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                                </span>
                            </button>
                        </span>
                    </div>
                    @include('layouts.sidebar')
                </div>
                <div class="app-main__outer">
                    <div class="app-main__inner">
                        <div class="tab-content">
                            @yield('content')
                        </div>
                    </div>
                    <br>
                    <div class="app-wrapper-footer">
                        <div class="app-footer">
                            <div class="app-footer__inner">
                                <div class="app-footer-right">
                                    Copyright © <script>var d = new Date(); document.write(d.getFullYear());</script> <a href="https://estradavelasquez.com/">&nbsp; Estrada Velasquez</a>. Todos los derechos reservados.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @yield('modal')
        </div>

        <script src="{{ asset('architectui/assets/scripts/main.js') }}"></script>

        {{--Jquery--}}
        <script src="{{ asset('librerias_javascript/jQuery-3.3.1/jquery-3.3.1.min.js') }}"></script>


        {{--Jquery ui--}}
        <script src="{{ asset('librerias_javascript/jquery-ui-1.12.1/jquery-ui.min.js') }}"></script>


        {{--Sweet Alert--}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>


        {{--Datatables--}}
       {{--// <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>--}}
        <script type="text/javascript" src="{{ asset('librerias_javascript/DataTables/datatables.min.js') }}"></script>


        {{--Select2--}}
        <script src="{{ asset('librerias_javascript/select2/select2.min.js ') }}"></script>


        {{--PopperJs--}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>


        {{--Jquery Validate--}}
        <script src="{{ asset('librerias_javascript/jquery-validation-1.19.2/dist/jquery.validate.min.js') }}"></script>


        {{--Boostrap--}}
        <script src="{{ asset('librerias_javascript/bootstrap-4.5.2/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('librerias_javascript/bootstrap-4.5.2/js/bootstrap.bundle.js') }}"></script>


        {{--Pdf Object--}}

        <script type="text/javascript" src="{{ asset('librerias_javascript/pdf-object/pdfobject.min.js') }}"></script>


        {{--ChartJs--}}
        {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>--}}


        {{--JsPdf--}}
        <script src="{{ asset('librerias_javascript/js-pdf/jspdf.umd.min.js') }}"></script>
        <script src="{{ asset('librerias_javascript/js-pdf/jspdf.plugin.autotable.js') }}"></script>



        {{--Firebase --}}
        <!-- The core Firebase JS SDK is always required and must be listed first -->
        <script src="https://www.gstatic.com/firebasejs/7.14.3/firebase-app.js"></script>
        <script src="https://www.gstatic.com/firebasejs/7.14.3/firebase-analytics.js"></script>
        <script src="https://www.gstatic.com/firebasejs/7.14.3/firebase-database.js"></script>


        {{--Toastr Alerts--}}
        <script src="{{ asset('librerias_javascript/toastr/toastr.min.js') }}"></script>


        {{--DateRange Picker--}}
        <script type="text/javascript" src="{{ asset('librerias_javascript/daterangepicker/moment-with-locales.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('librerias_javascript/daterangepicker/daterangepicker.js') }}"></script>


        <script type="text/javascript">
            var session_id  = "{!! (Session::getId())?Session::getId():'' !!}";
            var username    = "{!! (auth()->user()) ? auth()->user()->username:'' !!}";
            var user_id     = "{!! (auth()->user()) ? auth()->user()->id:'' !!}";
            var name        = "{!! (auth()->user()) ? auth()->user()->name:'' !!}";

            // Initialize Firebase
            const firebaseConfig = {
                apiKey: "AIzaSyCCrUM3pajbhlaAB1IrmCnUgefE5rOZoZM",
                authDomain: "evpiu-test.firebaseapp.com",
                databaseURL: "https://evpiu-test.firebaseio.com",
                projectId: "evpiu-test",
                storageBucket: "evpiu-test.appspot.com",
                messagingSenderId: "881208017465",
                appId: "1:881208017465:web:9809ad0390e83179c683e8",
                measurementId: "G-7B7ERZP1XC"

            };
            firebase.initializeApp(firebaseConfig);
            firebase.analytics();

            const database = firebase.database();


            if({!! Auth::user() !!}) {
                firebase.database().ref('/users/' + username + '/id').set(user_id);
                firebase.database().ref('/users/' + username + '/session_id').set(session_id);
                firebase.database().ref('/users/' + username + '/name').set(name);
            }


            firebase.database().ref('/users/' + username).on('value', function(snapshot2) {
                var v = snapshot2.val();
                if(v.session_id != session_id) {
                    toastr.warning('se ha iniciado sesión en tu cuenta desde otro dispositivo', 'ALERTA DE SEGURIDAD', {timeOut: 6000});
                    setTimeout(function() {
                        window.location = '/login';
                    }, 4000);
                }
            });

            $(document).ready(function () {
                $('.drop_user').dropdown()
            })
        </script>

        <script>
            @if( session()->has('alerts'))
                let alerts = {!! json_encode(Session::get('alerts')) !!};
                helpers.displayAlerts(alerts, toastr);
            @endif

            @if( session()->has('message') )
                // TODO: change Controllers to use AlertsMessages trait... then remove this
                let alertType = {!! json_encode(Session::get('alert-type', 'info')) !!};
                let alertMessage = {!! json_encode(Session::get('message')) !!};
                let alerter = toastr[alertType];

                if (alerter) {
                    alerter(alertMessage);
                } else {
                    toastr.error("toastr alert-type " + alertType + " is unknown");
                }
            @endif
        </script>
        @stack('javascript')
    </body>

</html>

