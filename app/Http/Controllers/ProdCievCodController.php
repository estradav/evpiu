<?php

namespace App\Http\Controllers;

use App\CodLinea;
use App\Http\Requests\CodLineasFormRequest;
use Illuminate\Http\Request;

class ProdCievCodController extends Controller
{
    public function lineas_show()
    {
        $Codlinea = CodLinea::all();
        return view('ProductosCIEV.Maestros.lineas_show',compact('Codlinea'));
    }

    public function store(Request $request)
    {

        CodLinea::UpdateOrCreate(['id' => $request->lineas_id,
            'name' => $request->name, 'abreviatura' => $request->abreviatura, 'cod' => $request->cod, 'coments' => $request->coments]);

         return response()->json(['success'=>'linea creada con exito.']);


    }
}
