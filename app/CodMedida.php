<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CodMedida extends Model
{
    protected $fillable = ['cod','denominacion','pestana','espesor','diametro','undmedida',
        'base','altura','perforacion','coments','mm2','med_lineas_id','med_sublineas_id','usuario'
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
