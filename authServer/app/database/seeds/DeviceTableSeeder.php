<?php

class DeviceTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('devices')->delete();
        Device::create(array(
            'secret'      => Hash::make('testdevice'),
            'description' => 'Test device',
        ));
    }
}
