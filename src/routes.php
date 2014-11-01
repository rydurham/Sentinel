<?php

/*
|--------------------------------------------------------------------------
| Sentinel Package Routes
|--------------------------------------------------------------------------
|
*/

// Pull routing values from config
$routesConfig = Config::get('Sentinel::config.routes');

$groupName = 'groups';
$sessionName = 'sessions';

if (is_array($routesConfig['users'])) {
    $users             = $routesConfig['users']['route'];
    $usersRouteEnabled = $routesConfig['users']['enabled'];
} else {
    $users             = $routesConfig['users'];
    $usersRouteEnabled = true;
}

if (is_array($routesConfig['groups'])) {
    $groups             = $routesConfig['groups']['route'];
    $groupsRouteEnabled = $routesConfig['groups']['enabled'];
} else {
    $groups             = $routesConfig['groups'];
    $groupsRouteEnabled = true;
}

if (is_array($routesConfig['sessions'])) {
    $sessions             = $routesConfig['sessions']['route'];
    $sessionsRouteEnabled = $routesConfig['sessions']['enabled'];
} else {
    $sessions             = $routesConfig['sessions'];
    $sessionsRouteEnabled = true;
}

if (is_array($routesConfig['login'])) {
    $login             = $routesConfig['login']['route'];
    $loginRouteEnabled = $routesConfig['login']['enabled'];
} else {
    $login             = $routesConfig['login'];
    $loginRouteEnabled = true;
}

if (is_array($routesConfig['logout'])) {
    $logout             = $routesConfig['logout']['route'];
    $logoutRouteEnabled = $routesConfig['logout']['enabled'];
} else {
    $logout            = $routesConfig['logout'];
    $logoutRouteEnabled = true;
}

if (is_array($routesConfig['register'])) {
    $register             = $routesConfig['register']['route'];
    $registerRouteEnabled = $routesConfig['register']['enabled'];
} else {
    $register             = $routesConfig['register'];
    $registerRouteEnabled = true;
}

if (is_array($routesConfig['resend'])) {
    $resend             = $routesConfig['resend']['route'];
    $resendRouteEnabled = $routesConfig['resend']['enabled'];
} else {
    $resend             = $routesConfig['resend'];
    $resendRouteEnabled = true;
}

if (is_array($routesConfig['forgot'])) {
    $forgot             = $routesConfig['forgot']['route'];
    $forgotRouteEnabled = $routesConfig['forgot']['enabled'];
} else {
    $forgot             = $routesConfig['forgot'];
    $forgotRouteEnabled = true;
}


// Session Routes
if ($loginRouteEnabled) {
    Route::get($login, array('as' => 'Sentinel\login', 'uses' => 'Sentinel\SessionController@create'));
}

if ($logoutRouteEnabled) {
    Route::get($logout, array('as' => 'Sentinel\logout', 'uses' => 'Sentinel\SessionController@destroy'));
}

if ($sessionsRouteEnabled) {
    Route::resource($sessions, 'Sentinel\SessionController', array(
        'only' => array(
            'create', 
            'store', 
            'destroy'
        ),
		'names' => array(
			'create'  => $sessionName . '.create',
			'store'   => $sessionName . '.store',
			'destroy' => $sessionName . '.destroy'
		)
    ));
}

// User Routes
if ($registerRouteEnabled) {
    Route::get($register, array('as' => 'Sentinel\register', 'uses' => 'Sentinel\UserController@register'));
}
if ($usersRouteEnabled) {
    Route::get($users . '/{id}/activate/{code}', 'Sentinel\UserController@activate')->where('id', '[0-9]+');
}
if ($resendRouteEnabled) {
    Route::get($resend, array('as' => 'Sentinel\resendActivationForm', function () {
        return View::make('Sentinel::users.resend');
    }));
    Route::post($resend, 'Sentinel\UserController@resend');
}
if ($forgotRouteEnabled) {
    Route::get($forgot, array('as' => 'Sentinel\forgotPasswordForm', function () {
        return View::make('Sentinel::users.forgot');
    }));
    Route::post($forgot, 'Sentinel\UserController@forgot');
}
if ($usersRouteEnabled) {
    Route::post($users . '/{id}/change', 'Sentinel\UserController@change')->where('id', '[0-9]+');
    Route::get($users . '/{id}/reset/{code}', 'Sentinel\UserController@reset')->where('id', '[0-9]+');
    Route::get($users . '/{id}/suspend', array('as' => 'Sentinel\suspendUserForm', function ($id) {
        return View::make('Sentinel::users.suspend')->with('user_id', $id);
    }))->where('id', '[0-9]+');
    Route::post($users . '/{id}/suspend', 'Sentinel\UserController@suspend')->where('id', '[0-9]+');
    Route::get($users . '/{id}/unsuspend', 'Sentinel\UserController@unsuspend')->where('id', '[0-9]+');
    Route::get($users . '/{id}/ban', 'Sentinel\UserController@ban')->where('id', '[0-9]+');
    Route::get($users . '/{id}/unban', 'Sentinel\UserController@unban')->where('id', '[0-9]+');
    Route::get($users, array('as' => 'users.index', 'uses' => 'Sentinel\UserController@index'));
    Route::get($users . '/create', array('as' => 'users.create', 'uses' => 'Sentinel\UserController@create'));
    Route::post($users . '/add', array('as' => 'users.add', 'uses' => 'Sentinel\UserController@add'));
    Route::post($users, array('as' => 'users.store', 'uses' => 'Sentinel\UserController@store'));
    Route::get($users . '/{id}', array('as' => 'users.show', 'uses' => 'Sentinel\UserController@show'))->where('id', '[0-9]+');
    Route::get($users . '/{id}/edit', array('as' => 'users.edit', 'uses' => 'Sentinel\UserController@edit'))->where('id', '[0-9]+');
    Route::put($users . '/{id}', array('as' => 'users.update', 'uses' => 'Sentinel\UserController@update'))->where('id', '[0-9]+');
    Route::delete($users . '/{id}', array('as' => 'users.destroy', 'uses' => 'Sentinel\UserController@destroy'))->where('id', '[0-9]+');

}

// Group Routes
if ($groupsRouteEnabled) {
    Route::resource($groups, 'Sentinel\GroupController', array(
		'names' => array(
			'index'   => $groupName . '.index',
			'create'  => $groupName . '.create',
			'store'   => $groupName . '.store',
			'show'    => $groupName . '.show',
			'edit'    => $groupName . '.edit',
			'update'  => $groupName . '.update',
			'destroy' => $groupName . '.destroy'
		)
	));
}

