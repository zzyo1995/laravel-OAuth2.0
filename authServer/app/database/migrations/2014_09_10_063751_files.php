<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class Files extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
			Schema::create("files",function(Blueprint $table){
				$table->increments('id') ;
				$table->string('file_str')->unique() ;
				$table->integer('filesize') ;
				$table->string('type')->nullable() ;
				$table->dateTime('created_at') ;
				$table->dateTime('updated_at') ;
			} ) ;
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		//Schema::dropIfExists("files") ;
	}

}
