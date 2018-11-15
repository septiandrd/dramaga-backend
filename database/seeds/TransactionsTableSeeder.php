<?php

use Illuminate\Database\Seeder;

class TransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Transaction::class, 500)->create()->each(function ($transaction) {
            $transaction->timeline()->save(factory(\App\Timeline::class)->make());
        });
    }
}
