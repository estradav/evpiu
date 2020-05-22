<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SensorChimenea extends Model
{
    protected $fillable = ['time','temperature_inyecctora','temperature_horno','fecha'];
}
