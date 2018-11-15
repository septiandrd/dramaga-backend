<?php

use Illuminate\Database\Seeder;

class ImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = \App\Product::all();
        foreach ($products as $product) {
            $product->images()->saveMany(factory(\App\Image::class, 5)->make());
        }
    }
}
