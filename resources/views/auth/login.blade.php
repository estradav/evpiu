<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <title>Iniciar sesión</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    </head>
    <body>
        <div class="login-dark">
            <form method="POST" action="{{ route('login') }}" autocomplete='off'>
                @csrf
                <h2 class="sr-only">Login Form</h2>
                <div class="illustration"><i class="icon ion-android-lock"></i></div>
                <div class="form-group">
                    <input type="text" name="username" placeholder="Usuario" class="form-control form-control-lg{{ $errors->has('username') ? ' is-invalid' : '' }}" value="{{ old('username') }}" autocomplete="off" />
                    @if ($errors->has('username'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Contraseña" class="form-control form-control-lg{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"  autocomplete="off" />
                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-block" type="submit">Iniciar sesión</button>
                </div>
            </form>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>

        <style>
            .login-dark{height:1000px;background:url(/img/star-sky.jpg) #475d62;background-size:cover;position:relative}.login-dark form{max-width:320px;width:90%;background-color:#1e2833;padding:40px;border-radius:4px;transform:translate(-50%,-50%);position:absolute;top:50%;left:50%;color:#fff;box-shadow:3px 3px 4px rgba(0,0,0,.2)}.login-dark .illustration{text-align:center;padding:15px 0 20px;font-size:100px;color:#2980ef}.login-dark form .form-control{background:0 0;border:none;border-bottom:1px solid #434a52;border-radius:0;box-shadow:none;outline:0;color:inherit}.login-dark form .btn-primary{background:#214a80;border:none;border-radius:4px;padding:11px;box-shadow:none;margin-top:26px;text-shadow:none;outline:0}.login-dark form .btn-primary:active,.login-dark form .btn-primary:hover{background:#214a80;outline:0}.login-dark form .forgot{display:block;text-align:center;font-size:12px;color:#6f7a85;opacity:.9;text-decoration:none}.login-dark form .forgot:active,.login-dark form .forgot:hover{opacity:1;text-decoration:none}.login-dark form .btn-primary:active{transform:translateY(1px)}

        </style>
    </body>
</html>






{{--

@section('title', 'Acceder')

@section('content')
<div class="card">
    <div class="card-header text-center"><a href="javascript:void(0);"><img class="logo-img" src="{{ asset('/img/ev_vector.png') }}" alt="logo"></a><span class="splash-description">Por favor ingresa tus credenciales para acceder a la plataforma.</span></div>
    <div class="card-body">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <input id="username" type="text" class="form-control form-control-lg{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" placeholder="Usuario" required autofocus>

                @if ($errors->has('username'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('username') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <input id="password" type="password" class="form-control form-control-lg{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Contraseña" required>

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
        --}}{{--<div class="card-footer-item card-footer-item-bordered">
            <a href="{{ route('register') }}" class="footer-link">{{ __('Crear cuenta') }}</a>
        </div>--}}{{--
        @if (Route::has('password.request'))
        <div class="card-footer-item card-footer-item-bordered">
            <a href="{{ route('password.request') }}" class="footer-link">{{ __('Olvidé mi contraseña') }}</a>
        </div>
        @endif
    </div>
</div>

<div class="login-dark">
    <form method="post">
        <h2 class="sr-only">Login Form</h2>
        <div class="illustration"><i class="icon ion-ios-locked-outline"></i></div>
        <div class="form-group"><input type="user" name="Usuario" placeholder="Usuario" class="form-control" /></div>
        <div class="form-group"><input type="password" name="password" placeholder="Contraseña" class="form-control" /></div>
        <div class="form-group"><button class="btn btn-primary btn-block" type="submit">Iniciar sesion</button></div>
    </form>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="resources/externos/assets/css/styles.min.css">



<style>
    body {
        background: #cccccc url("/img/back.JPG") no-repeat fixed center center;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
    }
</style>
@endsection--}}
