<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EncabezadoPedido extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'id', 'Ped_MAX', 'OrdenCompra','CodCliente','NombreCliente','DireccionCliente','Ciudad','Telefono', 'CodVendedor','NombreVendedor',
        'CondicionPago','Descuento','Iva','Estado','Bruto', 'TotalDescuento', 'TotalSubtotal','TotalIVA','TotalPedido','Notas', 'Destino', 'id_maestro' ,'created_at'];



    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'encabezado_pedidos';



    public function maestro(){
        return $this->belongsTo(MaestroPedido::class, 'id_maestro');
    }


    public function detalle(){
        return $this->hasMany(DetallePedido::class, 'idPedido','id');
    }


    public function info_area(){
        return $this->hasOne(InfoAreaPedido::class, 'idPedido','id');
    }


    public function cliente(){
        return $this->setConnection('MAX')->hasOne(ClienteMax::class, 'CODIGO_CLIENTE', 'CodCliente');
    }
}
