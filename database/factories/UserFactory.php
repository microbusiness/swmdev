<?php

use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use App\Models\Gender;
use Phaza\LaravelPostgis\Geometries\Point;


/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    $names=[
      'Vasya',
      'Masha',
      'Petya',
      'Jonh',
      'Smitt',
      'Ivanka',
      'Diego',
      'Pod',
      'Fumiko'
    ];

    $gender=[true,false];

    $hobby = App\Models\Hobby::all();

    $hobbyIds=$hobby->random(rand(1, 4))->pluck('id')->toArray();
    $hobbyIds=array_map(function ($a){
        return (string)$a;
    },$hobbyIds);

    $arrayMinus=[1,-1];
    $lat=(rand(0,8899999)/100000)*$arrayMinus[rand(0,1)];
    $lon=(rand(0,17999999)/100000)*$arrayMinus[rand(0,1)];
    $point=new Point($lat, $lon);
    return [
        'name' => $names[rand(0,count($names)-1)],
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'date_of_birth'=>new \DateTime('19'.rand(10,90).'-0'.rand(1,9).'-'.rand(10,28)),
        'male'=>$gender[rand(0,count($gender)-1)],
        'data'=>['hobby'=>$hobbyIds],
        'position'=>$point
    ];
});
