@extends('layouts.architectui')

@section('page_title', 'Editar pedido')

@section('action_recaptcha')
    {!! htmlScriptTagJsApi([ 'action' => 'pedidos_venta_editar' ]) !!}
@stop

@section('content')
    @can('aplicaciones.pedidos.editar')
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-note2 icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>Pedido {{ $encabezado->id }}
                        <div class="page-title-subheading">
                            {{ $encabezado->NombreCliente }}
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
                            <input type="hidden" value="{{ $encabezado->id }}" id="id" name="id">
                            <input type="hidden" value="{{ $encabezado->id_maestro }}" id="id_maestro" name="id_maestro">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Vendedor</span>
                                        </div>
                                        <select name="vendedor" id="vendedor" class="form-control" disabled>
                                            <option value="{{ $encabezado->CodVendedor }}">{{$encabezado->NombreVendedor }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Cliente</span>
                                        </div>
                                        <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente" value="{{ $encabezado->NombreCliente }}" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Cod Cliente</span>
                                        </div>
                                        <input type="text" class="form-control" id="cod_cliente" name="cod_cliente" value="{{ $encabezado->CodCliente }}" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">OC</span>
                                        </div>
                                        <input type="text" class="form-control"  id="orden_compra" name="orden_compra" value="{{ $encabezado->OrdenCompra }}">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Direccion</span>
                                        </div>
                                        <input type="text" class="form-control" id="direccion" name="direccion" value="{{ $encabezado->DireccionCliente }}" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Ciudad</span>
                                        </div>
                                        <input type="text" class="form-control" id="ciudad" name="ciudad" value="{{ $encabezado->Ciudad }}" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Telefono</span>
                                        </div>
                                        <input type="text" class="form-control" id="telefono" name="telefono" value="{{ $encabezado->Telefono }}" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Condicion pago</span>
                                        </div>
                                        <select name="condicion_pago" id="condicion_pago" class="form-control" disabled >
                                            <option value="{{ $encabezado->CondicionPago }}">{{ $encabezado->CondicionPago }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Descuento</span>
                                        </div>
                                        <input type="text" class="form-control" name="descuento" id="descuento" value="{{ $encabezado->Descuento}}">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">IVA</span>
                                        </div>
                                        <select name="iva" id="iva" class="form-control">
                                            <option value="" selected>Seleccione...</option>
                                            <option value="Y" {{ $encabezado->Iva == 'Y' ? 'selected' : '' }}>Si</option>
                                            <option value="N" {{ $encabezado->Iva == 'N' ? 'selected' : '' }}>No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Notas generales</span>
                                        </div>
                                        <textarea name="notas_generales" id="notas_generales" cols="71" rows="1" class="form-control">{{ $encabezado->Notas }}</textarea>
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
                                           {{-- <th>ARTE</th>
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
                                            <td>
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
                                            {{--<td>
                                                <input type="text" id="arte_item" name="arte_item" class="form-control form-control-sm" onkeyup="this.value=this.value.toUpperCase();">
                                            </td>
                                            <td>
                                                <input type="text" id="notas_item" name="notas_item" class="form-control form-control-sm" onkeyup="this.value=this.value.toUpperCase();">
                                            </td> --}}
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
                                        <th>COD CLIENTE	</th>
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
                                    @php
                                        $idx = 0
                                    @endphp

                                    @foreach($detalle as $d)
                                        <tr>
                                            <td class="item_cod_producto">{{ $d->CodigoProducto }}</td>
                                            <td class="item_cod_client" id="item_cod_client_{{ $idx }}">{{ $d->Cod_prod_cliente }}</td>
                                            <td class="item_descripcion">{{ $d->Descripcion }}</td>
                                            <td class="item_destino" id="item_destino_{{ $idx }}">{{ $d->Destino == 1 ? "Produccion": ($d->Destino == 2 ? "Bodega" : "Troqueles")  }} </td>
                                            <td class="item_n_r" id="item_nr_{{ $idx }}"> {{ $d->R_N }}</td>
                                            <td class="item_arte" id="item_arte_{{ $idx }}"><a href="javascript:void(0);" id="{{ $d->Arte }}" class="ver_arte" name="ver_arte_{{ $idx }}">{{ $d->Arte }}</a></td>
                                            <td class="item_marca" id="item_marca_{{ $idx }}">{{ $d->Marca }}</td>
                                            <td class="item_notas" id="item_notas_{{ $idx }}">{{ $d->Notas }}</td>
                                            <td class="item_unidad" id="item_unidad_{{ $idx }}">{{ $d->Unidad }}</td>
                                            <td class="item_precio" id="item_precio_{{ $idx }}">{{ $d->Precio }}</td>
                                            <td class="item_cantidad" id="item_cantidad_{{ $idx }}">{{ $d->Cantidad }}</td>
                                            <td class="item_total" id="item_total_{{ $idx }}">{{ $d->Total }}</td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-info btn-sm editar_item" name="{{ $idx }}" id="editar_item_{{ $idx }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-success btn-sm save_item" name="{{ $idx }}" id="save_item_{{ $idx }}" style="display: none">
                                                        <i class="fas fa-save"></i>
                                                    </button>
                                                    <a href="javascript:void(0)" data-id="{{ $d->CodigoProducto }}" class="btn btn-danger btn-sm eliminar_item">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                            <td class="id" style="display: none !important;">{{ $d->id }}</td>
                                        </tr>
                                        @php
                                            $idx++;
                                        @endphp
                                    @endforeach
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
                                            <input type="number" class="form-control form-control-sm totalCol" id="total_items_bruto" name="total_items_bruto" value="{{ $encabezado->Bruto }}" readonly>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm" id="total_items_descuento" name="total_items_descuento" value="{{ $encabezado->TotalDescuento }}" readonly>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm" id="total_items_subtotal" name="total_items_subtotal" value="{{ $encabezado->TotalSubtotal }}" readonly>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm" id="total_items_iva" name="total_items_iva" value="{{ $encabezado->TotalIVA }}" readonly>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm" id="total_items" name="total_items" value="{{ $encabezado->TotalPedido }}" readonly>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <button type="button" class="btn btn-primary btn-lg" id="actualizar_pedido">ACTUALIZAR PEDIDO</button>
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
    <script type="text/javascript" src="{{ asset('aplicaciones/pedidos/ventas/edit.js') }}">

    </script>
@endpush
