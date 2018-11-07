<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTransactionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('transactions', function(Blueprint $table)
		{
			$table->foreign('product_id', 'fk_product_transactions')->references('id')->on('products')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('user_id', 'fk_user_transactions')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('transactions', function(Blueprint $table)
		{
			$table->dropForeign('fk_product_transactions');
			$table->dropForeign('fk_user_transactions');
		});
	}

}
