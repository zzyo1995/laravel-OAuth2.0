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

Route::any('register','TestController@getRegister');
Route::get('usersList','TestController@getList');
Route::post('userInfo','TestController@getUserInfo');


Route::any('login','AuthController@login');

Route::get('auth/authorize', array(
    'before' => 'check-authorization-params|auth',
    'uses'   => 'AuthController@getAuth'
));

Route::post('auth/authorize', array(
    'before' => 'check-authorization-params|auth|csrf',
    'uses'   => 'AuthController@issueAuthCode'
));

Route::post('auth/access_token','AuthController@issueAccToken');
