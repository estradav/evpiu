<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DmsUser extends Model
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
        'usuarios';

    public static function find(DmsUser $dmsuser)
    {
        //
    }


}
