<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeConfig extends Model
{
    protected $fillable = [
        'id_numeracion_fac',
        'id_numeracion_nc',
        'id_numeracion_nd',
        'id_ambiente',
        'id_reporte_fac',
        'id_reporte_nc',
        'id_reporte_nd',
        'id_estado_envio_dian',
        'id_estado_envio_cliente'
    ];

}
