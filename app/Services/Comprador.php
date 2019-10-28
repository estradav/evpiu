<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class Comprador
{
    public function get()
    {
        $Comprador = DB::connection('MAXP')->table('Buyers')->select('Buyers.BUYID_95','Buyers.BUYNME_95')->get();
        $CompradorArray[''] = 'Seleccione...';
        foreach ($Comprador as $Compr){
            $CompradorArray[trim($Compr->BUYID_95)] = trim($Compr->BUYNME_95);
        }
        return $CompradorArray;
    }
}
