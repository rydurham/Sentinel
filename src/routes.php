<?php

/*
|--------------------------------------------------------------------------
| Sentinel Package Routes
|--------------------------------------------------------------------------
*/

// Session Routes
Route::get('login', ['as' => 'sentinel.login', 'uses' => 'Sentinel\SessionController@create']);
Route::get('logout', ['as' => 'sentinel.logout', 'uses' => 'Sentinel\SessionController@destroy']);
Route::get('sessions/create', ['as' => 'sentinel.session.create', 'uses' => 'Sentinel\SessionController@create']);
Route::post('sessions/store', ['as' => 'sentinel.session.store', 'uses' => 'Sentinel\SessionController@store']);
Route::delete('sessions/destroy', ['as' => 'sentinel.session.destroy', 'uses' => 'Sentinel\SessionController@destroy']);

// Registration
Route::get('register', ['as' => 'sentinel.register.form', 'uses' => 'Sentinel\RegistrationController@registration']);
Route::post('register', ['as' => 'sentinel.register.user', 'uses' => 'Sentinel\RegistrationController@register']);
Route::get('users/activate/{id}/{code}', ['as' => 'sentinel.activate', 'uses' => 'Sentinel\RegistrationController@activate']);
Route::get('reactivate', ['as' => 'sentinel.reactivate.form', 'uses' => 'Sentinel\RegistrationController@resendActivationForm']);
Route::post('reactivate', ['as' => 'sentinel.reactivate.send', 'uses' => 'Sentinel\RegistrationController@resendActivation']);
Route::get('forgot', ['as' => 'sentinel.forgot.form', 'uses' => 'Sentinel\RegistrationController@forgotPasswordForm']);
Route::post('forgot', ['as' => 'sentinel.reset.request', 'uses' => 'Sentinel\RegistrationController@sendResetPasswordEmail']);
Route::get('reset/{id}/{code}', ['as' => 'sentinel.reset.form', 'uses' => 'Sentinel\RegistrationController@passwordResetForm']);
Route::post('reset/{id}/{code}', ['as' => 'sentinel.reset.password', 'uses' => 'Sentinel\RegistrationController@resetPassword']);

// Profile
Route::post('users/{id}/password', ['as' => 'sentinel.password.change', 'uses' => 'Sentinel\UserController@changePassword']);

// Users
Route::get('users', ['as' => 'sentinel.users.index', 'uses' => 'Sentinel\UserController@index']);
Route::get('users/create', ['as' => 'sentinel.users.create', 'uses' => 'Sentinel\UserController@create']);
Route::post('users', ['as' => 'sentinel.users.store', 'uses' => 'Sentinel\UserController@store']);
Route::get('users/{id}', ['as' => 'sentinel.users.show', 'uses' => 'Sentinel\UserController@show']);
Route::get('users/{id}/edit', ['as' => 'sentinel.users.edit', 'uses' => 'Sentinel\UserController@edit']);
Route::post('users/{id}/memberships', ['as' => 'sentinel.users.memberships', 'uses' => 'Sentinel\UserController@updateGroupMemberships']);
Route::put('users/{id}', ['as' => 'sentinel.users.update', 'uses' => 'Sentinel\UserController@update']);
Route::delete('users/{id}', ['as' => 'sentinel.users.destroy', 'uses' => 'Sentinel\UserController@destroy']);
Route::get('users/{id}/suspend', ['as' => 'sentinel.users.suspend', 'uses' => 'Sentinel\UserController@suspend']);
Route::get('users/{id}/unsuspend', ['as' => 'sentinel.users.unsuspend', 'uses' => 'Sentinel\UserController@unsuspend']);
Route::get('users/{id}/ban', ['as' => 'sentinel.users.ban', 'uses' => 'Sentinel\UserController@ban']);
Route::get('users/{id}/unban', ['as' => 'sentinel.users.unban', 'uses' => 'Sentinel\UserController@unban']);

// Groups
Route::get('groups', ['as' => 'sentinel.groups.index', 'uses' => 'Sentinel\GroupController@index']);
Route::get('groups/create', ['as' => 'sentinel.groups.create', 'uses' => 'Sentinel\GroupController@create']);
Route::post('groups', ['as' => 'sentinel.groups.store', 'uses' => 'Sentinel\GroupController@store']);
Route::get('groups/{group}', ['as' => 'sentinel.groups.show', 'uses' => 'Sentinel\GroupController@show']);
Route::get('groups/{group}/edit', ['as' => 'sentinel.groups.edit', 'uses' => 'Sentinel\GroupController@edit']);
Route::put('groups/{group}', ['as' => 'sentinel.groups.update', 'uses' => 'Sentinel\GroupController@update']);
Route::delete('groups/{group}', ['as' => 'sentinel.groups.destroy', 'uses' => 'Sentinel\GroupController@destroy']);

