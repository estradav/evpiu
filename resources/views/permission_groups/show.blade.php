@extends('layouts.dashboard')

@section('page_title', 'Mostrar grupo de permisos')

@section('module_title', 'Permisos')

@section('subtitle', 'Este módulo gestiona todos los permisos de los roles de la aplicación.')

@section('breadcrumbs')
{{ Breadcrumbs::render('permission_groups_show', $permissionGroup) }}
@stop

@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Detalles del Grupo de Permisos</h5>
            <div class="card-body">
                <p><strong>Nombre:</strong> {{ $permissionGroup->name }}</p>
                <p><strong>Creado en:</strong> {{ $permissionGroup->created_at->format('d M Y h:ia') }}</p>
                <p><strong>Actualizado en:</strong> {{ $permissionGroup->updated_at->format('d M Y h:ia') }}</p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Permisos asociados</h5>
            <div class="card-body">
                <div class="row">
                    @forelse ($permissionGroup->permissions as $groupPermission)
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-6">
                        <ul class="list-unstyled arrow">
                            <li><a href="{{ route('permissions.show', $groupPermission) }}">{{ $groupPermission->description }}</a></li>
                        </ul>
                    </div>
                    @empty
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <p class="card-text">Este grupo no tiene permisos asociados.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@stop
