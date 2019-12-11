@extends('layouts.dashboard')

@section('page_title', 'Crear rol')

@section('module_title', 'Roles')

@section('subtitle', 'Este módulo gestiona todos los roles de los usuarios de la aplicación.')

@section('breadcrumbs')
{{ Breadcrumbs::render('role_create') }}
@stop

@section('content')
@can('roles.create')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="section-block" id="basicform">
            <h3 class="section-title">Crear Rol</h3>
            <p>Este formulario te ayudará a crear un nuevo rol en la plataforma.</p>
        </div>
        <div class="card">
            <h5 class="card-header">Crear Rol</h5>
            <div class="card-body">
                <form action="{{ route('roles.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="col-form-label">Identificador del rol</label>
                        <input id="r_name" name="name" type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}">

                        @if ($errors->has('name'))
                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-form-label">Descripción del rol</label>
                        <input id="r_description" name="description" type="text" class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" value="{{ old('description') }}">

                        @if ($errors->has('description'))
                        <div class="invalid-feedback">{{ $errors->first('description') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="protected" value="1">
                            <span class="custom-control-label">Rol del sistema</span>
                        </label>
                        <p>Un rol del sistema solo puede ser asignado a los usuarios por un súper administrador.</p>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                            <h4>Permisos disponibles ({{ $permissionsQuantity }})</h4>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                            <a href="javascript:void(0);" class="btn btn-link" id="toggleGroups"><i class="fas fa-angle-down"></i> Expandir todo</a>
                        </div>
                    </div>
                    <p>Todos los permisos disponibles se mostrarán en su respectivo grupo asociado.</p>
                    <div class="form-group">
                        <div class="row">
                            @forelse ($permissionGroups as $permissionGroup)
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                                    <div class="accrodion-regular">
                                        <div id="accordion">
                                            <div class="card">
                                                <div class="card-header" id="heading-{{ $permissionGroup->id }}">
                                                    <h5 class="mb-0">
                                                        <a class="btn btn-link" data-toggle="collapse" data-target="#pContainer-{{ $permissionGroup->id }}" aria-expanded="false" aria-controls="pContainer-{{ $permissionGroup->id }}"><span class="fas mr-3 fa-plus"></span> {{ $permissionGroup->name . ' (' . $permissionGroup->permissions->count() . ')' ?: 'Sin descripción' }}</a>
                                                    </h5>
                                                </div>
                                                <div class="collapse multi-collapse" id="pContainer-{{ $permissionGroup->id }}" aria-labelledby="heading-{{ $permissionGroup->id }}">
                                                    <div class="card-body">
                                                        @if (!$permissionGroup->permissions->isEmpty())
                                                        <div class="row">
                                                        <a href="javascript:void(0);" class="btn btn-link selPerms">Marcar todos los permisos</a>
                                                        </div>
                                                        @endif
                                                    <div class="row">
                                                            @forelse ($permissionGroup->permissions as $permission)
                                                                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-6">
                                                                    <label class="custom-control custom-checkbox">
                                                                        <input class="custom-control-input {{ $errors->has('permissions') ? ' is-invalid' : '' }}" type="checkbox" name="permissions[]" value="{{ $permission->id }}">
                                                                        <span class="custom-control-label">{{ $permission->description ?: 'Sin descripción' }}</span>
                                                                    </label>
                                                                </div>
                                                            @empty
                                                                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-6">
                                                                    <p class="card-text">Este grupo no tiene permisos asociados.</p>
                                                                </div>
                                                            @endforelse
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-6">
                                    <p>No hay grupos de permisos para mostrar.</p>
                                </div>
                            @endforelse
                        </div>

                        @if ($errors->has('permissions'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('permissions') }}</strong>
                        </div>
                        @endif
                    </div>
                    <div class="col-sm-12 pl-0">
                        <p class="text-right">
                            <a href="{{ route('roles.index') }}" class="btn btn-sm btn-secondary" role="button">Volver</a>
                            <button class="btn btn-sm btn-primary" type="submit">Guardar cambios</button>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@else
<div class="alert alert-danger" role="alert">
    No tienes permiso para crear nuevos roles.
</div>
@endcan
@stop

@push('javascript')
    <script>
        $(document).ready(function () {
            var $toggleInput = document.getElementById('toggleGroups');
            var $selectPermissions = $('.selPerms');
            var $collapses = $('.multi-collapse');

            // Muestra y oculta el contenido de todos los grupos de permisos en forma de acordeón
            $toggleInput.onclick = function () {
                if ($toggleInput.firstChild.classList.contains('fa-angle-down')) {
                    $collapses.collapse('show');
                    $toggleInput.firstChild.classList.remove('fa-angle-down');
                    $toggleInput.firstChild.classList.add('fa-angle-up');
                    $toggleInput.childNodes[1].textContent = " Ocultar todo";
                } else {
                    $collapses.collapse('hide');
                    $toggleInput.firstChild.classList.remove('fa-angle-up');
                    $toggleInput.firstChild.classList.add('fa-angle-down');
                    $toggleInput.childNodes[1].textContent = " Expandir todo";
                }
            };

            // Marca una selección para todos los permisos de un grupo en específico
            $selectPermissions.on('click', function(event) {
                let $currElement = $(event.target);
                let $permissionsCheckBoxes = $currElement.parent().next().find(':checkbox');

                if ($permissionsCheckBoxes.is(':checked')) {
                    $currElement[0].textContent = 'Marcar todos los permisos';
                    $permissionsCheckBoxes.prop('checked', false);
                } else {
                    $currElement[0].textContent = 'Desmarcar todos los permisos';
                    $permissionsCheckBoxes.prop('checked', true);
                }
            });
        });
    </script>
@endpush
