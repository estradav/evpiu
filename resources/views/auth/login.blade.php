@extends('layouts.auth')

@section('title', 'Acceder')

@section('content')
<div class="card">
    <div class="card-header text-center"><a href="javascript:void(0);"><img class="logo-img" src="{{ asset('/img/ev_vector.png') }}" alt="logo"></a><span class="splash-description">Por favor ingresa tus credenciales para acceder a la plataforma.</span></div>
    <div class="card-body">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <input id="email" type="email" class="form-control form-control-lg{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Tu correo electrónico" required autofocus>

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
                <label class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}><span class="custom-control-label">{{ __('Recuérdame') }}</span>
                </label>
            </div>
            <button type="submit" class="btn btn-primary btn-lg btn-block">{{ __('Acceder') }}</button>
        </form>
    </div>
    <div class="card-footer bg-white p-0">
        <div class="card-footer-item card-footer-item-bordered">
            <a href="{{ route('register') }}" class="footer-link">{{ __('Crear cuenta') }}</a>
        </div>
        @if (Route::has('password.request'))
        <div class="card-footer-item card-footer-item-bordered">
            <a href="{{ route('password.request') }}" class="footer-link">{{ __('Olvidé mi contraseña') }}</a>
        </div>
        @endif
    </div>
</div>
@endsection
