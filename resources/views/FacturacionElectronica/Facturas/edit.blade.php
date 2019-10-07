@extends('layouts.dashboard')

@section('page_title', 'Facturacion Electronica')

@section('module_title', 'Facturacion Electronica')

@section('subtitle', 'Este módulo permite editar facturas.')

@section('breadcrumbs')
    {{ Breadcrumbs::render('fact_electr') }}
@stop
@section('content')
    <div class="col-12"><h3> Factura #: {{ $var[0]->numero}} </h3></div>
    <form action="{{ route('fe.update', $var[0]->numero) }}" method="POST">
        @csrf
        @method('put')
        <div class="row">
            @foreach($var as $v)
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">Informacion Cliente</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Razon social:</label>
                                    <input type="text" class="form-control" placeholder="Razon Social" value=" {{ $v->nombres }}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Direccion:</label>
                                    <input type="text" class="form-control" placeholder="Direccion" value="{{ $v->direccion }}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Tipo de Cliente:</label>
                                    <input type="text" class="form-control" placeholder=" " value="{{  $v->tipo_cliente }}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Telefono:</label>
                                    <input type="text" class="form-control" placeholder="Telefono"  value="{{ $v->telefono }}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Ciudad, Estado, Pais:</label>
                                    <input type="text" class="form-control" placeholder="Ciudad" value="{{ $v->Ciudad.' - '.$v->Dpto.' - '.$v->Pais }}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Contacto:</label>
                                    <input type="text" class="form-control" placeholder="Nombre de contacto" disabled>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Motivo:</label>
                                    <select  class="form-control" id="">
                                        @foreach ($var as $v)
                                        <option value="{{ $v->motivo }}"> {{ $v->descmotivo }}fe</option>
                                        @endforeach
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
                                        <input type="text" class="form-control" placeholder="Enter ..." value="{{ $v->nit_cliente }}" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Fecha Factura:</label>
                                        <input type="text" class="form-control" placeholder="AAAA-MM-DD" value="{{ $v->fechadocumento }}" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Condiciones de pago:</label>
                                        <input type="text" class="form-control" placeholder="Enter ..." value="{{ $v->plazo }}" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Fecha Vencimiento:</label>
                                        <input type="text" class="form-control" placeholder="AAAA-MM-DD" value="{{ $v->fechavencimiento }}" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Codigo Cliente:</label>
                                        <input type="text" class="form-control" placeholder="Enter ..." value="{{ $v->codigocliente }}" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Remision:</label>
                                        <input type="text" class="form-control" placeholder="Enter ..." value="{{ $v->ov }}">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Notas Factura:</label>
                                        <input class="form-control" rows="2" placeholder="Enter ..." value="{{ $v->notas }}">
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
                                        <th>Orden</th>
                                        <th>Codigo</th>
                                        <th>Descripcion</th>
                                        <th>U/M</th>
                                        <th>Cantidad</th>
                                        <th>Precio Unitario</th>
                                        <th>Precio Total</th>
                                    </tr>
                                </thead>
                                @foreach( $detalle as $det)
                                <tbody> {{--foreach--}}
                                    <tr>
                                        <td> {{ $det->OV.$det->item}}</td>
                                        <td> {{ trim($det->CodigoProducto)}} </td>
                                        <td> {{ trim($det->descripcionproducto)}} </td>
                                        <td> {{ $det->UM}} </td>
                                        <td> {{ number_format($det->cantidad,0,'.','.')}} </td>
                                        <td> {{ number_format($det->precio,2,',','.' )}} </td>
                                        <td> {{ number_format($det->totalitem,2,',','.') }}</td>
                                    </tr>
                                </tbody>
                                @endforeach
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
                                <th>Total Bruto</th>
                                <th>Descuento</th>
                                <th>Retencion</th>
                                <th>Seguro</th>
                                <th>Flete</th>
                                <th>Subtotal</th>
                                <th>IVA</th>
                                <th>Total Factura</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php $total_factura = ( $v->bruto - $v->descuento) + $v->iva ?>
                                    <td>{{ number_format($v->bruto,2,',','.') }}</td>
                                    <td>{{ number_format($v->descuento,2,',','.') }}</td>
                                    <td> </td>
                                    <td>{{ number_format($v->seguros,2,',','.') }}</td>
                                    <td>{{ number_format($v->fletes,2,',','.') }}</td>
                                    <td>{{ number_format($v->subtotal,2,',','.') }}</td>
                                    <td>{{ number_format($v->iva,2,',','.' ) }}</td>
                                    <td>{{ number_format($total_factura,2,',','.')}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="card-body">
            <div class="col-sm-12 pl-0">
                <p class="text-right">
                    <a href="{{ route('fe.index') }}" class="btn btn-sm btn-secondary" role="button">Volver</a>
                    <button class="btn btn-sm btn-primary" type="submit">Guardar cambios</button>
                </p>
            </div>
        </div>
    </form>
@endsection
