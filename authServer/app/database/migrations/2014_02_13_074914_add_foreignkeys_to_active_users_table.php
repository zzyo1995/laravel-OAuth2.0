<?php

use Illuminate\Database\Migrations\Migration;

class AddForeignkeysToActiveUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('active_users', function($table) {
			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('device_id')->references('id')->on('devices');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('active_users', function($table) {
			$table->dropForeign('active_users_user_id_foreign');
			$table->dropForeign('active_users_device_id_foreign');
		});
	}

}