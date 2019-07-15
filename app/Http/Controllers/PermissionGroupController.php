<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PermissionGroup;

class PermissionGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:permission_groups.list', ['only' => ['index']]);
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
}
