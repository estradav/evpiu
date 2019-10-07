<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CodCodigo extends Model
{
    protected $fillable = ['codigo','descripcion','coments','cod_tipo_producto_id','cod_lineas_id','cod_sublineas_id',
        'cod_medidas_id','cod_caracteristicas_id','cod_materials_id'
    ];
}
