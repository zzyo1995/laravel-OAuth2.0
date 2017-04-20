<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ResourceInfo extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('resource_info'))
		{
			Schema::create('resource_info',function($table){
				$table->increments('id') ;
				$table->string('name') ;
				$table->string('password') ;
				$table->string('server_ip');
				$table->dateTime('created_at') ;
				$table->dateTime('updated_at') ;
			});
		}		
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('resource_info') ;		
	}

}
