<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        Schema::create('users', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('group_id')->unsigned()->nullable();
            $table->string('username',64)->nullable();
            $table->string('email',128)->unique()->nullable();
            $table->string('password',64)->nullable();

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
        Schema::dropIfExists('users');
	}

}
