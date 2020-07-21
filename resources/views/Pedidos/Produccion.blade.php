@extends('layouts.architectui')

@section('page_title', 'Pedidos (Produccion)')

@section('content')
    @can('pedidosProduccion.view')
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">
                        Pedidos pendientes
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-responsive table-striped table-sm dataTableP" id="table">
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
                                        <th>Sub Estado</th>
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


                <div class="main-card mb-3 card">
                    <div class="card-header">
                        Pedidos terminados
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-responsive table-striped table-sm" id="table_terminados">
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
    @else
        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-exclamation-triangle fa-4x" style="color: red"></i>
                <h3 class="card-title" style="color: red"> ACCESO DENEGADO </h3>
                <h3 class="card-text" style="color: red">No tiene permiso para usar esta aplicación, por favor comuníquese a la ext: 102 o escribanos al correo electrónico: auxsistemas@estradavelasquez.com para obtener acceso.</h3>
            </div>
        </div>
    @endcan
@endsection

@section('modal')
    <div class="modal fade" id="Options" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="PedidoTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" class="form-horizontal" id="FormCartera">
                    <div class="modal-body">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="EstadoPedido" class="control-label" ><b>Estado:&nbsp;&nbsp;</b></label>
                                <select name="EstadoPedido" id="EstadoPedido" class="form-control">
                                    <option value="" selected>Seleccione...</option>
                                    <option value="7">Rechazar y enviar al vendedor</option>
                                    <option value="8">Enviar a bodega</option>
                                    <option value="10">Finalizar</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="DescripccionPedido" class="control-label" ><b>Descripcion:&nbsp;&nbsp;</b></label>
                                <textarea name="DescripccionPedido" id="DescripccionPedido" cols="30" rows="5" class="form-control" placeholder="Por favor escriba una descripcion"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary Save_Est">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-xl" id="PdfView" tabindex="-1" role="dialog" aria-labelledby="PdfView" aria-hidden="true" style="overflow-y: scroll;">
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
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <h2 class="page-header">
                                        <img src="/img/Logo_v2.png" alt="" style="width: 195px !important; height: 142px !important;" class="headers">
                                        <small class="float-right">Fecha: <b><label id="Pdffecha"></label></b></small>
                                    </h2>
                                </div>
                            </div>
                            <div class="row invoice-info">
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 invoice-col">
                                    <address>
                                        <strong>CI Estrada Velasquez y CIA. SAS</strong><br>
                                        <b>NIT:</b> 890926617-8 <br>
                                        <b>Telefono:</b> 265-66-65<br>
                                        <b>Email:</b> Comercial@estradavelasquez.com <br>
                                        <b>Direccion:</b> KR 55 # 29 C 14 - Zona industrial de belen.
                                    </address>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 invoice-col">
                                    <address>
                                        <strong>Cliente: </strong><label id="PdfCliente"></label><br>
                                        <b>Codigo Cliente:</b> <label id="PdfCodigoCliente"></label> <br>
                                        <b>Ciudad:</b> <label id="PdfCity"></label><br>
                                        <b>Direccion:</b> <label id="PdfAddress"></label> <br>
                                        <b>Telefono:</b> <label id="PdfPhone"></label>
                                    </address>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 invoice-col">
                                    <b>Pedido #: </b><label id="PdfNumeroPedio"></label> <br>
                                    <b>Orden Compra: </b><label id="PdfOrdenCompra"></label> <br>
                                    <b>Condicion de pago: </b><label id="PdfCondicionPago"></label> <br>
                                    <b>Vendedor: </b><label id="PdfVendedor"></label>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm text-center">
                                        <thead>
                                        <tr>
                                            <th style="text-align: center">Codigo</th>
                                            <th style="text-align: center">Descripcion</th>
                                            <th>Destino</th>
                                            <th>R/N</th>
                                            <th style="text-align: center">Arte</th>
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
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
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
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 invoice-col">
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
@push('styles')
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
@endpush

@push('javascript')
    <script>
        $(document).ready(function(){
            var table;
            var CodVenUsuario1 =  @json( Auth::user()->codvendedor );
            var NombreVendedor = @json( Auth::user()->name );
            LoadTable();
            load_pedidos_terminados();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function LoadTable(CodVenUsuario = CodVenUsuario1, Estado = '4') {
                table = $('.dataTableP').DataTable({
                    processing: true,
                    serverSide: false,
                    searching: true,
                    paginate: true,
                    bInfo: true,
                    responsive: true,
                    ajax: {
                        url:'/PedidoProduccionIndex',
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
                        {data: 'SubEstado', name: 'SubEstado', orderable: false, searchable: false},
                        {data: 'created_at', name: 'created_at', orderable: false, searchable: false},
                        {data: 'opciones', name: 'opciones', orderable: false, searchable: false},

                    ],
                    language: {
                        url: '/Spanish.json'
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
                            $(row).find('td:eq(8)').html('<label class="alert-danger">Rechazado Costos</label>');
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
                        if (data.Iva == 'Y') {
                            $(row).find('td:eq(7)').html('<label>SI</label>');
                        }
                        else{
                            $(row).find('td:eq(7)').html('<label>NO</label>');
                        }
                        if(data.SubEstado == 6){
                            $(row).find('td:eq(9)').html('<label class="alert-success">Pendiente</label>');
                        }
                        if(data.SubEstado == 7){
                            $(row).find('td:eq(9)').html('<label class="alert-danger">Rechazado</label>');
                        }

                    }
                })
            }



            function load_pedidos_terminados() {
                $('#table_terminados').DataTable({
                    processing: true,
                    serverSide: false,
                    searching: true,
                    paginate: true,
                    bInfo: true,
                    responsive: true,
                    ajax: {
                        url:'/load_pedidos_terminados',
                    },
                    columns: [
                        {data: 'id', name: 'id', orderable: false, searchable: true},
                        {data: 'OrdenCompra', name: 'OrdenCompra', orderable: false, searchable: true},
                        {data: 'CodCliente', name: 'CodCliente', orderable: false, searchable: true},
                        {data: 'NombreCliente', name: 'NombreCliente', orderable: false, searchable: true},
                        {data: 'NombreVendedor', name: 'NombreVendedor', orderable: false, searchable: true},
                        {data: 'CondicionPago', name: 'CondicionPago', orderable: false, searchable: false},
                        {data: 'Descuento', name: 'Descuento', orderable: false, searchable: false, render: $.fn.dataTable.render.number('', '', 0, '% ')},
                        {data: 'Iva', name: 'Iva', orderable: false, searchable: false},
                        {data: 'Estado', name: 'Estado', orderable: false, searchable: true},
                        {data: 'created_at', name: 'created_at', orderable: false, searchable: false},
                        {data: 'opciones', name: 'opciones', orderable: false, searchable: false},

                    ],
                    language: {
                        url: '/Spanish.json'
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
                            $(row).find('td:eq(8)').html('<label class="alert-danger">Rechazado Costos</label>');
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
                            $(row).find('td:eq(8)').html('<label class="alert-success">Finalizado</label>');
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

            var id;

            $(document).on('click', '.Option', function () {
                id = $(this).attr("id");
                $('#Options').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $('#PedidoTitle').html('Pedido #'+ id)
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

            $("#FormCartera").validate({
                ignore: "",
                rules: {
                    EstadoPedido: {selectcheck: true},
                    DescripccionPedido: {
                        required: true,
                        minlength: 10,
                        maxlength: 250
                    }

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
                    $.ajax({
                        data: {
                            id: id,
                            EstadoPedido: $('#EstadoPedido').val(),
                            DescripccionPedido: $('#DescripccionPedido').val(),
                            User: NombreVendedor
                        },
                        url: "/PedidoProduccionUpdate",
                        type: "POST",
                        dataType: 'json',
                        success: function (data) {
                            if (data.hasOwnProperty('error')) {
                                /*toastr.error('SQLSTATE[' + data.error.code + ']: ¡El Producto ya existe!');*/
                                if(data.error.code2 == 664)  {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Hubo un problemaa...',
                                    });
                                    $('.Save_Est').html('Reintentar');
                                }
                            }

                            else {
                                $('#FormCartera').trigger("reset");
                                $('#Options').modal('hide');
                                $('.dataTableP').DataTable().destroy();
                                LoadTable();
                                toastr.success("Registro Guardado con Exito!");
                                $('.Save_Est').html('Guardar');
                            }
                        },
                    });
                    return false; // required to block normal submit since you used ajax
                }
            });

            const formatter = new Intl.NumberFormat('es-CO',{
                style: 'currency',
                currency: 'COP',
                minimumFractionDigits: 2,
            });

            const formatter2 = new Intl.NumberFormat('es-CO',{
                style: 'currency',
                currency: 'COP',
                minimumFractionDigits: 0,
            });

            $(document).on('click', '.Viewpdf', function () {
                let id = this.id;
                $.ajax({
                    type: "get",
                    url: "/ImprimirPedidoPdf",
                    data: {id: id},
                    dataType: "json",
                    success: function (data) {
                        console.log(data);
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
                            $('#PdfBrutoInvoice').html(formatter2.format(Math.round(data[0][0]['Bruto'])));
                            $('#PdfDescuentoInvoice').html(formatter2.format(Math.round(data[0][0]['TotalDescuento'])));
                            $('#PdfSubtotalInvoice').html(formatter2.format(Math.round(data[0][0]['TotalSubtotal'])));
                            $('#PdfIvaInvoice').html(formatter2.format(Math.round(data[0][0]['TotalIVA'])));
                            $('#PdfTotalInvoice').html(formatter2.format(Math.round(data[0][0]['TotalPedido'])));

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



                            for (let i = 0; i <= data[1].length -1; i++) {
                                function format_destino (){
                                    if (data[1][i].Destino == 1){
                                        return 'Produccion'
                                    } else{
                                        return 'Bodega'
                                    }
                                }

                                $('#ItemsInvoice').append('<tr>' +
                                    '<td style="text-align: center">'+ data[1][i].CodigoProducto +'</td>' +
                                    '<td style="text-align: center">'+ data[1][i].Descripcion +'</td>' +
                                    '<td style="text-align: center">'+ format_destino()  +'</td>' +
                                    '<td style="text-align: center">'+ data[1][i].R_N +'</td>' +
                                    '<td style="text-align: center">'+ '<a href="javascript:void(0);" class="ViewArt" id="'+ data[1][i].Arte +'">'+ data[1][i].Arte +'</a>' + '</td>' +
                                    '<td style="text-align: center">'+ data[1][i].Notas +'</td>' +
                                    '<td style="text-align: center">'+ data[1][i].Unidad +'</td>' +
                                    '<td style="text-align: right">'+ data[1][i].Cantidad +'</td>' +
                                    '<td style="text-align: right">'+ formatter.format(data[1][i].Precio) +'</td>' +
                                    '<td style="text-align: right">'+ formatter2.format(data[1][i].Total) +'</td>' +
                                    '</tr>'
                                );
                            }

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
                ventana.document.write('<html lang="es"><head><title>' + document.title + '</title>');
                ventana.document.write('<link rel="stylesheet" href="/bootstrap.min.css">');
                ventana.document.write('</head><body>');
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

            $(document).on('click', '.ViewArt', function() {
                var Art = $(this).attr("id");
                $('#ViewArtTitle').html('Arte #'+ Art);
                PDFObject.embed('//192.168.1.12/intranet_ci/assets/Artes/'+Art+'.pdf', '#ViewArtPdf');
                $('#ViewArtModal').modal('show');
            });
        })
    </script>
@endpush
