<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class UserProfiles extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		if(!Schema::hasTable('user_profiles'))
		{
			Schema::create('user_profiles',function($table){
				$table->increments('id') ;
				$table->integer('userId') ;
				$table->string('mobile') ;
				$table->string('address') ;
				$table->integer('age') ;
				$table->dateTime('created_at') ;
				$table->dateTime('updated_at') ;
			}) ;
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		//Schema::dropIfExists("user_profiles") ;
	}

}
