<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Default Routes
    |--------------------------------------------------------------------------
    |
    | Sentinel provides default routes for each of its components, but you can
    | alter those route paths here.  Note that this only changes the URL path,
    | not the names of the routes.
    |
    */

    'routes' => array(

        'users'     => array(
            'route' => 'users',
            'enabled' => true,
        ),

        'groups'    => array(
            'route' => 'groups',
            'enabled' => true,
        ),

        'sessions'  => array(
            'route' => 'sessions',
            'enabled' => true,
        ),

        'login'     => array(
            'route' => 'login',
            'enabled' => true,
        ),

        'logout'    => array(
            'route' => 'logout',
            'enabled' => true,
        ),

        'register'  => array(
            'route' => 'register',
            'enabled' => true,
        ),

        'resend'    => array(
            'route' => 'resend',
            'enabled' => true,
        ),

        'forgot'    => array(
            'route' => 'forgot',
            'enabled' => true,
        ),

    ),

    /*
    |--------------------------------------------------------------------------
    | Default Event Routes
    |--------------------------------------------------------------------------
    |
    | At certain points in the login and registration process Sentinel will
    | redirect the browser upon the completion of an event.  To change those
    | redirect locations, provide the name of a different route.
    |
    */

    'post_login'    => 'home',

    'post_logout'   => 'home',

    'post_confirmation_sent' => 'home', // Edit this to show your own 'confirmation sent!' page if you like.



);