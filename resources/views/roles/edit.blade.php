@extends('layouts.dashboard')

@section('page_title', 'Modificar rol')

@section('module_title', 'Roles')

@section('subtitle', 'Este módulo gestiona todos los roles de los usuarios de la aplicación.')

@section('breadcrumbs')
{{ Breadcrumbs::render('role_edit', $role) }}
@stop

@section('content')
@can('roles.edit')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="section-block" id="basicform">
            <h3 class="section-title">Modificar rol</h3>
            <p>Este formulario te ayudará a actualizar un rol existente en la aplicación.</p>
        </div>
        <div class="card">
            <h5 class="card-header">Modificar rol: {{ $role->description }}</h5>
            <div class="card-body">
                <form action="{{ route('roles.update', $role->id) }}" method="POST">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label for="name" class="col-form-label">Nombre del rol</label>
                        <input id="r_name" name="name" type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ $role->name }}">

                        @if ($errors->has('name'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('name') }}</strong>
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-form-label">Descripción del rol</label>
                        <input id="r_description" name="description" type="text" class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" value="{{ $role->description }}">

                        @if ($errors->has('description'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('description') }}</strong>
                        </div>
                        @endif
                    </div>
                    <h4>Permisos disponibles ({{ count($permissions) }})</h4>
                    <div class="form-group">
                        <div class="row">
                            @foreach ($permissions as $permission)
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-6">
                                <label class="custom-control custom-checkbox">
                                    <input class="custom-control-input {{ $errors->has('permissions') ? ' is-invalid' : '' }}" type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                        @foreach ($rolePermissions as $rolePermission)
                                            @if ($rolePermission->id == $permission->id)
                                                checked
                                            @endif
                                        @endforeach>
                                    <span class="custom-control-label">{{ $permission->description ?: 'Sin descripción' }}</span>
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
                    <div class="row">
                        <div class="col-sm-12 pl-0">
                            <p class="text-right">
                                <a href="{{ route('roles.index') }}" class="btn btn-sm btn-secondary" role="button">Volver</a>
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
    No tienes permiso para editar roles.
</div>
@endcan
@stop
