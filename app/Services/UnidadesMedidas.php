<?php

namespace App\Services;

use App\UnidadesMedida;

class UnidadesMedidas
{
    public function get()
    {
        $UnidadesMedidas = UnidadesMedida::get();

        $UnidadesMedidaArray =[];
        foreach ($UnidadesMedidas as $UnidadesMedida){
            $UnidadesMedidaArray[$UnidadesMedida->name] = $UnidadesMedida->descripcion;
        }
        return $UnidadesMedidaArray;

    }
}
