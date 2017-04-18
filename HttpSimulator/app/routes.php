<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('/simulator', 'SimulatorController@getIndex');

Route::post('/send', 'SimulatorController@send');

Route::get('/api-manage','ApiManagerController@getListByID');

Route::any('/api-manage/addApi', 'ApiManagerController@addApi');

Route::any('/api-manage/updateApi', 'ApiManagerController@updateApi');

Route::any('/api-manage/deleteApi', 'ApiManagerController@deleteApi');

Route::any('/api-manage/addGroup', 'ApiManagerController@addGroup');

Route::any('/api-manage/manage', 'ApiManagerController@manageApi');

Route::get('/api-manage/info', 'ApiManagerController@getApiInfo');

Route::any('/api-manage/test', 'ApiManagerController@apiTest');



