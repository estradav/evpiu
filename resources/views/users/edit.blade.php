@extends('layouts.dashboard')

@section('page_title', 'Modificar usuario')

@section('module_title', 'Usuarios')

@section('subtitle', 'Este módulo gestiona todos los usuarios de la aplicación.')

@section('breadcrumbs')
{{ Breadcrumbs::render('user_edit', $user) }}
@stop

@section('content')
    @can('users.edit')
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="section-block" id="basicform">
                    <h3 class="section-title">Modificar usuario</h3>
                    <p>Este formulario te ayudará a actualizar la información de un usuario existente en la aplicación.</p>
                </div>
                <div class="card">
                    <h5 class="card-header">Modificar usuario: {{ $user->name }}</h5>
                    <div class="card-body">
                        <h4>Datos personales</h4>
                        <div class="form-group">
                            <label for="name" class="col-form-label">Nombre del usuario <span class="text-secondary">*</span></label>
                            <input id="u_name" name="name" type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ $user->name }}">

                            @if ($errors->has('name'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('name') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-form-label">Correo electrónico del usuario <span class="text-secondary">*</span></label>
                            <input id="u_email" name="email" type="text" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ $user->email }}">

                            @if ($errors->has('email'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('email') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="username" class="col-form-label">Nick del usuario <span class="text-secondary">*</span></label>
                            <input id="u_username" name="username" type="text" class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}" value="{{ $user->username }}">

                            @if ($errors->has('username'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('username') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-form-label">Nueva contraseña</label>
                            <input id="u_password" name="password" type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}">

                            @if ($errors->has('password'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('password') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation" class="col-form-label">Confirmar contraseña</label>
                            <input id="u_password-confirm" type="password" class="form-control" name="password_confirmation">
                        </div>
                    </div>
                    <div class="card-body border-top">
                        <h4>Roles asociados ({{ $user->roles->count() }})</h4>
                        <div class="row">
                            @forelse ($user->roles as $userRole)
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-6">
                                <label class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" name="assigned_roles[]" value="{{ $userRole->id }}" checked>
                                    <span class="custom-control-label">{{ $userRole->description ?: 'Sin descripción' }}</span>
                                </label>
                            </div>
                            @empty
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <p class="card-text">Este usuario no tiene roles asociados.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                    <div class="card-body border-top">
                        <h4>Roles disponibles ({{ $availableRoles->count() }})</h4>
                        <div class="row">
                            @forelse ($availableRoles as $role)
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-6">
                                <label class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" name="avail_roles[]" value="{{ $role->id }}">
                                    <span class="custom-control-label">{{ $role->description ?: 'Sin descripción' }}</span>
                                </label>
                            </div>
                            @empty
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <p class="card-text">No hay más roles disponibles para asociar a este usuario.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                    <div class="card-body border-top">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                <h4>Permisos heredados ({{ $inheritedPermissions->count() }}) <small class="text-secondary">(<em>Solo lectura</em>)</small></h4>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                <a href="javascript:void(0);" class="btn btn-link" id="inhToggleGroups"><i class="fas fa-angle-down"></i> Expandir todo</a>
                            </div>
                        </div>

                        @if (!$inheritedPermissions->isEmpty())
                        <p>Todos los permisos heredados se mostrarán en su respectivo grupo asociado.</p>
                        @endif

                        <div class="row">
                            @forelse ($inheritedPermissionsGroups as $permissionGroup)
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                                    <div class="accrodion-regular">
                                        <div id="accordion">
                                            <div class="card">
                                                <div class="card-header" id="inhHeading-{{ $permissionGroup['id'] }}">
                                                    <h5 class="mb-0">
                                                        <a class="btn btn-link" data-toggle="collapse" data-target="#inhContainer-{{ $permissionGroup['id'] }}" aria-expanded="false" aria-controls="inhContainer-{{ $permissionGroup['id'] }}"><span class="fas mr-3 fa-plus"></span> {{ $permissionGroup['name'] . ' (' . $permissionGroup['permissions']->count() . ')' ?: 'Sin descripción' }}</a>
                                                    </h5>
                                                </div>
                                                <div class="collapse {{ (!$permissionGroup['permissions']->isEmpty()) ? 'show' : '' }} inh-multi-collapse" id="inhContainer-{{ $permissionGroup['id'] }}" aria-labelledby="inhHeading-{{ $permissionGroup['id'] }}">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            @forelse ($permissionGroup['permissions'] as $permission)
                                                                @if ($permission['group_id'] == $permissionGroup['id'])
                                                                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-6">
                                                                    <label class="custom-control custom-checkbox">
                                                                        <input class="custom-control-input" type="checkbox" name="inh_perms[]" value="{{ $permission['id'] }}" onclick="return false;" checked="checked">
                                                                        <span class="custom-control-label">
                                                                            @if ($permission['protected'])
                                                                            <span class="badge badge-primary"><i class="fas fa-lock"></i></span>
                                                                            @endif
                                                                            {{ $permission['description'] ?: 'Sin descripción' }}
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                                @endif
                                                            @empty
                                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
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
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <p class="card-text">Este usuario no cuenta con permisos heredados.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    <div class="card-body border-top">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                <h4>Permisos asociados ({{ $associatedPermissions->count() }})</h4>
                            </div>
                            @if (!$associatedPermissions->isEmpty())
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                <a href="javascript:void(0);" class="btn btn-link" id="assToggleGroups"><i class="fas fa-angle-down"></i> Expandir todo</a>
                            </div>
                            @endif
                        </div>

                        @hasrole('super-admin')
                        @else
                        @if (!$associatedPermissions->isEmpty())
                        <div class="alert alert-warning" role="alert">
                            <i class="fas fa-exclamation-triangle"></i> <b>ADVERTENCIA:</b> Aquí encontrarás algunos permisos que no podrás quitar. Pero tranquil@, ¡el Administrador del Sistema lo hará por ti!
                        </div>
                        @endif
                        @endhasrole

                        @if (!$associatedPermissions->isEmpty())
                        <p>Todos tus permisos asociados se mostrarán en su respectivo grupo asociado.</p>
                        @endif

                        <div class="row">
                            @forelse ($associatedPermissionsGroups as $permissionGroup)
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                                    <div class="accrodion-regular">
                                        <div id="accordion">
                                            <div class="card">
                                                <div class="card-header" id="assHeading-{{ $permissionGroup['id'] }}">
                                                    <h5 class="mb-0">
                                                        <a class="btn btn-link" data-toggle="collapse" data-target="#assContainer-{{ $permissionGroup['id'] }}" aria-expanded="false" aria-controls="assContainer-{{ $permissionGroup['id'] }}"><span class="fas mr-3 fa-plus"></span> {{ $permissionGroup['name'] . ' (' . $permissionGroup['permissions']->count() . ')' ?: 'Sin descripción' }}</a>
                                                    </h5>
                                                </div>
                                                <div class="collapse {{ (!$permissionGroup['permissions']->isEmpty()) ? 'show' : '' }} ass-multi-collapse" id="assContainer-{{ $permissionGroup['id'] }}" aria-labelledby="assHeading-{{ $permissionGroup['id'] }}">
                                                    <div class="card-body">
                                                        @if (!$permissionGroup['permissions']->isEmpty())
                                                        <div class="row">
                                                            <a href="javascript:void(0);" class="btn btn-link assSelPerms">Marcar todos los permisos</a>
                                                        </div>
                                                        @endif
                                                        <div class="row">
                                                            @forelse ($permissionGroup['permissions'] as $permission)
                                                                @if ($permission['group_id'] == $permissionGroup['id'])
                                                                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-6">
                                                                    <label class="custom-control custom-checkbox">
                                                                        @hasrole('super-admin')
                                                                        <input class="custom-control-input" type="checkbox" name="assigned_perms[]" value="{{ $permission['id'] }}" checked="checked">
                                                                        @else
                                                                        <input class="custom-control-input" type="checkbox" name="assigned_perms[]" value="{{ $permission['id'] }}" checked="checked"
                                                                            @if ($permission['protected'])
                                                                                data-type="restricted"
                                                                                onclick="return false;"
                                                                            @endif>
                                                                        @endhasrole
                                                                        <span class="custom-control-label">
                                                                            @if ($permission['protected'])
                                                                            <span class="badge badge-primary"><i class="fas fa-lock"></i></span>
                                                                            @endif
                                                                            {{ $permission['description'] ?: 'Sin descripción' }}
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                                @endif
                                                            @empty
                                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
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
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <p class="card-text">Este usuario no cuenta con permisos asociados.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    <div class="card-body border-top">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                <h4>Permisos disponibles ({{ $availablePermissions->count() }})</h4>
                            </div>
                            @if (!$availablePermissions->isEmpty())
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                <a href="javascript:void(0);" class="btn btn-link" id="avlbToggleGroups"><i class="fas fa-angle-down"></i> Expandir todo</a>
                            </div>
                            @endif
                        </div>

                        @hasrole('super-admin')
                        @else
                        <div class="alert alert-warning" role="alert">
                            <i class="fas fa-exclamation-triangle"></i> <b>ADVERTENCIA:</b> Aquí encontrarás algunos permisos que no podrás asignar. Pero tranquil@, ¡el Administrador del Sistema lo hará por ti!
                        </div>
                        @endhasrole

                        @if (!$availablePermissions->isEmpty())
                        <p>Todos los permisos disponibles se mostrarán en su respectivo grupo asociado.</p>
                        @endif

                        <div class="row">
                            @forelse ($availablePermissionsGroups as $permissionGroup)
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                                    <div class="accrodion-regular">
                                        <div id="accordion">
                                            <div class="card">
                                                <div class="card-header" id="avlbHeading-{{ $permissionGroup['id'] }}">
                                                    <h5 class="mb-0">
                                                        <a class="btn btn-link" data-toggle="collapse" data-target="#avlbContainer-{{ $permissionGroup['id'] }}" aria-expanded="false" aria-controls="avlbContainer-{{ $permissionGroup['id'] }}"><span class="fas mr-3 fa-plus"></span> {{ $permissionGroup['name'] . ' (' . $permissionGroup['permissions']->count() . ')' ?: 'Sin descripción' }}</a>
                                                    </h5>
                                                </div>
                                                <div class="collapse {{ (!$permissionGroup['permissions']->isEmpty()) ? 'show' : '' }} avlb-multi-collapse" id="avlbContainer-{{ $permissionGroup['id'] }}" aria-labelledby="avlbHeading-{{ $permissionGroup['id'] }}">
                                                    <div class="card-body">
                                                        @if (!$permissionGroup['permissions']->isEmpty())
                                                        <div class="row">
                                                            <a href="javascript:void(0);" class="btn btn-link avlbSelPerms">Marcar todos los permisos</a>
                                                        </div>
                                                        @endif
                                                        <div class="row">
                                                            @forelse ($permissionGroup['permissions'] as $permission)
                                                                @if ($permission['group_id'] == $permissionGroup['id'])
                                                                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-6">
                                                                    <label class="custom-control custom-checkbox">
                                                                        @hasrole('super-admin')
                                                                        <input class="custom-control-input" type="checkbox" name="avail_perms[]" value="{{ $permission['id'] }}">
                                                                        @else
                                                                        <input class="custom-control-input" type="checkbox" name="avail_perms[]" value="{{ $permission['id'] }}"
                                                                            @if ($permission['protected'])
                                                                                data-type="restricted"
                                                                                onclick="return false;"
                                                                            @endif>
                                                                        @endhasrole
                                                                        <span class="custom-control-label">
                                                                            @if ($permission['protected'])
                                                                            <span class="badge badge-primary"><i class="fas fa-lock"></i></span>
                                                                            @endif
                                                                            {{ $permission['description'] ?: 'Sin descripción' }}
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                                @endif
                                                            @empty
                                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
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
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <p class="card-text">No hay permisos disponibles para asignar.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-sm-12 pl-0">
                            <p class="text-right">
                                <a href="{{ route('users.index') }}" class="btn btn-sm btn-secondary" role="button">Volver</a>
                                <button class="btn btn-sm btn-primary" type="submit">Guardar cambios</button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @else
    <div class="alert alert-danger" role="alert">
        No tienes permiso para editar usuarios.
    </div>
    @endcan
@stop

@push('javascript')
    <script>
        $(document).ready(function () {
            var $inhToggleInput = document.getElementById('inhToggleGroups');
            var $assToggleInput = document.getElementById('assToggleGroups');
            var $avlbToggleInput = document.getElementById('avlbToggleGroups');
            var $inhCollapses = $('.inh-multi-collapse');
            var $assCollapses = $('.ass-multi-collapse');
            var $avlbCollapses = $('.avlb-multi-collapse');

            if ($inhToggleInput !== null) {
                // Verifica los acordeones que ya están desplegados para cambiar el texto de 'Expandir todo'
                if ($inhCollapses.is('.collapse.show')) {
                    $inhToggleInput.firstChild.classList.remove('fa-angle-down');
                    $inhToggleInput.firstChild.classList.add('fa-angle-up');
                    $inhToggleInput.childNodes[1].textContent = " Ocultar todo";
                } else {
                    $inhToggleInput.firstChild.classList.remove('fa-angle-up');
                    $inhToggleInput.firstChild.classList.add('fa-angle-down');
                    $inhToggleInput.childNodes[1].textContent = " Expandir todo";
                }

                // Muestra y oculta el contenido de todos los grupos de permisos en forma de acordeón
                $inhToggleInput.onclick = function () {
                    if ($inhToggleInput.firstChild.classList.contains('fa-angle-down')) {
                        $inhCollapses.collapse('show');
                        $inhToggleInput.firstChild.classList.remove('fa-angle-down');
                        $inhToggleInput.firstChild.classList.add('fa-angle-up');
                        $inhToggleInput.childNodes[1].textContent = " Ocultar todo";
                    } else {
                        $inhCollapses.collapse('hide');
                        $inhToggleInput.firstChild.classList.remove('fa-angle-up');
                        $inhToggleInput.firstChild.classList.add('fa-angle-down');
                        $inhToggleInput.childNodes[1].textContent = " Expandir todo";
                    }
                };
            }

            if ($assToggleInput !== null) {
                var $assSelectPermissions = $('.assSelPerms');

                // Verifica los acordeones que ya están desplegados para cambiar el texto de 'Expandir todo'
                if ($assCollapses.is('.collapse.show')) {
                    $assToggleInput.firstChild.classList.remove('fa-angle-down');
                    $assToggleInput.firstChild.classList.add('fa-angle-up');
                    $assToggleInput.childNodes[1].textContent = " Ocultar todo";
                } else {
                    $assToggleInput.firstChild.classList.remove('fa-angle-up');
                    $assToggleInput.firstChild.classList.add('fa-angle-down');
                    $assToggleInput.childNodes[1].textContent = " Expandir todo";
                }

                // Verifica las casillas que estén seleccionadas cuando carga la página para cambiar el texto de 'Marcar todos los permisos'
                $assCollapses.each(function(index, collapse) {
                    let $collapse = $(collapse);
                    let $permissionsCheckBoxes = $collapse.find(':checkbox');

                    $permissionsCheckBoxes.each(function(index, checkb) {
                        let $checkb = $(checkb);

                        if ($checkb.is(':checked')) {
                            $collapse.find('.assSelPerms')[0].textContent = 'Desmarcar todos los permisos';
                        }
                    });
                });

                // Muestra y oculta el contenido de todos los grupos de permisos en forma de acordeón
                $assToggleInput.onclick = function () {
                    if ($assToggleInput.firstChild.classList.contains('fa-angle-down')) {
                        $assCollapses.collapse('show');
                        $assToggleInput.firstChild.classList.remove('fa-angle-down');
                        $assToggleInput.firstChild.classList.add('fa-angle-up');
                        $assToggleInput.childNodes[1].textContent = " Ocultar todo";
                    } else {
                        $assCollapses.collapse('hide');
                        $assToggleInput.firstChild.classList.remove('fa-angle-up');
                        $assToggleInput.firstChild.classList.add('fa-angle-down');
                        $assToggleInput.childNodes[1].textContent = " Expandir todo";
                    }
                };

                // Marca una selección para todos los permisos de un grupo en específico
                $assSelectPermissions.on('click', function(event) {
                    let $currElement = $(event.target);
                    let $permissionsCheckBoxes = $currElement.parent().next().find(':checkbox');

                    // Cuando un grupo tiene consigo permisos del sistema, se etiquetan como restringidos y no son accesibles por algunos tipos de usuario
                    if ($permissionsCheckBoxes.filter('[data-type="restricted"]').length > 0) {
                        $permissionsCheckBoxes = $currElement.parent().next().find(':checkbox').not('[data-type="restricted"]');
                    }

                    if ($permissionsCheckBoxes.is(':not(:disabled)')) {
                        if ($permissionsCheckBoxes.is(':checked')) {
                            $currElement[0].textContent = 'Marcar todos los permisos';
                            $permissionsCheckBoxes.prop('checked', false);
                        } else {
                            $currElement[0].textContent = 'Desmarcar todos los permisos';
                            $permissionsCheckBoxes.prop('checked', true);
                        }
                    }
                });
            }

            if ($avlbToggleInput !== null) {
                var $avlbSelectPermissions = $('.avlbSelPerms');

                // Verifica los acordeones que ya están desplegados para cambiar el texto de 'Expandir todo'
                if ($avlbCollapses.is('.collapse.show')) {
                    $avlbToggleInput.firstChild.classList.remove('fa-angle-down');
                    $avlbToggleInput.firstChild.classList.add('fa-angle-up');
                    $avlbToggleInput.childNodes[1].textContent = " Ocultar todo";
                } else {
                    $avlbToggleInput.firstChild.classList.remove('fa-angle-up');
                    $avlbToggleInput.firstChild.classList.add('fa-angle-down');
                    $avlbToggleInput.childNodes[1].textContent = " Expandir todo";
                }

                // Muestra y oculta el contenido de todos los grupos de permisos en forma de acordeón
                $avlbToggleInput.onclick = function () {
                    if ($avlbToggleInput.firstChild.classList.contains('fa-angle-down')) {
                        $avlbCollapses.collapse('show');
                        $avlbToggleInput.firstChild.classList.remove('fa-angle-down');
                        $avlbToggleInput.firstChild.classList.add('fa-angle-up');
                        $avlbToggleInput.childNodes[1].textContent = " Ocultar todo";
                    } else {
                        $avlbCollapses.collapse('hide');
                        $avlbToggleInput.firstChild.classList.remove('fa-angle-up');
                        $avlbToggleInput.firstChild.classList.add('fa-angle-down');
                        $avlbToggleInput.childNodes[1].textContent = " Expandir todo";
                    }
                };

                // Marca una selección para todos los permisos de un grupo en específico
                $avlbSelectPermissions.on('click', function(event) {
                    let $currElement = $(event.target);
                    let $permissionsCheckBoxes = $currElement.parent().next().find(':checkbox');

                    // Cuando un grupo tiene consigo permisos del sistema, se etiquetan como restringidos y no son accesibles por algunos tipos de usuario
                    if ($permissionsCheckBoxes.filter('[data-type="restricted"]').length > 0) {
                        $permissionsCheckBoxes = $currElement.parent().next().find(':checkbox').not('[data-type="restricted"]');
                    }

                    if ($permissionsCheckBoxes.is(':not(:disabled)')) {
                        if ($permissionsCheckBoxes.is(':checked')) {
                            $currElement[0].textContent = 'Marcar todos los permisos';
                            $permissionsCheckBoxes.prop('checked', false);
                        } else {
                            $currElement[0].textContent = 'Desmarcar todos los permisos';
                            $permissionsCheckBoxes.prop('checked', true);
                        }
                    }
                });
            }
        });
    </script>
@endpush
