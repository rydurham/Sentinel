<?php

/*
|--------------------------------------------------------------------------
| Sentinel Package Routes
|--------------------------------------------------------------------------
|
*/

// Pull routing values from config
$routesConfig = Config::get('Sentinel::config.routes');

$users 		= $routesConfig['users'];
$groups 	= $routesConfig['groups'];
$sessions 	= $routesConfig['sessions'];
$login 		= $routesConfig['login'];
$logout 	= $routesConfig['logout'];
$register 	= $routesConfig['register'];
$resend 	= $routesConfig['resend'];
$forgot 	= $routesConfig['forgot'];

// Session Routes
Route::get( $login ,  array('as' => 'Sentinel\login', 'uses' => 'Sentinel\SessionController@create'));
Route::get( $logout , array('as' => 'Sentinel\logout', 'uses' => 'Sentinel\SessionController@destroy'));
Route::resource( $sessions , 'Sentinel\SessionController', array('only' => array('create', 'store', 'destroy')));

// User Routes
Route::get( $register , array('as' => 'Sentinel\register', 'uses' => 'Sentinel\UserController@register'));
Route::get( $users . '/{id}/activate/{code}', 'Sentinel\UserController@activate')->where('id', '[0-9]+');
Route::get( $resend , array('as' => 'Sentinel\resendActivationForm', function()
{
	return View::make('Sentinel::users.resend');
}));
Route::post( $resend , 'Sentinel\UserController@resend');
Route::get( $forgot , array('as' => 'Sentinel\forgotPasswordForm', function()
{
	return View::make('Sentinel::users.forgot');
}));
Route::post( $forgot , 'Sentinel\UserController@forgot');
Route::post( $users . '/{id}/change', 'Sentinel\UserController@change')->where('id', '[0-9]+');
Route::get( $users . '/{id}/reset/{code}', 'Sentinel\UserController@reset')->where('id', '[0-9]+');
Route::get( $users . '/{id}/suspend', array('as' => 'Sentinel\suspendUserForm', function($id)
{
	return View::make('Sentinel::users.suspend')->with('id', $id);
}))->where('id', '[0-9]+');
Route::post( $users . '/{id}/suspend', 'Sentinel\UserController@suspend')->where('id', '[0-9]+');
Route::get( $users . '/{id}/unsuspend', 'Sentinel\UserController@unsuspend')->where('id', '[0-9]+');
Route::get( $users . '/{id}/ban', 'Sentinel\UserController@ban')->where('id', '[0-9]+');
Route::get( $users . '/{id}/unban', 'Sentinel\UserController@unban')->where('id', '[0-9]+');
Route::resource( $users , 'Sentinel\UserController');

// Group Routes
Route::resource( $groups , 'Sentinel\GroupController');

