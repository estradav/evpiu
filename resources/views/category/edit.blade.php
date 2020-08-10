@extends('layouts.architectui')

@section('page_title', 'Modificar categoría')

@section('action_recaptcha')
    {!! htmlScriptTagJsApi([ 'action' => 'blog_categoria_editar' ]) !!}
@endsection

@section('content')
    @can('categories.edit')
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="section-block" id="basicform">
                    <h3 class="section-title">Modificar categoría</h3>
                    <p>Este formulario te ayudará a actualizar una categoría existente en la aplicación.</p>
                </div>
                <div class="card">
                    <h5 class="card-header">Modificar categoría ({{ $category->name }})</h5>
                    <div class="card-body">
                        <form action="{{ route('categories.update', $category->id) }}" method="POST">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label for="name" class="col-form-label">Nombre de la categoría</label>
                                <input id="t_name" name="name" type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ $category->name }}">

                                @if ($errors->has('name'))
                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="slug" class="col-form-label">Slug de la etiqueta</label>
                                <input id="t_slug" name="slug" type="text" class="form-control {{ $errors->has('slug') ? ' is-invalid' : '' }}" value="{{ $category->slug }}">

                                @if ($errors->has('slug'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('slug') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-sm-12 pl-0">
                                    <p class="text-right">
                                        <a href="{{ route('categories.index') }}" class="btn btn-sm btn-secondary" role="button">Volver</a>
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
        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-exclamation-triangle fa-4x" style="color: red"></i>
                <h3 class="card-title" style="color: red"> ACCESO DENEGADO </h3>
                <h3 class="card-text" style="color: red">No tiene permiso para usar esta aplicación, por favor comuníquese a la ext: 102 o escribanos al correo electrónico: auxsistemas@estradavelasquez.com para obtener acceso.</h3>
            </div>
        </div>
    @endcan
@stop
