<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Role;
use App\Permission;
use App\Http\Requests\RoleFormRequest;

class RoleController extends Controller
{
    /**
     * Protege los métodos del controlador por medio de permisos
     * y utilizando el middleware del paquete de roles y permisos.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:roles.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:roles.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:roles.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:roles.destroy', ['only' => ['destroy']]);
    }

    /**
     * Muestra una lista de todos los roles de la plataforma.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();

        return view('roles.index', compact('roles'));
    }

    /**
     * Muestra el formulario para crear un nuevo rol en la plataforma.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::pluck('description', 'id');

        return view('roles.create', compact('permissions'));
    }

    /**
     * Almacena un nuevo rol en la plataforma junto con sus
     * permisos asociados.
     *
     * @param  \App\Http\Requests\RoleFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleFormRequest $request)
    {
        // Crea el rol
        $role = Role::create($request->except('permissions'));

        // Asocia los permisos al rol
        $role->syncPermissions($request->get('permissions', []));

        return redirect()
            ->route('roles.index')
            ->with([
                'message'    => 'Rol creado con éxito.',
                'alert-type' => 'success'
            ]);
    }

    /**
     * Proporciona la información de un rol en específico
     * junto con los usuarios y permisos asociados.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        // Obtiene los permisos asociados al rol
        $rolePermissions = $role->permissions()->get();

        // Obtiene los usuarios que poseen el rol
        $roleUsers = User::role($role->name)->get();

        return view('roles.show', compact('role', 'rolePermissions', 'roleUsers'));
    }

    /**
     * Muestra el formulario para editar la información de un
     * rol en específico.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        // Únicamente un 'super-admin' puede editar el rol de 'super-admin' o 'admin'
        if ($role->id == 'super-admin' || $role->name == 'admin') {
            if (!Auth::user()->hasRole('super-admin')) {
                return redirect()
                    ->route('roles.index')
                    ->with([
                        'message'    => 'No tienes permiso para editar este rol.',
                        'alert-type' => 'error'
                    ]);
            }
        }

        // Obtiene todos los permisos de la plataforma
        $permissions = Permission::all();

        // Obtiene los permisos asociados al rol
        $rolePermissions = $role->permissions()->get();

        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Actualiza la información de un rol en específico
     * junto con sus nuevos permisos.
     *
     * @param  \App\Http\Requests\RoleFormRequest  $request
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(RoleFormRequest $request, Role $role)
    {
        $role->name         = $request->get('name');
        $role->description  = $request->get('description');
        $role->syncPermissions($request->get('permissions', []));
        $role->updated_at   = date('Y-m-d H:i:s');
        $role->save();

        return redirect()
            ->route('roles.edit', $role->id)
            ->with([
                'message'    => 'Rol actualizado con éxito.',
                'alert-type' => 'success'
            ]);
    }

    /**
     * Elimina un rol en específico de la plataforma.
     *
     * @param  \Spatie\Permissions\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        if ( $role->delete() ) {
            return redirect()->route('roles.index')
                ->with([
                    'message'    => 'Rol eliminado con éxito.',
                    'alert-type' => 'success',
                ]);
        } else {
            return redirect()->route('roles.index')
                ->with([
                    'message'    => 'Rol no eliminado.',
                    'alert-type' => 'error',
                ]);
        }
    }
}
