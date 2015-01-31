<?php

/*
|--------------------------------------------------------------------------
| Sentinel Package Routes
|--------------------------------------------------------------------------
*/

// Sentinel Session Routes
Route::get('login', ['as' => 'sentinel.login', 'uses' => 'App\Http\Controllers\Sentinel\SessionController@create']);
Route::get('logout', ['as' => 'sentinel.logout', 'uses' => 'App\Http\Controllers\Sentinel\SessionController@destroy']);
Route::get('sessions/create', ['as' => 'sentinel.session.create', 'uses' => 'App\Http\Controllers\Sentinel\SessionController@create']);
Route::post('sessions/store', ['as' => 'sentinel.session.store', 'uses' => 'App\Http\Controllers\Sentinel\SessionController@store']);
Route::delete('sessions/destroy', ['as' => 'sentinel.session.destroy', 'uses' => 'App\Http\Controllers\Sentinel\SessionController@destroy']);

// Sentinel Registration
Route::get('register', ['as' => 'sentinel.register.form', 'uses' => 'App\Http\Controllers\Sentinel\RegistrationController@registration']);
Route::post('register', ['as' => 'sentinel.register.user', 'uses' => 'App\Http\Controllers\Sentinel\RegistrationController@register']);
Route::get('users/activate/{hash}/{code}', ['as' => 'sentinel.activate', 'uses' => 'App\Http\Controllers\Sentinel\RegistrationController@activate']);
Route::get('reactivate', ['as' => 'sentinel.reactivate.form', 'uses' => 'App\Http\Controllers\Sentinel\RegistrationController@resendActivationForm']);
Route::post('reactivate', ['as' => 'sentinel.reactivate.send', 'uses' => 'App\Http\Controllers\Sentinel\RegistrationController@resendActivation']);
Route::get('forgot', ['as' => 'sentinel.forgot.form', 'uses' => 'App\Http\Controllers\Sentinel\RegistrationController@forgotPasswordForm']);
Route::post('forgot', ['as' => 'sentinel.reset.request', 'uses' => 'App\Http\Controllers\Sentinel\RegistrationController@sendResetPasswordEmail']);
Route::get('reset/{hash}/{code}', ['as' => 'sentinel.reset.form', 'uses' => 'App\Http\Controllers\Sentinel\RegistrationController@passwordResetForm']);
Route::post('reset/{hash}/{code}', ['as' => 'sentinel.reset.password', 'uses' => 'App\Http\Controllers\Sentinel\RegistrationController@resetPassword']);

// Sentinel Profile
Route::get('profile', ['as' => 'sentinel.profile.show', 'uses' => 'App\Http\Controllers\Sentinel\ProfileController@show']);
Route::get('profile/edit', ['as' => 'sentinel.profile.edit', 'uses' => 'App\Http\Controllers\Sentinel\ProfileController@edit']);
Route::put('profile', ['as' => 'sentinel.profile.update', 'uses' => 'App\Http\Controllers\Sentinel\ProfileController@update']);
Route::post('profile/password', ['as' => 'sentinel.profile.password', 'uses' => 'App\Http\Controllers\Sentinel\ProfileController@changePassword']);

// Sentinel Users
Route::get('users', ['as' => 'sentinel.users.index', 'uses' => 'App\Http\Controllers\Sentinel\UserController@index']);
Route::get('users/create', ['as' => 'sentinel.users.create', 'uses' => 'App\Http\Controllers\Sentinel\UserController@create']);
Route::post('users', ['as' => 'sentinel.users.store', 'uses' => 'App\Http\Controllers\Sentinel\UserController@store']);
Route::get('users/{hash}', ['as' => 'sentinel.users.show', 'uses' => 'App\Http\Controllers\Sentinel\UserController@show']);
Route::get('users/{hash}/edit', ['as' => 'sentinel.users.edit', 'uses' => 'App\Http\Controllers\Sentinel\UserController@edit']);
Route::post('users/{hash}/password', ['as' => 'sentinel.password.change', 'uses' => 'App\Http\Controllers\Sentinel\UserController@changePassword']);
Route::post('users/{hash}/memberships', ['as' => 'sentinel.users.memberships', 'uses' => 'App\Http\Controllers\Sentinel\UserController@updateGroupMemberships']);
Route::put('users/{hash}', ['as' => 'sentinel.users.update', 'uses' => 'App\Http\Controllers\Sentinel\UserController@update']);
Route::delete('users/{hash}', ['as' => 'sentinel.users.destroy', 'uses' => 'App\Http\Controllers\Sentinel\UserController@destroy']);
Route::get('users/{hash}/suspend', ['as' => 'sentinel.users.suspend', 'uses' => 'App\Http\Controllers\Sentinel\UserController@suspend']);
Route::get('users/{hash}/unsuspend', ['as' => 'sentinel.users.unsuspend', 'uses' => 'App\Http\Controllers\Sentinel\UserController@unsuspend']);
Route::get('users/{hash}/ban', ['as' => 'sentinel.users.ban', 'uses' => 'App\Http\Controllers\Sentinel\UserController@ban']);
Route::get('users/{hash}/unban', ['as' => 'sentinel.users.unban', 'uses' => 'App\Http\Controllers\Sentinel\UserController@unban']);

// Sentinel Groups
Route::get('groups', ['as' => 'sentinel.groups.index', 'uses' => 'App\Http\Controllers\Sentinel\GroupController@index']);
Route::get('groups/create', ['as' => 'sentinel.groups.create', 'uses' => 'App\Http\Controllers\Sentinel\GroupController@create']);
Route::post('groups', ['as' => 'sentinel.groups.store', 'uses' => 'App\Http\Controllers\Sentinel\GroupController@store']);
Route::get('groups/{hash}', ['as' => 'sentinel.groups.show', 'uses' => 'App\Http\Controllers\Sentinel\GroupController@show']);
Route::get('groups/{hash}/edit', ['as' => 'sentinel.groups.edit', 'uses' => 'App\Http\Controllers\Sentinel\GroupController@edit']);
Route::put('groups/{hash}', ['as' => 'sentinel.groups.update', 'uses' => 'App\Http\Controllers\Sentinel\GroupController@update']);
Route::delete('groups/{hash}', ['as' => 'sentinel.groups.destroy', 'uses' => 'App\Http\Controllers\Sentinel\GroupController@destroy']);

