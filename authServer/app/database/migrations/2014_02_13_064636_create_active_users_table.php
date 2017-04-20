<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActiveUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('active_users', function(Blueprint $table)
		{
			$table->integer('user_id')->unsigned();
			$table->integer('device_id')->unsigned();
			//$table->timestamp('last_active');
			$table->boolean('persistent');
			$table->timestamps();

			$table->primary(array('user_id', 'device_id'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('active_users');
	}

}