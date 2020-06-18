@extends('layouts.architectui')

@section('page_title', 'Editar Pedido')

@section('content')
    @can('pedidos.edit')
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-note2 icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>Pedido #{{$encabezado->id}}
                        <div class="page-title-subheading">
                            {{$encabezado->NombreCliente}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <form id="ProductForm" name="ProductForm">
                            <input type="text" value="{{$encabezado->id}}" style="display: none !important;" id="id" name="id">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <b>Vendedor:&nbsp;&nbsp; </b>
                                        <select name="vendedor" id="vendedor" class="form-control" disabled>
                                            <option value="{{$encabezado->CodVendedor}}">{{$encabezado->NombreVendedor }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <b>Nombre Cliente:&nbsp;&nbsp;</b>
                                        <input type="text" class="form-control" id="NombreCliente" name="NombreCliente" value="{{$encabezado->NombreCliente}}" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <b>Orden de Compra:&nbsp;&nbsp;</b>
                                        <input type="text" class="form-control"  id="OrdComp" name="OrdComp" value="{{$encabezado->OrdenCompra}}">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <b>Codigo Cliente:&nbsp;&nbsp;</b>
                                        <input type="text" class="form-control" id="CodCliente" name="CodCliente" value="{{$encabezado->CodCliente}}" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <b>Direccion:&nbsp;&nbsp;</b>
                                        <input type="text" class="form-control" id="address" name="address" value="{{$encabezado->DireccionCliente}}" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <b>Ciudad:&nbsp;&nbsp;</b>
                                        <input type="text" class="form-control" id="city" name="city" value="{{$encabezado->Ciudad}}" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <b>Telefono:&nbsp;&nbsp;</b>
                                        <input type="text" class="form-control" id="phone" name="phone" value="{{$encabezado->Telefono}}" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <b>Condicion de pago:&nbsp;&nbsp;</b>
                                        <select name="CondicionPago" id="CondicionPago" class="form-control" disabled >
                                            <option value="{{$encabezado->CondicionPago}}">{{$encabezado->CondicionPago}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <b>Descuento:&nbsp;&nbsp;</b>
                                        <input type="text" class="form-control" value="{{$encabezado->Descuento}}" id="descuento">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <b>IVA:&nbsp;&nbsp;</b>
                                        <select name="SelectIva" id="SelectIva" class="form-control">
                                            <option value="" selected>Seleccione...</option>
                                            <option value="Y" {{ $encabezado->Iva == 'Y' ? 'selected' : '' }}>Si</option>
                                            <option value="N" {{ $encabezado->Iva == 'N' ? 'selected' : '' }}>No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <b>Notas Generales:</b>
                                        <textarea name="GeneralNotes" id="GeneralNotes" cols="71" rows="2" class="form-control">{{$encabezado->Notas}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <b>Stock:</b> <label id="StockItem" name="StockItem"></label>
                        <form id="add_items_form" name="add_items_form">
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th style="width: 25%">Producto</th>
                                        <th style="width: 10%">Destino</th>
                                        <th>N/R</th>
                                        <th style="width: 12%">Arte</th>
                                        <th style="width: 10%">Notas</th>
                                        <th style="width: 10%">Unidad</th>
                                        <th style="width: 8%">Precio</th>
                                        <th style="width: 10%">Cantidad</th>
                                        <th style="width: 17%">Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <input type="hidden" value="" id="CodigoProductoMax" name="CodigoProductoMax">
                                        <input type="hidden" value="" id="DescripcionProductoMax" name="DescripcionProductoMax">
                                        <td style="width: 20% !important; ">
                                            <input type="text" id="ProductoMax" name="ProductoMax" class="form-control">
                                        </td>
                                        <td style="width: 10%">
                                            <select name="dest_item" id="dest_item" class="form-control">
                                                <option value="" selected>Seleccione..</option>
                                                <option value="Produccion">Produccion</option> //ojo validar value 1
                                                <option value="Bodega">Bodega</option> // ojo value 2
                                            </select>
                                        </td>
                                        <td style="width: 7%">
                                            <select name="n_r" id="n_r" class="form-control" required>
                                                <option value="" selected>Seleccione..</option>
                                                <option value="Nuevo">Nuevo</option>
                                                <option value="Repro">Repro.</option>
                                            </select>
                                        </td>
                                        <td style="width: 12%">
                                            <input type="text" id="AddArt" name="AddArt" class="form-control">
                                        </td>
                                        <td style="width: 10%">
                                            <input type="text" id="AddNotes" name="AddNotes" class="form-control">
                                        </td>
                                        <td style="width: 10%">
                                            <select name="AddUnidad" id="AddUnidad" class="form-control">
                                                <option value="Unidad" selected >Unidad</option>
                                                <option value="Kilos">Kilos</option>
                                                <option value="Millar">Millar</option>
                                            </select>
                                        </td>
                                        <td style="width: 8%">
                                            <input type="number" id="AddPrice" name="AddPrice" class="form-control">
                                        </td>
                                        <td style="width: 10%">
                                            <input type="number" id="AddQuantity" name="AddQuantity" class="form-control" value="1">
                                        </td>
                                        <td style="width: 21%">
                                            <input type="text" id="TotalItem" name="TotalItem" class="form-control" readonly="readonly" value="0">
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-success btn-sm" id="AddItem" disabled><i class="fa fa-plus"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-bordered table-sm ItemsTable" id="ItemsTable">
                                <thead>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Descripcion</th>
                                        <th>Dest.</th>
                                        <th>N/R</th>
                                        <th>Arte</th>
                                        <th>Notas</th>
                                        <th>Unidad</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th>Total</th>
                                        <th></th>
                                        <th style="display: none !important;"></th>
                                    </tr>
                                </thead>
                                <tbody id="ProductosAdd">
                                    @foreach($detalle as $d)
                                        <tr>
                                            <td class="ipcodproducto">{{ $d->CodigoProducto }}</td>
                                            <td class="iproducto">{{ $d->Descripcion }}</td>
                                            <td class="idestino">{{ $d->Destino == 1 ? 'Produccion': 'Bodega' }} </td>
                                            <td class="in_r"> {{ $d->R_N }}</td>
                                            <td class="iarte"><a href="javascript:void(0);" id="{{ $d->Arte }}" class="ViewArt">{{ $d->Arte }}</a></td>
                                            <td class="inotas">{{ $d->Notas }}</td>
                                            <td class="iunidad">{{ $d->Unidad }}</td>
                                            <td class="iprecio">{{ $d->Precio }}</td>
                                            <td class="rowDataSd icantidad">{{ $d->Cantidad }}</td>
                                            <td class="rowDataSd itotal">{{ $d->Total }}</td>
                                            <td style="align-content: center">
                                                <a href="javascript:void(0)" data-id="{{ $d->CodigoProducto }}" class="btn btn-danger btn-sm BorrarItem">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                            <td class="rowDataSd id" style="display: none !important;">{{ $d->id }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered first" id="TotalesTable">
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
                                        <td>
                                            <input type="number" class="form-control totalCol" id="TotalQuantityItems" name="TotalQuantityItems" value="" readonly="readonly">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control totalCol" id="TotalItemsBruto" name="TotalItemsBruto" value="{{$encabezado->Bruto}}" readonly="readonly">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" id="TotalItemsDiscount" name="TotalItemsDiscount" value="{{$encabezado->TotalDescuento}}" readonly="readonly">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" id="TotalItemsSubtotal" name="TotalItemsSubtotal" value="{{$encabezado->TotalSubtotal}}" readonly="readonly">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" id="TotalItemsIva" name="TotalItemsIva" value="{{$encabezado->TotalIVA}}" readonly="readonly">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" id="TotalItemsPrice" name="TotalItemsPrice" value="{{$encabezado->TotalPedido}}" readonly="readonly">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <button type="button" class="btn btn-primary btn-lg" id="SavePed">Actualizar Pedido</button>
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
@stop
@section('modal')
    <div class="modal fade bd-example-modal-lg" id="ViewArtModal" tabindex="-1" role="dialog" aria-labelledby="ViewArtModal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ViewArtTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="">
                    <div id="ViewArtPdf" style="height:750px;" ></div>
                </div>
                <div class="modal-footer" style="text-align: center !important;">
                    <button class="btn btn-primary" data-dismiss="modal" id="CloseViewArt">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('javascript')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
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
                    $('#StockItem').html([ui.item.Stock]);
                    $('#CodigoProductoMax').val([ui.item.Code]);
                    $('#DescripcionProductoMax').val([ui.item.Descripcion]);

                    return true;
                },
                select: function (event, ui) {
                    $('#AddPrice').val([ui.item.PriceItem]);
                    $('#AddItem').prop("disabled", false);
                    $('#StockItem').html([ui.item.Stock]);
                    $('#CodigoProductoMax').val([ui.item.Code]);
                    $('#DescripcionProductoMax').val([ui.item.Descripcion]);
                },
                minlength: 2
            });

            $("#AddArt").autocomplete({
                appendTo: "#NewPedido",
                source: function (request, response) {
                    var Product = $("#AddArt").val();
                    $.ajax({
                        url: "/SearchArts",
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
            });


            function Calcular(){
                const Cantidad = $('#AddQuantity').val();
                const Precio = $('#AddPrice').val();
                $('#TotalItem').val(Cantidad * Precio);
            }

            function CalcularIva(){
                const Selectiva = $('#SelectIva').val();
                const Subtotal = $('#TotalItemsSubtotal').val();

                if(Selectiva === 'N') {
                    $('#TotalItemsIva').val('0');
                }else{
                    $('#TotalItemsIva').val(Subtotal * 0.19);
                }
                Totalpedido();
            }

            function LimpiarCampos(){
                $('#ProductoMax').val('');
                $('#AddNotes').val('');
                $('#AddUnidad').val('Unidad');
                $('#dest_item').val('');
                $('#n_r').val('');
                $('#AddPrice').val(0);
                $('#AddQuantity').val(1);
                $('#StockItem').html('');
                $('#AddArt').val('');
                $('#TotalItem').val(0)
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
                var total = (desc / 100) * bruto;

                $('#TotalItemsDiscount').val(total);
            }

            function CalcularSubtotal(){
                var bruto = $('#TotalItemsBruto').val();
                var desc = $('#TotalItemsDiscount').val();
                var subtotal = bruto - desc;
                $('#TotalItemsSubtotal').val(subtotal);
            }

            function Totalpedido(){
                var subtotal = parseFloat($('#TotalItemsSubtotal').val());
                var iva =  parseFloat($('#TotalItemsIva').val());
                var total = subtotal + iva;
                $('#TotalItemsPrice').val(total)
            }


            $(document).on('keyup', '#AddQuantity', function () {
                Calcular();
            });

            $(document).on('keyup', '#AddPrice', function () {
                Calcular();
            });

            $('#add_items_form').validate({
                ignore: "",
                rules: {
                    n_r: {
                        selectcheck: true
                    },
                    dest_item: {
                        selectcheck: true
                    },
                    AddPrice: "required",
                    AddQuantity: "required"
                },
                errorPlacement: function(error,element) {
                    return true;
                },
                highlight: function (element) {
                    $(element).closest('.form-control').removeClass('is-valid').addClass('is-invalid');
                },
                unhighlight: function (element) {
                    $(element).closest('.form-control').removeClass('is-invalid');
                },

                submitHandler: function (form) {
                    const producto = $('#DescripcionProductoMax').val();
                    const codigo = $('#CodigoProductoMax').val();
                    const arte = $('#AddArt').val();
                    const notas = $('#AddNotes').val();
                    const unidad = $('#AddUnidad').val();
                    const precio = $('#AddPrice').val();
                    const cantidad = $('#AddQuantity').val();
                    const total = $('#TotalItem').val();
                    const destino = $('#dest_item').val();
                    const n_r = $('#n_r').val();



                    $('#ProductosAdd').append('<tr>' +
                        '<td class="ipcodproducto">'+ codigo +'</td>' +
                        '<td class="iproducto">'+ producto +'</td>' +
                        '<td class="idestino">'+ destino +'</td>' +
                        '<td class="in_r">'+ n_r +'</td>' +
                        '<td class="iarte">'+ '<a href="javascript:void(0);" id="'+arte+'" class="ViewArt">' + arte +'</a>' + '</td>' +
                        '<td class="inotas">'+ notas  +'</td>' +
                        '<td class="iunidad">'+ unidad +'</td>' +
                        '<td class="iprecio" contenteditable="true">'+ precio +'</td>' +
                        '<td class="rowDataSd icantidad" contenteditable="true">'+ cantidad +'</td>' +
                        '<td class="rowDataSd itotal">'+ total +'</td>' +
                        '<td style="align-content: center"><a href="javascript:void(0)" data-toggle="tooltip" data-id="'+ producto +'" data-original-title="Eliminar" class="btn btn-danger btn-sm BorrarItem"><i class="fas fa-trash"></i></a></td>' +
                        '<td class="rowDataSd id" style="display: none !important;"> </td>' +
                        '</tr> '
                    );
                    LimpiarCampos();
                    SumarItems();
                    CalcularDescuento();
                    CalcularSubtotal();
                    CalcularIva();
                    Totalpedido();
                    $('#AddItem').prop("disabled", true);

                    return false;
                }
            });

            $(document).on('click', '.BorrarItem', function () {
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

            $("#ProductForm").validate({
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
                    $(element).closest('.form-control').removeClass('is-valid').addClass('is-invalid');
                },
                unhighlight: function (element) {
                    $(element).closest('.form-control').removeClass('is-invalid');
                    //update_pedido

                },

            });



            $('#SavePed').click(function() {
                var form = $("#ProductForm").valid();
                if(form === true){
                    var encabezado = [];
                    let Items = [];
                    var Inputs = {
                        id: $('#id').val(),
                        CodVendedor: $('#SelectVendedor').val(),
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
                            arte: e.querySelector('.iarte').innerText,
                            notas: e.querySelector('.inotas').innerText,
                            unidad: e.querySelector('.iunidad').innerText,
                            precio: e.querySelector('.iprecio').innerText,
                            cantidad: e.querySelector('.icantidad').innerText,
                            total: e.querySelector('.itotal').innerText,
                            destino: e.querySelector('.idestino').innerText,
                            n_r: e.querySelector('.in_r').innerText,
                            id: e.querySelector('.id').innerText,
                        };
                        Items.push(fila);
                    });
                    $.ajax({
                        data:{Items,encabezado},
                        url: "/update_pedido",
                        type: "POST",
                        dataType: 'json',
                        success: function (data) {
                            if (data.hasOwnProperty('error')) {
                                /*toastr.error('SQLSTATE[' + data.error.code + ']: ¡El Producto ya existe!');*/
                                if(data.error.code2 === 664)  {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'No puedes ingresar un pedido sin productos...',
                                    });
                                    $('#SavePed').html('Reintentar');
                                }
                            }else {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Guardado!',
                                    text: 'El pedido fue actualizado con exito!',
                                });
                            }
                        },
                    });
                }else{
                    return false;
                }
            });





            $(document).on('click', '.ViewArt', function() {
                var Art = $(this).attr("id");
                $('#ViewArtTitle').html('Arte #'+ Art);
                PDFObject.embed('//192.168.1.12/intranet_ci/assets/Artes/'+Art+'.pdf', '#ViewArtPdf');
                $('#ViewArtModal').modal('show');
            });

            $(document).on('change', '#SelectIva', function () {
                CalcularIva();
            });

            $(document).on('change', '#descuento', function () {
                SumarItems();
                CalcularDescuento();
                CalcularSubtotal();
                CalcularIva();
                Totalpedido();
            });

        });
    </script>
@endpush
