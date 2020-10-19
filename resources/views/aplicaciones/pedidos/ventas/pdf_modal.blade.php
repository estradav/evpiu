<div class="modal fade" id="ver_pdf" tabindex="-1" role="dialog" aria-labelledby="ver_pdf" aria-hidden="true" style="overflow-y: scroll;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pdf_titulo"></h5>
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
            <div class="text-center ml-2 mr-2">
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated ProgressPed" role="progressbar" style="width: 80%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" id="ProgressPed"></div>
                </div>
            </div>
            <br>
            <div class="modal-body" id="texto_imprimible">
                <div class="wrapper">
                    <section class="invoice">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h2 class="page-header">
                                    <img src="/img/Logo_v2.png" alt="" style="width: 195px !important; height: 142px !important;" class="headers">
                                    <small class="float-right">Fecha: <b><label id="pdf_fecha"></label></b></small>
                                </h2>
                            </div>
                        </div>
                        <div class="row invoice-info">
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 invoice-col">
                                <address>
                                    <strong>CI Estrada Velasquez y CIA. SAS</strong><br>
                                    <b>NIT:</b> 890926617-8 <br>
                                    <b>TELEFONO:</b> 265-66-65<br>
                                    <b>EMAIL:</b> Comercial@estradavelasquez.com <br>
                                    <b>DIRECCION:</b> KR 55 # 29 C 14 - Zona industrial de belen.
                                </address>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 invoice-col">
                                <address>
                                    <b>CLIENTE: </b><span id="pdf_cliente"></span><br>
                                    <b>COD CLIENTE:</b> <span id="pdf_codigo_cliente"></span> <br>
                                    <b>CIUDAD:</b> <span id="pdf_ciudad"></span><br>
                                    <b>DIRECCION:</b> <span id="pdf_direccion"></span> <br>
                                    <b>TELEFONO:</b> <span id="pdf_telefono"></span>
                                </address>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 invoice-col">
                                <b>PEDIDO #: </b><span id="pdf_numero_pedido"></span> <br>
                                <b>OC: </b><span id="pdf_oc"></span> <br>
                                <b>CONDICION PAGO: </b><span id="pdf_condicion_pago"></span> <br>
                                <b>VENDEDOR(A): </b><span id="pdf_vendedor"></span>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm text-center">
                                    <thead>
                                        <tr>
                                            <th>CODIGO</th>
                                            <th>DESCRIPCION</th>
                                            <th>DESTINO</th>
                                            <th>R/N</th>
                                            <th>ARTE</th>
                                            <th>MARCA</th>
                                            <th>NOTAS</th>
                                            <th>U/M</th>
                                            <th>CANT</th>
                                            <th>PRECIO</th>
                                            <th>TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody id="items_pedido">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm text-center">
                                    <thead>
                                        <tr>
                                            <th>BRUTO</th>
                                            <th>DESCUENTO</th>
                                            <th>SUBTOTAL</th>
                                            <th>IVA</th>
                                            <th>TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td id="pdf_bruto_pedido"></td>
                                            <td id="pdf_descuento_pedido"></td>
                                            <td id="pdf_subtotal_pedido"></td>
                                            <td id="pdf_iva_pedido"></td>
                                            <td id="pdf_total_pedido"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 invoice-col">
                                <h6><b> NOTAS GENERALES:</b></h6> <h6 id="pdf_notas_generales"></h6>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary imprimir_pdf" id="imprimir_pdf">Imprimir</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrar">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="arte_modal" tabindex="-1" role="dialog" aria-labelledby="arte_modal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="arte_modal_title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="">
                <div id="arte_modal_pdf" style="height:750px;" ></div>
            </div>
            <div class="modal-footer" style="text-align: center !important;">
                <button class="btn btn-primary" data-dismiss="modal" id="arte_modal_cerrar">Aceptar</button>
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
