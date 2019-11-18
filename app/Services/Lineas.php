<?php

namespace App\Services;

use App\CodLinea;

class Lineas
{
    public function get()
    {
        $lineas = CodLinea::get();
        $lineasArray[''] = 'Seleccione una Linea...';
        foreach ($lineas as $Linea){
            $lineasArray[$Linea->id] = $Linea->name;
        }

       /* $sub = CodSublinea::find(1);
       /* foreach ($sub->UnidadesMedida as $um) {
            //obteniendo los datos de un menu específico
            echo $um->name;
            //obteniendo datos de la tabla pivot por menu
            echo $um->pivot->sub_id;
        }*/

        return $lineasArray;
    }
}
