<?php

namespace App\Services;

use App\User;

class Usuarios
{
    public function get()
    {
        $Us= User::get();

        return $Us;
    }
}
