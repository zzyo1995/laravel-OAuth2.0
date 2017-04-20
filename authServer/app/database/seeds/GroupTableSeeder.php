<?php

class GroupTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('groups')->delete();
        Group::create(array(
            'name'        => 'ordinary',
            'privileges'  => 'basic',
            'description' => 'Normal users',
        ));
        Group::create(array(
            'name'        => 'admin',
            'privileges'  => 'basic|users',
            'description' => 'administrators',
        ));
    }
}
