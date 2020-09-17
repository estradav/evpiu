<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CodLinea extends Model
{
    protected $fillable = [
        'name', 'cod','coments','abreviatura','user_id','id_tipo_producto'
    ];


    public function tipos_producto(){
        return $this->belongsTo(CodTipoProducto::class, 'id_tipo_producto'); // pertecene a Tipo de producto
    }

    public function CodSublineas()
    {
        return $this->hasMany(CodSublinea::class); // tiene muchas sublineas
    }

}
