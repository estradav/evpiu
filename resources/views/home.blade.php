@extends('layouts.dashboard')

@section('page_title', 'Tablero')

@section('title_icon_class', 'fas fa-tachometer-alt')

@section('module_title', 'Tablero')

@section('subtitle', 'Aquí podrás ver diferentes estadísticas y gráficas basadas en tus intereses.')

@section('breadcrumbs')
{{ Breadcrumbs::render('dashboard') }}
@stop

@section('content')
    @inject('Usuarios','App\Services\Usuarios')
@can('dashboard.view')
<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Usuarios Registrados en la Plataforma</h5>
            <div class="card-body">
                <div class="row">
                    <canvas id="Usuarios"></canvas>
                </div>
            </div>
        </div>
    </div>
    {{--<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Total de facturas por Mes</h5>
            <div class="card-body">
                <div class="row">
                    <canvas id="FacturasPorMes"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Ventas por Año</h5>
            <div class="card-body">
                <div class="row">
                    <canvas id="VentasPorAño"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Ventas por Mes</h5>
            <div class="card-body">
                <div class="row">
                    <canvas id="VentasPorMes"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Ventas por Dia</h5>
            <div class="card-body">
                <div class="row">
                    <canvas id="VentasPorDia"></canvas>
                </div>
            </div>
        </div>
    </div>--}}
</div>

@else
<div class="alert alert-danger" role="alert">
    No tienes permisos para visualizar el tablero principal.
</div>
@endcan

@push('javascript')
    <script type="text/javascript" src="/JsGlobal/Dashboard/Charts_Sales.js" ></script>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
    <script type="text/css" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.css"></script>
    <script type="text/css" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css"></script>
@endpush
@stop
