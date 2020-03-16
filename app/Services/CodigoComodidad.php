<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class CodigoComodidad
{
    public function get()
    {
        $Cod_Comodidad = DB::connection('MAX')
            ->table('Commodity_Codes')
            ->select('Commodity_Codes.COMCDE_48','Commodity_Codes.DESC_48')
            ->get();

        $Cod_ComodidadArray[''] = 'Seleccione...';

        foreach ($Cod_Comodidad as $C_Comod){
            $Cod_ComodidadArray[trim($C_Comod->COMCDE_48)] = trim($C_Comod->DESC_48);
        }
        return $Cod_ComodidadArray;
    }
}
