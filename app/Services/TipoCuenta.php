<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class TipoCuenta
{
    public function get()
    {
        $TipoCuenta = DB::connection('MAX')
            ->table('Account_Types')
            ->select('Account_Types.ACTTYP_104','Account_Types.DESCRPTN_104')
            ->get();

        $TipoCuentaArray[''] = 'Seleccione...';

        foreach ($TipoCuenta as $TipoCue){
            $TipoCuentaArray[$TipoCue->ACTTYP_104] = $TipoCue->DESCRPTN_104;
        }
        return $TipoCuentaArray;
    }
}
