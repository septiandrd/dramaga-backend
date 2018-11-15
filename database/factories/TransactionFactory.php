<?php

use Faker\Generator as Faker;

$factory->define(\App\Transaction::class, function (Faker $faker) {
    $users = \App\User::where('role_id',1)->get()->pluck('id')->toArray();
    $products = \App\Product::pluck('id')->toArray();
    $quantity = $faker->numberBetween(1,50);
    $product_id = $faker->randomElement($products);
    $product = \App\Product::find($product_id);
    $total = $product->original_price * $quantity;

    return [
        'user_id' => $faker->randomElement($users),
        'product_id' => $product_id,
        'quantity' => $quantity,
        'total' => $total,
        'resi' => str_random(12),
        'status' => $faker->randomElement(array('Ordered','Paid','Cancelled','Sent','Arrived','Finished'))
    ];
});
