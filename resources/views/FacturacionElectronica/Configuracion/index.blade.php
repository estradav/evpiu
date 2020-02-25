@extends('layouts.dashboard')

@section('page_title', 'Facturacion electronica')

@section('module_title', 'Configuracion')

@section('subtitle', 'Este módulo permite cambiar la configuracion de la aplicacion de facturacion electronica.')


@section('content')
    @can('fe.config')
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">Configuracion de Facturas</h5>
                    <div class="card-body">
                        <div class="row" >
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label for="name" class="control-label">ID Numeracion:</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="number" class="form-control" name="fac_idnumeracion" id="fac_idnumeracion" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label for="name" class="control-label">Tipo de Ambiente:</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <select name="fac_idambiente" id="fac_idambiente" class="form-control">
                                            <option value="" selected>Seleccione...</option>
                                            <option value="1">Producciòn</option>
                                            <option value="2">Pruebas</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label for="name" class="control-label">ID Reporte:</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="number" class="form-control" name="fac_idreporte" id="fac_idreporte" placeholder="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-success" id="SaveFacturas">Guardar Cambios</button>
                    </div>
                </div>


                <div class="card">
                    <h5 class="card-header">Configuracion de Notas Credito</h5>
                    <div class="card-body">
                        <div class="row" >
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label for="name" class="control-label">ID Numeracion:</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="number" class="form-control" name="nc_idnumeracion" id="nc_idnumeracion" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label for="name" class="control-label">Tipo de Ambiente:</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <select name="nc_idambiente" id="nc_idambiente" class="form-control">
                                            <option value="" selected>Seleccione...</option>
                                            <option value="1">Producciòn</option>
                                            <option value="2">Pruebas</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label for="name" class="control-label">ID Reporte:</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="number" class="form-control" name="nc_idreporte" id="nc_idreporte" placeholder="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-success" id="SaveNC">Guardar Cambios</button>
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
    @push('javascript')
        <script>
           $(document).ready(function() {
           	    getData();
                function getData() {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: "/fe_configs",
                        type: "GET",
                        dataType: 'json',
                        success: function (data) {
                        	var fac_idnumeracion = data[0]['fac_idnumeracion'];
                        	var fac_idambiente = data[0]['fac_idambiente'];
                        	var fac_idreporte = data[0]['fac_idreporte'];
                            var nc_idnumeracion = data[0]['nc_idnumeracion'];
                            var nc_idambiente = data[0]['nc_idambiente'];
                            var nc_idreporte = data[0]['nc_idreporte'];
                            $('#fac_idnumeracion').val(fac_idnumeracion);
                            $('#fac_idambiente').val(fac_idambiente);
                            $('#fac_idreporte').val(fac_idreporte);
                            $('#nc_idnumeracion').val(nc_idnumeracion);
                            $('#nc_idambiente').val(nc_idambiente);
                            $('#nc_idreporte').val(nc_idreporte);
                        }
                    })
                }
                $('#SaveFacturas').on('click', function () {
                    var fac_idnumeracion = $('#fac_idnumeracion').val();
                    var fac_idambiente = $('#fac_idambiente').val();
                    var fac_idreporte = $('#fac_idreporte').val();

                    $.ajax({
                        url: "/savefeConfigs",
                        type: "POST",
                        data:{
                            fac_idnumeracion: fac_idnumeracion,
                            fac_idambiente: fac_idambiente,
                            fac_idreporte: fac_idreporte
                        },
                        success: function () {
                            Swal.fire({
                                icon: 'success',
                                title: 'Informacion actualizada',
                                text: 'Se a guardado con exito la configuracion para las facturas...',
                            });
                        }
                    })
                });
                $('#SaveNC').on('click', function () {
                     var nc_idnumeracion = $('#nc_idnumeracion').val();
                     var nc_idambiente = $('#nc_idambiente').val();
                     var nc_idreporte = $('#nc_idreporte').val();

                     $.ajax({
                         url: "/savefeConfigsNc",
                         type: "POST",
                         data:{
                             nc_idnumeracion: nc_idnumeracion,
                             nc_idambiente: nc_idambiente,
                             nc_idreporte: nc_idreporte
                         },
                         success: function () {
                             Swal.fire({
                                 icon: 'success',
                                 title: 'Informacion actualizada',
                                 text: 'Se a guardado con exito la configuracion para las facturas...',
                             });
                         }
                     })
                })
           });

        </script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.3.10/dist/sweetalert2.all.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">

    @endpush
@stop
