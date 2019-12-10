@extends('layouts.dashboard')

@section('page_title', 'Maestro Codificador')

@section('subtitle', '')

@section('content')
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-4">Maestro de Codificador </h1>
        <p class="lead">El maestro de codificador permite crear nuevas Lineas, Sublineas, Caracteristicas, Medidas y Materiales.</p>
    </div>
    <div class="container">
        <div class="card-deck mb-3 text-center">
            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <h3 class="my-0 font-weight-normal">Tipos de Producto</h3>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mt-3 mb-4">
                        <li> clasificación Macro de la gama de elementos que requiere la codificacion de piezazs de Estrada Velasquez. segun su funcionalidad. </li>
                        &nbsp;
                    </ul>
                    @can('maestro.tipoproducto.view')
                    <a href="{{route('ProdCievCodTipoProducto.index')}}" class="btn btn-lg btn-block btn-primary">Ir</a>
                    @endcan
                </div>
            </div>
            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <h3 class="my-0 font-weight-normal">Lineas</h3>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mt-3 mb-4">
                        <li> Subdivisión de los tipos de productos y se definen según su aplicabilidad en el en el entorno productivo y comercial. </li>
                        &nbsp;
                    </ul>
                    @can('maestro.linea.view')
                    <a href="{{ route('ProdCievCod.index')}}" class="btn btn-lg btn-block btn-primary">Ir</a>
                    @endcan
                </div>
            </div>
            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <h3 class="my-0 font-weight-normal">Sublineas</h3>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mt-3 mb-4 " >
                        <li>División de las lineas que permiten granularizar las características de las piezas; Tienen una dependencia directa de las Lineas  </li>
                        &nbsp;
                    </ul>
                    @can('maestro.sublinea.view')
                    <a href="{{ route('ProdCievCodSublinea.index')}}" class="btn btn-lg btn-block btn-primary">Ir</a>
                    @endcan
                </div>
            </div>
        </div>

        <div class="card-deck mb-3 text-center">
            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <h3 class="my-0 font-weight-normal">Caracteristicas</h3>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>Es la máxima particularización de las lineas, con ellas se da un detalle mayor de las piezas. Existe una dependencia directa de éstas con las lineas y las sublineas.</li>
                    </ul>
                    @can('maestro.caracteristica.view')
                    <a href="{{ route('ProdCievCodCaracteristica.index')}}" class="btn btn-lg btn-block btn-primary">Ir</a>
                    @endcan
                </div>
            </div>
            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <h3 class="my-0 font-weight-normal">Materiales</h3>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mt-3 mb-4">
                        <li> Definicion de los posibles elementos con los que se puede construir una pieza, dependerán de la Linea y la sublinea.</li>
                        &nbsp;
                    </ul>
                    @can('maestro.material.view')
                    <a href="{{ route('ProdCievCodMaterial.index')}}" class="btn btn-lg btn-block btn-primary">Ir</a>
                    @endcan
                </div>
            </div>
            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <h3 class="my-0 font-weight-normal">Medidas</h3>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>Definición de las diferentes dimensiones en las que se puede elaborar una pieza, dependerán directamente de la Linea y la Sublinea.</li>
                        &nbsp;
                    </ul>
                    @can('maestro.medida.view')
                    <a href="{{ route('ProdCievCodMedida.index')}}" class="btn btn-lg btn-block btn-primary">Ir</a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection


