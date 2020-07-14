<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CodLinea;

class CodTipoProducto extends Model
{
    protected $fillable = [
        'name', 'cod','coments','usuario'
    ];

    public function Codlineas()
    {
        return $this->hasMany(Codlinea::class); // tiene muchas lineas
    }

}
