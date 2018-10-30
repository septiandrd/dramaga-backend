<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->string('address')->nullable();
			$table->timestamps();
			$table->string('email')->unique();
			$table->dateTime('email_verified_at')->nullable();
			$table->char('gender', 1)->nullable();
			$table->increments('id');
			$table->string('name');
			$table->string('password');
			$table->string('phone', 32)->nullable();
			$table->string('remember_token', 100)->nullable();
			$table->integer('role_id')->nullable()->index('fk_role_users');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
