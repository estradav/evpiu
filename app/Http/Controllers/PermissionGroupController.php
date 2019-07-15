<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Permission;
use App\PermissionGroup;
use App\Http\Requests\CreatePermissionGroupFormRequest;

class PermissionGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:permission_groups.list', ['only' => ['index']]);
        $this->middleware('permission:permission_groups.create', ['only' => ['create', 'store']]);
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
}
