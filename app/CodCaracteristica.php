<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CodCaracteristica extends Model
{

    protected $fillable = [
        'name','cod','coments','abreviatura','car_lineas_id','car_sublineas_id','usuario'
    ];

    public function Codlineas ()
    {
        return $this->belongsTo(CodLinea::class); // pertecene a linea
    }

    public function CodSublineas ()
    {
        return $this->belongsTo(CodSublinea::class); // pertecene a linea
    }
}
