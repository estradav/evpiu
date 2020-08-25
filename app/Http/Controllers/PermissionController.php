<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Permission;
use App\User;
use App\Http\Requests\PermissionFormRequest;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PermissionController extends Controller
{
    /**
     * Protege los métodos del controlador por medio de permisos
     * y utilizando el middleware del paquete de roles y permisos.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:permissions.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:permissions.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:permissions.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:permissions.destroy', ['only' => ['destroy']]);
    }

    /**
     * Muestra una lista de todos los permisos de la plataforma.
     *
     * @return Factory|View
     */
    public function index()
    {
        $permissions = Permission::all();

        return view('permissions.index', compact('permissions'));
    }

    /**
     * Muestra el formulario para crear un nuevo permiso en la plataforma.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('permissions.create');
    }

    /**
     * Almacena un nuevo permiso en la plataforma.
     *
     * @param PermissionFormRequest $request
     * @return RedirectResponse
     */
    public function store(PermissionFormRequest $request)
    {
        $permission = Permission::create($request->all());

        return redirect()
            ->route('permissions.index')
            ->with([
                'message'    => 'Permiso creado con éxito.',
                'alert-type' => 'success'
            ]);
    }

    /**
     * Proporciona la información de un permiso en específico
     * junto con los usuarios y roles asociados.
     *
     * @param Permission $permission
     * @return Factory|View
     */
    public function show(Permission $permission)
    {
        // Obtiene los usuarios con este permiso asociado
        $permissionUsers = User::permission($permission->name)->get();

        return view('permissions.show', compact('permission', 'permissionUsers'));
    }

    /**
     * Muestra el formulario para editar la información de un
     * permiso en específico.
     *
     * @param Permission $permission
     * @return Factory|View
     */
    public function edit(Permission $permission)
    {
        return view('permissions.edit', compact('permission'));
    }

    /**
     * Actualiza la información de un permiso en específico.
     *
     * @param PermissionFormRequest $request
     * @param Permission $permission
     * @return RedirectResponse
     */
    public function update(PermissionFormRequest $request, Permission $permission)
    {
        if ($request->input('protected') === null) {
            $permission->protected = '0';
        }

        $permission->fill($request->all());
        $permission->save();

        return redirect()
            ->route('permissions.edit', $permission->id)
            ->with([
                'message'    => 'Permiso actualizado con éxito.',
                'alert-type' => 'success'
            ]);
    }

    /**
     * Elimina un permiso en específico de la plataforma.
     *
     * @param Permission $permission
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Permission $permission)
    {
        if ( $permission->delete() ) {
            return redirect()->route('permissions.index')
                ->with([
                    'message'    => 'Permiso eliminado con éxito.',
                    'alert-type' => 'success',
                ]);
        } else {
            return redirect()->route('permissions.index')
                ->with([
                    'message'    => 'Permiso no eliminado.',
                    'alert-type' => 'error',
                ]);
        }
    }
}
