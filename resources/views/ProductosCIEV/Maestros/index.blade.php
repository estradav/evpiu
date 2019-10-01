@extends('layouts.dashboard')

@section('page_title', 'Maestro Codificador')

@section('module_title', 'Maestro Codificador')

@section('subtitle', '')

@section('breadcrumbs')
    {{ Breadcrumbs::render('fact_electr') }} {{--HAY QUE CAMBIARLO POR EL QUE CORRESPONDE--}}
@stop
@section('content')
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-4">Maestro de Codificador </h1>
        <p class="lead">El maestro de codificador permite crear nuevas Lineas, Sublineas, Caracteristicas, Medidas y Materiales.</p>
    </div>
    <div class="card-deck mb-3 text-center">
        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <h3 class="my-0 font-weight-normal">Lineas</h3>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mt-3 mb-4">
                    <li> Ver lineas </li>
                    <li> Edita</li>
                    <li> Eliminar</li>
                </ul>
                <a href="{{route('prod.lineas.show')}}" class="btn btn-lg btn-block btn-primary">IR</a>
            </div>
        </div>
        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <h3 class="my-0 font-weight-normal">Sublineas</h3>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mt-3 mb-4">
                    <li> Ver lineas </li>
                    <li> Edita</li>
                    <li> Eliminar</li>
                </ul>
                <button type="button" class="btn btn-lg btn-block btn-primary">Ir</button>
            </div>
        </div>
        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <h3 class="my-0 font-weight-normal">Caracteristicas</h3>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mt-3 mb-4">
                    <li> Ver lineas </li>
                    <li> Edita</li>
                    <li> Eliminar</li>
                </ul>
                <button type="button" class="btn btn-lg btn-block btn-primary">Ir</button>
            </div>
        </div>
        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <h3 class="my-0 font-weight-normal">Materiales</h3>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mt-3 mb-4">
                    <li> Ver lineas </li>
                    <li> Edita</li>
                    <li> Eliminar</li>
                </ul>
                <button type="button" class="btn btn-lg btn-block btn-primary">IR</button>
            </div>
        </div>
        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <h3 class="my-0 font-weight-normal">Medidas</h3>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mt-3 mb-4">
                    <li> Ver lineas </li>
                    <li> Edita</li>
                    <li> Eliminar</li>
                </ul>
                <button type="button" class="btn btn-lg btn-block btn-primary">Ir</button>
            </div>
        </div>

    </div>
@endsection


