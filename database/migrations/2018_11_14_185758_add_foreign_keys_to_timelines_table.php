<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTimelinesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('timelines', function(Blueprint $table)
		{
			$table->foreign('transaction_id', 'fk_transaction_timelines')->references('id')->on('transactions')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('timelines', function(Blueprint $table)
		{
			$table->dropForeign('fk_transaction_timelines');
		});
	}

}
