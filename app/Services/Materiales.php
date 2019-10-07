<?php

namespace App\Services;

use App\CodMaterial;

class Materiales
{
    public function get()
    {
        $Materiales = CodMaterial::get();
        $MaterialesArray[''] = 'Seleccione un Material...';
        foreach ($Materiales as $materiales){
            $MaterialesArray[$materiales->id] = $materiales->name;
        }
        return $MaterialesArray;
    }
}
