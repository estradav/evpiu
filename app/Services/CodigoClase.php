<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class CodigoClase
{
    public function get()
    {
        $Cod_Class = DB::connection('MAX')->table('Class_Codes')->select('Class_Codes.CLSCDE_47','Class_Codes.DESC_47')->get();
        $Cod_ClassArray[''] = 'Seleccione...';
        foreach ($Cod_Class as $C_Class){
            $Cod_ClassArray[$C_Class->CLSCDE_47] = $C_Class->DESC_47;
        }
        return $Cod_ClassArray;
    }
}
