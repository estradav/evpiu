@extends('layouts.blog')

@section('bg-img')
{{ asset('/img/home-bg.jpg') }}
@stop

@section('header')
<div class="site-heading noselect">
    <span class="subheading">Bienvenido a</span>
    <h1>EVPIU</h1>
    <span class="subheading">Plataforma de Información Unificada Estrada Velasquez</span>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-lg-8 col-md-10 mx-auto">
        <div class="post-preview">
            <a href="{{ url('/post') }}">
                <h2 class="post-title">Un nuevo comienzo...</h2>
                <h3 class="post-subtitle">En busca de centralizar y integrar la información</h3>
            </a>
            <p class="post-meta">Publicado por <a href="#">Martin Arboleda</a> en September 24, 2019</p>
        </div>
        <hr>
        <!-- Pager -->
        <div class="clearfix">
        <a class="btn btn-primary float-right" href="#">Publicaciones Antiguas &rarr;</a>
        </div>
    </div>
</div>
@stop
