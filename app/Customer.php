<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /**
     * The database connection used by the model.
     *
     * @var string
     */
    protected $connection = 'sqlsrv_max';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table =
        'customer_master';



    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'CUSTID_23';
}
