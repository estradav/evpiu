<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CodLinea extends Model
{
    protected $fillable = [
        'name', 'cod','coments','abreviatura'
    ];
}
