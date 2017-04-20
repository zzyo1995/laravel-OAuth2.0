<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class UserFiles extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		if(!Schema::hasTable('user_files'))
		{
			Schema::create('user_files',function($table){
				$table->increments('id') ;
				$table->integer('userId');
				$table->integer('fileId') ;
				$table->string('fileName') ;
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
		//Schema::dropIfExists('user_files') ;
	}

}
