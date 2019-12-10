@extends('layouts.auth')

@section('title', 'Cambiar mi contraseña')

@section('content')
<div class="splash-container">
    <div class="card">
        <div class="card-header">
            <h3 class="mb-1">Cambiar mi contraseña</h3>
            <p>Por favor diligencia la siguiente información para actualizar tu contraseña.</p>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group">
                    <input id="email" type="email" class="form-control form-control-lg{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" placeholder="Tu correo electrónico" required autofocus>

                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
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
                    <button class="btn btn-block btn-primary" type="submit">Cambiar mi contraseña</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
