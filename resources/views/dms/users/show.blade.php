@extends('layouts.dashboard')

@section('page_title', 'Mostrar usuario')

@section('module_title', 'Usuarios')

@section('subtitle', 'Este módulo gestiona todos los usuarios de la aplicación DMS.')

@section('breadcrumbs')
    {{ Breadcrumbs::render('dmsuser_show', $dmsuser) }}
@stop

@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header">Detalles del Usuario</h5>
                <div class="card-body">
                    <p><strong>Nombre:</strong> {{ $dmsuser->usuario }}</p>
                    <p><strong>Descripcion de Usuario:</strong> {{ $dmsuser->des_usuario }}</p>
                    <p><strong>¿Bloqueado?:</strong> {{ $dmsuser->bloqueado }}</p>
                    <p><strong>Razon de Bloqueo:</strong> {{ $dmsuser->razon_bloqueado }}</p>
                    <p><strong>Notas:</strong> {{ $dmsuser->notas }}</p>
                </div>
            </div>
        </div>
    </div>

@stop
