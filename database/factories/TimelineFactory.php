<?php

use Faker\Generator as Faker;

$factory->define(\App\Timeline::class, function (Faker $faker) {
    return [
        'ordered_at' => $faker->dateTime($max = 'now'),
        'paid_at' => $faker->dateTime($max = 'now'),
        'cancelled_at' => $faker->dateTime($max = 'now'),
        'sent_at' => $faker->dateTime($max = 'now'),
        'arrived_at' => $faker->dateTime($max = 'now'),
        'confirmed_at' => now(),
    ];
});
