<?php

class UserTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->delete();
        User::create(array(
            'group_id' => 1,
            'username' => 'test',
            'email'    => 'test@test.com',
            'password' => '123qwe',
	    'password_confirmation' => '123qwe',
        ));
        User::create(array(
            'group_id' => 2,
            'username' => 'admin',
            'email'    => 'admin@test.com',
            'password' => '123qwe',
	    'password_confirmation' => '123qwe',
        ));
    }
}
