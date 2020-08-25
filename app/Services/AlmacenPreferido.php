<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class AlmacenPreferido
{
    public function get()
    {
        $Alm_Prefer = DB::connection('MAX')
            ->table('Stock_Master')
            ->select('Stock_Master.STK_05','Stock_Master.DESC_05')
            ->get();

        $Alm_PreferArray[''] = 'Seleccione...';

        foreach ($Alm_Prefer as $Al_Pref){
            $Alm_PreferArray[trim($Al_Pref->STK_05)] = trim($Al_Pref->DESC_05);
        }
        return $Alm_PreferArray;
    }
}
