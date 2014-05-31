<?php

// User Login event
Event::listen('sentinel.user.login', function($user)
{
    Session::put('userId', $user->id);
    Session::put('email', $user->email);
}, 10);

// User logout event
Event::listen('sentinel.user.logout', function()
{
	Session::flush();
}, 10);

// Subscribe to User Mailer events
Event::subscribe('Sentinel\Mailers\UserMailer');