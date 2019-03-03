<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('gender')->updateOrInsert(
          ['name' => 'male'],
          ['name' => 'male']
        );

        DB::table('gender')->updateOrInsert(
          ['name' => 'female'],
          ['name' => 'female']
        );
    }
}
