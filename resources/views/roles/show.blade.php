@extends('layouts.dashboard')

@section('page_title', 'Mostrar rol')

@section('module_title', 'Roles')

@section('subtitle', 'Este módulo gestiona todos los roles de los usuarios de la aplicación.')

@section('breadcrumbs')
{{ Breadcrumbs::render('role_show', $role) }}
@stop

@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Detalles del Rol</h5>
            <div class="card-body">
                <p><strong>Descripción:</strong> {{ $role->description }}</p>
                <p><strong>Identificador:</strong> {{ $role->name }}</p>
                <p><strong>Tipo:</strong> {{ $role->guard_name }}</p>
                <p><strong>Creado en:</strong> {{ $role->created_at->format('d M Y h:ia') }}</p>
                <p><strong>Actualizado en:</strong> {{ $role->updated_at->format('d M Y h:ia') }}</p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Permisos asociados</h5>
            <div class="card-body">
                <div class="row">
                    @forelse ($rolePermissions as $rolePermission)
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-6">
                        <ul class="list-unstyled arrow">
                            <li><a href="{{ route('permissions.show', $rolePermission) }}">{{ $rolePermission->description }}</a></li>
                        </ul>
                    </div>
                    @empty
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <p class="card-text">Este rol no tiene permisos asociados.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Usuarios asociados</h5>
            <div class="card-body">
                <div class="row">
                    @forelse ($roleUsers as $roleUser)
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-6">
                        <ul class="list-unstyled arrow">
                            <li><a href="{{ route('users.show', $roleUser->id) }}">{{ $roleUser->name }}</a></li>
                        </ul>
                    </div>
                    @empty
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <p class="card-text">Este rol no tiene permisos asociados.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@stop
