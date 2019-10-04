<?php

namespace App\Services;

use App\CodSublinea;

class Sublineas
{
    public function get()
    {
        $Sublineas = CodSublinea::get();
        $SublineasArray[''] = 'Seleccione una Sublinea...';
        foreach ($Sublineas as $sublinea){
            $SublineasArray[$sublinea->id] = $sublinea->name;
        }
        return $SublineasArray;
    }
}
