<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CaracteristicasUnidadesMedida extends Model
{
    public function CodSublinea(){
        return $this->belongsToMany('\App\CodSublinea','caracteristicasmedidas_to_sublineas','car_med_id','sub_id');
    }
}
