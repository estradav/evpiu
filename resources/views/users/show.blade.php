@extends('layouts.dashboard')

@section('page_title', 'Mostrar usuario')

@section('module_title', 'Usuarios')

@section('subtitle', 'Este módulo gestiona todos los usuarios de la aplicación.')

@section('breadcrumbs')
{{ Breadcrumbs::render('user_show', $user) }}
@stop

@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Detalles del Usuario</h5>
            <div class="card-body">
                <p><strong>Nombre:</strong> {{ $user->name }}</p>
                <p><strong>Correo electrónico:</strong> {{ $user->email }}</p>
                <p><strong>Nick:</strong> {{ $user->username }}</p>
                <p><strong>Creado en:</strong> {{ $user->created_at->format('d M Y h:ia') }}</p>
                <p><strong>Actualizado en:</strong> {{ $user->updated_at->format('d M Y h:ia') }}</p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Roles asociados</h5>
            <div class="card-body">
                <div class="row">
                    @foreach ($user->roles as $role)
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-6">
                        <ul class="list-unstyled arrow">
                            <li><a href="{{ route('roles.show', $role->id) }}">{{ $role->description }}</a></li>
                        </ul>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Permisos asociados</h5>
            <div class="card-body">
                <div class="row">
                    @foreach ($userPermissions as $permission)
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-6">
                        <ul class="list-unstyled arrow">
                            <li><a href="{{ route('permissions.show', $permission->id) }}">{{ $permission->description }}</a></li>
                        </ul>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@stop
