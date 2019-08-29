@extends('layouts.dashboard')

@section('page_title', 'Mostrar Cliente')

@section('module_title', 'Clientes Max')

@section('subtitle', 'Este módulo gestiona todos los clientes de Max.')

@section('breadcrumbs')
    {{--{{ breadcrumbs::render('customer_max_show', $customer) }}--}}
@stop

@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header">Detalles del Cliente</h5>
                <div class="card-body">
                    @foreach($customer as $cus)
                    <p><strong>Nombre:</strong> {{ $cus->name_23 }}</p>
                    <p><strong>Localizacion:</strong> {{ $cus->cntry_23 }},<span> {{ $cus->city_23}}</span>-<span> {{ $cus->state_23 }}</span></p>
                    <p><strong>Contacto:</strong> {{ $cus->cntct_23}} </p>
                    <p><strong>Telefono:</strong> {{ $cus->phone_23}}</p>
                    <p><strong>Correo Electronico:</strong> {{ $cus->email1_23}}</p>
                    <p><strong>Nit o CC:</strong> {{ $cus->udfkey_23}}</p>
                    <p><strong>Tipo de Contribuyente:</strong> {{ $cus->tipo_contribuyente}}</p>
                    <p><strong>Tipo de Impuesto:</strong> {{ $cus->impuesto}}</p>
                    <p><strong>Fecha Creacion:</strong> {{ $cus->creationdate }}</p>
                    <p><strong>Ultima Actualizacion:</strong> {{ $cus->modificationdate }}</p>
                    <p><strong>Ultima Modificacion hecha por:</strong> {{ $cus->modifiedby}}</p>
                        @endforeach
                </div>
            </div>
        </div>
    </div>

   @endsection
