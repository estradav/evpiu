<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['idPedido', 'Cod_prod_cliente', 'Descripcion', 'Arte', 'Marca',
        'Notas', 'Unidad', 'Cantidad', 'Precio', 'Total', 'Destino','R_N', 'Estado'];



    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'detalle_pedidos';



    public function encabezado (){
        return $this->belongsTo(EncabezadoPedido::class, 'idPedido');
    }
}
