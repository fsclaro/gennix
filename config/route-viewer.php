<?php

return [

    /* -----------------------------------------------------------------
     |  Theme
     | -----------------------------------------------------------------
     */

    'theme' => 'bootstrap-4',

    /* -----------------------------------------------------------------
     |  Route settings
     | -----------------------------------------------------------------
     */

    'route'         => [
        'enabled'    => true,

        'attributes' => [
            'prefix'     => 'route-viewer',
            'as'         => 'route-viewer::',
            'namespace'  => 'Arcanedev\\RouteViewer\\Http\\Controllers',

            'middleware' => [ 'web', 'auth' , 'access-route-viewer'],
        ],
    ],

    /* -----------------------------------------------------------------
     |  URIs
     | -----------------------------------------------------------------
     */

    'uris'     => [
        'excluded' => [
            '_debugbar',
            '_ignition',
            'route-viewer',
        ],
    ],

    /* -----------------------------------------------------------------
     |  Methods
     | -----------------------------------------------------------------
     */

    'methods'  => [
        'excluded' => [
            'HEAD',
        ],

        'colors' => [
            'GET'     => 'success',
            'HEAD'    => 'secondary',
            'OPTIONS' => 'secondary',
            'POST'    => 'primary',
            'PUT'     => 'warning',
            'PATCH'   => 'info',
            'DELETE'  => 'danger',
        ],
    ],

];
