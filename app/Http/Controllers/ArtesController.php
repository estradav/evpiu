<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\TryCatch;
use Psy\Exception\Exception;
use Yajra\DataTables\DataTables;

class ArtesController extends Controller
{
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = DB::connection('EVPIUM')->table('V_Artes')->orderBy('idRequerimiento','desc')->get();
                return Datatables::of($data)->make(true);

            }
        }catch(Exception $e){
            Log::error('[Artes]: '. $e->getMessage());
        }

        return view('Artes.index');
    }

}
