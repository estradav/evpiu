<?php

namespace App\Http\Controllers\CRM;

use App\EventVisit;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;


class EventVisitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return RedirectResponse
     */
    public function index()
    {
        try {
            if (auth()->user()->hasRole('super-admin')) {
                $clientes = DB::connection('MAX')
                    ->table('CIEV_V_Clientes')
                    ->orderBy('RAZON_SOCIAL', 'asc')
                    ->take(10)
                    ->get();
            }else{
                $clientes = DB::connection('MAX')
                    ->table('CIEV_V_Clientes')
                    ->where('VENDEDOR', '=', auth()->user()->codvendedor)
                    ->orderBy('RAZON_SOCIAL', 'asc')
                    ->get();
            }

            return view('aplicaciones.CRM.index', compact('clientes'));
        }catch (\Exception $e){
            return redirect()
                ->back()
                ->with([
                    'message' => $e->getMessage(),
                    'alert-type' => 'error'
                ]);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function get_all_events_and_activities(Request $request){
        if ($request->json()) {
            try {
                if (auth()->user()->hasRole('super-admin')){
                    $visits = EventVisit::with('user_by')->get();
                }else{
                    $visits = EventVisit::where('created_by', auth()->user()->id)
                        ->with('user_by')
                        ->get();
                }
                return response()->json($visits, 200);
            }catch (\Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        }
    }


    public function get_events_and_activities(Request  $request){
        if ($request->json()) {
            try {
                $array = explode(",", $request->get('client_list'));

                $visits = EventVisit::whereIn('nit', $array)
                    ->with('user_by')
                    ->get();
                return response()->json($visits, 200);

            }catch (\Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        }
    }
}
