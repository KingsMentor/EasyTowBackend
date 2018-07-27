<?php

use Faker\Generator as Faker;

$factory->define(\App\Driver::class, function (Faker $faker) {
    return [
        'name' => $faker->name(),
        'email' => $faker->email,
        'phone_no' => "070".rand("38347834",'74837483'),
        'password' => bcrypt('secret'),
        'profile_pic' => "/storage/1528634024.png",
        'latitude' => 6.532323 + (0.001 * rand(1,99)),
        'longitude' => 3.5232 + (0.001 * rand(1,99)),
    ];
});
