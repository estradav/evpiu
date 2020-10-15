<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EncabezadoPedido extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'Ped_MAX', 'OrdenCompra','CodCliente','NombreCliente','DireccionCliente','Ciudad','Telefono', 'CodVendedor','NombreVendedor',
        'CondicionPago','Descuento','Iva', 'Estado', 'Bruto', 'TotalDescuento', 'TotalSubtotal','TotalIVA','TotalPedido','Notas', 'Destino', 'id_maestro' ,'created_at'];



    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'encabezado_pedidos';




    /**
     * The table associated with the model.
     *
     * @var array
     */
    protected $casts = [
        'CodCliente'   =>  'string',
    ];


    /**
     * Obtiene el registo del maestro de pedidos del cual es hijo.
     *
     * @return BelongsTo
     * @var array
     */
    public function maestro(){
        return $this->belongsTo(MaestroPedido::class, 'id_maestro');
    }


    /**
     * Obtiene el detalle del pedido
     *
     * @return HasMany
     */
    public function detalle(){
        return $this->hasMany(DetallePedido::class, 'idPedido','id');
    }

    /**
     * Obtiene el detalle por area
     *
     * @return HasOne
     */
    public function info_area(){
        return $this->hasOne(InfoAreaPedido::class, 'idPedido','id');
    }


    /**
     * Obtiene la informacion del cliente (Desde MAX)
     *
     * @return HasOne
     */
    public function cliente(){
        return $this->hasOne(ClienteMax::class, 'CODIGO_CLIENTE','CodCliente');
    }


    /**
     * Obtiene la informacion del Vendedor
     *
     * @return HasOne
     */
    public function vendedor(){
        return $this->hasOne(User::class, 'id', 'vendedor_id');
    }
}
