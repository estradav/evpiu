<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ClienteMax extends Model
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
    protected $table = 'CIEV_V_Clientes';


    /**
     * The database primary key
     *
     * @var string
     */
    public $primaryKey = 'CODIGO_CLIENTE';




    /**
     * The database primary key type
     *
     * @var string
     */
    protected $keyType = 'string';









}
