<?php

// User Login event
Event::listen('sentinel.user.login', function($userId, $email)
{
    Session::put('userId', $userId);
    Session::put('email', $email);
}, 10);

// User logout event
Event::listen('sentinel.user.logout', function()
{
	Session::flush();
}, 10);

// Subscribe to User Mailer events
Event::subscribe('Sentinel\Mailers\UserMailer');