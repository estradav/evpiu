@extends('layouts.dashboard')

@section('page_title', 'Crear permiso')

@section('module_title', 'Permisos')

@section('subtitle', 'Este módulo gestiona todos los permisos de los roles de la aplicación.')

@section('breadcrumbs')
{{ Breadcrumbs::render('permission_create') }}
@stop

@section('content')
@can('permissions.create')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="section-block" id="basicform">
            <h3 class="section-title">Crear Permiso</h3>
            <p>Este formulario te ayudará a crear un nuevo permiso en la plataforma.</p>
        </div>
        <div class="card">
            <h5 class="card-header">Crear Permiso</h5>
            <div class="card-body">
                <form action="{{ route('permissions.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="col-form-label">Identificador del permiso</label>
                        <input id="p_name" name="name" type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}">

                        @if ($errors->has('name'))
                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-form-label">Descripción del permiso</label>
                        <input id="p_description" name="description" type="text" class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" value="{{ old('description') }}">

                        @if ($errors->has('description'))
                        <div class="invalid-feedback">{{ $errors->first('description') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="protected" value="1">
                            <span class="custom-control-label">Permiso del sistema</span>
                        </label>
                        <p>Un permiso del sistema solo puede ser asignado a los usuarios y roles por un súper administrador.</p>
                    </div>
                    <div class="col-sm-12 pl-0">
                        <p class="text-right">
                            <a href="{{ route('permissions.index') }}" class="btn btn-sm btn-secondary" role="button">Volver</a>
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
    No tienes permiso para crear nuevos permisos.
</div>
@endcan
@stop
