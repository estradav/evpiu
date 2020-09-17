<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CodMaterial extends Model
{
    protected $fillable = [
        'id_material','user_id','coments','mat_lineas_id','mat_sublineas_id'
    ];

    public function Codlineas (){
        return $this->belongsTo(CodLinea::class,'mat_lineas_id'); // pertecene a linea
    }

    public function CodSublineas (){
        return $this->belongsTo(CodSublinea::class, 'mat_sublineas_id'); // pertecene a linea
    }

    public function materiales() {
        return $this->belongsTo(Material::class, 'id_material');
    }
}
