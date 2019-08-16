<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\User;
use App\Role;
use App\Permission;
use App\PermissionGroup;
use App\Http\Requests\UserFormRequest;

class UserController extends Controller
{
    /**
     * Protege los métodos del controlador por medio de permisos
     * y utilizando el middleware del paquete de roles y permisos.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:users.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:users.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:users.destroy', ['only' => ['destroy']]);
    }

    /**
     * Muestra una lista de todos los usuarios de la plataforma.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return view('users.index', compact('users'));
    }

    /**
     * Este método no es utilizado ya que solo se deben de
     * registrar los usuarios de la plataforma por su cuenta.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Este método no es utilizado ya que solo se deben de
     * registrar los usuarios de la plataforma por su cuenta.
     *
     * @return void
     */
    public function store()
    {
        //
    }

    /**
     * Proporciona la información de un usuario en específico
     * junto con sus roles y permisos asociados.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        // Obtiene los permisos del usuario
        $userPermissions = $user->getAllPermissions();

        return view('users.show', compact('user', 'userPermissions'));
    }

    /**
     * Muestra el formulario para editar la información de un
     * usuario en específico.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        // Únicamente un 'super-admin' puede editar un usuario con rol 'super-admin' o 'admin'
        if ($user->hasRole('super-admin') || $user->hasRole('admin')) {
            if (!Auth::user()->hasRole('super-admin')) {
                return redirect()
                    ->route('users.index')
                    ->with([
                        'message'    => 'No tienes permiso para editar este usuario.',
                        'alert-type' => 'error'
                    ]);
            }
        }

        // El usuario actual no puede editarse a sí mismo
        if ($user->hasPermissionTo('users.edit')) {
            if (Auth::user()->id == $user->id) {
                return redirect()
                    ->route('users.index')
                    ->with([
                        'message'    => 'No puedes editar tu perfil.',
                        'alert-type' => 'error'
                    ]);
            }
        }

        if (Auth::user()->hasRole('super-admin')) {
            // Son los roles que el usuario aún no tiene y está disponible su asignación
            $availableRoles = Role::whereDoesntHave('users', function (Builder $query) use ($user) {
                $query->where('id', $user->id);
            })->get();
        } else {
            // Son los roles que el usuario aún no tiene y está disponible su asignación. Además no son roles del sistema.
            $availableRoles = Role::where('protected', 0)
            ->whereDoesntHave('users', function (Builder $query) use ($user) {
                $query->where('id', $user->id);
            })->get();
        }

        // Son todos los permisos directos de la plataforma que el usuario aún no tiene
        $allAvailablePermissions = Permission::whereDoesntHave('users', function (Builder $query) use ($user) {
            $query->where('id', $user->id);
        })->get();

        // Son los permisos heredados de los roles que posee el usuario
        $inheritedPermissions = $user->getPermissionsViaRoles();

        // Se clasifican todos los permisos heredados de los roles a cada grupo perteneciente
        $inheritedPermissionsGroups = $inheritedPermissions->groupBy('group_id')->transform(function($item, $key) {
            $permissionGroup = PermissionGroup::find($key);
            return ['id' => $permissionGroup->id, 'name' => $permissionGroup->name, 'permissions' => $item];
        })->values();

        // Son los permisos asociados a el usuario
        $associatedPermissions = $user->permissions;

        // Se clasifican todos los permisos asociados al usuario a cada grupo perteneciente
        $associatedPermissionsGroups = $associatedPermissions->groupBy('group_id')->transform(function($item, $key) {
            $permissionGroup = PermissionGroup::find($key);
            return ['id' => $permissionGroup->id, 'name' => $permissionGroup->name, 'permissions' => $item];
        })->values();

        // Son los permisos que están disponibles para asignar a el usuario
        $availablePermissions = $allAvailablePermissions->diff($inheritedPermissions);

        // Se clasifican todos los permisos que están disponibles para asignar a los grupos pertenecientes
        $availablePermissionsGroups = $availablePermissions->groupBy('group_id')->transform(function($item, $key) {
            $permissionGroup = PermissionGroup::find($key);
            return ['id' => $permissionGroup->id, 'name' => $permissionGroup->name, 'permissions' => $item];
        })->values();

        return view('users.edit', compact('user', 'availableRoles', 'inheritedPermissions', 'inheritedPermissionsGroups', 'associatedPermissions', 'associatedPermissionsGroups', 'availablePermissions', 'availablePermissionsGroups'));
    }

    /**
     * Actualiza la información de un usuario en específico
     * junto con sus nuevos roles y permisos.
     *
     * @param  \App\Http\Requests\UserFormRequest  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserFormRequest $request, User $user)
    {
        // Obtiene información de campos del formulario y si no encuentra valor, asigna un array vacío
        $assignedRoles = $request->get('assigned_roles', []);
        $availableRoles = $request->get('avail_roles', []);
        $assignedPermissions = $request->get('assigned_perms', []);
        $availablePermissions = $request->get('avail_perms', []);

        // Se mezclan los roles y permisos ya asignados al usuario con los nuevos asociados
        $userRoles = array_merge($assignedRoles, $availableRoles);
        $userPerms = array_merge($assignedPermissions, $availablePermissions);

        // Actualiza la informacion del usuario
        $user->fill($request->except('assigned_roles', 'avail_roles', 'inh_perms', 'assigned_perms', 'avail_perms', 'password', 'password_confirmation'));

        // Verifica si se necesita cambiar la contraseña
        if ($request->input('password')) {
            $user->password = bcrypt($request->get('password'));
        }

        // Asocia los roles y permisos a el usuario
        $user->syncRoles($userRoles);
        $user->syncPermissions($userPerms);
        $user->updated_at = date('Y-m-d H:i:s');
        $user->save();

        return redirect()
            ->route('users.edit', $user->id)
            ->with([
                'message'    => 'Usuario actualizado con éxito.',
                'alert-type' => 'success'
            ]);
    }

    /**
     * Elimina un usuario en específico de la plataforma.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ( Auth::user()->id == $user->id ) {
            return redirect()->route('users.index')
                ->with([
                    'message'    => 'No puedes eliminar tu usuario actual.',
                    'alert-type' => 'error',
                ]);
        }

        if ($user->username == 'administrator') {
            return redirect()->route('users.index')
                ->with([
                    'message'    => 'No puedes eliminar el super usuario de la plataforma.',
                    'alert-type' => 'error',
                ]);
        }

        if ( $user->delete() ) {
            return redirect()->route('users.index')
                ->with([
                    'message'    => 'Usuario eliminado con éxito.',
                    'alert-type' => 'success',
                ]);
        } else {
            return redirect()->route('users.index')
                ->with([
                    'message'    => 'Usuario no eliminado.',
                    'alert-type' => 'error',
                ]);
        }

        return redirect()->back();
    }
}
