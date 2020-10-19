<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MaestroPedido extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_bodega', 'id_produccion', 'id_troqueles'];



    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'maestro_pedidos';



    /**
     *  Get bodega  data.
     *
     * @return BelongsTo
     * @var string
     */
    public function bodega(){
        return $this->belongsTo(EncabezadoPedido::class, 'id_bodega');
    }


    /**
     *  Get produccion data.
     *
     * @return BelongsTo
     * @var string
     */
    public function produccion(){
        return $this->belongsTo(EncabezadoPedido::class, 'id_produccion');
    }


    /**
     *  Get troqueles data.
     *
     * @return BelongsTo
     * @var string
     */
    public function troqueles(){
        return $this->belongsTo(EncabezadoPedido::class, 'id_troqueles');
    }
}
