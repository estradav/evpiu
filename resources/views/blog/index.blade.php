@extends('layouts.blog')

@section('action_recaptcha')
    {!! htmlScriptTagJsApi([ 'action' => 'blog' ]) !!}
@endsection

@section('bg-img')
    {{ asset('img/home_bg.JPG') }}
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
            @if($posts->isEmpty())
                <div class="post-preview">
                    <p>Aún no hay artículos para mostrar. 😔</p>
                </div>
            @else
                @foreach ($posts as $post)
                    <div class="post-preview">
                        <a href="{{ route('post', $post->slug) }}">
                            <h2 class="post-title">{{ $post->title }}</h2>
                            <h3 class="post-subtitle">{{ $post->subtitle }}</h3>
                        </a>
                        <p class="post-meta">Publicado por <a href="javascript:void(0)">{{ $post->user->name  }}</a> {{ $post->created_at->diffForHumans() }}</p>
                    </div>
                    <hr>
                @endforeach
                <!-- Pager -->
                <div class="clearfix">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </div>
@stop
