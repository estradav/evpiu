<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'code','name','abbreviation'
    ];



    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'materiales';
}
