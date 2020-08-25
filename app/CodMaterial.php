<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CodMaterial extends Model
{
    protected $fillable = [
        'name','cod','coments','abreviatura','mat_lineas_id','mat_sublineas_id','usuario'
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
