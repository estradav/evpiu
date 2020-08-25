<?php

namespace App\Services;

use App\CodSublinea;

class Sublineas
{
    public function get()
    {
        $Sublineas = CodSublinea::get();

        $SublineasArray[''] = 'Seleccione una sublinea...';

        foreach ($Sublineas as $sublinea){
            $SublineasArray[$sublinea->id] = $sublinea->name;
        }

        return $SublineasArray;

    }
}
