<?php

use Faker\Generator as Faker;

$factory->define(\App\Product::class, function (Faker $faker) {
    $stores = \App\Store::pluck('id')->toArray();
    return [
        'store_id' => $faker->randomElement($stores),
        'name' => $faker->sentence($nbWords = 3, $variableNbWords = true),
        'description' => $faker->sentence($nbWords = 10, $variableNbWords = true),
        'original_price' => $faker->numberBetween($min = 20000, $max = 500000),
        'stock' => $faker->numberBetween($min = 10, $max = 200),
        'category' => $faker->word,
        'created_at' => now(),
    ];
});
