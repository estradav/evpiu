<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use App\Permission;
use App\PermissionGroup;
use App\Http\Requests\CreatePermissionGroupFormRequest;
use App\Http\Requests\UpdatePermissionGroupFormRequest;

class PermissionGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:permission_groups.list', ['only' => ['index']]);
        $this->middleware('permission:permission_groups.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:permission_groups.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:permission_groups.destroy', ['only' => ['destroy']]);
    }

    /**
     * Muestra una lista de todos los grupos de permisos de la plataforma.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissionGroups = PermissionGroup::all();

        return view('permission_groups.index', compact('permissionGroups'));
    }

    /**
     * Muestra el formulario para crear un nuevo grupo de permisos en la plataforma.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Únicamente un 'super-admin' puede asociar permisos del sistema a un grupo
        if (Auth::user()->hasRole('super-admin')) {
            // Obtiene todos los permisos del grupo 'Estándar' para asignar a nuevos grupos
            $permissions = Permission::where('group_id', 1)
                                        ->pluck('description', 'id');
        } else {
            // Obtiene todos los permisos que no estén protegidos y sean del grupo 'Estándar'
            $permissions = Permission::where(['group_id' => 1, 'protected' => 0])
                                        ->pluck('description', 'id');
        }

        return view('permission_groups.create', compact('permissions'));
    }

    /**
     * Almacena un nuevo grupo de permisos en la plataforma
     * y asocia permisos a éste.
     *
     * @param  \App\Http\Requests\CreatePermissionGroupFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePermissionGroupFormRequest $request)
    {
        $permissionGroup = PermissionGroup::create($request->except('permissions'));

        if ($permissionGroup->save()) {
            $permissions = $request->get('permissions');

            Permission::whereIn('id', $permissions)
                        ->update(['group_id' => $permissionGroup->id]);

            return redirect()
                ->route('permission_groups.index')
                ->with([
                    'message'    => 'Grupo de permisos creado con éxito.',
                    'alert-type' => 'success'
                ]);
        }

        return redirect()
            ->route('permission_groups.index')
            ->with([
                'message'    => 'Grupo de permisos no creado.',
                'alert-type' => 'error'
            ]);
    }

    /**
     * Proporciona la información de un grupo de permisos en específico
     * junto con sus permisos asociados.
     *
     * @param  \App\PermissionGroup  $permissionGroup
     * @return \Illuminate\Http\Response
     */
    public function show(PermissionGroup $permissionGroup)
    {
        return view('permission_groups.show', compact('permissionGroup',));
    }

    /**
     * Muestra el formulario para editar la información de un
     * grupo de permisos en específico.
     *
     * @param  \App\PermissionGroup  $permissionGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(PermissionGroup $permissionGroup)
    {
        // Únicamente un 'super-admin' puede asociar permisos del sistema a un grupo
        if (Auth::user()->hasRole('super-admin')) {
            // Obtiene todos los permisos que no estén asociados al grupo incluso los protegidos
            $availablePermissions = Permission::whereDoesntHave('group', function (Builder $query) use ($permissionGroup) {
                $query->where('id', $permissionGroup->id); })
            ->pluck('description', 'id');
        } else {
            // Obtiene todos los permisos que no estén asociados al grupo pero que no estén protegidos
            $availablePermissions = Permission::where('protected', 0)
                ->whereDoesntHave('group', function (Builder $query) use ($permissionGroup) {
                    $query->where('id', $permissionGroup->id); })
                ->pluck('description', 'id');
        }

        return view('permission_groups.edit', compact('permissionGroup', 'availablePermissions'));
    }

    /**
     * Actualiza la información de un grupo de permisos en específico
     * junto con sus nuevos permisos.
     *
     * @param  \App\Http\Requests\UpdatePermissionGroupFormRequest  $request
     * @param  \App\PermissionGroup  $permissionGroup
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermissionGroupFormRequest $request, PermissionGroup $permissionGroup)
    {
        // Son los valores de los campos del formulario, si no hay un valor se les asigna un array vacío
        $selectedPermissions = $request->get('assigned_perms', []);
        $availablePermissions = $request->get('avail_perms', []);

        // Son los permisos que ya están asociados al grupo
        $relatedPermissions = $permissionGroup->permissions()->pluck('id');

        // Son los permisos que estaban asociados al grupo, pero se desmarco su selección para desasociarlos
        $excludedPermissions = array_diff($relatedPermissions->toArray(), $selectedPermissions);

        // Se fusionan los permisos ya asignados anteriormente al grupo con los nuevos seleccionados por el usuario
        $permissionsToAssign = array_merge($selectedPermissions, $availablePermissions);

        // Se respalda el grupo al que pertenecía cada permiso que se va a mover a un nuevo grupo
        $previousPermissionGroups = array_map(function ($group) {
            return $group['id'];
        }, Permission::getGroups($availablePermissions));

        // Actualiza la informacion estándar del grupo
        $permissionGroup->fill($request->except('assigned_perms', 'avail_perms'));

        if (!empty($excludedPermissions)) {
            // Al desmarcar permisos asociados a un grupo, estos se deben de mover al grupo de permisos 'Estándar'
            Permission::whereIn('id', $excludedPermissions)->update([
                'group_id' => '1'
            ]);

            // Actualiza la fecha de modificación del grupo de permisos 'Estándar'
            PermissionGroup::where('id', 1)->update([
                'updated_at' => Carbon::now()
            ]);
        }

        // Se asigna la fusión de permisos a el grupo
        Permission::whereIn('id', $permissionsToAssign)->update([
            'group_id' => $permissionGroup->id
        ]);

        $permissionGroup->touch();

        if (!empty($previousPermissionGroups)) {
            // Actualiza la fecha de modificación del grupo de permisos al que pertenecía cada permiso que se movió a un nuevo grupo
            PermissionGroup::whereIn('id', $previousPermissionGroups)->update([
                'updated_at' => Carbon::now()
            ]);
        }

        return redirect()
            ->route('permission_groups.edit', $permissionGroup->id)
            ->with([
                'message'    => 'Grupo de permisos actualizado con éxito.',
                'alert-type' => 'success'
            ]);
    }

    /**
     * Elimina un grupo de permisos específico de la plataforma
     *
     * @param  \App\PermissionGroup  $permissionGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(PermissionGroup $permissionGroup)
    {
        if ( $permissionGroup->delete() ) {
            return redirect()->route('permission_groups.index')
                ->with([
                    'message'    => 'Grupo de permisos eliminado con éxito.',
                    'alert-type' => 'success',
                ]);
        }

        return redirect()->route('permission_groups.index')
            ->with([
                'message'    => 'Grupo de permisos no eliminado.',
                'alert-type' => 'error',
            ]);
    }
}
