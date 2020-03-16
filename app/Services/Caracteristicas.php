<?php

namespace App\Services;

use App\CodCaracteristica;

class Caracteristicas
{
    public function get()
    {
        $Caracteristicas = CodCaracteristica::get();

        $CaracteristicasArray[''] = 'Seleccione una caracteristica...';

        foreach ($Caracteristicas as $caracteristicas){
            $CaracteristicasArray[$caracteristicas->id] = $caracteristicas->name;
        }
        return $CaracteristicasArray;
    }
}
