@extends('layouts.architectui')

@section('page_title', 'Home')

@section('action_recaptcha')
    {!! htmlScriptTagJsApi([ 'action' => 'home' ]) !!}
@endsection

@section('content')
    <div class="row">
        @if (\Illuminate\Support\Facades\Auth::user()->hasRole('super-admin'))
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="main-card mb-3 card">
                    <h5 class="card-header">Home</h5>
                    <div class="card-body">
                        @can('usuarios.online')
                            <div class="table-responsive">
                                <table class="table table-striped" id="table">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Usuario</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->username }}</td>
                                            <td>
                                                @if ($user->isOnline())
                                                    <span class="badge badge-success">Online</span>
                                                @else
                                                    <span class="badge badge-secondary">Offline</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-danger" role="alert">
                                Nada por aqui...
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
        @endif

        @if (\Illuminate\Support\Facades\Auth::user()->hasRole('COMERCIAL') || \Illuminate\Support\Facades\Auth::user()->hasRole('super-admin'))
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-8">
                                <div class="input-group input-group-lg mb-3">
                                    <input type="number" id="factura" name="factura" class="form-control" placeholder="Escriba el numero de factura o nota" aria-label="Escriba el numero de factura o nota" aria-describedby="id" style="border-radius: 0">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="search" style="border-radius: 0"><i class="pe-7s-search"></i> BUSCAR</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row justify-content-center" id="result">
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@stop

@push('javascript')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#table').dataTable({
                language: {
                    url: '/Spanish.json'
                },
                order: [
                    [ 2, "desc" ]
                ]
            });
        });
    </script>


    <script type="text/javascript">
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click', '#search', function () {
                if (document.getElementById('factura').value == ''){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops',
                        text: 'Por favor ingresa el numero de la factura o nota para comenzar la busqueda'
                    });
                }else{
                    document.getElementById("search").disabled = true;
                    $('#result').html('').append(`
                        <div id="loader-wrapper">
                            <div id="loader"></div>
                        </div>
                        <h4>Recuperando informacion, un momento por favor...</h4>
                   `);

                    $.ajax({
                        url: '/aplicaciones/consultas/verificar_documento',
                        type: 'post',
                        data: {
                            id: document.getElementById('factura').value,
                        },
                        success: function (data){
                            if (data.code === 100){
                                $('#result').html('').append(`
                                    <div class="alert alert-danger" role="alert">
                                        <h4 class="alert-heading">No tiene permisos!</h4>
                                        <p>`+ data.data +`</p>
                                    </div>
                               `);
                            }else if (data.code === 101){
                                $('#result').html('').append(`
                                    <div class="alert alert-warning" role="alert">
                                        <h4 class="alert-heading">Documento no disponible!</h4>
                                        <p>`+ data.data +`</p>
                                    </div>
                               `);
                            }else if(data.code === 102){
                                $('#result').html('').append(`
                                    <div class="col-sm-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row justify-content-center">
                                                    <div class="col-sm-4">
                                                        <b>CLIENTE:</b> <span>`+ data.data.nombreAdquiriente +`</span>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <b>NIT/CC:</b> <span>`+ data.data.identificacionAdquiriente +`</span>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <b>DOCUMENTO ELECTRONICO:</b> <span>`+ data.data.numero +`</span>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-center">
                                                    <div class="col-sm-4">
                                                        <b>FECHA GENERACION:</b> <span>`+ data.data.fechageneracion +`</span>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <b>FECHA REGISTRO:</b> <span>`+ data.data.fecharegistro +`</span>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <b>CORREO ENVIO:</b> <span>`+ data.data.correoenvio +`</span>
                                                    </div>
                                                </div>
                                                <br>
                                                <hr>
                                                <div class="row justify-content-center">
                                                    <div class="col-sm-8">
                                                        <div class="btn-group special" role="group">
                                                            <button class="btn btn-outline-light download_ws" id="`+ data.data.numero +`">
                                                                <i class="pe-7s-cloud-download pe-4x icon-gradient bg-premium-dark"></i> <br>
                                                                <b class="icon-gradient bg-premium-dark">DESCARGAR PDF</b>
                                                            </button>
                                                            <button class="btn btn-outline-light send_email" id="`+ data.data.numero +`">
                                                                <i class="pe-7s-paper-plane pe-4x icon-gradient bg-premium-dark"></i> <br>
                                                                <b class="icon-gradient bg-premium-dark">REENVIAR FACTURA</b>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                               `);
                            }
                            document.getElementById("search").disabled = false;
                        },
                        error: function (data) {
                            $('#result').html('').append(`
                                <div class="alert alert-danger" role="alert">
                                    <h4 class="alert-heading">Oops!</h4>
                                    <p>Hubo un error al recuperar los datos, por favor comuniquese con el area de sistemas o intente de nuevo mas tarde</p>
                                </div>
                            `);
                            document.getElementById("search").disabled = false;
                        }
                    });
                }
            });


            $(document).on('click', '.download_ws', function () {
                toastr.success('Descargando documento... Un momento por favor!');

                const id = this.id;
                $.ajax({
                    type: 'post',
                    url: '/aplicaciones/facturacion_electronica/web_service/descargar_documento',
                    data: {
                        id: id,
                    },
                    success: function (data) {
                        var base64str = data;
                        var binary = atob(base64str.replace(/\s/g, ''));
                        var len = binary.length;
                        var buffer = new ArrayBuffer(len);
                        var view = new Uint8Array(buffer);
                        for (var i = 0; i < len; i++) {
                            view[i] = binary.charCodeAt(i);
                        }
                        var blob = new Blob([view], { type: "application/pdf" });
                        var link=document.createElement('a');
                        link.href=window.URL.createObjectURL(blob);
                        link.download="FE_"+id+".pdf";
                        link.click();
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error en la Descarga...',
                            text: 'Hubo un error al descargar el pdf de esta factura...!',
                        });
                    }
                });
            });


            $(document).on('click', '.send_email', function () {
                let id = this.id
                swal.mixin({
                    title: 'Reenviar factura',
                    text: 'Escriba los email a los cuales desea enviar esta factura',
                    icon: 'info',
                    showCancelButton: true,
                    input: 'text',
                    onOpen: () => {
                        $('.correos').select2({
                            createTag: function(term, data) {
                                var value = term.term;
                                if(validateEmail(value)) {
                                    return {
                                        id: value,
                                        text: value
                                    };
                                }
                                return null;
                            },
                            placeholder: "Escribe uno o varios email..",
                            tags: true,
                            tokenSeparators: [',', ' ',';'],
                            width: '100%',
                        });
                    }
                }).queue([
                    {
                        html: '<select class="form-control correos" name="correos" id="correos" multiple="multiple" style="width: 100%"></select>',
                        inputValidator: () => {
                            if (document.getElementById('correos').value == '') {
                                return 'Debes escribir al menos una direccion de correo...';
                            }
                        },

                        preConfirm: function () {
                            return $("#correos").val();
                        },
                        onBeforeOpen: function (dom) {
                            swal.getInput().style.display = 'none';
                        }
                    },
                ]).then((result) => {
                    if (result.value) {
                        Swal.fire({
                            icon: false,
                            title: 'Enviando correo(s), un momento por favor...',
                            html: '<br><video autoplay loop muted playsinline  width="70%"><source src="/img/shake.mp4" type="video/mp4"></video> </div>',
                            showConfirmButton: false,
                            showCancelButton: false,
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        });

                        $.ajax({
                            url: '/aplicaciones/facturacion_electronica/web_service/enviar_documento_electronico',
                            type: 'post',
                            data: {
                                id : id,
                                correos: result.value[0]
                            },
                            success:function () {
                                sweetAlert.close();
                                Swal.fire({
                                    title: 'Factura(s) enviada(s)!',
                                    html: 'Proceso finalizado con exito!.',
                                    icon: 'success',
                                    confirmButtonText: 'Aceptar',
                                });
                            },
                            error: function (data) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: data.responseText,
                                });
                            }
                        })
                    }else{
                        result.dismiss === Swal.DismissReason.cancel
                    }

                });
            });

            function validateEmail(email) {
                var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            }
        });
    </script>
@endpush


@push('styles')
    <style type="text/css">
        #loader-wrapper {
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1000;
        }
        #loader {
            display: block;
            position: relative;
            left: 45%;
            top: 50%;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 3px solid transparent;
            border-top-color: #3498db;

            -webkit-animation: spin 2s linear infinite; /* Chrome, Opera 15+, Safari 5+ */
            animation: spin 2s linear infinite; /* Chrome, Firefox 16+, IE 10+, Opera */
        }

        #loader:before {
            content: "";
            position: absolute;
            top: 5px;
            left: 5px;
            right: 5px;
            bottom: 5px;
            border-radius: 50%;
            border: 3px solid transparent;
            border-top-color: #e74c3c;

            -webkit-animation: spin 3s linear infinite; /* Chrome, Opera 15+, Safari 5+ */
            animation: spin 3s linear infinite; /* Chrome, Firefox 16+, IE 10+, Opera */
        }

        #loader:after {
            content: "";
            position: absolute;
            top: 15px;
            left: 15px;
            right: 15px;
            bottom: 15px;
            border-radius: 50%;
            border: 3px solid transparent;
            border-top-color: #f9c922;

            -webkit-animation: spin 1.5s linear infinite; /* Chrome, Opera 15+, Safari 5+ */
            animation: spin 1.5s linear infinite; /* Chrome, Firefox 16+, IE 10+, Opera */
        }

        @-webkit-keyframes spin {
            0%   {
                -webkit-transform: rotate(0deg);  /* Chrome, Opera 15+, Safari 3.1+ */
                -ms-transform: rotate(0deg);  /* IE 9 */
                transform: rotate(0deg);  /* Firefox 16+, IE 10+, Opera */
            }
            100% {
                -webkit-transform: rotate(360deg);  /* Chrome, Opera 15+, Safari 3.1+ */
                -ms-transform: rotate(360deg);  /* IE 9 */
                transform: rotate(360deg);  /* Firefox 16+, IE 10+, Opera */
            }
        }
        @keyframes spin {
            0%   {
                -webkit-transform: rotate(0deg);  /* Chrome, Opera 15+, Safari 3.1+ */
                -ms-transform: rotate(0deg);  /* IE 9 */
                transform: rotate(0deg);  /* Firefox 16+, IE 10+, Opera */
            }
            100% {
                -webkit-transform: rotate(360deg);  /* Chrome, Opera 15+, Safari 3.1+ */
                -ms-transform: rotate(360deg);  /* IE 9 */
                transform: rotate(360deg);  /* Firefox 16+, IE 10+, Opera */
            }
        }


        .btn-primary {
            margin-bottom: 10px;
            margin-left: 8px;
        }

        .btn-group.special {
            display: flex;
        }

        .special .btn {
            flex: 1;
            border-radius: 0;
        }
    </style>
@endpush
