<?php

namespace App\Services;

use App\CodLinea;

class Lineas
{
    public function get()
    {
        $lineas = CodLinea::get();
        $lineasArray[''] = 'seleccione una Linea';
        foreach ($lineas as $Linea){
            $lineasArray[$Linea->id] = $Linea->name;
        }
        return $lineasArray;
    }
}
