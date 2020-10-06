@extends('layouts.architectui')

@section('page_title', 'Nuevo pedido')

@section('action_recaptcha')
    {!! htmlScriptTagJsApi([ 'action' => 'pedidos_venta_crear' ]) !!}
@stop

@section('content')
    @can('aplicaciones.pedidos.ventas.create')
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-note2 icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>Pedidos
                        <div class="page-title-subheading">
                            Creacion de nuevo pedido
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <form id="form" name="form">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Vendedor</span>
                                        </div>
                                        <select name="vendedor" id="vendedor" class="form-control">
                                            <option value="" selected>Seleccione...</option>
                                            @foreach( $vendedores as $v)
                                                <option value="{{ $v->codvendedor}}">{{ $v->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Cliente</span>
                                        </div>
                                        <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Cod Cliente</span>
                                        </div>
                                        <input type="text" class="form-control" id="cod_cliente" name="cod_cliente" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">OC</span>
                                        </div>
                                        <input type="text" class="form-control"  id="orden_compra" name="orden_compra">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Direccion</span>
                                        </div>
                                        <input type="text" class="form-control" id="direccion" name="direccion" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Ciudad</span>
                                        </div>
                                        <input type="text" class="form-control" id="ciudad" name="ciudad" readonly >
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Telefono</span>
                                        </div>
                                        <input type="text" class="form-control" id="telefono" name="telefono" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Condicion pago</span>
                                        </div>
                                        <select name="condicion_pago" id="condicion_pago" class="form-control" disabled>
                                            <option value="" selected>Seleccione...</option>
                                            @foreach( $condicion_pago as $cp )
                                                <option value="{{ trim($cp->DESC_36) }}">{{ trim($cp->DESC_36) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Descuento</span>
                                        </div>
                                        <input type="number" class="form-control" name="descuento" id="descuento">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">IVA</span>
                                        </div>
                                        <select name="iva" id="iva" class="form-control">
                                            <option value="" selected>Seleccione...</option>
                                            <option value="Y">Si</option>
                                            <option value="N">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Notas generales</span>
                                        </div>
                                        <textarea name="notas_generales" id="notas_generales" cols="71" rows="1" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <br>
                        <hr>
                        <br>
                        <b>Stock:</b> <label id="stock_item"></label>
                        <form id="add_items_form" name="add_items_form">
                            <div class="table-responsive">
                                <table class="table table-borderless table-sm">
                                    <thead>
                                        <tr class="table-primary">
                                            <th>PRODUCTO</th>
                                            <th>DESTINO</th>
                                            <th>N/R</th>
                                            {{--<th>ARTE</th>
                                            <th>NOTAS</th>--}}
                                            <th>U/M</th>
                                            <th>PRECIO</th>
                                            <th>CANT</th>
                                            <th>TOTAL</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="table-primary">
                                            <td class="w-25">
                                                <input type="text" id="producto" name="producto" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <select name="destino_item" id="destino_item" class="form-control form-control-sm">
                                                    <option value="" selected>Seleccione..</option>
                                                    <option value="Bodega">Bodega</option> // ojo value 2
                                                    <option value="Produccion">Produccion</option> //ojo validar value 1
                                                    <option value="Troqueles" disabled>Troqueles</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="n_r_item" id="n_r_item" class="form-control form-control-sm" required>
                                                    <option value="" selected>Seleccione..</option>
                                                    <option value="Nuevo">Nuevo</option>
                                                    <option value="Repro">Repro.</option>
                                                </select>
                                            </td>
                                           {{-- <td>
                                                <input type="text" id="arte_item" name="arte_item" class="form-control form-control-sm arte_item" onkeyup="this.value=this.value.toUpperCase();">
                                            </td>
                                            <td>
                                                <input type="text" id="notas_item" name="notas_item" class="form-control form-control-sm" onkeyup="this.value=this.value.toUpperCase();">
                                            </td>--}}
                                            <td>
                                                <select name="um_item" id="um_item" class="form-control form-control-sm">
                                                    <option value="Unidad" selected >Unidad</option>
                                                    <option value="Kilos">Kilos</option>
                                                    <option value="Millar">Millar</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" id="precio_item" name="precio_item" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="number" id="cantidad_item" name="cantidad_item" class="form-control form-control-sm" value="1">
                                            </td>
                                            <td>
                                                <input type="text" id="total_item" name="total_item" class="form-control form-control-sm" readonly="readonly" value="0">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-info btn-sm" id="add_info" disabled><i class="fa fa-comment"></i></button>
                                                <button type="submit" class="btn btn-success btn-sm" id="agregar_item" disabled><i class="fa fa-plus"></i></button>
                                            </td>
                                        </tr>
                                        <tr class="table-primary">
                                            <td colspan="10"></td>
                                        </tr>
                                        <tr class="table-primary">
                                            <td colspan="10"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <input type="hidden" id="notas_item">
                            <input type="hidden" id="arte_item">
                            <input type="hidden" id="marca_item">
                            <input type="hidden" id="cod_cliente_item">
                        </form>

                        <div class="table-responsive">
                            <table class="table table-bordered table-sm" id="tabla_items">
                                <thead>
                                    <tr>
                                        <th>COD</th>
                                        <th>COD CLIENTE</th>
                                        <th>DESCRIPCION</th>
                                        <th>DESTINO</th>
                                        <th>N/R</th>
                                        <th>ARTE</th>
                                        <th>MARCA</th>
                                        <th>NOTAS</th>
                                        <th>U/M</th>
                                        <th>PRECIO</th>
                                        <th>CANT</th>
                                        <th>TOTAL</th>
                                        <th></th>
                                        <th style="display: none !important;"></th>
                                    </tr>
                                </thead>
                                <tbody id="tabla_items_body">
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm first" id="TotalesTable">
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
                                        <td>
                                            <input type="number" class="form-control form-control-sm totalCol" id="total_items_bruto" name="total_items_bruto" readonly>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm" id="total_items_descuento" name="total_items_descuento" readonly>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm" id="total_items_subtotal" name="total_items_subtotal" readonly>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm" id="total_items_iva" name="total_items_iva" readonly>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm" id="total_items" name="total_items" readonly>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <button type="button" class="btn btn-primary btn-lg" id="crear_pedido">CREAR PEDIDO</button>
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

@section('modal')
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



    <div class="modal fade" id="add_info_modal" tabindex="-1" aria-labelledby="add_info_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add_info_modal_title">Agregar info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add_info_modal_form">
                    <div class="modal-body">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Arte</span>
                            </div>
                            <input type="text" class="form-control" id="add_info_modal_art" name="add_info_modal_art" placeholder="Numero de arte" aria-label="add_info_modal_art" aria-describedby="add_info_modal_art">
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" >Marca</span>
                            </div>
                            <input type="text" class="form-control" id="add_info_modal_marca" name="add_info_modal_marca" placeholder="Numero de marca" aria-label="add_info_modal_marca" aria-describedby="add_info_modal_marca">
                        </div>


                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" >CP. Cliente</span>
                            </div>
                            <input type="text" class="form-control" id="add_info_modal_cp_client" name="add_info_modal_cp_client" placeholder="Codigo producto cliente" aria-label="add_info_modal_cp_client" aria-describedby="add_info_modal_cp_client">
                        </div>


                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Notas</span>
                            </div>
                            <textarea type="text" class="form-control" id="add_info_modal_notas" name="add_info_modal_notas" placeholder="Notas" aria-label="add_info_modal_notas" aria-describedby="add_info_modal_notas" cols="30" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="add_info_modal_save">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@push('javascript')
    <script type="text/javascript" src="{{ asset('aplicaciones/pedidos/ventas/create.js') }}"></script>
@endpush
