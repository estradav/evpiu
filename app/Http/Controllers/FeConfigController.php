<?php

namespace App\Http\Controllers;

use App\FeConfig;
use App\Http\Requests\FeConfigFromRequest;
use Illuminate\Http\Request;

class FeConfigController extends Controller
{
    public function index ()
    {
        $feconfigs = FeConfig::all();
        //dd($feconfigs);
        return view('FacturacionElectronica.Configuracion.Index',compact('feconfigs'));
    }




    public  function store ()
    {

    }

    public  function update(FeConfigFromRequest $request, FeConfig $feConfig)
    {

        $formData = $request->all();
        $feConfig->update($formData);
        return view('FacturacionElectronica.Configuracion.Index');
    }

}
