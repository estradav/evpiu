@extends('layouts.dashboard')

@section('page_title', 'Modificar permiso')

@section('module_title', 'Permisos')

@section('subtitle', 'Este módulo gestiona todos los permisos de los roles de la aplicación.')

@section('breadcrumbs')
{{ Breadcrumbs::render('permission_edit', $permission) }}
@stop

@section('content')
    @can('permissions.edit')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="section-block" id="basicform">
                <h3 class="section-title">Modificar permiso</h3>
                <p>Este formulario te ayudará a actualizar un permiso existente en la plataforma.</p>
            </div>
            <div class="card">
                <h5 class="card-header">Modificar permiso: {{ $permission->description }}</h5>
                <div class="card-body">
                    <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="name" class="col-form-label">Identificador del permiso</label>
                            <input id="p_name" name="name" type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ $permission->name }}">

                            @if ($errors->has('name'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('name') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-form-label">Descripción del permiso</label>
                            <input id="p_description" name="description" type="text" class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" value="{{ $permission->description }}">

                            @if ($errors->has('description'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('description') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-sm-12 pl-0">
                                <p class="text-right">
                                    <a href="{{ route('permissions.index') }}" class="btn btn-sm btn-secondary" role="button">Volver</a>
                                    <button class="btn btn-sm btn-primary" type="submit">Guardar cambios</button>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="alert alert-danger" role="alert">
        No tienes permiso para editar permisos.
    </div>
    @endcan
@stop
