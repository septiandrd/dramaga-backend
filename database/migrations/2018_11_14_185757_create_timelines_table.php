<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTimelinesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('timelines', function(Blueprint $table)
		{
			$table->dateTime('arrived_at')->nullable();
			$table->dateTime('cancelled_at')->nullable();
			$table->dateTime('checkout_at');
			$table->dateTime('confirmed_at')->nullable();
			$table->integer('id', true);
			$table->dateTime('paid_at')->nullable();
			$table->dateTime('sent_at')->nullable();
			$table->integer('transaction_id')->index('fk_transaction_timelines');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('timelines');
	}

}
