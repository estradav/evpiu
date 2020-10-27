<?php

namespace App\Models\facturacion_electronica\facturas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detalle extends Model
{
    use HasFactory;


    /**
     * The database connection used by the model.
     *
     * @var string
     */
    protected $connection = 'MAX';



    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'CIEV_V_FacturasDetalladas';



    /**
     * The database primary key
     *
     * @var string
     */
    public $primaryKey = 'Factura';


    /**
     * The database primary key type
     *
     * @var string
     */
    protected $keyType = 'string';


}
