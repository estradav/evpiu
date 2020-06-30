@extends('layouts.architectui')

@section('page_title','Editar RC')

@section('content')
    @can('recibo_caja.edit')
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-credit icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>Recibo de caja # {{ $encabezado->id }}
                        <div class="page-title-subheading">
                            Edicion de RC
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-4 text-center">
                                <div class="input-group">
                                    <div class="input-group-prepend text-danger">
                                        <span class="input-group-text" id="">FECHA DE PAGO:</span>
                                    </div>
                                    <input type="date" name="fecha_pago" id="fecha_pago" class="form-control" placeholder="Fecha de pago" value="{{  date('Y-m-d', strtotime($encabezado->fecha_pago)) }}">
                                </div>
                            </div>
                            <div class="col-4 text-center">
                                <div class="input-group">
                                    <div class="input-group-prepend" style="background-color: white !important; ">
                                        <span class="input-group-text" id="">VALOR PAGADO:</span>
                                    </div>
                                    <input type="number" class="form-control" value="{{ $encabezado->total }}" id="pagado" name="pagado" min="0" onClick="this.select();">
                                </div>
                            </div>
                            <div class="col-4 text-center">
                                <div class="input-group">
                                    <div class="input-group-prepend" style="background-color: white !important; ">
                                        <span class="input-group-text" id="">CUENTA:</span>
                                    </div>
                                    <select name="cuenta_pago" id="cuenta_pago" class="form-control">
                                        <option value="" selected>Seleccione...</option>
                                        <option value="11200505" {{ $encabezado->cuenta_pago == 11200505 ? 'selected' : '' }}>BANCOLOMBIA - xxxxxxx1953</option>
                                        <option value="11200510" {{ $encabezado->cuenta_pago == 11200510 ? 'selected' : '' }}>BANCOLOMBIA - xxxxxxx9471</option>
                                        <option value="11200515" {{ $encabezado->cuenta_pago == 11200515 ? 'selected' : '' }}>BANCOLOMBIA - xxxxxxx3587</option>
                                        <option value="11100505" {{ $encabezado->cuenta_pago == 11100505 ? 'selected' : '' }}>BANCOLOMBIA - xxxxxxx1701</option>
                                        <option value="11100506" {{ $encabezado->cuenta_pago == 11100506 ? 'selected' : '' }}>BANCOLOMBIA - xxxxxxx2074</option>
                                        <option value="11100506" {{ $encabezado->cuenta_pago == 11100506 ? 'selected' : '' }}>BANCO OCCIDENTE - xxxxxxx3489</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm table_items" id="table_items" >
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" name="" id="" class="custom-checkbox"></th>
                                        <th>Numero</th>
                                        <th>Saldo</th>
                                        <th>Bruto</th>
                                        <th>% Descuento</th>
                                        <th>Retencion</th>
                                        <th>ReteIVA</th>
                                        <th>ReteICA</th>
                                        <th>Otras deducciones</th>
                                        <th>Otros ingresos</th>
                                        <th>Total</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="facturas">
                                    @php
                                        $total_cartera = 0;
                                        $facturas = Array();
                                    @endphp
                                    @foreach( $final_array as $recibos)
                                        @php $total_cartera = $total_cartera + $recibos->Saldo  @endphp
                                        @if( isset($recibos->invoice))
                                            <tr>
                                                <th>
                                                    <input type="checkbox" name="check_{{ $recibos->invoice }}" id="{{ $recibos->invoice }}" class="custom-checkbox check" checked >
                                                </th>
                                                <td>
                                                    {{ $recibos->invoice }} <input type="number" style="display: none !important;" class="factura" value="{{ $recibos->invoice }}">
                                                </td>
                                                <td style="text-align: right !important;">{{ number_format( $recibos->Saldo, 0, ',', '.') }} </td>
                                                <td>
                                                    <input type="number" id="{{ $recibos->invoice }}" class="form-control bruto_{{ $recibos->invoice }} bruto" value="{{ $recibos->bruto }}">
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <button class="btn btn-secondary descuento_btn_{{ $recibos->invoice }} descuento_btn" type="button" id="{{ $recibos->invoice }}"><i class="fas fa-percentage"></i></button>
                                                        </div>
                                                        <input type="number" id="{{ $recibos->invoice }}" class="form-control descuento_{{ $recibos->invoice }} descuento" value="{{ $recibos->descuento }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <button class="btn btn-secondary retencion_btn_{{ $recibos->invoice }} retencion_btn" type="button" id="{{ $recibos->invoice }}"><i class="fas fa-calculator"></i></button>
                                                        </div>
                                                        <input type="number" id="{{ $recibos->invoice }}" class="form-control retencion_{{ $recibos->invoice }} retencion" value="{{ $recibos->retencion }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <button class="btn btn-secondary reteiva_btn_{{ $recibos->invoice }} reteiva_btn" type="button" id="{{ $recibos->invoice }}" ><i class="fas fa-calculator"></i></button>
                                                        </div>
                                                        <input type="number" id="{{ $recibos->invoice }}" class="form-control reteiva_{{ $recibos->invoice }} reteiva" value="{{ $recibos->reteiva }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <button class="btn btn-secondary reteica_btn_{{ $recibos->invoice }} reteica_btn" type="button" id="{{ $recibos->invoice }}"><i class="fas fa-calculator"></i></button>
                                                        </div>
                                                        <input type="number" id="{{ $recibos->invoice }}" class="form-control reteica_{{ $recibos->invoice }} reteica" value="{{ $recibos->reteica }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="number" id="{{ $recibos->invoice }}" class="form-control otras_dedu_{{ $recibos->invoice }} otras_dedu" value="{{ $recibos->otras_deduc }}">
                                                </td>
                                                <td>
                                                    <input type="number" id="{{ $recibos->invoice }}" class="form-control otros_ingre_{{ $recibos->invoice }} otros_ingre" value="{{ $recibos->otros_ingre }}">
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control total_{{ $recibos->invoice }} total" value="{{ $recibos->total }}" id="total" name="total" disabled >
                                                </td>
                                                <td>
                                                    <button class="btn btn-outline-info btn-sm info_documento" id="{{ $recibos->invoice }}"><i class="fas fa-info-circle"></i> Info</button>
                                                </td>
                                                <td style="display: none!important;">
                                                    <input type="text" class="form-control id_itm" value="{{ $recibos->id }}">
                                                    <input type="number" class="form-control iva_{{ $recibos->invoice }} iva" value="{{ $recibos->iva }}">
                                                    <input type="number" class="form-control valor_merc_{{ $recibos->invoice }}" value="{{ $recibos->valor_mercancia }}">
                                                    <input type="number" class="form-control desc_merc_{{ $recibos->invoice }}" value="{{ $recibos->descuento_pie }}">
                                                </td>
                                            </tr>
                                        @else
                                            <tr class="table-secondary">
                                                <th>
                                                    <input type="checkbox" name="check_{{ $recibos->numero }}" id="{{ $recibos->numero }}" class="custom-checkbox check" >
                                                </th>
                                                <td>
                                                    {{ $recibos->numero }} <input type="number" style="display: none !important;" class="factura" value="{{ $recibos->numero }}">
                                                </td>
                                                <td style="text-align: right !important;">{{ number_format( $recibos->Saldo, 0, ',', '.') }} </td>
                                                <td>
                                                    <input type="number" id="{{ $recibos->numero }}" class="form-control bruto_{{ $recibos->numero }} bruto" value="{{ $recibos->bruto ?? $recibos->Saldo }}" disabled>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <button class="btn btn-secondary descuento_btn_{{ $recibos->numero }} descuento_btn" type="button" id="{{ $recibos->numero }}" disabled><i class="fas fa-percentage"></i></button>
                                                        </div>
                                                        <input type="number" id="{{ $recibos->numero }}" class="form-control descuento_{{ $recibos->numero }} descuento" value="0" disabled>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <button class="btn btn-secondary retencion_btn_{{ $recibos->numero }} retencion_btn" type="button" id="{{ $recibos->numero }}" disabled><i class="fas fa-calculator"></i></button>
                                                        </div>
                                                        <input type="number" id="{{ $recibos->numero }}" class="form-control retencion_{{ $recibos->numero }} retencion" value="0" disabled>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <button class="btn btn-secondary reteiva_btn_{{ $recibos->numero }} reteiva_btn" type="button" id="{{ $recibos->numero }}" disabled><i class="fas fa-calculator"></i></button>
                                                        </div>
                                                        <input type="number" id="{{ $recibos->numero }}" class="form-control reteiva_{{ $recibos->numero }} reteiva" value="0" disabled>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <button class="btn btn-secondary reteica_btn_{{ $recibos->numero }} reteica_btn" type="button" id="{{ $recibos->numero }}" disabled><i class="fas fa-calculator"></i></button>
                                                        </div>
                                                        <input type="number" id="{{ $recibos->numero }}" class="form-control reteica_{{ $recibos->numero }} reteica" value="0" disabled>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="number" id="{{ $recibos->numero }}" class="form-control otras_dedu_{{ $recibos->numero }} otras_dedu" value="0" disabled>
                                                </td>
                                                <td>
                                                    <input type="number" id="{{ $recibos->numero }}" class="form-control otros_ingre_{{ $recibos->numero }} otros_ingre" value="0" disabled>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control total_{{ $recibos->numero }} total" value="{{ $recibos->total ?? 0 }}" id="total" name="total" disabled >
                                                </td>
                                                <td>
                                                    <button class="btn btn-outline-info btn-sm info_documento" id="{{ $recibos->numero }}"><i class="fas fa-info-circle"></i> Info</button>
                                                </td>
                                                <td style="display: none!important;">
                                                    <input type="text" class="form-control id_itm" value="{{ $recibos->id ?? null }}">
                                                    <input type="number" class="form-control iva_{{ $recibos->numero }} iva" value="{{ $recibos->iva }}">
                                                    <input type="number" class="form-control valor_merc_{{ $recibos->numero }}" value="{{ $recibos->valor_mercancia }}">
                                                    <input type="number" class="form-control desc_merc_{{ $recibos->numero }}" value="{{ $recibos->descuento_pie }}">
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                                <tfoot id="totales">
                                    <tr>
                                        <td colspan="2"><b>TOTAL CARTERA: </b></td>
                                        <td>{{number_format($total_cartera, 0, ',', '.')}}</td>
                                        <td colspan="7" class="text-right"><b>TOTAL LIQUIDADO:</b></td>
                                        <td id="total_liquidado">{{ '$ '.number_format($encabezado->total, 0, ',', '.')}}</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-12">
                                <textarea name="comentarios" id="comentarios" cols="5" rows="3" placeholder="ESCRIBA AQUI LOS COMENTARIOS" class="form-control">{{ $encabezado->comments }}</textarea>
                            </div>
                        </div>
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-8 text-center">
                                <button class="btn btn-primary btn-lg btn-block" id="guardar">GUARDAR RC</button>
                            </div>
                        </div>
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
    <div class="modal fade" id="calcular_desc_modal" tabindex="-1" role="dialog" aria-labelledby="calcular_desc_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">%</span>
                        </div>
                        <input type="number" class="form-control" min="0" max="100" value="0" id="descuento_input_modal" autofocus>
                    </div>
                </div>
                <div class="modal-footer text-center" >
                    <button type="button" class="btn btn-primary calcular_descuento" id="0">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="info_documento_modal" tabindex="-1" role="dialog" aria-labelledby="info_documento_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="info_documento_modal_title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody id="info_documento_modal_table_body">
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('javascript')
    <script type="text/javascript"> let id_rc = @json( $encabezado->id ); </script>
    <script type="text/javascript" src="{{ asset('aplicaciones/gestion_terceros/recibos_caja/edit.js') }}"></script>
@endpush
