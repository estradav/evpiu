<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CodLinea extends Model
{
    protected $fillable = [
        'name', 'cod','coments','abreviatura','tipoproducto_id'
    ];


    public function CodTipoProductos ()
    {
        return $this->belongsTo(CodTipoProducto::class); // pertecene a Tipo de producto
    }

    public function CodSublineas()
    {
        return $this->hasMany(CodSublinea::class); // tiene muchas sublineas
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
