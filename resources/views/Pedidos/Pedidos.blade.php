@extends('layouts.dashboard')

@section('page_title', 'Pedidos')

@section('module_title', 'Pedidos')

@section('subtitle', 'Este módulo permite ver y crear Pedidos.')
{{--
@section('breadcrumbs')
    {{ Breadcrumbs::render('fact_electr_facturas') }}
@stop--}}

@section('content')
    @can('pedidos.view')
        <div class="col-lg-12">
            <div class="form-group">
                <span><input type="button" class="btn btn-primary btn-sm NewPed" id="NewPed" value="Crear Pedido"></span>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-responsive table-striped dataTableP" id="table">
                                <thead>
                                    <tr>
                                        <th># Pedido</th>
                                        <th>Orden de Compra</th>
                                        <th>Codigo Cliente</th>
                                        <th>Nombre Cliente</th>
                                        <th>Vendedor</th>
                                        <th>Condiciones de pago</th>
                                        <th>Descuento</th>
                                        <th>IVA</th>
                                        <th>Estado</th>
                                        <th>Fecha Creacion</th>
                                        <th style="text-align:center ">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade bd-example-modal-xl" id="NewPedido" tabindex="-1" role="dialog" aria-labelledby="NewPedido" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="NewPedidoTitle"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" class="form-horizontal" id="FormPrincipal">
                        <div class="modal-body">
                            <div class="row" >
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="name" class="control-label" ><b>Vendedor:&nbsp;&nbsp; </b></label>
                                        <select name="SelectVendedor" id="SelectVendedor" class="custom-select">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="name" class="control-label" ><b>Nombre Cliente:&nbsp;&nbsp;</b></label>
                                        <input type="text" class="form-control" id="NombreCliente" name="NombreCliente" placeholder="Buscar Cliente">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="name" class="control-label" ><b>Orden de Compra:&nbsp;&nbsp;</b></label>
                                        <input type="text" class="form-control" value="" id="OrdComp" name="OrdComp">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="name" class="control-label" ><b>Codigo Cliente:&nbsp;&nbsp;</b></label>
                                        <input type="text" class="form-control" value="" id="CodCliente" name="CodCliente">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="name" class="control-label" ><b>Direccion:&nbsp;&nbsp;</b></label>
                                        <input type="text" class="form-control" value="" id="address" name="address">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="name" class="control-label" ><b>Ciudad:&nbsp;&nbsp;</b></label>
                                        <input type="text" class="form-control" value="" id="city" name="city">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="name" class="control-label" ><b>Telefono:&nbsp;&nbsp;</b></label>
                                        <input type="text" class="form-control" value="" id="phone" name="phone">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="CondicionPago" class="control-label" ><b>Condicion de pago:&nbsp;&nbsp;</b></label>
                                        <select name="CondicionPago" id="CondicionPago" class="form-control">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="name" class="control-label"><b>Descuento:&nbsp;&nbsp;</b></label>
                                        <input type="text" class="form-control" value="0" id="descuento">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="name" class="control-label"><b>IVA:&nbsp;&nbsp;</b></label>
                                        <select name="SelectIva" id="SelectIva" class="form-control">
                                            <option value="" selected>Seleccione...</option>
                                            <option value="Y">Si</option>
                                            <option value="N">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="GeneralNotes"><b>Notas Generales:</b></label>
                                        <textarea name="GeneralNotes" id="GeneralNotes" cols="71" rows="2" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 30%">Producto</th>
                                    <th style="width: 10%">Stock</th>
                                    <th style="width: 15%">Notas</th>
                                    <th style="width: 10%">Unidad</th>
                                    <th style="width: 10%">Precio</th>
                                    <th style="width: 10%">Cantidad</th>
                                    <th style="width: 15%">Total</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <input type="hidden" value="" id="CodigoProductoMax" name="CodigoProductoMax">
                                        <input type="hidden" value="" id="DescripcionProductoMax" name="DescripcionProductoMax">
                                        <td style="width: 30%"><input type="text" id="ProductoMax" name="ProductoMax" class="form-control"></td>
                                        <td style="width: 10%"><input type="number" id="StockItem" name="StockItem" class="form-control" readonly="readonly"></td>
                                        <td style="width: 15%"><input type="text" id="AddNotes" name="AddNotes" class="form-control"></td>
                                        <td style="width: 10%">
                                            <select name="AddUnidad" id="AddUnidad" class="form-control">
                                                <option value="Unidad" selected >Unidad</option>
                                                <option value="Kilos">Kilos</option>
                                                <option value="Millar">Millar</option>
                                            </select>
                                        </td>
                                        <td style="width: 10%"><input type="number" id="AddPrice" name="AddPrice" class="form-control"></td>
                                        <td style="width: 10%"><input type="number" id="AddQuantity" name="AddQuantity" class="form-control" value="1"></td>
                                        <td style="width: 15%"><input type="text" id="TotalItem" name="TotalItem" class="form-control" readonly="readonly" value="0"></td>
                                        <td><button type="button" class="btn btn-success" id="AddItem" disabled><i class="fa fa-plus"></i></button></td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>
                            <br>
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered ItemsTable" id="ItemsTable">
                                            <thead>
                                                <tr>
                                                    <th>Codigo</th>
                                                    <th>Descripcion</th>
                                                    <th>Notas</th>
                                                    <th>Unidad</th>
                                                    <th>Precio</th>
                                                    <th>Cantidad</th>
                                                    <th>Total por Item</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="ProductosAdd">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <br>
                                <div class="card-footer">
                                    <div class="table-responsive">
                                        <table class="table table-striped first" id="TotalesTable">
                                            <thead>
                                                <tr>
                                                    <th>Cantidad Items</th>
                                                    <th>Valor Bruto</th>
                                                    <th>Descuento</th>
                                                    <th>Subtotal</th>
                                                    <th>IVA</th>
                                                    <th>Total Pedido</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input type="number" class="form-control totalCol" id="TotalQuantityItems" name="TotalQuantityItems" readonly="readonly"></td>
                                                    <td><input type="number" class="form-control totalCol" id="TotalItemsBruto" name="TotalItemsBruto" readonly="readonly"></td>
                                                    <td><input type="number" class="form-control" id="TotalItemsDiscount" name="TotalItemsDiscount" readonly="readonly"></td>
                                                    <td><input type="number" class="form-control" id="TotalItemsSubtotal" name="TotalItemsSubtotal" readonly="readonly"></td>
                                                    <td><input type="number" class="form-control" id="TotalItemsIva" name="TotalItemsIva" readonly="readonly"></td>
                                                    <td><input type="number" class="form-control" id="TotalItemsPrice" name="TotalItemsPrice" readonly="readonly"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="SavePed">Crear Pedido</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade bd-example-modal-xl" id="PdfView" tabindex="-1" role="dialog" aria-labelledby="PdfView" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="PdfTitle"></h5>
                    </div>
                    <br>
                    <div class="container">
                        <ul class="progressbar">
                            <li class="active" id="ProgBorrador"><a href="javascript:void(0);" style="color: #008000" class="StepBorrador">Borrador</a></li>
                            <li class="" id="ProgCartera"><a href="javascript:void(0);" style="color: #7d7d7d" class="StepCartera" id="StepCartera">Cartera</a></li>
                            <li id="ProgCostos"><a href="javascript:void(0);" style="color: #7d7d7d" class="StepCostos" id="StepCostos">Costos</a></li>
                            <li id="ProgProduccion"><a href="javascript:void(0);" style="color: #7d7d7d" class="StepProduccion" id="StepProduccion">Produccion</a></li>
                            <li id="ProgBodega"><a href="javascript:void(0);" style="color: #7d7d7d" class="StepBodega" id="StepBodega">Bodega</a></li>
                        </ul>
                    </div>
                    <div align="center" style="text-align: center !important; margin-left: 70px; margin-right: 70px;">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated ProgressPed" role="progressbar" style="width: 80%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" id="ProgressPed"></div>
                        </div>
                    </div>
                    <br>
                    <div class="modal-body" id="TextoImprimir" name="TextoImprimir">
                        <div class="wrapper">
                            <section class="invoice">
                                <div class="row">
                                    <div class="col-12">
                                        <h2 class="page-header">
                                            <img src="/img/Logo_v2.png" alt="" style="width: 195px !important; height: 142px !important;" class="headers">
                                            <small class="float-right">Fecha: <b><label id="Pdffecha"></label></b></small>
                                        </h2>
                                    </div>
                                </div>
                                <div class="row invoice-info">
                                    <div class="col-sm-4 invoice-col">
                                        <address>
                                            <strong>CI Estrada Velasquez y CIA. SAS</strong><br>
                                            <b>NIT:</b> 890926617-8 <br>
                                            <b>Telefono:</b> 265-66-65<br>
                                            <b>Email:</b> Comercial@estradavelasquez.com <br>
                                            <b>Direccion:</b> KR 55 # 29 C 14 - Zona industrial de belen.
                                        </address>
                                    </div>
                                    <div class="col-sm-4 invoice-col">
                                        <address>
                                            <strong>Cliente: </strong><label id="PdfCliente"></label><br>
                                            <b>Codigo Cliente:</b> <label id="PdfCodigoCliente"></label> <br>
                                            <b>Ciudad:</b> <label id="PdfCity"></label><br>
                                            <b>Direccion:</b> <label id="PdfAddress"></label> <br>
                                            <b>Telefono:</b> <label id="PdfPhone"></label>
                                        </address>
                                    </div>
                                    <div class="col-sm-4 invoice-col">
                                        <b>Pedido #: </b><label id="PdfNumeroPedio"></label> <br>
                                        <b>Orden Compra: </b><label id="PdfOrdenCompra"></label> <br>
                                        <b>Condicion de pago: </b><label id="PdfCondicionPago"></label> <br>
                                        <b>Vendedor: </b><label id="PdfVendedor"></label>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th style="text-align: center">Codigo</th>
                                                <th style="text-align: center">Descripcion</th>
                                                <th style="text-align: center">Notas</th>
                                                <th style="text-align: center">Unidad</th>
                                                <th style="text-align: center">Cantidad</th>
                                                <th style="text-align: center">Precio</th>
                                                <th style="text-align: center">Total</th>
                                            </tr>
                                            </thead>
                                            <tbody id="ItemsInvoice">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center" >Valor Bruto</th>
                                                    <th style="text-align: center">Descuento</th>
                                                    <th style="text-align: center">Subtotal</th>
                                                    <th style="text-align: center">IVA</th>
                                                    <th style="text-align: center">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td id="PdfBrutoInvoice" style="text-align: center"></td>
                                                    <td id="PdfDescuentoInvoice" style="text-align: center"></td>
                                                    <td id="PdfSubtotalInvoice" style="text-align: center"></td>
                                                    <td id="PdfIvaInvoice"style="text-align: center"></td>
                                                    <td id="PdfTotalInvoice" style="text-align: center"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <br>
                                <div class="row invoice-info">
                                    <div class="col-sm-12 invoice-col">
                                        <strong>NOTAS GENERALES:</strong> <label id="PdfGeneralNotes"></label><br>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary ImprimirPdf" id="ImprimirPdf">Imprimir</button>
                        <button type="button" class="btn btn-secondary Cerrar" data-dismiss="modal" id="Cerrar">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <style>
            .container {
                width: 750px;
                margin: 10px auto;
            }
            .progressbar {
                counter-reset: step;
            }
            .progressbar li {
                list-style-type: none;
                width: 20%;
                float: left;
                font-size: 12px;
                position: relative;
                text-align: center;
                text-transform: uppercase;
                color: #7d7d7d;
            }
            .progressbar li:before {
                width: 30px;
                height: 30px;
                content: counter(step);
                counter-increment: step;
                line-height: 30px;
                border: 2px solid #7d7d7d;
                display: block;
                text-align: center;
                margin: 0 auto 10px auto;
                border-radius: 50%;
                background-color: white;
            }
            .progressbar li:after {
                width: 100%;
                height: 2px;
                content: '';
                position: absolute;
                background-color: #7d7d7d;
                top: 15px;
                left: -50%;
                z-index: -1;
            }
            .progressbar li:first-child:after {
                content: none;
            }
            .progressbar li.active {
                color: green;
            }
            .progressbar li.active:before {
                border-color: #55b776;
            }
            .progressbar li.active + li:after {
                background-color: #55b776;
            }
        </style>
    @endcan
    @push('javascript')
        <script>
            $(document).ready(function(){
            	var table;
                var CodVenUsuario1 =  @json( Auth::user()->codvendedor );
                var NombreVendedor = @json( Auth::user()->name );
                console.log(CodVenUsuario1);
                LoadTable();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                function LoadTable(CodVenUsuario = CodVenUsuario1, Estado = '') {
                     table = $('.dataTableP').DataTable({
                        processing: true,
                        serverSide: false,
                        searching: true,
                        paginate: true,
                        bInfo: true,
                        ajax: {
                            url:'/PedidosIndex',
                            data:{CodVenUsuario: CodVenUsuario, Estado:Estado}
                        },
                        columns: [
                            {data: 'id', name: 'id', orderable: false, searchable: false},
                            {data: 'OrdenCompra', name: 'OrdenCompra', orderable: false, searchable: false},
                            {data: 'CodCliente', name: 'CodCliente', orderable: false, searchable: false},
                            {data: 'NombreCliente', name: 'NombreCliente', orderable: false, searchable: false},
                            {data: 'NombreVendedor', name: 'NombreVendedor', orderable: false, searchable: false},
                            {data: 'CondicionPago', name: 'CondicionPago', orderable: false, searchable: false},
                            {data: 'Descuento', name: 'Descuento', orderable: false, searchable: false, render: $.fn.dataTable.render.number('', '', 0, '% ')},
                            {data: 'Iva', name: 'Iva', orderable: false, searchable: false},
                            {data: 'Estado', name: 'Estado', orderable: false, searchable: false},
                            {data: 'created_at', name: 'created_at', orderable: false, searchable: false},
                            {data: 'opciones', name: 'opciones', orderable: false, searchable: false},

                        ],
                        language: {
                            // traduccion de datatables
                            processing: "Procesando...",
                            search: "Buscar&nbsp;:",
                            lengthMenu: "Mostrar _MENU_ registros",
                            info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
                            infoFiltered: "(filtrado de un total de _MAX_ registros)",
                            infoPostFix: "",
                            loadingRecords: "Cargando...",
                            zeroRecords: "No se encontraron resultados",
                            emptyTable: "No se encontraron pedidos...",
                            paginate: {
                                first: "Primero",
                                previous: "Anterior",
                                next: "Siguiente",
                                last: "Ultimo"
                            },
                            aria: {
                                sortAscending: ": Activar para ordenar la columna de manera ascendente",
                                sortDescending: ": Activar para ordenar la columna de manera descendente"
                            },
                        },
                        rowCallback: function (row, data, index) {
                        	if (data.Estado == 1) {
                                $(row).find('td:eq(8)').html('<label class="alert-success">Borrador</label>');
                            }
                            if (data.Estado == 0) {
                                $(row).find('td:eq(8)').html('<label class="alert-danger">Anulado Vendedor</label>');
                                $("#Reopen").prop('disabled',true);
                            }
                            if (data.Estado == 2) {
                                $(row).find('td:eq(8)').html('<label class="alert-primary">Cartera</label>');
                            }
                            if (data.Estado == 3) {
                                $(row).find('td:eq(8)').html('<label class="alert-warning">Rechazado Cartera</label>');
                            }
                            if (data.Estado == 4) {
                                $(row).find('td:eq(8)').html('<label class="alert-primary">Costos</label>');
                            }
                            if (data.Estado == 5) {
                                $(row).find('td:eq(8)').html('<label class="alert-warning">Rechazado Costos</label>');
                            }
                            if (data.Estado == 6) {
                                $(row).find('td:eq(8)').html('<label class="alert-primary">Produccion</label>');
                            }
                            if (data.Estado == 7) {
                                $(row).find('td:eq(8)').html('<label class="alert-warning">Rechazado Produccion</label>');
                            }
                            if (data.Estado == 8) {
                                $(row).find('td:eq(8)').html('<label class="alert-primary">Bodega</label>');
                            }
                            if (data.Estado == 9) {
                                $(row).find('td:eq(8)').html('<label class="alert-warning">Rechazado Bodega</label>');
                            }
                            if (data.Estado == 10) {
                                $(row).find('td:eq(8)').html('<label class="alert-success">Pedido Completado</label>');
                            }
                            if (data.Iva == 'Y') {
                                $(row).find('td:eq(7)').html('<label>SI</label>');
                            }
                            else{
                                $(row).find('td:eq(7)').html('<label>NO</label>');
                            }
                        }
                     })
                }

                function getUsers(){
                    $.ajax({
                        type: "get",
                        url: '/PedidosGetUsers',
                        success: function (data) {
                            var i = 0;
                            $(data).each(function () {
                                $('#SelectVendedor').append('<option value="'+data[i].codvendedor +'">'+data[i].name+' - '+ data[i].codvendedor +'</option>');
                                i++;
                            });
                        }
                    })
                }

                function getCondicion(){
                	$.ajax({
                        type: "get",
                        url: 'PedidosGetCondicion',
                        success: function (data) {
                            var i = 0;
                            $('#CondicionPago').append('<option value="" >Seleccione...</option>');
                            $(data).each(function (){
                              $('#CondicionPago').append('<option value="'+ data[i].DESC_36.trim() +'" >'+ data[i].DESC_36.trim() +'</option>');
                              i++
                            });
                        }
                    })
                }

                $('body').on('click', '.NewPed', function () {
                    $('#NewPedido').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $('#NewPedidoTitle').html('Nuevo pedido');
                    getUsers();
                    getCondicion();
                });

                $("#ProductoMax").autocomplete({
                    appendTo: "#NewPedido",
                    source: function (request, response) {
                        var Product = $("#ProductoMax").val();
                        $.ajax({
                            url: "/PedidosSearchProductsMax",
                            method: "get",
                            data: {
                            	query: Product,
                            },
                            dataType: "json",
                            success: function (data) {
                                var resp = $.map(data, function (obj) {
                                    return obj
                                });
                                response(resp);
                            }
                        })
                    },
                    focus: function (event, ui) {
                        $('#AddPrice').val([ui.item.PriceItem]);
                        $('#StockItem').val([ui.item.Stock]);
                        $('#CodigoProductoMax').val([ui.item.Code]);
                        $('#DescripcionProductoMax').val([ui.item.Descripcion]);

                        return true;
                    },
                    select: function (event, ui) {
                        $('#AddPrice').val([ui.item.PriceItem]);
                        $('#AddItem').prop("disabled", false);
                        $('#StockItem').val([ui.item.Stock]);
                        $('#CodigoProductoMax').val([ui.item.Code]);
                        $('#DescripcionProductoMax').val([ui.item.Descripcion]);
                    },
                    minlength: 2
                });

                $("#NombreCliente" ).autocomplete({
                    appendTo: "#NewPedido",
                    source: function (request, response) {
                        var client = $("#NombreCliente").val();
                        $.ajax({
                            url: "/SearchClients",
                            method: "get",
                            data: {
                                query: client,
                            },
                            dataType: "json",
                            success: function (data) {
                                var resp = $.map(data, function (obj) {
                                    return obj
                                });
                                console.log(data);
                                response(resp);
                            }
                        })
                    },
                    focus: function( event, ui ) {
                        $('#CodCliente').val([ui.item.CodigoCliente]);
                        $('#address').val([ui.item.Direccion]);
                        $('#city').val([ui.item.Ciudad]);
                        $('#phone').val([ui.item.Telefono]);
                        $('#CondicionPago').val([ui.item.Plazo]);
                        $('#descuento').val([ui.item.descuento]);

                      return true;
                    },
                    select: function(event, ui)	{
                        $('#CodCliente').val([ui.item.CodigoCliente]);
                        $('#address').val([ui.item.Direccion]);
                        $('#city').val([ui.item.Ciudad]);
                        $('#phone').val([ui.item.Telefono]);
                        $('#CondicionPago').val([ui.item.Plazo]);
                        $('#descuento').val([ui.item.descuento])
                    },
                    minlength: 2
                });

                function Calcular(){
                    var Cantidad = $('#AddQuantity').val();
                    var Precio = $('#AddPrice').val();
                    var Total = Cantidad * Precio;
                    $('#TotalItem').val(Total);
                }

                function CalcularIva(){
                	var Selectiva = $('#SelectIva').val();
                	var Subtotal= $('#TotalItemsSubtotal').val();
                	var Totaliva = Subtotal * 0.19;

                	console.log(Totaliva);
                	if(Selectiva == 0)
                	{
                        $('#TotalItemsIva').val('0');
                    }else{
                        $('#TotalItemsIva').val(Totaliva);
                    }
                }

                function LimpiarCampos(){
                    $('#ProductoMax').val('');
                    $('#AddNotes').val('');
                    $('#AddUnidad').val('Unidad');
                    $('#AddPrice').val(0);
                    $('#AddQuantity').val(1);
                    $('#TotalItem').val('');
                    $('#StockItem').val('')
                }

                function SumarItems(){
                    var totals=[0,0];
                    var $dataRows=$("#ItemsTable tr:not('.totalColumn, .titlerow')");
                    $dataRows.each(function() {
                        $(this).find('.rowDataSd').each(function(i){
                            totals[i]+=parseInt( $(this).html());
                        });
                    });
                    $("#TotalesTable td .totalCol").each(function(i){
                        $(this).val(totals[i]);
                    });
                }

                function CalcularDescuento(){
                	var desc = $('#descuento').val();
                	var bruto = $('#TotalItemsBruto').val();
                	var total = (desc / 100)* bruto;

                    $('#TotalItemsDiscount').val(total);
                }

                function CalcularSubtotal(){
                	var bruto = $('#TotalItemsBruto').val();
                	var desc  = $('#TotalItemsDiscount').val();
                	var subtotal = bruto - desc;
                	$('#TotalItemsSubtotal').val(subtotal);
                	console.log(bruto , desc);
                }

                function Totalpedido(){
					var subtotal = parseInt($('#TotalItemsSubtotal').val());
					var iva =  parseInt($('#TotalItemsIva').val());
					total = subtotal + iva;
					$('#TotalItemsPrice').val(total)
                }

                $('#AddQuantity').on('keyup', function () {
                	Calcular();
                });

                $('#AddPrice').on('keyup', function () {
                    Calcular();
                });

                $('#AddItem').click(function(){
                	var producto    = $('#DescripcionProductoMax').val();
                	var codigo      = $('#CodigoProductoMax').val();
                	var notas       = $('#AddNotes').val();
                	var unidad      = $('#AddUnidad').val();
                	var precio      = $('#AddPrice').val();
                	var cantidad    = $('#AddQuantity').val();
                	var total       = $('#TotalItem').val();

                	$('#ProductosAdd').append('<tr>' +
                      '<td class="ipcodproducto">'+ codigo +'</td>' +
                      '<td class="iproducto">'+ producto +'</td>' +
                      '<td class="inotas">'+ notas  +'</td>' +
                      '<td class="iunidad">'+ unidad +'</td>' +
                      '<td class="iprecio">'+ precio +'</td>' +
                      '<td class="rowDataSd icantidad">'+ cantidad +'</td>' +
                      '<td class="rowDataSd itotal">'+ total +'</td>' +
                      '<td style="align-content: center"><a href="javascript:void(0)" data-toggle="tooltip" data-id="'+ producto +'" data-original-title="Eliminar" class="btn btn-danger btn-sm BorrarItem"><i class="fas fa-trash"></i></a></td></tr> ');
                    LimpiarCampos();
                    SumarItems();
                    CalcularDescuento();
                    CalcularSubtotal();
                    CalcularIva();
                    Totalpedido();
                    $('#AddItem').prop("disabled", true);
                });

                $('body').on('click', '.BorrarItem', function () {
                    id = $(this).parents("tr").find("td").eq(0).html();
                    Swal.fire({
                        title: '¿Esta seguro de Eliminar?',
                        html: "¿Esta seguro de Eliminar  <br>" + "<b>"+ id +"</b>"+ "<br>" + "la lista de items?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, Eliminar!',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.value) {
                            $(this).parents("tr").fadeOut("normal", function () {
                                $(this).remove();
                                SumarItems();
                                CalcularDescuento();
                                CalcularSubtotal();
                                CalcularIva();
                                Totalpedido();
                            })
                        }
                    });

                });

                jQuery.extend(jQuery.validator.messages, {
                    required: "Este campo es obligatorio.",
                    remote: "Por favor, rellena este campo.",
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

                jQuery.validator.addMethod("selectcheck", function(value){
                    return (value != '');
                }, "Por favor, seleciona una opcion.");

                $("#FormPrincipal").validate({
                    ignore: "",
                    rules: {
                        NombreCliente: "required",
                        CodCliente: "required",
                        address: "required",
                        city: "required",
                        phone: "required",
                        CondicionPago: {selectcheck: true},
                        SelectIva: {selectcheck: true},
                        SelectVendedor: {selectcheck: true},
                    },
                    highlight: function (element) {
                        // Only validation controls
                        $(element).closest('.form-control').removeClass('is-valid').addClass('is-invalid');
                        //$('#saveBtn').html('Reintentar');
                    },
                    unhighlight: function (element) {
                        // Only validation controls
                        $(element).closest('.form-control').removeClass('is-invalid');
                    },

                    submitHandler: function (form) {
                    	var encabezado = [];
                        let Items = [];
                        var Inputs = {
                            NombreVendedor: NombreVendedor,
                        	CodVendedor: CodVenUsuario1,
                        	NombreCliente: $('#NombreCliente').val(),
                            OrdComp: $('#OrdComp').val(),
                            CodCliente: $('#CodCliente').val(),
                            address: $('#address').val(),
                            city: $('#city').val(),
                            phone: $('#phone').val(),
                            CondicionPago: $('#CondicionPago').val(),
                            descuento: $('#descuento').val(),
                            SelectIva: $('#SelectIva').val(),
                            TotalQuantityItems: $('#TotalQuantityItems').val(),
                            TotalItemsBruto: $('#TotalItemsBruto').val(),
                            TotalItemsDiscount: $('#TotalItemsDiscount').val(),
                            TotalItemsSubtotal: $('#TotalItemsSubtotal').val(),
                            TotalItemsIva: $('#TotalItemsIva').val(),
                            TotalItemsPrice: $('#TotalItemsPrice').val(),
                            GeneralNotes: $('#GeneralNotes').val()
                        };
                        encabezado.push(Inputs);


                        document.querySelectorAll('.ItemsTable tbody tr').forEach(function(e){
                            let fila = {
                                codproducto: e.querySelector('.ipcodproducto').innerText,
                                producto: e.querySelector('.iproducto').innerText,
                                notas: e.querySelector('.inotas').innerText,
                                unidad: e.querySelector('.iunidad').innerText,
                                precio: e.querySelector('.iprecio').innerText,
                                cantidad: e.querySelector('.icantidad').innerText,
                                total: e.querySelector('.itotal').innerText
                            };
                            Items.push(fila);
                            console.log(Items);
                        });

                        $.ajax({
                            data:{Items,encabezado},
                            url: "/SavePedido",
                            type: "POST",
                            dataType: 'json',
                            success: function (data) {
                                if (data.hasOwnProperty('error')) {
                                    /*toastr.error('SQLSTATE[' + data.error.code + ']: ¡El Producto ya existe!');*/
                                    if(data.error.code2 == 664)  {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: 'No puedes ingresar un pedido sin productos...',
                                        });
                                        $('#SavePed').html('Reintentar');
                                    }
                                }

                                else {
                                    $('#ProductForm').trigger("reset");
                                    $('#NewPedido').modal('hide');
                                    $('.dataTableP').DataTable().destroy();
                                    LoadTable();
                                    toastr.success("Registro Guardado con Exito!");
                                    $('#SavePed').html('Guardar');
                                }
                            },
                        });
                        return false; // required to block normal submit since you used ajax
                    }
                });

                $('#NewPedido').on('show.bs.modal', function (event) {
                    $('.form-control').removeClass('is-invalid');
                    $('#AddItem').prop("disabled", true);
                    $('.error').remove();
                    $('#NombreCliente').val('');
                    $('#OrdComp').val('');
                    $('#CodCliente').val('');
                    $('#address').val('');
                    $('#city').val('');
                    $('#phone').val('');
                    $('#CondicionPago').val('');
                    $('#descuento').val(0);
                    $('#SelectIva').val('');
                    $('#ProductoMax').val('');
                    $('#AddNotes').val('');
                    $('#AddUnidad').val('Unidad');
                    $('#AddPrice').val(0);
                    $('#AddQuantity').val(1);
                    $('#ProductosAdd').html('');
                    $('#SelectVendedor').html('');
                    $('#SavePed').html('Crear Pedido');

                });

                $('body').on('click', '.Promover', function (){
                    var id = $(this).attr("id");
                    $.ajax({
                        type: "get",
                        url: "/Estadopedido",
                        data: {id: id},
                        dataType: "json",
                        success: function (data) {
                            if(data[0].estado == 1 ){
                                Swal.fire({
                                    title: '¿Enviar a cartera?',
                                    text: "¡Tu pedido sera enviado al area de cartera!",
                                    icon: 'question',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: '¡Si, Enviar!',
                                    cancelButtonText: 'Cancelar'
                                }).then((result) => {
                                    if (result.value) {
                                        $.ajax({
                                            type: "post",
                                            url: "/PedidoPromoverCartera",
                                            data: {id: id},
                                            dataType: "json",
                                            success: function (data) {
                                                Swal.fire({
                                                    title: 'Enviado!',
                                                    text: "Tu pedido ha sido enviado con exito al area Cartera!.",
                                                    icon: 'success',
                                                });
                                                $('.dataTableP').DataTable().destroy();
                                                LoadTable();
                                            },
                                            error: function (data) {
                                                Swal.fire(
                                                    'Error al Enviar!',
                                                    'Hubo un error y tu pedido no pudo ser enviado al area de cartera',
                                                    'error'
                                                )
                                            }
                                        });
                                    }else if (
                                        result.dismiss === Swal.DismissReason.cancel
                                    )
                                    {
                                        Swal.fire(
                                            'Cancelado',
                                            'Tu pedido NO fue enviado a cartera. :)',
                                            'error'
                                        )
                                    }
                                })

                            }
                            if(data[0].estado == 0){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    html: 'Este pedido pedido esta '+'<b>' +'Anulado'+'</b>'+'!'+'<br>' +
                                      'Para poder enviar el pedido a '+'<b>' +'Cartera'+'</b>'+'<br>' +' debe estar en estado '+'<b>' +'Borrador'+'</b>'
                                })
                            }
                            if(data[0].estado == 2){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    html: 'Este pedido ya fue enviado a '+'<b>' +'CARTERA'+'!',
                                })
                            }
                            if(data[0].estado == 4){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    html: 'Este pedido ya fue enviado a '+'<b>' +'COSTOS'+'!',
                                })
                            }
                        }
                    });
                });

                $('body').on('click', '.Reopen', function () {
                    var id = $(this).attr("id");
                    $.ajax({
                        type: "get",
                        url: "/Estadopedido",
                        data: {id: id},
                        dataType: "json",
                        success: function (data) {
                            if(data[0].estado == 0 || data[0].estado == 3 || data[0].estado == 5 || data[0].estado == 7 || data[0].estado == 9){
                                Swal.fire({
                                    title: '¿Re-abrir pedido?',
                                    text: "¡El pedido quedarada en estado borrador y podra enviarlo al area de cartera!",
                                    icon: 'question',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: '¡Si, Re-abrir!',
                                    cancelButtonText: 'Cancelar'
                                }).then((result) => {
                                    if (result.value) {
                                        $.ajax({
                                            type: "post",
                                            url: "/PedidoReabrir",
                                            data: {id: id},
                                            dataType: "json",
                                            success: function (data) {
                                                Swal.fire({
                                                    title: 'Abierto!',
                                                    text: "El pedido ha sido re-abierto con exito!.",
                                                    icon: 'success',
                                                });
                                                $('.dataTableP').DataTable().destroy();
                                                LoadTable();
                                            },
                                            error: function (data) {
                                                Swal.fire(
                                                    'Error al re-abrir!',
                                                    'Hubo un error y el pedido no pudimos procesar tu solicitud',
                                                    'error'
                                                )
                                            }
                                        });
                                    }else if (
                                        result.dismiss === Swal.DismissReason.cancel
                                    )
                                    {
                                        Swal.fire(
                                            '¡Cancelado!',
                                            'Solicitud Cancelada...',
                                            'error'
                                        )
                                    }
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    html: 'No puedes reabrir un pedido si no ha sido '+'<b>' +'ANULADO'+'!',
                                })
                            }
                        }
                    })
                });

                $('body').on('click', '.Anular', function () {
                    var id = $(this).attr("id");
                    $.ajax({
                        type: "get",
                        url: "/Estadopedido",
                        data: {id: id},
                        dataType: "json",
                        success: function (data) {
                            if (data[0].estado <= 5) {
                                Swal.fire({
                                    title: '¿Cancelar pedido?',
                                    text: "¡Tu pedido sera cancelado, ¿Estas seguro?",
                                    icon: 'question',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Si, Cancelar!',
                                    cancelButtonText: 'Volver'
                                }).then((result) => {
                                    if (result.value) {
                                        $.ajax({
                                            type: "post",
                                            url: "/PedidoAnular",
                                            data: {id: id},
                                            dataType: "json",
                                            success: function (data) {
                                                Swal.fire({
                                                    title: 'Cancelado!',
                                                    text: "Tu pedido ha sido Cancelado!.",
                                                    icon: 'success',
                                                });
                                                $('.dataTableP').DataTable().destroy();
                                                LoadTable();
                                            },
                                            error: function (data) {
                                                Swal.fire(
                                                    'Houston tenemos problemas!',
                                                    'Hubo un error y no pudimos procesar tu solicitud...',
                                                    'error'
                                                )
                                            }
                                        });
                                    }else if (
                                        result.dismiss === Swal.DismissReason.cancel
                                    )
                                    {
                                        Swal.fire(
                                            'Peticion cancelada!',
                                            'Tu pedido NO fue Cancelado. :)',
                                            'info'
                                        )
                                    }
                                })
                            }
                            if(data[0].estado == 0){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    html: 'No puedes Anular este pedido por que ya ha sido '+'<b>' +'ANULADO'+'!',
                                })
                            }
                        }

                    })
                });

                $('body').on('click', '.Viewpdf', function () {
                    var id = $(this).attr("id");
                    $.ajax({
                        type: "get",
                        url: "/ImprimirPedidoPdf",
                        data: {id: id},
                        dataType: "json",
                        success: function (data) {
                        	console.log(data[1]);
                        	if(data != null){
                                $('#PdfTitle').html('Pedido #'+data[0][0]['id']);
                                $('#PdfCliente').html(data[0][0]['NombreCliente']);
                                $('#Pdffecha').html(data[0][0]['created_at']);
                                $('#PdfCodigoCliente').html(data[0][0]['CodCliente']);
                                $('#PdfCity').html(data[0][0]['Ciudad']);
                                $('#PdfAddress').html(data[0][0]['DireccionCliente']);
                                $('#PdfPhone').html(data[0][0]['Telefono']);
                                $('#PdfNumeroPedio').html(data[0][0]['id']);
                                $('#PdfOrdenCompra').html(data[0][0]['OrdenCompra']);
                                $('#PdfVendedor').html(data[0][0]['NombreVendedor']);
                                $('#PdfCondicionPago').html(data[0][0]['CondicionPago']);
                                $('#PdfGeneralNotes').html(data[0][0]['Notas']);
                                $('#PdfBrutoInvoice').html(data[0][0]['Bruto']);
                                $('#PdfDescuentoInvoice').html(data[0][0]['TotalDescuento']);
                                $('#PdfSubtotalInvoice').html(data[0][0]['TotalSubtotal']);
                                $('#PdfIvaInvoice').html(data[0][0]['TotalIVA']);
                                $('#PdfTotalInvoice').html(data[0][0]['TotalPedido']);

                                if(data[0][0]['Estado'] == 1){
                                    document.getElementById("ProgressPed").style.width="10%";
                                    $('#ProgressPed').html('10%');
                                    $('#ProgressPed').addClass('bg-success');
                                }

                                if(data[0][0]['Estado'] == 2 && data[0][0]['Cartera'] == 2){
                                    document.getElementById("ProgressPed").style.width="25%";
                                    $('#ProgressPed').html('25%');
                                    $('#ProgCartera').addClass('active');
                                    document.getElementById("StepCartera").style.color="green";
                                    $('#ProgressPed').addClass('bg-success');
                                }

                                if(data[0][0]['Estado'] == 2 && data[0][0]['Cartera'] == 3.1){
                                    document.getElementById("ProgressPed").style.width="30%";
                                    $('#ProgressPed').html('30%');
                                    $('#ProgCartera').addClass('active');
                                    document.getElementById("StepCartera").style.color="green";
                                    $('#ProgressPed').addClass('bg-warning');
                                }

                                if(data[0][0]['Estado'] == 2 && data[0][0]['Cartera'] == 3.2){
                                    document.getElementById("ProgressPed").style.width="30%";
                                    $('#ProgressPed').html('30%');
                                    $('#ProgCartera').addClass('active');
                                    document.getElementById("StepCartera").style.color="green";
                                    $('#ProgressPed').addClass('bg-warning');
                                }

                                if(data[0][0]['Estado'] == 3 && data[0][0]['Cartera'] == 3){
                                    document.getElementById("ProgressPed").style.width="30%";
                                    $('#ProgressPed').html('30%');
                                    $('#ProgCartera').addClass('active');
                                    document.getElementById("StepCartera").style.color="green";
                                    $('#ProgressPed').addClass('bg-danger');
                                } //ok

                                if(data[0][0]['Estado'] == 4 && data[0][0]['Costos'] == 4){
                                    document.getElementById("ProgressPed").style.width="50%";
                                    $('#ProgressPed').html('50%');
                                    $('#ProgCartera').addClass('active');
                                    document.getElementById("StepCartera").style.color="green";
                                    $('#ProgCostos').addClass('active');
                                    document.getElementById("StepCostos").style.color="green";
                                    $('#ProgressPed').addClass('bg-success');
                                }

                                if(data[0][0]['Estado'] == 5 && data[0][0]['Costos'] == 5){
                                    document.getElementById("ProgressPed").style.width="50%";
                                    $('#ProgressPed').html('50%');
                                    $('#ProgCartera').addClass('active');
                                    document.getElementById("StepCartera").style.color="green";
                                    $('#ProgCostos').addClass('active');
                                    document.getElementById("StepCostos").style.color="green";
                                    $('#ProgressPed').addClass('bg-danger');
                                }

                                if(data[0][0]['Estado'] == 6 && data[0][0]['Produccion'] == 6 ){
                                    document.getElementById("ProgressPed").style.width="75%";
                                    $('#ProgressPed').html('75%');
                                    $('#ProgCartera').addClass('active');
                                    document.getElementById("StepCartera").style.color="green";
                                    $('#ProgCostos').addClass('active');
                                    document.getElementById("StepCostos").style.color="green";
                                    $('#ProgProduccion').addClass('active');
                                    document.getElementById("StepProduccion").style.color="green";
                                    $('#ProgressPed').addClass('bg-success');
                                }

                                if(data[0][0]['Estado'] == 7 && data[0][0]['Produccion'] == 7 ){
                                    document.getElementById("ProgressPed").style.width="75%";
                                    $('#ProgressPed').html('75%');
                                    $('#ProgCartera').addClass('active');
                                    document.getElementById("StepCartera").style.color="green";
                                    $('#ProgCostos').addClass('active');
                                    document.getElementById("StepCostos").style.color="green";
                                    $('#ProgProduccion').addClass('active');
                                    document.getElementById("StepProduccion").style.color="green";
                                    $('#ProgressPed').addClass('bg-danger');
                                }

                                if(data[0][0]['Estado'] == 8 && data[0][0]['Bodega'] == 8){
                                    document.getElementById("ProgressPed").style.width="90%";
                                    $('#ProgressPed').html('90%');
                                    $('#ProgCartera').addClass('active');
                                    document.getElementById("StepCartera").style.color="green";
                                    $('#ProgCostos').addClass('active');
                                    document.getElementById("StepCostos").style.color="green";
                                    $('#ProgProduccion').addClass('active');
                                    document.getElementById("StepProduccion").style.color="green";
                                    $('#ProgBodega').addClass('active');
                                    document.getElementById("StepBodega").style.color="green";
                                    $('#ProgressPed').addClass('bg-success');
                                }

                                if(data[0][0]['Estado'] == 9 && data[0][0]['Bodega'] == 9){
                                    document.getElementById("ProgressPed").style.width="90%";
                                    $('#ProgressPed').html('90%');
                                    $('#ProgCartera').addClass('active');
                                    document.getElementById("StepCartera").style.color="green";
                                    $('#ProgCostos').addClass('active');
                                    document.getElementById("StepCostos").style.color="green";
                                    $('#ProgProduccion').addClass('active');
                                    document.getElementById("StepProduccion").style.color="green";
                                    $('#ProgBodega').addClass('active');
                                    document.getElementById("StepBodega").style.color="green";
                                    $('#ProgressPed').addClass('bg-success');
                                }

                                if(data[0][0]['Estado'] == 10){
                                    document.getElementById("ProgressPed").style.width="100%";
                                    $('#ProgressPed').html('100%');
                                    $('#ProgCartera').addClass('active');
                                    document.getElementById("StepCartera").style.color="green";
                                    $('#ProgCostos').addClass('active');
                                    document.getElementById("StepCostos").style.color="green";
                                    $('#ProgProduccion').addClass('active');
                                    document.getElementById("StepProduccion").style.color="green";
                                    $('#ProgBodega').addClass('active');
                                    document.getElementById("StepBodega").style.color="green";
                                    $('#ProgressPed').addClass('bg-success');
                                }

                                var i = 0;
                                $(data[1]).each(function () {
                                    $('#ItemsInvoice').append('<tr>' +
                                        '<td style="text-align: center">'+ data[1][i].CodigoProducto +'</td>' +
                                        '<td style="text-align: center">'+ data[1][i].Descripcion +'</td>' +
                                        '<td style="text-align: center">'+ data[1][i].Notas +'</td>' +
                                        '<td style="text-align: center">'+ data[1][i].Unidad +'</td>' +
                                        '<td style="text-align: right">'+ data[1][i].Cantidad +'</td>' +
                                        '<td style="text-align: right">'+ data[1][i].Precio +'</td>' +
                                        '<td style="text-align: right">'+ data[1][i].Total +'</td>' +
                                        '</tr>'
                                    );
                                	i++;
                                });
                                $('#PdfView').modal({
                                    backdrop: 'static',
                                    keyboard: false,
                                });
                            }
                        	else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    html: 'Hubo un error al cargar los datos del pedido...!',
                                })
                            }
                        }
                    })
                });

                function imprimirElemento(elemento) {
                    var ventana =  window.open('Print','','width=900');
                    ventana.document.write('<html><head><title>' + document.title + '</title>');
                    ventana.document.write('<link rel="stylesheet" href="http://evpiu.test/dashboard/styles/app.css">' +
                      ' <link rel="stylesheet" href="http://evpiu.test/dashboard/styles/main.css">');
                    ventana.document.write('</head><body >');
                    ventana.document.write(elemento.innerHTML);
                    ventana.document.write('</body></html>');
                    ventana.document.close();
                    ventana.focus();
                    ventana.onload = function() {
                        ventana.print();
                        ventana.close();
                    };
                    return true;
                }

                document.querySelector("#ImprimirPdf").addEventListener("click", function() {
                    var div = document.querySelector("#TextoImprimir");
                    imprimirElemento(div);
                });

                $('body').on('click', '.Cerrar', function () {
                    $('#PdfTitle').html('');
                    $('#PdfCliente').html('');
                    $('#Pdffecha').html('');
                    $('#PdfCodigoCliente').html('');
                    $('#PdfCity').html('');
                    $('#PdfAddress').html('');
                    $('#PdfPhone').html('');
                    $('#PdfNumeroPedio').html('');
                    $('#PdfOrdenCompra').html('');
                    $('#PdfVendedor').html('');
                    $('#PdfCondicionPago').html('');
                    $('#ItemsInvoice').html('')
                    document.getElementById("ProgressPed").style.width="0%";
                    $('#ProgressPed').html('0%');
                    $('#ProgCartera').removeClass('active');
                    document.getElementById("StepCartera").style.color="black";
                    $('#ProgCostos').removeClass('active');
                    document.getElementById("StepCostos").style.color="black";
                    $('#ProgProduccion').removeClass('active');
                    document.getElementById("StepProduccion").style.color="black";
                    $('#ProgBodega').removeClass('active');
                    document.getElementById("StepBodega").style.color="black";
                    $('#ProgressPed').removeClass('bg-success');
                    $('#ProgressPed').removeClass('bg-warning');
                    $('#ProgressPed').removeClass('bg-danger');

                });

                $('body').on('click', '.StepCartera', function (){
                	var id = $('#PdfNumeroPedio').html();
                    $.ajax({
                        url: "/getStep",
                        type: "get",
                        data: {
                            id: id
                        },
                        success: function (data) {
                            if(data[0]['Cartera'] == 2){
                                Swal.fire({
                                    title: 'Cartera',
                                    html: '<b>Estado:</b> '+ 'Pendiente por aprobacion' + '<br>',
                                    icon: 'info',
                                    confirmButtonText: 'Aceptar',
                                    timer: 10000,
                                    showClass: {
                                        popup: 'animated bounceIn'
                                    },
                                    hideClass: {
                                        popup: 'animated zoomOut'
                                    }
                                })
                            }
                            if(data[0]['Cartera'] == 3){
                                Swal.fire({
                                    title: 'Cartera',
                                    html: '<b>Estado:</b> '+ 'Rechazado' + '<br>' + '<b>Descripcion:</b> ' + data[0]['DetalleCartera'],
                                    icon: 'info',
                                    confirmButtonText: 'Aceptar',
                                    timer: 10000,
                                    showClass: {
                                        popup: 'animated bounceIn'
                                    },
                                    hideClass: {
                                        popup: 'animated zoomOut'
                                    }
                                })
                            }
                            if(data[0]['Cartera'] == 3.1){
                                Swal.fire({
                                    title: 'Cartera',
                                    html: '<b>Estado Cartera:</b> '+ 'En estudio de Cartera' + '<br>' + '<b>Descripcion:</b> ' + data[0]['DetalleCartera'],
                                    icon: 'info',
                                    confirmButtonText: 'Aceptar',
                                    timer: 10000,
                                    showClass: {
                                        popup: 'animated bounceIn'
                                    },
                                    hideClass: {
                                        popup: 'animated zoomOut'
                                    }
                                })
                            }
                            if(data[0]['Cartera'] == 3.2){
                                Swal.fire({
                                    title: 'Cartera',
                                    html: '<b>Estado Cartera:</b> '+ 'Retenido por Cartera' + '<br>' + '<b>Descripcion:</b> ' + data[0]['DetalleCartera'],
                                    icon: 'info',
                                    confirmButtonText: 'Aceptar',
                                    timer: 10000,
                                    showClass: {
                                        popup: 'animated bounceIn'
                                    },
                                    hideClass: {
                                        popup: 'animated zoomOut'
                                    }
                                })
                            }
                            if(data[0]['Cartera'] == 4){
                                Swal.fire({
                                    title: 'Cartera',
                                    html: '<b>Estado Cartera:</b> '+ 'Completado!' + '<br>' + '<b>Descripcion:</b> ' + data[0]['DetalleCartera'],
                                    icon: 'info',
                                    confirmButtonText: 'Aceptar',
                                    timer: 10000,
                                    showClass: {
                                        popup: 'animated bounceIn'
                                    },
                                    hideClass: {
                                        popup: 'animated zoomOut'
                                    }
                                })
                            }
                            if(data[0]['Cartera'] == null){
                                Swal.fire({
                                    title: 'Cartera',
                                    html: 'Este pedido no ha sido enviado a Cartera.',
                                    icon: 'error',
                                    confirmButtonText: 'Aceptar',
                                    timer: 10000,
                                    showClass: {
                                        popup: 'animated bounceIn'
                                    },
                                    hideClass: {
                                        popup: 'animated zoomOut'
                                    }
                                })
                            }
                        }
                    });
                });

                $('body').on('click', '.StepCostos', function(){
                	var id = $('#PdfNumeroPedio').html();
                	$.ajax({
                        url: "/getStep",
                        type: "get",
                        data: {
                            id: id
                        },
                        success: function (data) {
                            if(data[0]['Costos'] == 4){
                                Swal.fire({
                                    title: 'Costos',
                                    html: '<b>Estado:</b> '+ 'Pendiente por aprobacion' + '<br>',
                                    icon: 'info',
                                    confirmButtonText: 'Aceptar',
                                    timer: 10000,
                                    showClass: {
                                        popup: 'animated bounceIn'
                                    },
                                    hideClass: {
                                        popup: 'animated zoomOut'
                                    }
                                })
                            }
                            if(data[0]['Costos'] == 5){
                                Swal.fire({
                                    title: 'Costos',
                                    html: '<b>Estado:</b> '+ 'Rechazado' + '<br>' + '<b>Descripcion:</b> ' + data[0]['DetalleCostos'],
                                    icon: 'info',
                                    confirmButtonText: 'Aceptar',
                                    timer: 10000,
                                    showClass: {
                                        popup: 'animated bounceIn'
                                    },
                                    hideClass: {
                                        popup: 'animated zoomOut'
                                    }
                                })
                            }
                            if(data[0]['Costos'] == 6){
                                Swal.fire({
                                    title: 'Costos',
                                    html: '<b>Estado:</b> '+ 'Aprobado!' + '<br>' + '<b>Descripcion:</b> ' + data[0]['DetalleCostos'],
                                    icon: 'info',
                                    confirmButtonText: 'Aceptar',
                                    timer: 10000,
                                    showClass: {
                                        popup: 'animated bounceIn'
                                    },
                                    hideClass: {
                                        popup: 'animated zoomOut'
                                    }
                                })
                            }
                            if(data[0]['Costos'] == null){
                                Swal.fire({
                                    title: 'Cartera',
                                    html: 'Este pedido no ha sido enviado a Costos.',
                                    icon: 'error',
                                    confirmButtonText: 'Aceptar',
                                    timer: 10000,
                                    showClass: {
                                        popup: 'animated bounceIn'
                                    },
                                    hideClass: {
                                        popup: 'animated zoomOut'
                                    }
                                })
                            }
                        }
                    })
                });

                $('body').on('click', '.StepProduccion', function() {
                    var id = $('#PdfNumeroPedio').html();
                    $.ajax({
                        url: "/getStep",
                        type: "get",
                        data: {
                            id: id
                        },
                        success: function (data) {
                            if(data[0]['Produccion'] == 6){
                                Swal.fire({
                                    title: 'Produccion',
                                    html: '<b>Estado:</b> '+ 'Pendiente por aprobacion' + '<br>',
                                    icon: 'info',
                                    confirmButtonText: 'Aceptar',
                                    timer: 10000,
                                    showClass: {
                                        popup: 'animated bounceIn'
                                    },
                                    hideClass: {
                                        popup: 'animated zoomOut'
                                    }
                                })
                            }
                            if(data[0]['Produccion'] == 7){
                                Swal.fire({
                                    title: 'Produccion',
                                    html: '<b>Estado:</b> '+ 'Rechazado' + '<br>' + '<b>Descripcion:</b> ' + data[0]['DetalleProduccion'],
                                    icon: 'info',
                                    confirmButtonText: 'Aceptar',
                                    timer: 10000,
                                    showClass: {
                                        popup: 'animated bounceIn'
                                    },
                                    hideClass: {
                                        popup: 'animated zoomOut'
                                    }
                                })
                            }
                            if(data[0]['Produccion'] == 8){
                                Swal.fire({
                                    title: 'Produccion',
                                    html: '<b>Estado:</b> '+ 'Aprobado!' + '<br>' + '<b>Descripcion:</b> ' + data[0]['DetalleProduccion'],
                                    icon: 'info',
                                    confirmButtonText: 'Aceptar',
                                    timer: 10000,
                                    showClass: {
                                        popup: 'animated bounceIn'
                                    },
                                    hideClass: {
                                        popup: 'animated zoomOut'
                                    }
                                })
                            }
                            if(data[0]['Produccion'] == null){
                                Swal.fire({
                                    title: 'Produccion',
                                    html: 'Este pedido no ha sido enviado a Produccion.',
                                    icon: 'error',
                                    confirmButtonText: 'Aceptar',
                                    timer: 10000,
                                    showClass: {
                                        popup: 'animated bounceIn'
                                    },
                                    hideClass: {
                                        popup: 'animated zoomOut'
                                    }
                                })
                            }
                        }
                    })
                });

                $('body').on('click', '.StepBodega', function() {
                    var id = $('#PdfNumeroPedio').html();
                    $.ajax({
                        url: "/getStep",
                        type: "get",
                        data: {
                            id: id
                        },
                        success: function (data) {
                            if(data[0]['Bodega'] == 8){
                                Swal.fire({
                                    title: 'Bodega',
                                    html: '<b>Estado:</b> '+ 'Pendiente por aprobacion' + '<br>',
                                    icon: 'info',
                                    confirmButtonText: 'Aceptar',
                                    timer: 10000,
                                    showClass: {
                                        popup: 'animated bounceIn'
                                    },
                                    hideClass: {
                                        popup: 'animated zoomOut'
                                    }
                                })
                            }
                            if(data[0]['Bodega'] == 9){
                                Swal.fire({
                                    title: 'Bodega',
                                    html: '<b>Estado:</b> '+ 'Rechazado' + '<br>' + '<b>Descripcion:</b> ' + data[0]['DetalleBodega'],
                                    icon: 'info',
                                    confirmButtonText: 'Aceptar',
                                    timer: 10000,
                                    showClass: {
                                        popup: 'animated bounceIn'
                                    },
                                    hideClass: {
                                        popup: 'animated zoomOut'
                                    }
                                })
                            }
                            if(data[0]['Bodega'] == 10){
                                Swal.fire({
                                    title: 'Bodega',
                                    html: '<b>Estado:</b> '+ 'Pedido Completado!' + '<br>' + '<b>Descripcion:</b> ' + data[0]['DetalleBodega'],
                                    icon: 'info',
                                    confirmButtonText: 'Aceptar',
                                    timer: 10000,
                                    showClass: {
                                        popup: 'animated bounceIn'
                                    },
                                    hideClass: {
                                        popup: 'animated zoomOut'
                                    }
                                })
                            }
                            if(data[0]['Bodega'] == null){
                                Swal.fire({
                                    title: 'Bodega',
                                    html: 'Este pedido no ha sido enviado a Produccion.',
                                    icon: 'error',
                                    confirmButtonText: 'Aceptar',
                                    timer: 10000,
                                    showClass: {
                                        popup: 'animated bounceIn'
                                    },
                                    hideClass: {
                                        popup: 'animated zoomOut'
                                    }
                                })
                            }
                        }
                    })
                });
            })
        </script>

        <link href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.css" rel="stylesheet"/>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/js/bootstrap.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.3.10/dist/sweetalert2.all.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">



    @endpush
@stop
