@extends('layouts.dashboard')

@section('page_title', 'Crear grupo de permisos')

@section('module_title', 'Permisos')

@section('subtitle', 'Este módulo gestiona todos los permisos de los roles de la aplicación.')

@section('breadcrumbs')
{{ Breadcrumbs::render('permission_groups_create') }}
@stop

@section('content')
@can('permission_groups.create')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="section-block" id="basicform">
            <h3 class="section-title">Crear Grupo de Permisos</h3>
            <p>Este formulario te ayudará a agrupar los permisos en la plataforma.</p>
        </div>
        <div class="card">
            <h5 class="card-header">Crear Grupo de Permisos</h5>
            <div class="card-body">
                @if ($permissions->isEmpty())
                <div class="alert alert-danger" role="alert">
                    Actualmente no hay permisos disponibles para asociar al nuevo grupo de permisos.
                </div>
                @endif
                <form action="{{ route('permission_groups.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="col-form-label">Nombre del grupo</label>
                        <input id="pg_name" name="name" type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}">

                        @if ($errors->has('name'))
                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                        @endif
                    </div>
                    <hr>
                    <h4>Permisos disponibles ({{ count($permissions) }})</h4>
                    <div class="form-group">
                        <div class="row">
                            @forelse ($permissions as $id => $description)
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-6">
                                <label class="custom-control custom-checkbox">
                                    <input class="custom-control-input {{ $errors->has('permissions') ? ' is-invalid' : '' }}" type="checkbox" name="permissions[]" value="{{ $id }}">
                                    <span class="custom-control-label">{{ $description ?: 'Sin descripción' }}</span>
                                </label>
                            </div>
                            @empty
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <p class="card-text">No hay permisos disponibles para asociar a un grupo.</p>
                                </div>
                            @endforelse
                        </div>

                        @if ($errors->has('permissions'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('permissions') }}</strong>
                        </div>
                        @endif
                    </div>
                    <div class="col-sm-12 pl-0">
                        <p class="text-right">
                            <a href="{{ route('permission_groups.index') }}" class="btn btn-sm btn-secondary" role="button">Volver</a>
                            <button class="btn btn-sm btn-primary" type="submit" @if($permissions->isEmpty()) disabled @endif>Guardar cambios</button>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@else
<div class="alert alert-danger" role="alert">
    No tienes permiso para crear nuevos grupos de permisos.
</div>
@endcan
@stop
