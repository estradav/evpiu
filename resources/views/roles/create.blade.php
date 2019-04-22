@extends('layouts.dashboard')

@section('page_title', 'Crear rol')

@section('module_title', 'Roles')

@section('subtitle', 'Este módulo gestiona todos los roles de los usuarios de la aplicación.')

@section('breadcrumbs')
{{ Breadcrumbs::render('role_create') }}
@stop

@section('content')
@can('roles.create')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="section-block" id="basicform">
            <h3 class="section-title">Crear Rol</h3>
            <p>Este formulario te ayudará a crear un nuevo rol en la plataforma.</p>
        </div>
        <div class="card">
            <h5 class="card-header">Crear Rol</h5>
            <div class="card-body">
                <form action="{{ route('roles.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="col-form-label">Identificador del rol</label>
                        <input id="r_name" name="name" type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}">

                        @if ($errors->has('name'))
                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-form-label">Descripción del rol</label>
                        <input id="r_description" name="description" type="text" class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" value="{{ old('description') }}">

                        @if ($errors->has('description'))
                        <div class="invalid-feedback">{{ $errors->first('description') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="protected" value="1">
                            <span class="custom-control-label">Rol del sistema</span>
                        </label>
                        <p>Un rol del sistema solo puede ser asignado a los usuarios por un súper administrador.</p>
                    </div>
                    <hr>
                    <h4>Permisos disponibles ({{ count($permissions) }})</h4>
                    <div class="form-group">
                        <div class="row">
                            @foreach ($permissions as $id => $description)
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-6">
                                <label class="custom-control custom-checkbox">
                                    <input class="custom-control-input {{ $errors->has('permissions') ? ' is-invalid' : '' }}" type="checkbox" name="permissions[]" value="{{ $id }}">
                                    <span class="custom-control-label">{{ $description ?: 'Sin descripción' }}</span>
                                </label>
                            </div>
                            @endforeach
                        </div>

                        @if ($errors->has('permissions'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('permissions') }}</strong>
                        </div>
                        @endif
                    </div>
                    <div class="col-sm-12 pl-0">
                        <p class="text-right">
                            <a href="{{ route('roles.index') }}" class="btn btn-sm btn-secondary" role="button">Volver</a>
                            <button class="btn btn-sm btn-primary" type="submit">Guardar cambios</button>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@else
<div class="alert alert-danger" role="alert">
    No tienes permiso para crear nuevos roles.
</div>
@endcan
@stop
