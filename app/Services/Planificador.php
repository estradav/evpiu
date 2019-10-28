<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class Planificador
{
    public function get()
    {
        $Planner_Class = DB::connection('MAX')->table('Planners')->select('Planners.PLNID_63','Planners.NAME_63')->get();
        $Planner_ClassArray[''] = 'Seleccione...';
        foreach ($Planner_Class as $Pla_Class){
            $Planner_ClassArray[$Pla_Class->PLNID_63] = $Pla_Class->NAME_63;
        }
        return $Planner_ClassArray;
    }
}
