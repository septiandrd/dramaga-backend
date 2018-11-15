<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table)
		{
			$table->string('category');
			$table->timestamps();
			$table->softDeletes();
			$table->text('description');
			$table->float('discounted_price', 10, 0)->nullable();
			$table->integer('id', true);
			$table->string('name');
			$table->float('original_price', 10, 0);
			$table->integer('stock');
			$table->integer('store_id')->index('fk_store_products');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('products');
	}

}
