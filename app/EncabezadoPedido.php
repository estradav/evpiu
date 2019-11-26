<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EncabezadoPedido extends Model
{
    protected $fillable = [
        'id', 'OrdenCompra', 'CodCliente','CodCliente','DireccionCliente','Ciudad','Telefono',
        'CodVendedor','NombreVendedor','CondicionPago','Descuento','Iva','Estado','Bruto',
        'TotalDescuento', 'TotalSubtotal','TotalIVA','TotalPedido','Notas'
    ];
}
