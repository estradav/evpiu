<?php

namespace App\Http\Controllers;

use App\Terceros;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;

class TercerosController extends Controller
{
    public function index()
    {
        set_time_limit(240);
        $terceros=Terceros::join('definicion_tributaria_tipo',
                'definicion_tributaria_tipo.id','=','terceros.id_definicion_tributaria_tipo')
            ->join('y_tipos_identificacion',
                'y_tipos_identificacion.alias','=','terceros.tipo_identificacion')
            ->select('terceros.nombres',
                'terceros.direccion',
                'terceros.ciudad',
                'terceros.telefono_1',
                'terceros.pais',
                'terceros.nit_real',
                'terceros.mail',
                'definicion_tributaria_tipo.descripcion as definicion_tributaria',
                'y_tipos_identificacion.descripcion as identificacion')
            ->get();
        return view('dms.terceros.index', compact('terceros'));
    }
}
