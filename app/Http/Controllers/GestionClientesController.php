<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class GestionClientesController extends Controller
{
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $data = DB::connection('MAX')
                ->table('customer_master')
                ->join('terceros','customer_master.CUSTID_23','=','terceros.codigo_alterno')
                ->select('customer_master.CUSTID_23 as codigo_cliente',
                    'customer_master.NAME_23 as razon_social',
                    'customer_master.UDFKEY_23 as nit',
                    'customer_master.CITY_23 as ciudad',
                    'customer_master.CNTRY_23 as pais',
                    'customer_master.CUSTYP_23 as tipo_cliente',
                    'customer_master.UDFKEY_23 as id',
                    'customer_master.STATUS_23 as estado'
                )
                ->get();


            return datatables::of($data)
                ->addColumn('opciones', function($row){
                    $btn = '<div class="btn-group ml-auto float-center">'.'<a href="/GestionClientes/'.$row->id.'/edit" class="btn btn-sm btn-outline-light" id="view-customer"><i class="far fa-eye"></i></a>';
                    return $btn;
                })
                ->addColumn('info', function($row){
                    $btn = '<div class="btn-group ml-auto float-center">'.'<a href="/GestionClientes/'.$row->id.'/edit" class="btn btn-sm btn-outline-light" id="view-customer"><i class="far fa-eye"></i></a>';
                    return $btn;
                })
                ->rawColumns(['opciones','info'])
                ->make(true);
        }
        return view('GestionClientes.index');
    }
}
