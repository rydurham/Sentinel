<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Default Routing
    |--------------------------------------------------------------------------
    |
    | Sentinel provides default routes for its sessions, users and groups.
    | You can use them as is, or you can disable them entirely.
    |
    */

    'routes_enabled' => true,

    /*
    |--------------------------------------------------------------------------
    | URL Redirection
    |--------------------------------------------------------------------------
    |
    | When the Sentinel Controller methods are complete, they will redirect
    | the browser to the url, route or action specified here. If no
    | action is specified, a raw JSON response will be returned.
    |
    */

    'session.store'   => ['route' => 'home'],
    'session.destroy' => ['action' => 'Sentinel\SessionController@create'],



);