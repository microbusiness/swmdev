<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hobby = App\Models\Hobby::all();
        factory(App\User::class, 100)->create()->each(function (\App\User $user) use ($hobby) {
            $user->hobby()->attach(
              $hobby->random(rand(1, 4))->pluck('id')->toArray()
            );
        });
    }
}
