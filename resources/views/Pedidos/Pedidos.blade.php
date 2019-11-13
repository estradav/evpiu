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
                                        <th>Pedido</th>
                                        <th>Orden de Compra</th>
                                        <th>Codigo Cliente</th>
                                        <th>Nombre Cliente</th>
                                        <th>Direccion</th>
                                        <th>Ciudad</th>
                                        <th>Telefono</th>
                                        <th>Vendedor</th>
                                        <th>Condiciones de pago</th>
                                        <th>Descuento</th>
                                        <th>IVA</th>
                                        <th>Estado</th>
                                        <th>Fecha Creacion</th>
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
                                        <label for="name" class="control-label" ><b>Descuento:&nbsp;&nbsp;</b></label>
                                        <input type="text" class="form-control" value="0" id="descuento">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="name" class="control-label" ><b>IVA:&nbsp;&nbsp;</b></label>
                                        <select name="SelectIva" id="SelectIva" class="form-control">
                                            <option value="" selected>Seleccione...</option>
                                            <option value="Y">Si</option>
                                            <option value="N">No</option>
                                        </select>
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
                                                    <th>Productos</th>
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
                            {data: 'DireccionCliente', name: 'DireccionCliente', orderable: false, searchable: false},
                            {data: 'Ciudad', name: 'Ciudad', orderable: false, searchable: false},
                            {data: 'Telefono', name: 'Telefono', orderable: false, searchable: false},
                            {data: 'NombreVendedor', name: 'NombreVendedor', orderable: false, searchable: false},
                            {data: 'CondicionPago', name: 'CondicionPago', orderable: false, searchable: false},
                            {data: 'Descuento', name: 'Descuento', orderable: false, searchable: false},
                            {data: 'Iva', name: 'Iva', orderable: false, searchable: false},
                            {data: 'Estado', name: 'Estado', orderable: false, searchable: false},
                            {data: 'created_at', name: 'created_at', orderable: false, searchable: false},

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
                                $(row).find('td:eq(11)').html('<label class="alert-success">Borrador</label>');
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
                    	return true;
                    },
                    select: function (event, ui) {
                        $('#AddPrice').val([ui.item.PriceItem]);
                        $('#AddItem').prop("disabled", false);
                        $('#StockItem').val([ui.item.Stock]);
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
                	var producto    = $('#ProductoMax').val();
                	var notas       = $('#AddNotes').val();
                	var unidad      = $('#AddUnidad').val();
                	var precio      = $('#AddPrice').val();
                	var cantidad    = $('#AddQuantity').val();
                	var total       = $('#TotalItem').val();

                	$('#ProductosAdd').append('<tr><td class="iproducto">'+ producto +'</td> ' +
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
                    respuesta = confirm("Desea eliminar Item: " + id);
                    if (respuesta) {
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
                        };
                        encabezado.push(Inputs);


                        document.querySelectorAll('.ItemsTable tbody tr').forEach(function(e){
                            let fila = {
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
                                    toastr.error('SQLSTATE[' + data.error.code + ']: ¡El Producto ya existe!');
                                    $('#saveBtn').html('Reintentar');
                                    console.log(encabezado);
                                }
                                else {
                                    $('#ProductForm').trigger("reset");
                                    $('#NewPedido').modal('hide');
                                    $('.dataTableP').DataTable().destroy();
                                    LoadTable();
                                    toastr.success("Registro Guardado con Exito!");
                                    $('#saveBtn').html('Guardar');
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
                });
            });
        </script>
        <link href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.css" rel="stylesheet"/>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/js/bootstrap.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    @endpush
@stop
