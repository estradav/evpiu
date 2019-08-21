@extends('layouts.dashboard')

@section('page_title', 'Crear publicación')

@section('module_title', 'Publicaciones')

@section('subtitle', 'Este módulo gestiona todas las publicaciones del blog de la aplicación.')

@section('breadcrumbs')
{{ Breadcrumbs::render('post_create') }}
@stop

@section('content')
@can('posts.create')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="section-block" id="basicform">
            <h3 class="section-title">Crear Publicación</h3>
            <p>Este formulario te ayudará a realizar una nueva publicación en la aplicación, ¡puedes crearla y publicarla ahora mismo!, aunque sí aún te faltan ideas puedes dejarla para después...</p>
        </div>
        <div class="card">
            <h5 class="card-header">Crear Publicación</h5>
            <div class="card-body">
                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="title" class="col-form-label">Título de la publicación</label>
                        <input id="p_title" name="title" type="text" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ old('title') }}">

                        @if ($errors->has('title'))
                        <div class="invalid-feedback">{{ $errors->first('title') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="subtitle" class="col-form-label">Subtítulo de la publicación</label>
                        <input id="p_subtitle" name="subtitle" type="text" class="form-control {{ $errors->has('subtitle') ? ' is-invalid' : '' }}" value="{{ old('subtitle') }}">

                        @if ($errors->has('subtitle'))
                        <div class="invalid-feedback">{{ $errors->first('subtitle') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="slug" class="col-form-label">Slug de la publicación</label>
                        <input id="p_slug" name="slug" type="text" class="form-control {{ $errors->has('slug') ? ' is-invalid' : '' }}" value="{{ old('slug') }}">

                        @if ($errors->has('slug'))
                        <div class="invalid-feedback">{{ $errors->first('slug') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="categories" class="col-form-label">Categorías de la publicación</label>
                        <select id="p_categories" class="custom-select select2 {{ $errors->has('categories') ? ' is-invalid' : '' }}" name="categories[]" data-placeholder="Selecciona una categoría" multiple="multiple">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ (collect(old('categories'))->contains($category->id)) ? 'selected':'' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>

                        @if ($errors->has('categories'))
                        <div class="invalid-feedback">{{ $errors->first('categories') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="tags" class="col-form-label">Etiquetas de la publicación</label>
                        <select id="p_tags" class="custom-select select2 {{ $errors->has('tags') ? ' is-invalid' : '' }}" name="tags[]" multiple="multiple">
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->id }}" {{ (collect(old('tags'))->contains($tag->id)) ? 'selected':'' }}>{{ $tag->name }}</option>
                            @endforeach
                        </select>

                        @if ($errors->has('tags'))
                            <div class="invalid-feedback">{{ $errors->first('tags') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-form-label">Imagen de portada</label>
                        <input type="file" class="form-control-file {{ $errors->has('image') ? ' is-invalid' : '' }}" id="p_image" name="image">

                        @if ($errors->has('image'))
                        <div class="invalid-feedback">{{ $errors->first('image') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="body">Contenido de la publicación</label>
                        <textarea class="form-control {{ $errors->has('body') ? ' is-invalid' : '' }}" name="body" id="p_body">{{ old('body') }}</textarea>

                        @if ($errors->has('body'))
                        <div class="invalid-feedback">{{ $errors->first('body') }}</div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-sm-6 pb-2 pb-sm-4 pb-lg-0 pr-0">
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" id="p_status" name="status" class="custom-control-input" value="1"><span class="custom-control-label">Publicar</span>
                            </label>
                        </div>
                        <div class="col-sm-6 pl-0">
                            <p class="text-right">
                                <a href="{{ route('posts.index') }}" class="btn btn-sm btn-secondary" role="button">Volver</a>
                                <button class="btn btn-sm btn-primary" type="submit">Guardar publicación</button>
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
    No tienes permiso para crear nuevas publicaciones.
</div>
@endcan
@stop

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@endpush

@push('javascript')
<script src="https://cdn.ckeditor.com/4.11.2/standard/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
    $('.select2').select2();
    CKEDITOR.replace( 'p_body' );
</script>
@endpush
