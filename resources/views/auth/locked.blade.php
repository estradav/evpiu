@extends('layouts.auth')

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
@endsection
