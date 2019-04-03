@extends('layouts.dashboard')

@section('page_title', 'Modificar etiqueta')

@section('module_title', 'Etiquetas')

@section('subtitle', 'Este módulo gestiona todas las etiquetas de las publicaciones del blog de la aplicación.')

@section('breadcrumbs')
{{ Breadcrumbs::render('tag_edit', $tag) }}
@stop

@section('content')
    @can('tags.edit')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="section-block" id="basicform">
                <h3 class="section-title">Modificar Etiqueta</h3>
                <p>Este formulario te ayudará a crear una nueva etiqueta para una publicación.</p>
            </div>
            <div class="card">
                <h5 class="card-header">Modificar etiqueta ({{ $tag->name }})</h5>
                <div class="card-body">
                    <form action="{{ route('tags.update', $tag->id) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="name" class="col-form-label">Nombre de la etiqueta</label>
                            <input id="t_name" name="name" type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ $tag->name }}">

                            @if ($errors->has('name'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('name') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="slug" class="col-form-label">Slug de la etiqueta</label>
                            <input id="t_slug" name="slug" type="text" class="form-control {{ $errors->has('slug') ? ' is-invalid' : '' }}" value="{{ $tag->slug }}">

                            @if ($errors->has('slug'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('slug') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-sm-12 pl-0">
                                <p class="text-right">
                                    <a href="{{ route('tags.index') }}" class="btn btn-sm btn-secondary" role="button">Volver</a>
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
        No tienes permiso para editar etiquetas.
    </div>
    @endcan
@stop
