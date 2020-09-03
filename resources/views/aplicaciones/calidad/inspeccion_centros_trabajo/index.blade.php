@extends('layouts.architectui')

@section('page_title', 'Control de calidad')

@section('action_recaptcha')
    {!! htmlScriptTagJsApi([ 'action' => 'aplicaciones_calidad_revision' ]) !!}
@endsection

@section('content')
    @can('aplicaciones.calidad.revision')
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-check icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>Calidad
                        <div class="page-title-subheading">
                            Control de calidad
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="input-group">
                                    <input type="number" class="form-control" aria-label="search" aria-describedby="search" id="search" name="search" placeholder="Ingrese el numero de la orden sin los ultimos 4 ceros">
                                    <h5 class="text-center"></h5>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary btn-block" type="button" id="search_button">CONSULTAR OP</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="main-card card">
                    <div class="card-body" id="result_search">
                        <div class="alert alert-info text-center" role="alert">
                            <h4 class="alert-heading text-center">
                                <i class="fas fa-info-circle fa-3x"></i> <br>
                                <b>Por favor, realice una busqueda para ver la informacion..!</b>
                            </h4>
                        </div>
                    </div>

                    <br>


                    <div class="card-body">
                        <div class="row justify-content-center mb-2">
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3">
                                <h5 class="text-center"><b> ORDER DE PRODUCCION</b></h5>
                                <h6 class="text-center"><b>501768640000</b></h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3">
                                <h6><b>PIEZA:</b> 30708L070120800</h6>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3">
                                <h6><b>DESCRIPCION:</b> TB GRIPPER L 20 M.AR N/P</h6>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3">
                                <h6><b>ORDEN VENTA:</b>201396840101</h6>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3">
                                <h6><b>ARTE:</b>C1544</h6>
                            </div>

                        </div>
                    </div>


                </div>
            </div>
        </div>
    @else
        <div class="main-card mb-3 card">
            <div class="card-body text-center">
                <i class="fas fa-exclamation-triangle fa-4x" style="color: red"></i>
                <h3 class="card-title" style="color: red"> ACCESO DENEGADO </h3>
                <h3 class="card-text" style="color: red">No tiene permiso para usar esta aplicación, por favor comuníquese a la ext: 102 o escribanos al correo electrónico: auxsistemas@estradavelasquez.com para obtener acceso.</h3>
            </div>
        </div>
    @endcan
@endsection

@push('javascript')
    <script type="text/javascript">
        $(document).ready(function (){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click', '#search_button', function () {
                let production_order = document.getElementById('search').value;

                if (production_order !== ''){
                    $('#result_search').html('').append(`
                        <div id="loader-wrapper">
                            <div id="loader"></div>
                        </div>
                        <h4 class="text-center">Recuperando informacion, un momento por favor...</h4>
                    `);


                    $.ajax({
                        url: '/aplicaciones/calidad/revision/consultar_op',
                        type: 'get',
                        data: {
                            production_order: production_order
                        },
                        success: function (data) {
                            if (data.registros.length === 0){
                                $('#result_search').html('').append(`
                                    <div class="alert alert-warning text-center" role="alert">
                                        <h4 class="alert-heading text-center">
                                            <i class="fas fa-exclamation-triangle fa-4x"></i><br>
                                            <b>¡No se encontro infomacion!</b>
                                        </h4>
                                        <h5>Por favor verifique que el numero de la orden de produccion sea correcto!</h5>
                                    </div>
                                `);
                            }else{
                                $('#result_search').html('').append(`
                                    <div class="row justify-content-center">
                                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-8">
                                            <button class="btn btn-block btn-lg btn-primary b-radius-0 add_review" id="`+ production_order +`">
                                                <i class="pe-7s-plus pe-4x"></i> <br>
                                                AGREGAR REVISION
                                            </button>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-sm">
                                            <thead>
                                                <tr>
                                                    <th scope="col">CANT INSPECCIONADA</th>
                                                    <th scope="col">CANT CONFORME</th>
                                                    <th scope="col">CANT NO CONFORME</th>
                                                    <th scope="col">OPERARIO</th>
                                                    <th scope="col">INSPECTOR</th>
                                                    <th scope="col">CENTRO DE TRABAJO</th>
                                                    <th scope="col">ACCIONES</th>
                                                </tr>
                                            </thead>
                                            <tbody id="inspections_table_body">
                                            </tbody>
                                        </table>
                                    </div>
                                `);

                                for (let i = 0; i < data.registros.length; i++) {
                                    $('#inspections_table_body').append(`
                                        <tr>
                                            <td>`+ data.registros[i].quantity_inspected +`</td>
                                            <td>`+ data.registros[i].conforming_quantity +`</td>
                                            <td>`+ data.registros[i].non_conforming_quantity +`</td>
                                            <td>`+ data.registros[i].operator.name +`</td>
                                            <td>`+ data.registros[i].inspector.name +`</td>
                                            <td>`+ data.registros[i].center +`</td>
                                            <td>
                                                <button type="button" class="btn btn-secondary info_review" id="`+ data.registros[i].id +`">Mas info</button>
                                            </td>
                                        </tr>
                                    `);
                                }
                            }
                        },
                        error: function(jqXHR, textStatus, err){
                            console.log('text status '+textStatus+', err '+err);
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: err,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Aceptar',
                            })
                        }
                    });
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: '¡Debes escribir el numero de la orden de produccion..!',
                    });
                }
            });


            $(document).on('click', '.add_review', function (){
                let production_order = this.id;

                document.getElementById('new_review_modal_title').innerText = 'OP #'+ production_order;
                document.getElementById('production_order').value = production_order+'0000'

                $('#new_review_modal').modal('show');

            });


            $('#new_review_modal_form').validate({
                ignore: "",
                rules: {
                    quantity_inspected: {
                        required: true,
                        digits: true,
                        min: 1,
                    },
                    conforming_quantity: {
                        required: true,
                        digits: true,
                        min: 1,
                    },
                    non_conforming_quantity: {
                        required: true,
                        digits: true,
                        min: 1,
                    },
                    cause: {
                        select_check: true
                    },
                    operator_id: {
                        select_check: true
                    },
                    non_compliant_treatment: {
                        required: true
                    },
                    action: {
                        required: true
                    },
                    observation: {
                        required: true
                    },
                    center: {
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
                        url: '/aplicaciones/calidad/revision/guardar',
                        type: 'post',
                        data: $('#new_review_modal_form').serialize(),
                        dataType: 'json',
                        success:function (data){
                            $('#new_review_modal_form').trigger('reset');
                            $('#new_review_modal').modal('hide');

                            Swal.fire({
                                icon: 'success',
                                title: 'Completado!',
                                text: data
                            });
                            $('#search_button').click();
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
                remote: "Este codigo ya existe.",
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

@section('modal')
    <div class="modal fade" id="new_review_modal" tabindex="-1" aria-labelledby="new_review_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="new_review_modal_title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="new_review_modal_form">
                    <div class="modal-body">
                        <input type="hidden" id="production_order" name="production_order">
                        <input type="hidden" id="inspector_id" name="inspector_id" value="{{ auth()->user()->id }}">
                        <div class="form-group">
                            <label for="quantity_inspected">Cantidad inspeccionada</label>
                            <input type="number" class="form-control" id="quantity_inspected" name="quantity_inspected">
                        </div>
                        <div class="form-group">
                            <label for="conforming_quantity">Cantidad conforme</label>
                            <input type="number" class="form-control" id="conforming_quantity" name="conforming_quantity">
                        </div>
                        <div class="form-group">
                            <label for="non_conforming_quantity">Cantidad no conforme</label>
                            <input type="number" class="form-control" id="non_conforming_quantity" name="non_conforming_quantity">
                        </div>
                        <div class="form-group">
                            <label for="cause">Causa</label>
                            <select class="form-control" name="cause" id="cause">
                                <option value="" selected>Seleccione...</option>
                                <option value="CASCARA">CASCARA</option>
                                <option value="CONTAMINACION DE LOTE">CONTAMINACION DE LOTE</option>
                                <option value="EMBOMBADAS">EMBOMBADAS</option>
                                <option value="FUERA DE MEDIDA">FUERA DE MEDIDA</option>
                                <option value="HUNDIDOS">HUNDIDOS</option>
                                <option value="LASER BORRADO">LASER BORRADO</option>
                                <option value="MAL ENSAMBLE">MAL ENSAMBLE</option>
                                <option value="MANCHADAS">MANCHADAS</option>
                                <option value="MUY PULIDO">MUY PULIDO</option>
                                <option value="OPACAS">OPACAS</option>
                                <option value="PEGADOS">PEGADOS</option>
                                <option value="PICADAS">PICADAS</option>
                                <option value="PIEL POROSA">PIEL POROSA</option>
                                <option value="POROSIDAD MATERIAL">POROSIDAD MATERIAL</option>
                                <option value="QUEMADAS">QUEMADAS</option>
                                <option value="REBABA">REBABA</option>
                                <option value="REVIENTA TERMINADO">REVIENTA TERMINADO</option>
                                <option value="TALLON">TALLON</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="operator_id">Operario</label>
                            <select class="form-control" name="operator_id" id="operator_id">
                                <option value="" selected>Seleccione...</option>
                                @foreach ($operators as $operator)
                                    <option value="{{ $operator->id }}">{{ $operator->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="non_compliant_treatment">Tratamiento a la no conformidad</label>
                            <textarea class="form-control" name="non_compliant_treatment" id="non_compliant_treatment" cols="30" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="action">Accion tomada</label>
                            <textarea class="form-control" name="action" id="action" cols="30" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="observation">Observaciones</label>
                            <textarea class="form-control" name="observation" id="observation" cols="30" rows="2"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="center">Centro</label>
                            <select class="form-control" name="center" id="center">
                                <option value="" selected>Seleccione...</option>
                                <option value="GALVANO">GALVANO</option>
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

@push('styles')
    <style>
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
    </style>
@endpush
