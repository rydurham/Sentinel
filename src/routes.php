<?php

/*
|--------------------------------------------------------------------------
| Sentinel Package Routes
|--------------------------------------------------------------------------
|
*/

// Session Routes
Route::get('login', ['as' => 'sentinel.login', 'uses' => 'Sentinel\SessionController@create']);
Route::get('logout', ['as' => 'sentinel.logout', 'uses' => 'Sentinel\SessionController@destroy']);
Route::get('sessions/create', ['as' => 'sentinel.session.create', 'uses' => 'Sentinel\SessionController@create']);
Route::post('sessions/store', ['as' => 'sentinel.session.store', 'uses' => 'Sentinel\SessionController@store']);
Route::delete('sessions/destroy', ['as' => 'sentinel.session.destroy', 'uses' => 'Sentinel\SessionController@destroy']);

// Registration
Route::get('register', ['as' => 'sentinel.register', 'uses' => 'Sentinel\UserController@register']);
Route::get('users/{id}/activate/{code}', ['as' => 'sentinel.activate', 'uses' => 'Sentinel\UserController@activate']);
Route::get('reactivate', [
    'as' => 'sentinel.reactivate.form',
    function ()
    {
        return View::make('Sentinel::sentinel.users.resend');
    }
]);
Route::post('reactivate', ['as' => 'sentinel.resend.activation', 'uses' => 'Sentinel\UserController@resend']);
Route::get('reminder', [
    'as' => 'sentinel.reminder.form',
    function ()
    {
        return View::make('Sentinel::sentinel.users.forgot');
    }
]);
Route::post('reminder', ['as' => 'sentinel.send.reminder', 'uses' => 'Sentinel\UserController@forgot']);

// Profile
Route::post('users/{id}/change', ['as' => 'sentinel.change.password', 'uses' => 'Sentinel\UserController@changePassword']);
Route::get('users/{id}/reset/{code}', ['as' => 'sentinel.reset.password.form', 'uses' => 'Sentinel\UserController@resetPassword']);

// Users
Route::get('users', ['as' => 'sentinel.users.index', 'uses' => 'Sentinel\UserController@index']);
Route::post('users/add', ['as' => 'sentinel.users.add', 'uses' => 'Sentinel\UserController@add']);
Route::post('users/register', ['as' => 'sentinel.users.store', 'uses' => 'Sentinel\UserController@register']);
Route::get('users/{id}', ['as' => 'sentinel.users.show', 'uses' => 'Sentinel\UserController@show']);
Route::get('users/{id}/edit', ['as' => 'sentinel.users.edit', 'uses' => 'Sentinel\UserController@edit']);
Route::put('users/{id}', ['as' => 'sentinel.users.update', 'uses' => 'Sentinel\UserController@update']);
Route::delete('users/{id}', ['as' => 'sentinel.users.destroy', 'uses' => 'Sentinel\UserController@destroy']);
Route::get('users/{id}/suspend', ['as' => 'sentinel.users.suspend', 'uses' => 'Sentinel\UserController@suspend']);
Route::get('users/{id}/unsuspend', ['as' => 'sentinel.users.unsuspend', 'uses' => 'Sentinel\UserController@unsuspend']);
Route::get('users/{id}/ban', ['as' => 'sentinel.users.ban', 'uses' => 'Sentinel\UserController@ban']);
Route::get('users/{id}/unban', ['as' => 'sentinel.users.unban', 'uses' => 'Sentinel\UserController@unban']);

// Group Routes
Route::get('groups', ['as' => 'sentinel.groups.index', 'uses' => 'Sentinel\GroupController@index']);
Route::get('groups/create', ['as' => 'sentinel.groups.create', 'uses' => 'Sentinel\GroupController@create']);
Route::post('groups', ['as' => 'sentinel.groups.store', 'uses' => 'Sentinel\GroupController@store']);
Route::get('groups/{group}', ['as' => 'sentinel.groups.show', 'uses' => 'Sentinel\GroupController@show']);
Route::get('groups/{group}', ['as' => 'sentinel.groups.edit', 'uses' => 'Sentinel\GroupController@edit']);
Route::put('groups/{group}', ['as' => 'sentinel.groups.update', 'uses' => 'Sentinel\GroupController@update']);
Route::delete('groups/{group}', ['as' => 'sentinel.groups.destroy', 'uses' => 'Sentinel\GroupController@destroy']);

