@extends('layouts.dashboard')

@section('page_title', 'Tablero')

@section('title_icon_class', 'fas fa-tachometer-alt')

@section('module_title', 'Tablero')

@section('subtitle', 'Aquí podrás ver diferentes estadísticas y gráficas basadas en tus intereses.')

@section('breadcrumbs')
{{ Breadcrumbs::render('dashboard') }}
@stop

@section('content')
@can('dashboard.view')
<div class="row justify-content-center">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <div class="card-header">Tablero</div>
            <div class="card-body">
                ¡Bienvenido a EVPIU!
            </div>
        </div>
    </div>
</div>
@else
<div class="alert alert-danger" role="alert">
    No tienes permisos para visualizar el tablero principal.
</div>
@endcan
@stop
