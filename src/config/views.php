<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Default Views
	|--------------------------------------------------------------------------
	|
	*/

	'emails' => array(

		'welcome' 			=> 'sentinel::emails.welcome',

		'password_reset'	=> 'sentinel::emails.reset',

		'new_password'		=> 'sentinel::emails.newpassword',

		),

	'groups' => array(

		'create'	=> 'sentinel::groups.create',

		'edit'		=> 'sentinel::groups.edit',

		'index'		=> 'sentinel::groups.index',

		'show'		=> 'sentinel::groups.show',

		),

	'sessions' => array(

		'login'	=> 'sentinel::sessions.login',

		),

	'users' => array(

		'create'	=> 'sentinel::users.create',

		'edit'		=> 'sentinel::users.edit',

		'forgot'	=> 'sentinel::users.forgot',

		'index'		=> 'sentinel::users.index',

		'resend'	=> 'sentinel::users.resend',

		'show'		=> 'sentinel::users.show',

		'suspend'	=> 'sentinel::users.suspend',

		),

	'layouts' => array(

		'default'		=> 'sentinel::layouts.default',

		'notifications'	=> 'sentinel::layouts.notifications',

		),
);