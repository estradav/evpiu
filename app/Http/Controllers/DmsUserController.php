<?php

namespace App\Http\Controllers;

use App\DmsUser;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Role;
use App\Permission;
use App\PermissionGroup;
use App\Http\Requests\DmsUserFormRequest;

class DmsUserController extends Controller
{
    public function index()
    {
        $dmsusers = DmsUser::all();
        return view('dms.users.index', compact('dmsusers'));
    }

    public function create()
    {
        return view('dms.users.create');
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


    public function edit(DmsUser $dmsuser)
    {
        return view('users.edit', compact('dmsuser'));
    }

    /**
     * Proporciona la información de un usuario en específico
     * junto con sus roles y permisos asociados.
     *
     * @param DmsUser $dmsuser
     * @return Response
     */
    public function show(DmsUser $dmsuser)
    {
        return view('dmsusers.show', compact('dmsuser', 'userPermissions'));
    }

    public function destroy(DmsUser $dmsUser)
    {
        {
            if ($dmsUser->delete()) {
                return redirect()->route('dmsusers.index')
                    ->with([
                        'message' => 'Usuario eliminado con éxito.',
                        'alert-type' => 'success',
                    ]);
            } else {
                return redirect()->route('users.index')
                    ->with([
                        'message' => 'Usuario no eliminado.',
                        'alert-type' => 'error',
                    ]);
            }

            return redirect()->back();
        }
    }


}
