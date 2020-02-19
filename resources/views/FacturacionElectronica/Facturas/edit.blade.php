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
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">Informacion Cliente</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Razon social:</label>
                                    <input type="text" class="form-control" id="razon_social" name="razon_social" readonly="readonly">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Direccion:</label>
                                    <input type="text" class="form-control" id="direccion" name="direccion" readonly="readonly">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Tipo de Cliente:</label>
                                    <input type="text" class="form-control" id="tipo_cliente" name="tipo_cliente" readonly="readonly">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Telefono:</label>
                                    <input type="text" class="form-control" id="telefono" name="telefono" readonly="readonly">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Ciudad, Estado, Pais:</label>
                                    <input type="text" class="form-control" id="ciudad_est_pais" name="ciudad_est_pais" readonly="readonly">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Contacto:</label>
                                    <input type="text" class="form-control" id="contacto" name="contacto" readonly="readonly">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Motivo:</label>
                                    <select  class="form-control" id="motivo" name="motivo">
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>% Descuento:</label>
                                    <input type="number" id="descuento" name="descuento" class="form-control" max="100" min="0">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>IVA:</label>
                                    <select name="tieneiva" id="tieneiva" class="form-control">
                                        <option value="1">Si</option>
                                        <option value="2">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Orden Compra:</label>
                                    <input type="text" id="oc" name="oc" class="form-control">
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
                                        <input type="text" class="form-control" id="documento" name="documento" readonly="readonly">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Fecha Factura:</label>
                                        <input type="text" class="form-control" id="fecha_factura" name="fecha_factura" readonly="readonly">
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
                                        <input type="text" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento" readonly="readonly">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Codigo Cliente:</label>
                                        <input type="text" class="form-control" id="codigo_cliente" name="codigo_cliente" readonly="readonly">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Orden de venta:</label>
                                        <input type="text" class="form-control" id="remision" name="remision" readonly="readonly">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Notas Factura:</label>
                                        <textarea cols="30" rows="5" class="form-control" id="notas_factura" name="notas_factura"></textarea>
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
                            <table class="table table-striped first tabla_productos">
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
                                    <td><input type="number" class="form-control" style="text-align: right" id="Total_bruto" readonly="readonly"></td>
                                    <td><input type="number" class="form-control" style="text-align: right" id="Total_descuento" readonly="readonly"></td>
                                    <td><input type="number" class="form-control" style="text-align: right" id="Total_retencion" readonly="readonly"></td>
                                    <td><input type="number" class="form-control" style="text-align: right" id="Total_seguro" readonly="readonly"></td>
                                    <td><input type="number" class="form-control" style="text-align: right" id="Total_flete" readonly="readonly"></td>
                                    <td><input type="number" class="form-control" style="text-align: right" id="Total_subtotal" readonly="readonly"></td>
                                    <td><input type="number" class="form-control" style="text-align: right" id="Total_iva" readonly="readonly"></td>
                                    <td><input type="number" class="form-control" style="text-align: right" id="Total_factura" readonly="readonly"></td>
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
                    <a href="javascript:void(0)" id="SaveBtn" name="SaveBtn" class="btn btn-sm btn-primary">Guardar cambios</a>
                </p>
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
                preload();
                function preload() {
                    Swal.fire({
                        icon: false,
                        title: 'Cargando informacion, un momento por favor...',
                        html: '<br><div class="container" style="align-items: center !important; margin-left: 150px; margin-right: 150px"><div class="preloader"></div></div>',
                        showConfirmButton: false,
                        showCancelButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    });
                }
                var Numero_factura = @json( $var );
                console.log(Numero_factura);
                function ObtenerDatos() {
               	    $.ajax({
                        url: "/DatosxFactura",
                        type: "get",
                        data: {
                        	numero: Numero_factura
                        },
                        success: function (data) {
                        	console.log(data);
                        	var ciudad_est_pais = data['encabezado'][0]['ciudad'].trim() + '-'+ data['encabezado'][0]['dpto'].trim() + '-' + data['encabezado'][0]['pais'].trim();
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
                            $('#condicion_pago').val(data['encabezado'][0]['dias'].trim());
                            $('#Total_flete').val(data['encabezado'][0]['fletes'].trim());
                            $('#Total_subtotal').val(data['encabezado'][0]['subtotal'].trim());
                            $('#Total_seguro').val(data['encabezado'][0]['seguros'].trim());
                            $('#Total_descuento').val(data['encabezado'][0]['descuento'].trim());
                            $('#Total_bruto').val(data['encabezado'][0]['bruto'].trim());
                            $('#Total_iva').val(data['encabezado'][0]['iva'].trim());
                            $('#Total_retencion').val(0);
                            $('#oc').val(data['encabezado'][0]['OC'].trim());


                            var i = 0;
                            var n = 1;
                            $(data['detalle']).each(function (){
                                $('#items_factura').append('<tr>' +
                                    '<td style="width: 10% !important;">' + '<input type="text" class="form-control" value="'+ data['detalle'][i]['OV'].trim() +'" readonly="readonly" >' + '</td>' +
                                    '<td style="width: 12% !important;">' + '<input type="text" class="form-control" value="'+ data['detalle'][i]['CodigoProducto'].trim() +' " readonly="readonly">' + '</td>' +
                                    '<td style="width: 15% !important;">' + '<input type="text" class="form-control" value="'+ data['detalle'][i]['descripcionproducto'].trim() +'" readonly="readonly">' + '</td>' +
                                    '<td style="width: 5%  !important;">' + '<input id="'+n+'" type="text" class="form-control item_unidadmedida" value="'+ data['detalle'][i]['UM'].trim() +'" readonly="readonly">'  + '</td>' +
                                    '<td style="width: 10% !important;">' + '<input id="Cant-'+n+'" style="text-align: right !important;" type="number" class="form-control item_cantidad" value="'+ parseFloat(data['detalle'][i]['cantidad'].trim()).toFixed(2) +'" readonly="readonly">' + '</td>' +
                                    '<td style="width: 10% !important;">' + '<input id="Precun-'+n+'" style="text-align: right !important;" type="number" class="form-control item_preciounitario" value="'+ parseFloat(data['detalle'][i]['precio'].trim()).toFixed(2) +'">' + '</td>' +
                                    '<td style="width: 10% !important;">' + '<input id="Itmiva-'+n+'" style="text-align: right !important;" type="number" class="form-control item_iva" value="'+ parseFloat(data['detalle'][i]['iva_item'].trim()).toFixed(2) +'" readonly="readonly">' + '</td>' +
                                    '<td style="width: 15% !important;">' + '<input id="ItmPrec-'+n+'" style="text-align: right !important;" type="number" class="form-control item_preciototal" value="'+ parseFloat(data['detalle'][i]['totalitem'].trim()).toFixed(2) +'" readonly="readonly">' +'</td>' +
                                    '<td class="item" style="display: none !important;">' + ' <input type="text" value="'+ data['detalle'][i]['item'].trim() +'">' + '</td>' +
                                    '<td class="ordencompra" style="display: none !important;">' + '<input type="text" value="' + data['detalle'][i]['OV'].trim() + '">' + '</td>' +
                                    '</tr>'
                                );
                                i++;
                                n++;
                            });
                            Calcular_Valores();
                            sweetAlert.close();
                        },
                        error: function (data) {
                            sweetAlert.close();
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Hubo un error en el cargue de la factura..!',
                            });
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
                                $('#condicion_pago').append('<option value="'+ data[i].DAYS_36.trim() +'" >'+ data[i].DESC_36.trim() +'</option>');
                                i++
                            });
                        },
                        error: function (data) {
                            sweetAlert.close();
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Hubo un error en el cargue de la factura..!',
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
                        },
                        error: function (data) {
                            sweetAlert.close();
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Hubo un error en el cargue de la factura..!',
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
                    var TotalSubtotal   = parseFloat(TotalBruto) - parseFloat(TotalDescuento);
                    var TotalIva        = $('#Total_iva').val();
                    var TotalFactura    = (parseFloat(TotalSubtotal) + parseFloat(TotalIva)  + parseFloat(TotalSeguro) + parseFloat(TotalFlete)) - parseFloat(TotalRetencion);

                    $('#Total_factura').val(TotalFactura);
                    $('#Total_subtotal').val(TotalSubtotal);

                }

                function Sumar() {
                    var Subtotal=0;
                    var IVA = 0;
                    var $dataRows=$("#items_factura");
                    $dataRows.each(function() {
                        $(this).find('.item_preciototal').each(function(){
                            Subtotal+=parseFloat( $(this).val());
                        });
                        $(this).find('.item_iva').each(function(){
                            IVA+=parseFloat( $(this).val());
                        });
                    });

                    $('#Total_bruto').val(Subtotal);
                    $('#Total_iva').val(IVA);
                    console.log(Subtotal);


                    var valuedesc = $('#descuento').val();
                    var bruto = $('#Total_bruto').val();

                    if(valuedesc == 0 || valuedesc < 0){
                        $('#Total_descuento').val(0);
                    }else{
                        var Descuento = (bruto * valuedesc) / 100;
                        console.log('Descuento:'+Descuento);
                        $('#Total_descuento').val(Descuento);
                    }

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

                    var Porcdescuento = $('#descuento').val();
                    var descuento = (subtotal * Porcdescuento) / 100;

                    var subtotalmenosdesc = subtotal - descuento;
                    var iva = subtotalmenosdesc * 0.19;

                    document.getElementById(item_subtotal).value=subtotalmenosdesc;
                    document.getElementById(id).value=precio_unitarioitm;

                    if($('#tieneiva').val() == 1){
                        document.getElementById(item_iva).value=iva;
                    }else{
                        document.getElementById(item_iva).value=0;
                    }
                    Sumar();
                });

                $('#tieneiva').on('change',function () {
                    var estado = $(this).val();
                    console.log(estado);
                    if(estado == 1)
                    {
                       Sumar();
                    }
                    if(estado == 2)
                    {
                       $('.item_iva').val(0);
                       Sumar();
                    }
                });

                $('#condicion_pago').on('change', function () {
                    var fecha_inicio = $('#fecha_factura').val();
                    console.log('Fecha', fecha_inicio);
                    var dias = $(this).val();
                    console.log('Días', dias);

                    // Fecha
                    // Separar las partes de la fecha por /
                    var dateparts = fecha_inicio.split('-').map(d => parseInt(d));
                    // Si no hay 3 partes o alguna no es un número no es correcto
                    if (dateparts.length !== 3 || !dateparts.every(d => !isNaN(d))){
                        alert('La fecha no tiene un formato correcto');
                        return;
                    }
                    console.log(dateparts);
                    // Crea el objeto Date pasando año, mes, día
                    var fechaDate = new Date(dateparts[0], dateparts[1]-1, dateparts[2]);

                    console.log('part:'+dateparts[2]);
                    // Dias en formato entero
                    var diasNum = parseInt(dias);

                    console.log(diasNum);
                    // Si no es un número no es correcto
                    if (isNaN(diasNum)){
                      alert('El número de días no tiene un formato correcto');
                    }

                    // Suma los días a la fecha
                    fechaDate.setDate(fechaDate.getDate() + diasNum);

                    console.log('dias:'+ fechaDate.getDate());

                    let formatted_date = fechaDate.getFullYear() + "-" + (fechaDate.getMonth() + 1) + "-" + fechaDate.getDate() + " " + fechaDate.getHours() + ":" + fechaDate.getMinutes() + ":" + fechaDate.getSeconds();

                    $('#fecha_vencimiento').val(formatted_date);
                    alert('El resultado de sumar ' + dias + ' días a la fecha ' + fecha_inicio + ' es ' + formatted_date);
                });

                $('#SaveBtn').on('click', function () {
					var notas =	$('#notas_factura').val();
					var motivo = $('#motivo').val();
					var condicionpago = $('#condicion_pago').val();
					var fechavencimiento = $('#fecha_vencimiento').val();
					var total_bruto = $('#Total_bruto').val();
                    var total_descuento = $('#Total_descuento').val();
                    var total_retencion = $('#Total_retencion').val();
                    var total_seguro = $('#Total_seguro').val();
                    var total_flete = $('#Total_flete').val();
                    var total_subtotal = $('#Total_subtotal').val();
                    var total_iva = $('#Total_iva').val();
                    var total_factura = $('#Total_factura').val();
                    var orden_compra = $('#oc').val();

                    var encabezado = [];
                    let Items = [];
                    var Inputs = {
                        notas: notas,
                        motivo: motivo,
                        condicionpago: condicionpago,
                        fechavencimiento: fechavencimiento,
                        total_bruto: total_bruto,
                        total_descuento: total_descuento,
                        total_retencion: total_retencion,
                        total_seguro: total_seguro,
                        total_flete: total_flete,
                        total_subtotal: total_subtotal,
                        total_iva: total_iva,
                        total_factura: total_factura,
                        Numero_factura: Numero_factura,
                        ordencompra: orden_compra
                    };
                    encabezado.push(Inputs);


                    var filas = $("#items_factura").find("tr"); //devulve las filas del body de tu tabla segun el ejemplo que brindaste
                    for(i=0; i<filas.length; i++) { //Recorre las filas 1 a 1
                        var celdas = $(filas[i]).find("td"); //devolverá las celdas de una fila
                        var cantidad = $($(celdas[4]).children("input")[0]).val();
                        var preciounitario = $($(celdas[5]).children("input")[0]).val();
                        var iva = $($(celdas[6]).children("input")[0]).val();
                        var subtotal = $($(celdas[7]).children("input")[0]).val();
                        var item = $($(celdas[8]).children("input")[0]).val();
                        var ordencompra = $($(celdas[9]).children("input")[0]).val();

                        let values = {
                            cantidad,
                            preciounitario,
                            iva,
                            subtotal,
                            item,
                            ordencompra,
                        };
                        Items.push(values);
                    }
                    console.log(Items);

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: "/GuardarFacturaEdit",
                        type: "post",
                        data:{
                            Items,encabezado
                        },
                        success: function (data) {
                            if (data.hasOwnProperty('error')) {
                                Swal.fire({
                                    icon: 'error',
                                    title: '¡Oops!',
                                    text: '¡Hubo un error al guardar la factura!',
                                })
                            }else{
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Guardado!',
                                    text: '¡Factura editada con exito!',
                                })
                            }
                        }
                    })
                });

                $('#descuento').on('keyup', function () {
                    var value = $(this).val();
                    var bruto = $('#Total_bruto').val();

                    if(value == 0 || value < 0){
                    	$('#Total_descuento').val(0);
                    	Sumar();
                    }else{
                    	var Descuento = (bruto * value) / 100;
                    	console.log('Descuento:'+Descuento);
                        $('#Total_descuento').val(Descuento);
                        Sumar();
                    }
                    resultado();
                });

                function resultado(){
                    var filas = $("#items_factura").find("tr"); //devulve las filas del body de tu tabla segun el ejemplo que brindaste
                    var resultado = [];
                    for(i=0; i<filas.length; i++){ //Recorre las filas 1 a 1
                        var celdas = $(filas[i]).find("td"); //devolverá las celdas de una fila
                        var cantidad = $($(celdas[4]).children("input")[0]).val();
                        var precio_unitario = $($(celdas[5]).children("input")[0]).val();
                        var iva = $($(celdas[6]).children("input")[0]).val();
                        var subtotal = $($(celdas[7]).children("input")[0]).val();

                        var items = [cantidad, precio_unitario, iva, subtotal];

                        console.log(items);
                        resultado.push(items);
                    }
                    console.log(items);
                }

            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.3.10/dist/sweetalert2.all.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
    @endpush
@stop
