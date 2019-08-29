<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
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
        'Invoice_Master';



    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'INVCE_31';


}
