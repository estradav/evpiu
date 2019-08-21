@extends('layouts.blog')

@section('bg-img', Storage::disk('local')->url($post->image))

@section('header')
<div class="post-heading noselect">
    <h1>{{ $post->title }}</h1>
    <h2 class="subheading">{{ $post->subtitle }}</h2>
    <span class="meta">
        Posteado por <a href="javascript:void(0)">{{ $post->user->name }}</a>
        {{ $post->created_at->diffForHumans() }}
    </span>
    @foreach ($post->categories as $category)
        <a href="{{ route('category', $category->slug) }}" class="badge badge-pill badge-primary">{{ $category->name }}</a>
    @endforeach
</div>
@stop

@section('content')
<article>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                {!! htmlspecialchars_decode($post->body) !!}
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                @if ($post->tags)
                    <ul class="list-inline">
                        @foreach($post->tags as $tag)
                            <li class="tag">
                                <a href="{{ route('tag', $tag->slug) }}" class="badge badge-pill badge-primary"><i class="fas fa-tag"></i> {{ $tag->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</article>
@stop
