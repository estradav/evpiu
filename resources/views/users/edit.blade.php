@extends('layouts.dashboard')

@section('page_title', 'Modificar usuario')

@section('module_title', 'Usuarios')

@section('subtitle', 'Este módulo gestiona todos los usuarios de la aplicación.')

@section('breadcrumbs')
{{ Breadcrumbs::render('user_edit', $user) }}
@stop

@section('content')
    @can('users.edit')
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="section-block" id="basicform">
                    <h3 class="section-title">Modificar usuario</h3>
                    <p>Este formulario te ayudará a actualizar la información de un usuario existente en la aplicación.</p>
                </div>
                <div class="card">
                    <h5 class="card-header">Modificar usuario: {{ $user->name }}</h5>
                    <div class="card-body">
                        <h4>Datos personales</h4>
                        <div class="form-group">
                            <label for="name" class="col-form-label">Nombre del usuario <span class="text-secondary">*</span></label>
                            <input id="u_name" name="name" type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ $user->name }}">

                            @if ($errors->has('name'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('name') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-form-label">Correo electrónico del usuario <span class="text-secondary">*</span></label>
                            <input id="u_email" name="email" type="text" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ $user->email }}">

                            @if ($errors->has('email'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('email') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="username" class="col-form-label">Nick del usuario <span class="text-secondary">*</span></label>
                            <input id="u_username" name="username" type="text" class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}" value="{{ $user->username }}">

                            @if ($errors->has('username'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('username') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-form-label">Nueva contraseña</label>
                            <input id="u_password" name="password" type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}">

                            @if ($errors->has('password'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('password') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation" class="col-form-label">Confirmar contraseña</label>
                            <input id="u_password-confirm" type="password" class="form-control" name="password_confirmation">
                        </div>
                    </div>
                    <div class="card-body border-top">
                        <h4>Roles asociados ({{ $user->roles->count() }})</h4>
                        <div class="row">
                            @forelse ($user->roles as $userRole)
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-6">
                                <label class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" name="assigned_roles[]" value="{{ $userRole->id }}" checked>
                                    <span class="custom-control-label">{{ $userRole->description ?: 'Sin descripción' }}</span>
                                </label>
                            </div>
                            @empty
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <p class="card-text">Este usuario no tiene roles asociados.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                    <div class="card-body border-top">
                        <h4>Roles disponibles ({{ $availableRoles->count() }})</h4>
                        <div class="row">
                            @forelse ($availableRoles as $id => $description)
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-6">
                                <label class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" name="avail_roles[]" value="{{ $id }}">
                                    <span class="custom-control-label">{{ $description ?: 'Sin descripción' }}</span>
                                </label>
                            </div>
                            @empty
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <p class="card-text">No hay más roles disponibles para asociar a este usuario.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                    <div class="card-body border-top">
                        <h4>Permisos heredados ({{ $inheritedPermissions->count() }}) <small class="text-secondary">(<em>Solo lectura</em>)</small></h4>
                        <div class="row">
                            @forelse ($inheritedPermissions as $id => $description)
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-6">
                                <label class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" name="inh_perms[]" value="{{ $id }}" onclick="return false;" checked>
                                    <span class="custom-control-label">{{ $description ?: 'Sin descripción' }}</span>
                                </label>
                            </div>
                            @empty
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <p class="card-text">Este usuario no cuenta con permisos heredados.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                    <div class="card-body border-top">
                        <h4>Permisos asociados ({{ $user->permissions->count() }})</h4>
                        <div class="row">
                            @forelse ($user->permissions as $userPermission)
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-6">
                                <label class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" name="assigned_perms[]" value="{{ $userPermission->id }}" checked>
                                    <span class="custom-control-label">{{ $userPermission->description ?: 'Sin descripción' }}</span>
                                </label>
                            </div>
                            @empty
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <p class="card-text">Este usuario no cuenta con permisos asociados.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                    <div class="card-body border-top">
                        <h4>Permisos disponibles ({{ count($availablePermissions) }})</h4>
                        <div class="row">
                            @forelse ($availablePermissions as $id => $description)
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-6">
                                <label class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" name="avail_perms[]" value="{{ $id }}">
                                    <span class="custom-control-label">{{ $description ?: 'Sin descripción' }}</span>
                                </label>
                            </div>
                            @empty
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <p class="card-text">No hay permisos disponibles para asociar al usuario.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-sm-12 pl-0">
                            <p class="text-right">
                                <a href="{{ route('users.index') }}" class="btn btn-sm btn-secondary" role="button">Volver</a>
                                <button class="btn btn-sm btn-primary" type="submit">Guardar cambios</button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @else
    <div class="alert alert-danger" role="alert">
        No tienes permiso para editar usuarios.
    </div>
    @endcan
@stop
