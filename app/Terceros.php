<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Terceros extends Model
{
    /**
     * The database connection used by the model.
     *
     * @var string
     */
    protected $connection = 'sqlsrv_dms';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table =
        'terceros';


    protected $fillable = [
        'nombres',
        'direccion',
        'cuidad',
        'telefono_1',
        'pais',
        'nit_real',
    ];
}
