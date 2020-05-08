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
        <link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet"/>
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="cache-control" content="no-cache">
        <style>
            input[type=radio] {
                border: 0;
                width: 100%;
                height: 2em;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <form id="form" name="form">
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
                <br>
                <div class="row justify-content-center">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <b>TEMPERATURA: </b>
                                <input type="number" class="form-control" max="40" min="20" id="temperatura" name="temperatura" required disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row justify-content-center">
                    <div class="col-6">
                        <div class="card shadow">
                            <div class="card-body">
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
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center" style="margin-top: 30px">
                    <h2 id="msj"></h2>
                </div>


                <div class="row justify-content-center">
                    <div class="col-4">
                        <button type="submit" class="btn btn-success btn-block"> GUARDAR REGISTRO </button>
                    </div>
                </div>
                <br>
            </form>
        </div>

        <script src="{{ asset('dashboard/scripts/app.js') }}"></script>
        <script src="{{ asset('dashboard/scripts/main.js') }}"></script>
        <script src="{{ asset('architectui/assets/scripts/main.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <script>
            $(document).ready(function () {
                $(document).on('blur','#cedula', function () {
                    var cc = this.value;

                    if( cc.length > 6 && cc.length <= 10 ){
                        consulta_cc(cc);
                    }
                    else if(cc.length > 10){
                        consulta_codigo_barras(cc)
                    }

                });

                function consulta_cc(cc) {
                    $.ajax({
                        url: '/consultar_empleado_invitado_cc',
                        type: 'get',
                        data: {
                            cc: cc
                        },
                        success: function (data) {
                            if (data == true){
                                $("#temperatura").removeAttr('disabled');
                                toastr.success('El empleado existe')
                            }else{
                                $("#temperatura").attr('disabled','disabled');
                                toastr.error('El empleado No existe')
                            }
                        }
                    })
                }

                function consulta_codigo_barras(cc) {
                    let cadena = cc;
                    let buscar = cadena.search("PubDSK?");
                    if (buscar === -1){
                        console.log('cadena con espacios')
                    }else {
                        let text =  cadena.split('?');
                        text = text[1];
                        text = text.split('');


                        var cedula = [];
                        var letters = /^[A-Za-z]+$/;

                        for (let i = 0; i <= text.length -1 ; i++) {
                            if (i > 6){
                                if (text[i].match(letters)){
                                    break
                                }else{
                                    cedula.push(text[i]);
                                }
                            }
                        }

                        cedula =  cedula.join('');
                        console.log(cedula)
                    }
                }

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

                $('#form').validate({
                    rules: {
                        cedula: {
                            required: true,
                            min: 6,
                            /*remote: {
                                url: '/GetUniqueCode',
                                type: 'POST',
                                async: true,
                            }*/
                        },
                        temperatura: {
                            required: true,
                            min: 20,
                            max: 40
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
                            data: $('#form').serializeArray(),
                            url: "/",
                            type: "POST",
                            dataType: 'json',
                            success: function (data) {
                                $('#form').trigger("reset");



                                toastr.success("Registro Guardado con Exito!");
                            },
                            error: function (data) {
                                console.log('Error:', data);
                            }
                        });
                    }
                });
            });
        </script>
    </body>
</html>
