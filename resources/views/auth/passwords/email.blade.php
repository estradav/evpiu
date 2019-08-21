@extends('layouts.auth')

@section('title', 'Restablecer contraseña')

@section('content')
<div class="card">
<div class="card-header text-center"><img class="logo-img" src="{{ asset('/img/ev_vector.png') }}" alt="logo"><span class="splash-description">Por favor ingresa tu correo electrónico para restablecer tu contraseña.</span></div>
    <div class="card-body">
        @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <p>No te preocupes, te podemos enviar un correo electrónico para que cambies tu contraseña.</p>
            <div class="form-group">
                <input id="email" type="email" class="form-control form-control-lg{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Tu correo electrónico" required>

                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group pt-1">
                <button type="submit" class="btn btn-block btn-primary btn-xl">{{ __('Solicitar cambio de contraseña') }}</button>
            </div>
        </form>
    </div>
    <div class="card-footer text-center">
        <span>¿Aún no tenés una cuenta?, <a class="text-secondary" href="{{ route('register') }}">¡Regístrate!</a></span>
    </div>
</div>
@endsection
