<!DOCTYPE html>
<html lang="es">
    <head>
        <title>@yield('page_title') - {{ config('app.name') }}</title>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="shortcut icon" type="image/png" href="{{ asset('/img/favicon_192x192.png') }}">
        <link rel="shortcut icon" sizes="192x192" href="{{ asset('/img/favicon_192x192.png') }}">
        <link rel="stylesheet" href="{{ asset('architectui/main.css') }}">
        {{--<link rel="stylesheet" href="{{ asset('dashboard/styles/app.css') }}">--}}
        <link rel="stylesheet" href="{{ asset('dashboard/styles/main.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css"/>
        <link href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.css" rel="stylesheet"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="cache-control" content="no-cache">
    </head>
    <body>
        <div class="container-fluid">
            <div class="row justify-content-center" style="margin-top: 60px; margin-bottom: 20px">
                <div class="col-0">
                    <h1>INGRESO DE PERSONAL Y INVITADOS</h1>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <h5><b>Instrucciones:</b></h5>
                            <ul>
                                <li>Acerque la cedula al lector de codigo de barras</li>
                                <li>Si es un empleado el sistema registrara el ingreso</li>
                                <li>Si es un visitante se registrara en la base de datos</li>
                            </ul>
                            <input type="text" class="form-control" placeholder="Cedula" id="cedula" name="cedula" autofocus onclick="select()">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center" style="margin-top: 30px">
                <h2 id="msj"></h2>
            </div>
        </div>
        <script src="{{ asset('dashboard/scripts/app.js') }}"></script>
        <script src="{{ asset('dashboard/scripts/main.js') }}"></script>
        <script src="{{ asset('architectui/assets/scripts/main.js') }}"></script>
        <script>
            $(document).ready(function () {
                $(document).on('keyup','#cedula', function () {
                    var cc = this.value;
                    if( cc.length > 6 && cc.length <= 10 ){
                        consulta_cc(cc);
                    }
                    else if(cc.length > 10){
                        consulta_codigo_barras(cc)
                    }


                    function consulta_cc(cc) {
                        $.ajax({
                            url: '/consultar_empleado_invitado_cc',
                            type: 'get',
                            data: {
                                cc: cc
                            },
                            success: function (data) {
                                console.log(data);
                                $('#msj').html(data);
                            }
                        })
                    }

                    function consulta_codigo_barras(cc) {
                        let cadena = cc.split('')
                        console.log(cadena)
                    }
                });
            });
        </script>
    </body>
</html>
