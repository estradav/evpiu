<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ArtesController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::connection('EVPIUM')->table('V_Artes')->orderBy('idRequerimiento','desc')->get();
            return Datatables::of($data)->make(true);

        }

        return view('Artes.index');
    }

}
