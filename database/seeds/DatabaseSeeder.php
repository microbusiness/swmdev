<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(GenderTableSeeder::class);
        $this->call(HobbyTableSeeder::class);
        $this->call(UserTableSeeder::class);
    }
}
