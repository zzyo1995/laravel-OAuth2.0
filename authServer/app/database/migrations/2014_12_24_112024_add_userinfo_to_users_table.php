<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddUserinfoToUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//添加用户信息到用户数据包
		Schema::table("users",function($table){
			//
			$table->integer('sex')->nullable() ;//性别，0表示男，1表示女
			$table->string('address')->nullable() ;//家庭住址
			$table->string('phone')->nullable() ;//联系电话
			$table->string('portrait')->nullable() ;//头像
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
