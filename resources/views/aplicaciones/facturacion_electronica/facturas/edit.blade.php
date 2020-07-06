@extends('layouts.architectui')

@section('page_title', 'Factura #'. $numero_factura )

@section('content')
    @can('facturacion.edit')
        <div class="col-12"><h3> Factura #: {{ $numero_factura }} </h3></div>
        <input type="hidden" name="num_fac" id="num_fac" value="{{ $numero_factura }}">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                <div class="main-card mb-3 card">
                    <h5 class="card-header">Informacion Cliente</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                <div class="form-group">
                                    <label>Razon social:</label>
                                    <input type="text" class="form-control" id="razon_social" name="razon_social" readonly="readonly" value="{{ $encabezado->nombres }}">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                <div class="form-group">
                                    <label>Direccion:</label>
                                    <input type="text" class="form-control" id="direccion" name="direccion" readonly="readonly" value="{{ $encabezado->direccion }}">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                <div class="form-group">
                                    <label>Tipo de Cliente:</label>
                                    <input type="text" class="form-control" id="tipo_cliente" name="tipo_cliente" readonly="readonly" value="{{ $encabezado->tipo_cliente }}">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                <div class="form-group">
                                    <label>Telefono:</label>
                                    <input type="text" class="form-control" id="telefono" name="telefono" readonly="readonly" value="{{ $encabezado->telefono }}">
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label>Ciudad, Estado, Pais:</label>
                                    <input type="text" class="form-control" id="ciudad_est_pais" name="ciudad_est_pais" readonly="readonly" value="{{ $encabezado->ciudad.'-'.$encabezado->dpto.'-'.$encabezado->pais }}">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                <div class="form-group">
                                    <label>Contacto:</label>
                                    <input type="text" class="form-control" id="contacto" name="contacto" readonly="readonly" value="{{ $encabezado->nombres }}">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                <div class="form-group">
                                    <label for="motivo">Motivo:</label>
                                    <select  class="form-control" id="motivo" name="motivo">
                                        @foreach($motivos as $motivo)
                                            <option value="{{ $motivo->CODE_36 }}" {{ $motivo->CODE_36 == $encabezado->motivo ? 'selected' : '' }}>{{ $motivo->DESC_36 }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3">
                                <div class="form-group">
                                    <label>% Descuento:</label>
                                    <input type="number" id="descuento" name="descuento" class="form-control" max="100" min="0" value="{{ ($encabezado->descuento * 100) / $encabezado->bruto }}">
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3">
                                <div class="form-group">
                                    <label>IVA:</label>
                                    <select name="tieneiva" id="tieneiva" class="form-control">
                                        <option value="1" {{ $encabezado->iva > 0 ? 'selected' : '' }}>Si</option>
                                        <option value="2" {{ $encabezado->iva == 0 ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                <div class="form-group">
                                    <label>Orden Compra:</label>
                                    <input type="text" id="oc" name="oc" class="form-control" value="{{ $encabezado->OC }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                <div class="main-card mb-3 card">
                    <h5 class="card-header">Informacion de facturacion</h5>
                    <div class="card-body">
                        <form role="form">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label>Cedula o Nit:</label>
                                        <input type="text" class="form-control" id="documento" name="documento" readonly="readonly" value="{{ $encabezado->nit_cliente}}">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label>Fecha Factura:</label>
                                        <input type="text" class="form-control" id="fecha_factura" name="fecha_factura" readonly="readonly" value="{{ $encabezado->fechadocumento}}">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label for="condicion_pago">Condiciones de pago:</label>
                                        <select id="condicion_pago" name="condicion_pago" class="form-control" >
                                            @foreach ( $condicion_pago as $condicion )
                                                <option value="{{ $condicion->CODE_36 }}" {{ $condicion->DESC_36 == $encabezado->plazo ? 'selected' : '' }}>{{ trim($condicion->DESC_36) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label>Fecha Vencimiento:</label>
                                        <input type="text" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento" readonly="readonly" value="{{ $encabezado->fechavencimiento }}">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label>Codigo Cliente:</label>
                                        <input type="text" class="form-control" id="codigo_cliente" name="codigo_cliente" readonly="readonly" value="{{ $encabezado->codigocliente }}">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label>Orden de venta:</label>
                                        <input type="text" class="form-control" id="remision" name="remision" readonly="readonly" value="{{ $encabezado->ov }}">
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>Notas Factura:</label>
                                        <textarea cols="30" rows="5" class="form-control" id="notas_factura" name="notas_factura">{{ $encabezado->notas }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="main-card mb-3 card">
            <h5 class="card-header">Productos</h5>
            <div class="card-body">
                <form role="form">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered tabla_productos">
                            <thead>
                            <tr>
                                <th>ORDEN</th>
                                <th>CODIGO</th>
                                <th>DESCRIPCION</th>
                                <th>U/M</th>
                                <th>CANTIDAD</th>
                                <th>PRECIO UNITARIO</th>
                                <th>TOTAL ITEM</th>
                                <th>IVA</th>
                            </tr>
                            </thead>
                            <tbody id="items_factura">
                                @php
                                    $id = 1
                                @endphp
                                @foreach($detalles as $detalle)
                                    <tr>
                                        <td>{{ $detalle->OV }}</td>
                                        <td>{{ $detalle->CodigoProducto }}</td>
                                        <td>{{ $detalle->descripcionproducto }}</td>
                                        <td>{{ $detalle->UM == 94 ? 'UND' : '' }}</td>
                                        <td><input type="number" class="form-control cantidad_{{ $id }} cantidad" value="{{ trim($detalle->cantidad) }}" id="{{ $id }}" disabled></td>
                                        <td><input type="number" class="form-control precio_{{ $id }} precio" value="{{ trim($detalle->precio) }}" id="{{ $id }}"></td>
                                        <td><input type="number" class="form-control total_{{ $id }} total" name="total" value="{{ $detalle->totalitem }}" disabled></td>
                                        <td><input type="number" class="form-control iva_{{ $id }} iva" name="iva" value="{{ trim($detalle->iva_item) }}" disabled></td>
                                        <td style="display: none !important;"><input type="text" name="id_reg" id="id_reg" value="{{ $detalle->factura.'-'.$detalle->OV.'-'.$detalle->item }}" class="form-control id_reg"></td>
                                    </tr>
                                    @php
                                        $id++;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <br>
            <div class="card-footer">
                <div class="table-responsive">
                    <table class="table table-striped first">
                        <thead>
                            <tr>
                                <th style="text-align: center">TOTAL BRUTO</th>
                                <th style="text-align: center">DESCUENTO</th>
                                <th style="text-align: center">RETENCION</th>
                                <th style="text-align: center">SEGURO</th>
                                <th style="text-align: center">FLETE</th>
                                <th style="text-align: center">SUBTOTAL</th>
                                <th style="text-align: center">IVA</th>
                                <th style="text-align: center">TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="number" class="form-control" style="text-align: right" id="total_bruto" value="{{ $encabezado->bruto }}" disabled></td>
                                <td><input type="number" class="form-control" style="text-align: right" id="total_descuento" value="{{ $encabezado->descuento }}" disabled></td>
                                <td>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-secondary retencion_btn" type="button" id="{{ $numero_factura.','.$encabezado->tipo_cliente }}"><i class="fas fa-calculator"></i></button>
                                        </div>
                                        <input type="number" class="form-control" style="text-align: right" id="total_retencion" value="{{ $encabezado->retefte }}">
                                    </div>
                                </td>
                                <td><input type="number" class="form-control" style="text-align: right" id="total_seguro" value="{{ $encabezado->seguros }}" {{ $encabezado->tipo_cliente != 'EX' ? 'disabled': '' }}></td>
                                <td><input type="number" class="form-control" style="text-align: right" id="total_flete" value="{{ $encabezado->fletes }}" {{ $encabezado->tipo_cliente != 'EX' ? 'disabled': '' }}></td>
                                <td><input type="number" class="form-control" style="text-align: right" id="total_subtotal"  value="{{ $encabezado->subtotal }}" disabled></td>
                                <td><input type="number" class="form-control" style="text-align: right" id="total_iva" value="{{ $encabezado->iva }}" disabled></td>
                                <td><input type="number" class="form-control" style="text-align: right" id="total_factura" value="{{ $encabezado->subtotal + $encabezado->iva  - $encabezado->retefte }}" disabled></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <button id="Guardar" class="btn btn-primary btn-lg">Guardar cambios</button> &nbsp;
                <a href="{{ route('factura.index') }}" class="btn btn-secondary btn-lg" role="button">Volver</a>
            </div>
        </div>


        <style>
            .preloader {
                width: 140px;
                height: 140px;
                border: 20px solid #eee;
                border-top: 20px solid #008000;
                border-radius: 50%;
                animation-name: girar;
                animation-duration: 1s;
                animation-iteration-count: infinite;
            }
            @keyframes girar {
                from {
                    transform: rotate(0deg);
                }
                to {
                    transform: rotate(360deg);
                }
            }
        </style>
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
            $(document).ready(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                function calcular_total_fila(fila) {
                    const id = fila;
                    const precio = $('.precio_'+id).val();
                    const cantidad =  $('.cantidad_'+id).val();
                    const select_iva = $('#tieneiva').val();

                    var porc_desc =  $('#descuento').val();

                    var total_desc = porc_desc * (cantidad * precio) / 100;

                    if (select_iva == 1){
                        $('.iva_'+id).val((parseFloat(precio) * parseFloat(cantidad) - total_desc) * 19/100);
                    }else{
                        $('.iva_'+id).val(0);
                    }

                    $('.total_'+id).val(parseFloat(precio) * parseFloat(cantidad));
                    sumar_total_tabla();
                }

                function sumar_total_tabla(){
                    var arr_tot = document.getElementsByName('total');
                    var tot_fac=0;
                    for(let i = 0; i < arr_tot.length; i++){
                        if(parseFloat(arr_tot[i].value))
                            tot_fac += parseFloat(arr_tot[i].value);
                    }

                    var arr = document.getElementsByName('iva');
                    var tot_iva=0;
                    for(let i = 0; i < arr.length; i++){
                        if(parseFloat(arr[i].value))
                            tot_iva += parseFloat(arr[i].value);
                    }
                    var input_descuento = $('#descuento').val();
                    document.getElementById('total_bruto').value = tot_fac;
                    document.getElementById('total_iva').value = tot_iva;


                    if (input_descuento > 0){
                        document.getElementById('total_descuento').value = tot_fac * input_descuento/100;
                    }else{
                        document.getElementById('total_descuento').value = 0;
                    }

                    var descuento = tot_fac * input_descuento/100;
                    var fletes = $('#total_flete').val();
                    var seguros = $('#total_seguro').val();
                    var retencion = $('#total_retencion').val();
                    var Subtotal = tot_fac - descuento + parseFloat(fletes) + parseFloat(seguros);

                    document.getElementById('total_subtotal').value = Subtotal;
                    document.getElementById('total_factura').value = Subtotal+ tot_iva - parseFloat(retencion);
                }


                $(document).on('keyup', '.cantidad', function () {
                    let fila = this.id;
                    calcular_total_fila(fila);
                });

                $(document).on('keyup', '.precio', function () {
                    let fila = this.id;
                    calcular_total_fila(fila);
                });

                $(document).on('keyup', '#descuento', function () {
                    sumar_total_tabla();
                });

                $(document).on('change', '#tieneiva', function () {
                    sumar_total_tabla();
                });

                $(document).on('keyup', '#total_flete', function () {
                    sumar_total_tabla();
                });

                $(document).on('keyup', '#total_seguro', function () {
                    sumar_total_tabla();
                });

                $(document).on('click', '.retencion_btn', function (message) {
                    var id = this.id;
                    id = id.split(',');
                    var fac = id[0];
                    var tc  = id[1];
                    var motivo = $('#motivo').val();
                    var iva = $('#total_iva').val();
                    var subtotal = $('#total_subtotal').val();
                    var fecha = $('#fecha_factura').val();

                    $.ajax({
                        url: '/aplicaciones/facturacion_electronica/factura/edit/calcular_retencion',
                        method: 'get',
                        data: {
                            fac: fac,
                            tc: tc,
                            motivo: motivo,
                            iva: iva,
                            subtotal: subtotal,
                            fecha: fecha
                        },
                        success: function (data) {
                            console.log(data);
                            $('#total_retencion').val(data);
                            sumar_total_tabla();
                        },
                        error: function (data) {
                            alert('error al calcular retencion')
                        }
                    })

                });

                $(document).on('click', '#Guardar', function () {
                    const encabezado = {
                        factura: $('#num_fac').val(),
                        notas: $('#notas_factura').val(),
                        motivo: $('#motivo').val(),
                        oc: $('#oc').val(),
                        condicion_pago: $('#condicion_pago').val(),
                        bruto: $('#total_bruto').val(),
                        descuento: $('#total_descuento').val(),
                        retencion: $('#total_retencion').val(),
                        seguro: $('#total_seguro').val(),
                        flete: $('#total_flete').val(),
                        subtotal: $('#total_subtotal').val(),
                        iva: $('#total_iva').val(),
                        fecha_factura: $('#fecha_factura').val(),
                        codigo_cliente: $('#codigo_cliente').val(),
                        ov: $('#remision').val()
                    };

                    const items = [];

                    document.querySelectorAll('.tabla_productos tbody tr').forEach(function(e){
                        let fila = {
                            cantidad: e.querySelector('.cantidad').value,
                            precio_uni: e.querySelector('.precio').value,
                            total_item: e.querySelector('.total').value,
                            iva_item: e.querySelector('.iva').value,
                            id_reg: e.querySelector('.id_reg').value,
                        };
                        items.push(fila);

                    });


                    $.ajax({
                        url: '/aplicaciones/facturacion_electronica/factura_edit/guardar_facura',
                        type: 'post',
                        data: {
                            encabezado: encabezado,
                            items: items
                        },
                        success: function (data) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Terminado!',
                                text: data,
                            });
                        },
                        error: function (data) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Hubo un error!',
                                text: data,
                            });
                        }
                    })


                });

            });


        </script>
    @endpush
@stop
