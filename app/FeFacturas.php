<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeFacturas extends model
{
    protected $dates = ['fecha','fecha_venc'];

    protected  $dateFormat = 'Ymd';

}

