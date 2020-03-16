<?php

namespace App\Services;

use App\CodMedida;

class Medidas
{
    public function get()
    {
        $Medidas = CodMedida::get();

        $MedidasArray[''] = 'Seleccione una Medida...';

        foreach ($Medidas as $medidas){
            $MedidasArray[$medidas->id] = $medidas->name;
        }
        return $MedidasArray;
    }
}
