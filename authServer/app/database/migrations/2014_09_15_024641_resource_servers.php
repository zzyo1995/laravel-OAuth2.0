<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ResourceServers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('resource_servers',function($table){
			$table->increments('id') ;
			$table->string('name')->unique() ;//资源服务器名称，全局唯一
			$table->string('password') ;//资源服务器密码
			$table->integer('status')->default(0) ;//资源服务器的状态
			$table->string('reason')->nullable() ;//资源服务器的状态说明
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
