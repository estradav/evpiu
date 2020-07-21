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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" />


        {{--Datatables--}}
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css"/>


        {{--Jqueryui--}}
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />


        {{--Animate CSS--}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">


        {{--ChartJs--}}
        <script type="text/css" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.css"></script>
        <script type="text/css" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css"></script>


        {{--Boostrap Switch--}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/css/bootstrap3/bootstrap-switch.css">


        {{--Toastr Alerts--}}
        <script type="text/css" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css"></script>
        <script type="text/css" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css"></script>


        {{--DateRange Picker--}}
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


        {{--Pe7 Stroke icons--}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">

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
        </style>

        @stack('styles')
    </head>
    <body>
        <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
            <div class="app-header header-shadow">
                <div class="app-header__logo">
                    <img src="{{ asset('architectui/assets/images/logo_ev.png')}}" class="logo-src">
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
                                            <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
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
                                            {{ Auth::user()->name  }}
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
        <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>


        {{--Jquery ui--}}
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>


        {{--Sweet Alert--}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.3.10/dist/sweetalert2.all.min.js"></script>


        {{--Datatables--}}
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>


        {{--Select2--}}
        <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>


        {{--PopperJs--}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>


        {{--Jquery Validate--}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>


        {{--Boostrap--}}
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>


        {{--Pdf Object--}}
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.1.1/pdfobject.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.1.1/pdfobject.min.js"></script>


        {{--ChartJs--}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>


        {{--JsPdf--}}
        <script src="https://unpkg.com/jspdf@latest/dist/jspdf.min.js"></script>
        <script src="https://unpkg.com/jspdf-autotable@3.2.11/dist/jspdf.plugin.autotable.js" ></script>


        {{--Boostrap Switch--}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.js"></script>


        {{--Firebase --}}
        <!-- The core Firebase JS SDK is always required and must be listed first -->
        <script src="https://www.gstatic.com/firebasejs/7.14.3/firebase-app.js"></script>
        <script src="https://www.gstatic.com/firebasejs/7.14.3/firebase-analytics.js"></script>
        <script src="https://www.gstatic.com/firebasejs/7.14.3/firebase-database.js"></script>


        {{--Toastr Alerts--}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

        {{--DateRange Picker--}}
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment-with-locales.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


        <script type="text/javascript">
            var session_id  = "{!! (Session::getId())?Session::getId():'' !!}";
            var username    = "{!! (Auth::user())?Auth::user()->username:'' !!}";
            var user_id     = "{!! (Auth::user())?Auth::user()->id:'' !!}";
            var name        = "{!! (Auth::user())?Auth::user()->name:'' !!}";

            // Initialize Firebase
            var firebaseConfig = {
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

            var database = firebase.database();


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
        </script>

        <script>
            @if(Session::has('alerts'))
                let alerts = {!! json_encode(Session::get('alerts')) !!};
                helpers.displayAlerts(alerts, toastr);
            @endif

            @if(Session::has('message'))
                // TODO: change Controllers to use AlertsMessages trait... then remove this
                var alertType = {!! json_encode(Session::get('alert-type', 'info')) !!};
                var alertMessage = {!! json_encode(Session::get('message')) !!};
                var alerter = toastr[alertType];

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

