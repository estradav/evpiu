<?php

namespace App\Models\facturacion_electronica\facturas;

use App\ClienteMax;
use App\CustomerMaster;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Encabezado extends Model
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
    protected $table = 'CIEV_V_FE_FacturasTotalizadas';




    /**
     * The database primary key
     *
     * @var string
     */
    public $primaryKey = 'NUMERO';






    public function detalle() {
        return $this->hasMany(Detalle::class, 'Factura', 'NUMERO');
    }


    /**
     * Obtiene la informacion del cliente (Desde MAX)
     *
     * @return HasOne
     */
    public function cliente(){
        return $this->hasOne(ClienteMax::class, 'CODIGO_CLIENTE', 'CLIENTE');

    }

}
