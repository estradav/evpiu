@extends('layouts.dashboard')

@section('page_title', 'Mostrar permiso')

@section('module_title', 'Permisos')

@section('subtitle', 'Este módulo gestiona todos los permisos de los roles de la aplicación.')

@section('breadcrumbs')
{{ Breadcrumbs::render('permission_show', $permission) }}
@stop

@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Detalles del permiso</h5>
            <div class="card-body">
                <p><strong>Nombre:</strong> {{ $permission->name }}</p>
                <p><strong>Tipo:</strong> {{ $permission->guard_name }}</p>
                <p><strong>Descripción:</strong> {{ $permission->description }}</p>
                <p><strong>Creado en:</strong> {{ $permission->created_at->format('d M Y h:ia') }}</p>
                <p><strong>Actualizado en:</strong> {{ $permission->updated_at->format('d M Y h:ia') }}</p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Usuarios asociados ({{ $permissionUsers->count() }})</h5>
            <div class="card-body">
                <div class="row">
                    @forelse ($permissionUsers as $user)
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-6">
                        <ul class="list-unstyled arrow">
                            <li><a href="{{ route('users.show', $user->id) }}">{{ $user->name }}</a></li>
                        </ul>
                    </div>
                    @empty
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <p class="card-text">Este permiso no tiene usuarios asociados.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Roles asociados ({{ $permission->roles->count() }})</h5>
            <div class="card-body">
                <div class="row">
                    @forelse ($permission->roles as $role)
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-6">
                        <ul class="list-unstyled arrow">
                            <li><a href="{{ route('roles.show', $role->id) }}">{{ $role->name }}</a></li>
                        </ul>
                    </div>
                    @empty
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <p class="card-text">Este permiso no tiene roles asociados.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@stop
