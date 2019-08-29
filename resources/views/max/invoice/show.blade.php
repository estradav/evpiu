@extends('layouts.dashboard')

@section('page_title', 'Mostrar Factura')

@section('module_title', 'Facturas Max')

@section('subtitle', 'Este módulo gestiona todas las Facturas de Max.')

@section('breadcrumbs')
{{--    {{ Breadcrumbs::render('invoices_show', $invoice) }}    --}}
@stop

@section('content')

    <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header">Informacion Cliente</h5>
                <div class="card-body">
                    @foreach( $invoice as $inv)
                    <p><strong>Cliente:</strong> {{ $inv->name_31}}</p>
                    <p><strong>Direccion:</strong> {{ $inv->addr1_31 }}</p>
                    <p><strong>Ciudad:</strong> {{ $inv->city_31}} - <span>{{ $inv->state_31 }} - </span><span>{{ $inv->cntry_31 }}</span> </p>
                    <p><strong>Telefono:</strong> {{ $inv->phone_31}}</p>
                    <p><strong>Contacto:</strong> {{ $inv->cntct_31}} </p>
                    <p><strong>Tipo de regimen:</strong> {{ $inv->tax_type}}</p>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header">Informacion de la Factura</h5>
                <div class="card-body">
                    @foreach( $invoice as $inv)
                    <p><strong>Cedula o nit:</strong> {{ $inv->nit }} </p>
                    <p><strong>Codigo cliente:</strong> {{ $inv->custid_31}}</p>
                    <p><strong>Remision:</strong> {{ $inv->ordnum_31}}</p>
                    <p><strong>Condiciones de pago:</strong>   </p>
                    <p><strong>Fecha factura:</strong> {{ $inv->creationdate}}</p>
                    <p><strong>Fecha vencimiento:</strong> {{ $inv->creationdate}}</p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header">Detalles de la Factura</h5>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped first">
                            <thead>
                            <tr>
                                <th>Orden</th>
                                <th>Codigo</th>
                                <th>Descripcion</th>
                                <th>U/M</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
{{--                                    @foreach( $invoice as $inv)--}}
{{--                                    <td>{{ $inv->ordnum_32 }}</td>--}}
{{--                                    <td>falta</td>--}}
{{--                                    <td>{{ $inv->descr_prod }}</td>--}}
{{--                                    <td>{{ $inv->u_med }}</td>--}}
{{--                                    <td>falta</td>--}}
{{--                                    <td>falta</td>--}}
{{--                                    @endforeach--}}
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
