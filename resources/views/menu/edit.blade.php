@extends('layouts.architectui')

@section('page_title', 'Modificar Menu')

@section('module_title', 'Menus')

@section('subtitle', 'Este módulo sirve para gestionar los menus y sus elementos que permiten acceder a diferentes secciones de la plataforma.')

@section('breadcrumbs')
{{ Breadcrumbs::render('menu_edit', $menu) }}
@stop

@section('content')
    @can('menus.edit')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="list">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card">
                <h5 class="card-header">Modificar menú ({{ $menu->name }})</h5>
                <div class="card-body">
                    <form action="{{ route('menus.update', $menu->id) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" id="m_name" name="name" placeholder="Escribe el nombre del menú" value="{{ $menu->name }}">
                        </div>
                        <input type="submit" class="btn btn-sm btn-primary" value="Guardar cambios">
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
