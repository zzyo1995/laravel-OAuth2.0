<?php
Route::group(array(
	'https',
	'prefix' => 'api/v1'
), function() {
    Route::post('users/register', [
        'before' => 'oauth:user|oauth-owner:client',
        'uses'   => 'ApiController@postRegister'
    ]);
    Route::post('token/validation', [
        'uses' => 'ApiController@postTokenValidation'
    ]);
    Route::post('users/update', [
        'before' => 'oauth:user',
        'uses'   => 'ApiController@postUpdateProfile'
    ]);
    Route::post('users/new-password', [
        'before' => 'oauth:user',
        'uses'   => 'ApiController@postNewPassword'
    ]);
});

