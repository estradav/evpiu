<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoAreaPedido extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'id_d', 'idPedido', 'Cartera', 'DetalleCartera', 'AproboCartera', 'Notas','Unidad','Cantidad', 'Precio','Total',
        'Destino','R_N','Estado'];




    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pedidos_detalles_area';



    /**
     * The database primary key
     *
     * @var string
     */
    public $primaryKey = 'id_d';
}
