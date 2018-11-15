<?php

use Faker\Generator as Faker;

$factory->define(\App\Store::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text,
        'address' => $faker->address,
        'level' => $faker->randomElement($array=array(1,2,3))
    ];
});
