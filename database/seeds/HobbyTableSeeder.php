<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HobbyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hobby')->updateOrInsert([
          'name' => 'football'
        ],[
          'name' => 'football'
        ]);
        DB::table('hobby')->updateOrInsert([
          'name' => 'hockey'
        ],[
          'name' => 'hockey'
        ]);
        DB::table('hobby')->updateOrInsert([
          'name' => 'curling'
        ],[
          'name' => 'curling'
        ]);
        DB::table('hobby')->updateOrInsert([
          'name' => 'snowboarding'
        ],[
          'name' => 'snowboarding'
        ]);
        DB::table('hobby')->updateOrInsert([
          'name' => 'skiing'
        ],[
          'name' => 'skiing'
        ]);
        DB::table('hobby')->updateOrInsert([
          'name' => 'fishing'
        ],[
          'name' => 'fishing'
        ]);
        DB::table('hobby')->updateOrInsert([
          'name' => 'cycling'
        ],[
          'name' => 'cycling'
        ]);
        DB::table('hobby')->updateOrInsert([
          'name' => 'baseball'
        ],[
          'name' => 'baseball'
        ]);
        DB::table('hobby')->updateOrInsert([
          'name' => 'basketball'
        ],[
          'name' => 'basketball'
        ]);
    }
}
