<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\User::class, 100)->create()->each(function ($user) {
            if ($user->role_id==2) {
                $user->store()->save(factory(\App\Store::class)->make())->each(function ($store) {
                    $store->products()->save(factory(\App\Product::class),5)->create();
                });
            }
        });
    }
}
