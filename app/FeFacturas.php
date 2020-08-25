<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeFacturas extends model
{
    protected $connection = ['MAX'];

    protected $fillable = [
        'codigo_alterno','numero'
    ];

    protected $dates = ['fecha','fecha_venc'];

    protected  $dateFormat = 'Ymd';

}

