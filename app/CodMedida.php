<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CodMedida extends Model
{
    public function Codlineas ()
    {
        return $this->belongsTo(CodLinea::class); // pertecene a linea
    }

    public function CodSublineas ()
    {
        return $this->belongsTo(CodSublinea::class); // pertecene a linea
    }
}
