<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BitacoraOmffController extends Controller
{
    public function index()
    {
        DB::table('bi')->insertOrIgnore([

        ]);
        return view('BitacoraOMFF.index');


    }
}
