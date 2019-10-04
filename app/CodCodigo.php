<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CodCodigo extends Model
{
    protected $fillable = ['codigo','coments','cod_tipoproducto','cod_lineas_id','cod_sublineas_id',
        'cod_medidas_id','cod_caracteristicas','cod_materials_id'
    ];
}
