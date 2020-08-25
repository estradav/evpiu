<?php

use App\Material;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\DB;

class MaterialesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       /*
        $material = Material::Create([
            'code'          => '',
            'name'          => '',
            'abbreviation'  => ''
        ]);
       */

        DB::table('materiales')->insert([
            'code'          => 'A',
            'name'          => 'ALUMINIO',
            'abbreviation'  => 'ALU',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);

        DB::table('materiales')->insert([
            'code'          => 'C',
            'name'          => 'COBRE',
            'abbreviation'  => 'COB',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);


        DB::table('materiales')->insert([
            'code'          => 'E',
            'name'          => 'PAPEL LITOGRAFICO',
            'abbreviation'  => 'PAL',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);


        DB::table('materiales')->insert([
            'code'          => 'H',
            'name'          => 'HIERRO',
            'abbreviation'  => 'HIE',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);

        DB::table('materiales')->insert([
            'code'          => 'I',
            'name'          => 'ACERO INOX',
            'abbreviation'  => 'AINOX',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);

        DB::table('materiales')->insert([
            'code'          => 'L',
            'name'          => 'LATON',
            'abbreviation'  => 'LAT',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);

        DB::table('materiales')->insert([
            'code'          => 'P',
            'name'          => 'POLIPROPILENO',
            'abbreviation'  => 'PP',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);

        DB::table('materiales')->insert([
            'code'          => '0',
            'name'          => 'N/A',
            'abbreviation'  => 'N/A',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);

        DB::table('materiales')->insert([
            'code'          => 'Z',
            'name'          => 'ZAMAK',
            'abbreviation'  => 'ZMK',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);

        DB::table('materiales')->insert([
            'code'          => 'N',
            'name'          => 'SINTETICO',
            'abbreviation'  => 'SNT',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);

        DB::table('materiales')->insert([
            'code'          => 'T',
            'name'          => 'TELA',
            'abbreviation'  => 'TELA',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);

        DB::table('materiales')->insert([
            'code'          => 'V',
            'name'          => 'PVC',
            'abbreviation'  => 'PVC',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);

        DB::table('materiales')->insert([
            'code'          => 'R',
            'name'          => 'REMOLIDA',
            'abbreviation'  => 'RML',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);

        DB::table('materiales')->insert([
            'code'          => 'O',
            'name'          => 'ACERO',
            'abbreviation'  => 'ACE',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);

        DB::table('materiales')->insert([
            'code'          => 'M',
            'name'          => 'POLIACETAL',
            'abbreviation'  => 'POM',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);

        DB::table('materiales')->insert([
            'code'          => 'U',
            'name'          => 'CUERO',
            'abbreviation'  => 'CUE',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);

        DB::table('materiales')->insert([
            'code'          => 'D',
            'name'          => 'ACERO DF2',
            'abbreviation'  => 'DF2',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);

        DB::table('materiales')->insert([
            'code'          => 'B',
            'name'          => 'POLIESTER',
            'abbreviation'  => 'POL',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);

        DB::table('materiales')->insert([
            'code'          => 'G',
            'name'          => 'VIDRIO',
            'abbreviation'  => 'VID',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);


    }


}

