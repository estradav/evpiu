@extends('layouts.dashboard')

@section('page_title', 'Modificar usuario')

@section('module_title', 'Usuarios')

@section('subtitle', 'Este módulo gestiona todos los usuarios de la aplicación.')

@section('breadcrumbs')
    {{ Breadcrumbs::render('dmsuser_edit', $dmsuser) }}
@stop

@section('content')
    @can('dmsusers.edit')
        <form action="{{ route('users.update', $dmsuser->usuario) }}" method="POST">
            @csrf
            @method('put')
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="section-block" id="basicform">
                        <h3 class="section-title">Modificar usuario</h3>
                        <p>Este formulario te ayudará a actualizar la información de un usuario existente en la aplicación.</p>
                    </div>
                    <div class="card">
                        <h5 class="card-header">Modificar usuario: {{ $dmsuser->usuario }}</h5>
                        <div class="card-body">
                            <h4>Datos personales</h4>
                            <div class="form-group">
                                <label for="name" class="col-form-label">Nombre del usuario <span class="text-secondary">*</span></label>
                                <input id="u_name" name="name" type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ $dmsuser->usuario }}">

                                @if ($errors->has('name'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="des_usuario" class="col-form-label">descripcion <span class="text-secondary">*</span></label>
                                <input id="u_email" name="email" type="text" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ $dmsuser->des_usuario }}">

                                @if ($errors->has('email'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="username" class="col-form-label">Estado de bloqueo <span class="text-secondary">*</span></label>
                                <input id="u_username" name="username" type="text" class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}" value="{{ $dmsuser->bloqueado }}">

                                @if ($errors->has('username'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-form-label">Razon de Bloqueo</label>
                                <input id="u_password" name="password" type="text" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" value="{{ $dmsuser->razon_bloqueado }}>

                                @if ($errors->has('password'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </div>
                                @endif
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
        </form>
    @else
        <div class="alert alert-danger" role="alert">
            No tienes permiso para editar usuarios.
        </div>
    @endcan
@stop


