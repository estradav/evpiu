<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CodCodigo extends Model
{
    protected $fillable = ['codigo','descripcion','coments','cod_tipo_producto_id','cod_lineas_id','cod_sublineas_id',
        'cod_medidas_id','cod_caracteristicas_id','cod_materials_id','usuario'
    ];


    /**
     * The table associated with the model.
     *
     * @return BelongsTo
     * @var string
     */
    public function tipo_producto(){
        return $this->belongsTo(CodTipoProducto::class, 'cod_tipo_producto_id');
    }


    /**
     * The table associated with the model.
     *
     * @return BelongsTo
     * @var string
     */
    public function linea(){
        return $this->belongsTo(CodLinea::class, 'cod_lineas_id');
    }


    /**
     * The table associated with the model.
     *
     * @return BelongsTo
     * @var string
     */
    public function sublinea(){
        return $this->belongsTo(CodSublinea::class, 'cod_sublineas_id');
    }


    /**
     * The table associated with the model.
     *
     * @return BelongsTo
     * @var string
     */
    public function medida(){
        return $this->belongsTo(CodMedida::class, 'cod_medidas_id');
    }


    /**
     * The table associated with the model.
     *
     * @return BelongsTo
     * @var string
     */
    public function material(){
        return $this->belongsTo(CodMaterial::class, 'cod_materials_id');
    }


    /**
     * The table associated with the model.
     *
     * @return BelongsTo
     * @var string
     */
    public function caracteristica(){
        return $this->belongsTo(CodCaracteristica::class, 'cod_caracteristicas_id');
    }
}
