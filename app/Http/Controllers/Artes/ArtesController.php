<?php

namespace App\Http\Controllers\Artes;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class ArtesController extends Controller
{
    /**
     * lista los artes
     *
     * @param Request $request
     * @return Factory|View
     * @throws \Exception
     */
    public function index(Request $request){
        try {
            if ($request->ajax()) {
                $data = DB::connection('EVPIUM')
                    ->table('V_Artes')
                    ->orderBy('idRequerimiento','desc')
                    ->get();

                return Datatables::of($data)->make(true);
            }
        }catch(\Exception $e){
            Log::error('[artes]: '.$e->getMessage());
        }
        return view('aplicaciones.artes.index');
    }
}
