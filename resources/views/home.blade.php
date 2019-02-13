@extends('layouts.dashboard')

@section('title_icon_class', 'fas fa-tachometer-alt')
@section('title', 'Tablero')

@section('subtitle', 'Aquí podrás ver diferentes estadísticas y gráficas basadas en tus intereses.')

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <div class="card-header">Dashboard</div>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                You are logged in!
            </div>
        </div>
    </div>
</div>
@endsection
