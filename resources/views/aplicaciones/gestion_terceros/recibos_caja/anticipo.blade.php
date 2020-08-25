@extends('layouts.architectui')

@section('page_title','Anticipos RC')

@section('action_recaptcha')
    {!! htmlScriptTagJsApi([ 'action' => 'recibos_caja_anticipos' ]) !!}
@stop

@section('content')
    @can('recibos_caja.nuevo')
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-credit icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>Anticipos
                        <div class="page-title-subheading">
                            Registro de anticipos RC !
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <div class="container mt-2 mb-5">
                            <div class="row justify-content-center">
                                <h5><b>CLIENTE SELECCIONADO:</b> <span id="cliente_seleccionado"></span></h5>
                            </div>
                        </div>
                        <form id="form">
                            <input type="hidden" id="nit" name="nit">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="cliente">ClIENTE</label>
                                </div>
                                <input type="text" class="form-control" id="cliente" name="cliente" placeholder="Escriba al menos 2 caracteres para comenzar la busqueda" onClick="this.select();">
                                <div class="input-group-append">
                                     <button class="btn btn-primary" id="seleccionar_cliente" disabled type="button">SELECCIONAR CLIENTE</button>
                                </div>
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label for="fecha" class="input-group-text">FECHA</label>
                                </div>
                                    <input type="date" class="form-control" id="fecha" name="fecha">
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label for="banco" class="input-group-text">BANCO</label>
                                </div>
                                <select name="banco" id="banco" class="form-control">
                                    <option value="" selected="">Seleccione...</option>
                                    <option value="11200505">BANCOLOMBIA - xxxxxxx1953</option>
                                    <option value="11200510">BANCOLOMBIA - xxxxxxx9471</option>
                                    <option value="11200515">BANCOLOMBIA - xxxxxxx3587</option>
                                    <option value="11100505">BANCOLOMBIA - xxxxxxx1701</option>
                                    <option value="11100506">BANCOLOMBIA - xxxxxxx2074</option>
                                    <option value="11100506">BANCO OCCIDENTE - xxxxxxx3489</option>
                                </select>
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label for="valor" class="input-group-text">VALOR</label>
                                </div>
                                <input type="number" class="form-control" id="valor" name="valor" value="0">
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label for="detalles" class="input-group-text">DETALLES</label>
                                </div>
                                <textarea name="detalles" id="detalles" cols="30" rows="3" class="form-control"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block btn-lg" id="registrar_anticipo" disabled>REGISTRAR ANTICIPO</button>
                        </form>
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
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let cliente = '';

            $('#cliente').autocomplete({
                source: function (request, response) {
                    const query = document.getElementById('cliente').value;
                    $.ajax({
                        url: "/aplicaciones/recibos_caja/buscar_cliente",
                        method: "get",
                        data: {
                            query: query,
                        },
                        dataType: "json",
                        success: function (data) {
                            const resp = $.map(data, function (obj) {
                                return obj
                            });
                            response(resp);
                        }
                    })
                },

                select: function (event, ui) {
                    $('#seleccionar_cliente').prop("disabled", false);
                    $('#registrar_anticipo').prop("disabled", true);
                    document.getElementById('nit').value = ui.item.nit;
                    cliente = ui.item.value
                },
                minlength: 2
            });


            $(document).on('click', '#seleccionar_cliente', function () {
                document.getElementById('cliente_seleccionado').innerText = cliente
                $('#seleccionar_cliente').prop("disabled", true);
                $('#registrar_anticipo').prop("disabled", false);
            });


            $('#form').validate({
                rules: {
                    cliente: {
                        required: true
                    },
                    fecha: {
                        required: true
                    },
                    banco: {
                        select_check: true
                    },
                    valor: {
                        required: true,
                        min: 1000,
                    },
                },
                errorPlacement: function(error, element) {
                    return true;
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
                        url: "/aplicaciones/recibos_caja/anticipo/guardar_anticipo",
                        type: "POST",
                        dataType: 'json',
                        success: function (data) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Completado',
                                text: data
                            });
                            setTimeout(function() {
                                window.location.href = '/aplicaciones/recibos_caja'
                            }, 3000);
                        },
                        error: function (data) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops',
                                text: data.responseText
                            });
                        }
                    });
                    return false;
                }
            });


            jQuery.validator.addMethod("select_check", function(value){
                return (value != '');
            }, "Por favor, seleciona una opcion.");
        });
    </script>
@endpush
