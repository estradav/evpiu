@extends('layouts.dashboard')

@section('page_title', 'Crear Menu')

@section('module_title', 'Menus')

@section('subtitle', 'Este módulo sirve para gestionar los menus y sus elementos que permiten acceder a diferentes secciones de la plataforma.')

@section('breadcrumbs')
{{ Breadcrumbs::render('menu_create') }}
@stop

@section('content')
    @can('menus.create')
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
                <h5 class="card-header">Crear menú</h5>
                <div class="card-body">
                    <form action="{{ route('menus.store')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Escribe el nombre del menú" value="{{ old('name') }}">
                        </div>
                        <input type="submit" class="btn btn-sm btn-primary" value="Guardar">
                    </form>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="alert alert-danger" role="alert">
        No tienes permisos para crear menus.
    </div>
    @endcan
@stop
