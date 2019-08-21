@extends('layouts.dashboard')

@section('page_title', 'Modificar publicación')

@section('module_title', 'Publicaciones')

@section('subtitle', 'Este módulo gestiona todas las publicaciones del blog de la aplicación.')

@section('breadcrumbs')
{{ Breadcrumbs::render('post_edit', $post) }}
@stop

@section('content')
@can('posts.edit')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="section-block" id="basicform">
                <h3 class="section-title">Modificar publicación</h3>
                <p>Este formulario te ayudará a actualizar una publicación existente en la aplicación; Sí aún no está publicada, ¡puedes publicarla ahora mismo!, aunque sí aún te faltan ideas puedes dejarla para después...</p>
            </div>
            <div class="card">
                <h5 class="card-header">Modificar publicación ({{ $post->title }})</h5>
                <div class="card-body">
                    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="title" class="col-form-label">Título de la publicación</label>
                            <input id="p_title" name="title" type="text" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ $post->title }}">

                            @if ($errors->has('title'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('title') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="subtitle" class="col-form-label">Subtítulo de la publicación</label>
                            <input id="p_subtitle" name="subtitle" type="text" class="form-control {{ $errors->has('subtitle') ? ' is-invalid' : '' }}" value="{{ $post->subtitle }}">

                            @if ($errors->has('subtitle'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('subtitle') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="slug" class="col-form-label">Slug de la publicación</label>
                            <input id="p_slug" name="slug" type="text" class="form-control {{ $errors->has('slug') ? ' is-invalid' : '' }}" value="{{ $post->slug }}">

                            @if ($errors->has('slug'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('slug') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="categories" class="col-form-label">Categorías de la publicación</label>
                            <select id="p_categories" class="form-control select2" name="categories[]" data-placeholder="Selecciona una categoría" multiple="multiple">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        @foreach ($post->categories as $postCategory)
                                            @if ($postCategory->id == $category->id)
                                                selected
                                            @endif
                                        @endforeach
                                        >{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tags" class="col-form-label">Etiquetas de la publicación</label>
                            <select id="p_tags" class="form-control select2" name="tags[]" multiple="multiple">
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->id }}"
                                        @foreach ($post->tags as $postTag)
                                            @if ($postTag->id == $tag->id)
                                                selected
                                            @endif
                                        @endforeach
                                        >{{ $tag->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-form-label">Imagen de portada</label>
                            <input type="file" class="form-control-file {{ $errors->has('image') ? ' is-invalid' : '' }}" id="p_image" name="image">

                            @if ($errors->has('image'))
                            <div class="invalid-feedback">{{ $errors->first('image') }}</div>
                            @endif
                        </div>
                        @if(empty(!$post->image))
                        <div class="form-group">
                            <label for="p_uploaded_image">Imagen actual</label>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                <img class="img-fluid" id="p_uploaded_image" src="{{ Storage::disk('local')->url($post->image) }}" alt="Imagen de portada">
                            </div>
                        </div>
                        @endif
                        <div class="form-group">
                            <label for="body">Contenido de la publicación</label>
                            <textarea class="form-control {{ $errors->has('body') ? ' is-invalid' : '' }}" name="body" id="p_body">{{ $post->body }}</textarea>

                            @if ($errors->has('body'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('body') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-sm-6 pb-2 pb-sm-4 pb-lg-0 pr-0">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" id="p_status" name="status" class="custom-control-input" value="1" @if ($post->status == 1) {{ 'checked=""' }} @endif><span class="custom-control-label">Publicar</span>
                                </label>
                            </div>
                            <div class="col-sm-6 pl-0">
                                <p class="text-right">
                                    <a href="{{ route('posts.index') }}" class="btn btn-sm btn-secondary" role="button">Volver</a>
                                    <button class="btn btn-sm btn-primary" type="submit">Guardar cambios</button>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@else
<div class="alert alert-danger" role="alert">
    No tienes permiso para editar publicaciones.
</div>
@endcan
@stop

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">
@endpush

@push('javascript')
<script src="https://cdn.ckeditor.com/4.11.2/standard/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
<script>
    $('.select2').select2();
    CKEDITOR.replace( 'p_body' );
</script>
@endpush
