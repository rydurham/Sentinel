<?php

/*
|--------------------------------------------------------------------------
| Sentinel Package Routes
|--------------------------------------------------------------------------
*/

// Sentinel Session Routes
Route::get('login', ['as' => 'sentinel.login', 'uses' => 'Sentinel\SessionController@create']);
Route::get('logout', ['as' => 'sentinel.logout', 'uses' => 'Sentinel\SessionController@destroy']);
Route::get('sessions/create', ['as' => 'sentinel.session.create', 'uses' => 'Sentinel\SessionController@create']);
Route::post('sessions/store', ['as' => 'sentinel.session.store', 'uses' => 'Sentinel\SessionController@store']);
Route::delete('sessions/destroy', ['as' => 'sentinel.session.destroy', 'uses' => 'Sentinel\SessionController@destroy']);

// Sentinel Registration
Route::get('register', ['as' => 'sentinel.register.form', 'uses' => 'Sentinel\RegistrationController@registration']);
Route::post('register', ['as' => 'sentinel.register.user', 'uses' => 'Sentinel\RegistrationController@register']);
Route::get('users/activate/{hash}/{code}', ['as' => 'sentinel.activate', 'uses' => 'Sentinel\RegistrationController@activate']);
Route::get('reactivate', ['as' => 'sentinel.reactivate.form', 'uses' => 'Sentinel\RegistrationController@resendActivationForm']);
Route::post('reactivate', ['as' => 'sentinel.reactivate.send', 'uses' => 'Sentinel\RegistrationController@resendActivation']);
Route::get('forgot', ['as' => 'sentinel.forgot.form', 'uses' => 'Sentinel\RegistrationController@forgotPasswordForm']);
Route::post('forgot', ['as' => 'sentinel.reset.request', 'uses' => 'Sentinel\RegistrationController@sendResetPasswordEmail']);
Route::get('reset/{hash}/{code}', ['as' => 'sentinel.reset.form', 'uses' => 'Sentinel\RegistrationController@passwordResetForm']);
Route::post('reset/{hash}/{code}', ['as' => 'sentinel.reset.password', 'uses' => 'Sentinel\RegistrationController@resetPassword']);

// Sentinel Profile
Route::get('profile', ['as' => 'sentinel.profile.show', 'uses' => 'Sentinel\ProfileController@show']);
Route::get('profile/edit', ['as' => 'sentinel.profile.edit', 'uses' => 'Sentinel\ProfileController@edit']);
Route::put('profile', ['as' => 'sentinel.profile.update', 'uses' => 'Sentinel\ProfileController@update']);
Route::post('profile/password', ['as' => 'sentinel.profile.password', 'uses' => 'Sentinel\ProfileController@changePassword']);

// Sentinel Users
Route::get('users', ['as' => 'sentinel.users.index', 'uses' => 'Sentinel\UserController@index']);
Route::get('users/create', ['as' => 'sentinel.users.create', 'uses' => 'Sentinel\UserController@create']);
Route::post('users', ['as' => 'sentinel.users.store', 'uses' => 'Sentinel\UserController@store']);
Route::get('users/{hash}', ['as' => 'sentinel.users.show', 'uses' => 'Sentinel\UserController@show']);
Route::get('users/{hash}/edit', ['as' => 'sentinel.users.edit', 'uses' => 'Sentinel\UserController@edit']);
Route::post('users/{hash}/password', ['as' => 'sentinel.password.change', 'uses' => 'Sentinel\UserController@changePassword']);
Route::post('users/{hash}/memberships', ['as' => 'sentinel.users.memberships', 'uses' => 'Sentinel\UserController@updateGroupMemberships']);
Route::put('users/{hash}', ['as' => 'sentinel.users.update', 'uses' => 'Sentinel\UserController@update']);
Route::delete('users/{hash}', ['as' => 'sentinel.users.destroy', 'uses' => 'Sentinel\UserController@destroy']);
Route::get('users/{hash}/suspend', ['as' => 'sentinel.users.suspend', 'uses' => 'Sentinel\UserController@suspend']);
Route::get('users/{hash}/unsuspend', ['as' => 'sentinel.users.unsuspend', 'uses' => 'Sentinel\UserController@unsuspend']);
Route::get('users/{hash}/ban', ['as' => 'sentinel.users.ban', 'uses' => 'Sentinel\UserController@ban']);
Route::get('users/{hash}/unban', ['as' => 'sentinel.users.unban', 'uses' => 'Sentinel\UserController@unban']);

// Sentinel Groups
Route::get('groups', ['as' => 'sentinel.groups.index', 'uses' => 'Sentinel\GroupController@index']);
Route::get('groups/create', ['as' => 'sentinel.groups.create', 'uses' => 'Sentinel\GroupController@create']);
Route::post('groups', ['as' => 'sentinel.groups.store', 'uses' => 'Sentinel\GroupController@store']);
Route::get('groups/{hash}', ['as' => 'sentinel.groups.show', 'uses' => 'Sentinel\GroupController@show']);
Route::get('groups/{hash}/edit', ['as' => 'sentinel.groups.edit', 'uses' => 'Sentinel\GroupController@edit']);
Route::put('groups/{hash}', ['as' => 'sentinel.groups.update', 'uses' => 'Sentinel\GroupController@update']);
Route::delete('groups/{hash}', ['as' => 'sentinel.groups.destroy', 'uses' => 'Sentinel\GroupController@destroy']);

