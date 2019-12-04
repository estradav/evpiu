@extends('layouts.dashboard')

@section('page_title', 'Facturacion Electronica')

@section('module_title', 'Facturacion Electronica')

@section('subtitle', 'Este módulo permite editar facturas.')

@section('breadcrumbs')
    {{ Breadcrumbs::render('fact_electr') }}
@stop
@section('content')
    @can('facturacion.edit')
    <div class="col-12"><h3> Factura #: {{ $var }} </h3></div>
    <form action="" method="POST">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">Informacion Cliente</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Razon social:</label>
                                    <input type="text" class="form-control" id="razon_social" name="razon_social">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Direccion:</label>
                                    <input type="text" class="form-control" id="direccion" name="direccion" >
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Tipo de Cliente:</label>
                                    <input type="text" class="form-control" id="tipo_cliente" name="tipo_cliente">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Telefono:</label>
                                    <input type="text" class="form-control" id="telefono" name="telefono">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Ciudad, Estado, Pais:</label>
                                    <input type="text" class="form-control" id="ciudad_est_pais" name="ciudad_est_pais">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Contacto:</label>
                                    <input type="text" class="form-control" id="contacto" name="contacto">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Motivo:</label>
                                    <select  class="form-control" id="motivo" name="motivo">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">Informacion de facturacion</h5>
                    <div class="card-body">
                        <form role="form">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Cedula o Nit:</label>
                                        <input type="text" class="form-control" id="documento" name="documento">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Fecha Factura:</label>
                                        <input type="text" class="form-control" id="fecha_factura" name="fecha_factura">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Condiciones de pago:</label>
                                        <select id="condicion_pago" name="condicion_pago" class="form-control">

                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Fecha Vencimiento:</label>
                                        <input type="text" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Codigo Cliente:</label>
                                        <input type="text" class="form-control" id="codigo_cliente" name="codigo_cliente">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Orden de venta:</label>
                                        <input type="text" class="form-control" id="remision" name="remision">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Notas Factura:</label>
                                        <textarea cols="30" rows="3" class="form-control" id="notas_factura" name="notas_factura"></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="card">
                <h5 class="card-header">Productos</h5>
                <div class="card-body">
                    <form role="form">
                        <div class="table-responsive">
                            <table class="table table-striped first">
                                <thead>
                                    <tr>
                                        <th style="width: 10% !important; text-align: center">ORDEN</th>
                                        <th style="width: 12% !important; text-align: center">CODIGO</th>
                                        <th style="width: 15% !important; text-align: center">DESCRIPCION</th>
                                        <th style="width: 5%  !important; text-align: center">U/M</th>
                                        <th style="width: 10% !important; text-align: center">CANTIDAD</th>
                                        <th style="width: 10% !important; text-align: center">PRECIO UNITARIO</th>
                                        <th style="width: 10% !important; text-align: center">IVA</th>
                                        <th style="width: 15% !important; text-align: center">SUBTOTAL</th>
                                    </tr>
                                </thead>
                                <tbody id="items_factura" name="items_factura">
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
                            <tbody id="totales_factura">
                                <tr>
                                    <td><input type="number" class="form-control" style="text-align: right" id="Total_bruto"></td>
                                    <td><input type="number" class="form-control" style="text-align: right" id="Total_descuento"></td>
                                    <td><input type="number" class="form-control" style="text-align: right" id="Total_retencion"></td>
                                    <td><input type="number" class="form-control" style="text-align: right" id="Total_seguro"></td>
                                    <td><input type="number" class="form-control" style="text-align: right" id="Total_flete"></td>
                                    <td><input type="number" class="form-control" style="text-align: right" id="Total_subtotal"></td>
                                    <td><input type="number" class="form-control" style="text-align: right" id="Total_iva"></td>
                                    <td><input type="number" class="form-control" style="text-align: right" id="Total_factura"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="col-sm-12 pl-0">
                <p class="text-right">
                    <a href="{{ route('fe.index') }}" class="btn btn-sm btn-secondary" role="button">Volver</a>
                    <button class="btn btn-sm btn-primary" type="submit">Guardar cambios</button>
                </p>
            </div>
        </div>
    </form>
    @else
        <div class="alert alert-danger" role="alert">
            No tienes permisos para visualizar editar facturas.
        </div>
    @endcan

    @push('javascript')
        <script>
            $(document).ready(function () {
                var Numero_factura = @json( $var );
                function ObtenerDatos() {
               	    $.ajax({
                        url: "/DatosxFactura",
                        type: "get",
                        data: {
                        	numero: Numero_factura
                        },
                        success: function (data) {
                        	var ciudad_est_pais = data['encabezado'][0]['Ciudad'].trim() + '-'+ data['encabezado'][0]['Dpto'].trim() + '-' + data['encabezado'][0]['Pais'].trim();
                        	console.log(data['encabezado']);
                            $('#razon_social').val(data['encabezado'][0]['nombres'].trim());
                            $('#direccion').val(data['encabezado'][0]['direccion'].trim());
                            $('#tipo_cliente').val(data['encabezado'][0]['tipo_cliente'].trim());
                            $('#ciudad_est_pais').val(ciudad_est_pais.trim());
                            $('#contacto').val(data['encabezado'][0]['nombres'].trim());
                            $('#telefono').val(data['encabezado'][0]['telefono'].trim());
                            $('#motivo').val(data['encabezado'][0]['motivo'].trim());
                            $('#documento').val(data['encabezado'][0]['nit_cliente'].trim());
                            $('#fecha_factura').val(data['encabezado'][0]['fechadocumento'].trim());
                            $('#fecha_vencimiento').val(data['encabezado'][0]['fechavencimiento'].trim());
                            $('#codigo_cliente').val(data['encabezado'][0]['codigocliente'].trim());
                            $('#remision').val(data['encabezado'][0]['ov'].trim());
                            $('#notas_factura').val(data['encabezado'][0]['notas'].trim());
                            $('#condicion_pago').val(data['encabezado'][0]['plazo'].trim());
                            $('#Total_flete').val(data['encabezado'][0]['fletes'].trim());
                            $('#Total_subtotal').val(data['encabezado'][0]['subtotal'].trim());
                            $('#Total_seguro').val(data['encabezado'][0]['seguros'].trim());
                            $('#Total_descuento').val(data['encabezado'][0]['descuento'].trim());
                            $('#Total_bruto').val(data['encabezado'][0]['bruto'].trim());
                            $('#Total_iva').val(data['encabezado'][0]['iva'].trim());
                            $('#Total_retencion').val(0);

                            var i = 0;
                            var n = 1;
                            $(data['detalle']).each(function (){
                                $('#items_factura').append('<tr>' +
                                    '<td style="width: 10% !important;">' + '<input id="'+n+'" type="text" class="form-control" value="'+ data['detalle'][i]['OV'].trim() +'">' + '</td>' +
                                    '<td style="width: 12% !important;">' + '<input id="'+n+'" type="text" class="form-control" value="'+ data['detalle'][i]['CodigoProducto'].trim() +'">' + '</td>' +
                                    '<td style="width: 15% !important;">' + '<input id="'+n+'" type="text" class="form-control" value="'+ data['detalle'][i]['descripcionproducto'].trim() +'">' + '</td>' +
                                    '<td style="width: 5%  !important;">' + '<input id="'+n+'" type="text" class="form-control item_unidadmedida" value="'+ data['detalle'][i]['UM'].trim() +'">'  + '</td>' +
                                    '<td style="width: 10% !important;">' + '<input id="Cant-'+n+'" style="text-align: right !important;" type="number" class="form-control item_cantidad" value="'+ data['detalle'][i]['cantidad'].trim() +'">' + '</td>' +
                                    '<td style="width: 10% !important;">' + '<input id="Precun-'+n+'" style="text-align: right !important;" type="number" class="form-control item_preciounitario" value="'+ data['detalle'][i]['precio'].trim() +'">' + '</td>' +
                                    '<td style="width: 10% !important;">' + '<input id="Itmiva-'+n+'" style="text-align: right !important;" type="number" class="form-control item_iva" value="'+ data['detalle'][i]['iva_item'].trim() +'">' + '</td>' +
                                    '<td style="width: 15% !important;">' + '<input id="ItmPrec-'+n+'" style="text-align: right !important;" type="number" class="form-control item_preciototal" value="'+ data['detalle'][i]['totalitem'].trim() +'">' +'</td>' +
                                    '</tr>'
                                );
                                i++;
                                n++;
                            });
                            Calcular_Valores();
                        }
                    })
                }

                getMotivo();

                getCondicion();

                function getCondicion(){
                    $.ajax({
                        type: "get",
                        url: '/PedidosGetCondicion',
                        success: function (data) {
                            ObtenerDatos();
                            var i = 0;
                            $('#condicion_pago').append('<option value="" >Seleccione...</option>');
                            $(data).each(function (){
                                $('#condicion_pago').append('<option value="'+ data[i].DESC_36.trim() +'" >'+ data[i].DESC_36.trim() +'</option>');
                                i++
                            });
                        }
                    })
                }

                function getMotivo(){
                    $.ajax({
                        type: "get",
                        url: '/VerCondicionesPago',
                        success: function (data) {
                            var i = 0;
                            $('#motivo').append('<option value="" >Seleccione...</option>');
                            $(data).each(function (){
                                $('#motivo').append('<option value="'+ data[i].CODE_36.trim() +'" >'+ data[i].DESC_36.trim() +'</option>');
                                i++
                            });
                        }
                    })
                }

                function Calcular_Valores(){

                	var TotalBruto      = $('#Total_bruto').val();
                	var TotalDescuento  = $('#Total_descuento').val();
                	var TotalRetencion  = $('#Total_retencion').val();
                    var TotalSeguro     = $('#Total_seguro').val();
                    var TotalFlete      = $('#Total_flete').val();
                    var TotalSubtotal   = TotalBruto - TotalDescuento;
                    var TotalIva        = $('#Total_iva').val();
                    var TotalFactura    = (TotalSubtotal + parseFloat(TotalIva) + parseFloat(TotalSeguro) + parseFloat(TotalFlete)) - parseFloat(TotalRetencion)

                    console.log( TotalSubtotal , TotalSubtotal , parseFloat(TotalIva) , parseFloat(TotalSeguro) , parseFloat(TotalRetencion));

                    $('#Total_factura').val(TotalFactura);
                    $('#Total_subtotal').val(TotalSubtotal);


                }

                function Sumar() {

                    var Subtotal=0;
                    var IVA = 0;
                    var $dataRows=$("#items_factura");
                    $dataRows.each(function() {
                        $(this).find('.item_preciototal').each(function(){
                            Subtotal+=parseInt( $(this).val());
                        });
                        $(this).find('.item_iva').each(function(){
                            IVA+=parseInt( $(this).val());
                        });
                    });

                    $('#Total_bruto').val(Subtotal);
                    $('#Total_iva').val(IVA);
                    console.log(Subtotal);
                    Calcular_Valores();
                }

                $('form').on('keyup','.item_preciounitario', function () {
					var id = $(this).attr('id');
                    id = id.substring(7);
                    var precio_unitario = 'Precun-'+id;
                    var item_iva = 'Itmiva-'+id;
                    var item_cant = 'Cant-'+id;
                    var item_subtotal = 'ItmPrec-'+id;
                    var value = document.getElementById(item_cant).value;
                    var precio_unitarioitm = document.getElementById(precio_unitario).value;
                    var subtotal = precio_unitarioitm * value;
                    var iva = subtotal * 0.19;

                    document.getElementById(item_iva).value=iva;
                    document.getElementById(item_subtotal).value=subtotal;
                    console.log(subtotal);

                    Sumar();
                })
            });
        </script>
    @endpush
@stop
