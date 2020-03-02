<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <title>Usuario Bloqueado</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    </head>
    <body>
        <div class="login-dark">
            <form method="POST" action="{{ route('login.unlock') }}" autocomplete='off'>
                @csrf
                <h2 class="sr-only">Unlock</h2>
                <div class="illustration">
                    <i class="icon ion-android-unlock"></i><br>
                </div>
                <div align="center">
                    <h5><b>{{ Auth::user()->name }}</b></h5>
                </div>
                <label class="text-center">Usuario bloqueado, escriba su contraseña para continuar.</label>
                <div class="form-group">
                    <input type="password" placeholder="Contraseña" class="form-control form-control-lg{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"  autocomplete="off" />
                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-block" type="submit">Desbloquear</button>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();" class="btn btn-primary btn-block">{{ __('Cambiar de usuario') }}</a>
                </div>
            </form>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>

        <style>
            .login-dark{
                height:1000px;
                background:url(/img/star-sky.jpg) #475d62;
                background-size:cover;
                position:relative
            }
            .login-dark form{
                max-width:320px;
                width:90%;
                background-color:#1e2833;
                padding:40px;
                border-radius:4px;
                transform:translate(-50%,-50%);
                position:absolute;
                top:50%;
                left:50%;
                color:#fff;
                box-shadow:3px 3px 4px rgba(0,0,0,.2)
            }
            .login-dark .illustration{
                text-align:center;
                padding:0px 0 0px;
                font-size:100px;
                color:#2980ef
            }
            .login-dark form .form-control{
                background:0 0;
                border:none;
                border-bottom:1px solid #434a52;
                border-radius:0;
                box-shadow:none;
                outline:0;
                color:inherit
            }
            .login-dark form .btn-primary{
                background:#214a80;
                border:none;
                border-radius:4px;
                padding:11px;
                box-shadow:none;
                margin-top:10px;
                text-shadow:none;
                outline:0
            }
            .login-dark form .btn-primary:active,.login-dark form .btn-primary:hover{background:#214a80;outline:0}.login-dark form .forgot{display:block;text-align:center;font-size:12px;color:#6f7a85;opacity:.9;text-decoration:none}.login-dark form .forgot:active,.login-dark form .forgot:hover{opacity:1;text-decoration:none}.login-dark form .btn-primary:active{transform:translateY(1px)}

        </style>
    </body>
</html>


















{{--@extends('layouts.auth')

@section('title', 'Bloqueado')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-16">
                <div class="card">
                    <div class="card-header text-center">{{ __('Bloqueado') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('login.unlock') }}" aria-label="{{ __('Locked') }}">
                            @csrf
                            <div class="text-center" style="font-size: 48px;">
                                <i class="fas fa-user-lock fa-x20"></i>
                            </div>
                            <div align="center">
                                <h3><b>{{ Auth::user()->name }}</b></h3>
                            </div>
                            <label class="text-center">Su usuario ha sido bloqueado por inactividad, por favor escriba su contraseña para desbloquear.</label>
                            <div class="form-group row">
                                <label for="password" class="col-md-12 col-form-label text-center">{{ __('Contraseña:') }}</label>
                                <div class="col-md-12">
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-block">{{ __('Desbloquear') }}</button>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();" class="btn btn-primary btn-block">{{ __('Cambiar de Usuario') }}</a>

                                </div>
                            </div>
                        </form>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
