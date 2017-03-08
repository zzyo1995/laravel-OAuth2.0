<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiInfoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        Schema::create('api_info', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('method')->nullable()->default("POST");
            $table->string('url')->nullable();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('params')->nullable();
            $table->string('success_response')->nullable();
            $table->string('fail_response')->nullable();
            $table->integer('group_id')->nullable();

            $table->timestamps();
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
        Schema::dropIfExists('api_info');
	}

}
