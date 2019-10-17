<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CodSublinea extends Model
{
    protected $fillable = [
        'name', 'cod','coments','abreviatura','lineas_id','tipoproductos_id'
    ];

    public function Codlineas ()
    {
        return $this->belongsTo(CodLinea::class); // pertecene a linea
    }

    public function CodMateriales()
    {
        return $this->hasMany(CodMaterial::class); // tiene muchos materiales
    }

    public function CodMedidas()
    {
        return $this->hasMany(CodMedida::class); // tiene muchas medidas
    }

    public function CodCaracteristicas()
    {
        return $this->hasMany(CodCaracteristica::class); // tiene muchas caracteristicas
    }
}
