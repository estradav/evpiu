@extends('layouts.auth')

@section('title', 'Registrarse')

@section('content')
<div class="splash-container">
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="card">
            <div class="card-header">
                <h3 class="mb-1">Registro de usuario</h3>
                <p>Por favor diligencia tu información para crearte una cuenta en la aplicación.</p>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <input id="name" type="text" class="form-control form-control-lg{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" placeholder="Tu nombre completo" required autofocus>

                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <input id="email" type="email" class="form-control form-control-lg{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Tu correo electrónico" required>

                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <input id="username" type="text" class="form-control form-control-lg{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" placeholder="Tu alias o nombre de usuario" required>

                    @if ($errors->has('username'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <input id="password" type="password" class="form-control form-control-lg{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Tu contraseña" required>

                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <input id="password-confirm" type="password" class="form-control form-control-lg" name="password_confirmation"  placeholder="Confirma tu contraseña" required>
                </div>
                <div class="form-group pt-2">
                    <button class="btn btn-block btn-primary" type="submit">¡Registrarme!</button>
                </div>
            </div>
            <div class="card-footer bg-white">
                <p>¿Ya tenés una cuenta?, <a href="{{ route('login') }}" class="text-secondary">¡Entra aquí!</a></p>
            </div>
        </div>
    </form>
</div>
@endsection
