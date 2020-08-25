<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnidadesMedida extends Model
{
    public function CodSublinea(){
        return $this->belongsToMany('\App\CodSublinea','medidas_to_sublineas','med_id','sub_id');
    }
}
