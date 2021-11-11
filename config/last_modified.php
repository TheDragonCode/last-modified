<?php

return [

    /*
     * Enable or disable the package.
     *
     * Default, true.
     */

    'enabled' => env('LAST_MODIFIED_ENABLED', true),

    'database' => [
        'connection' => env('DB_CONNECTION', 'mysql'),

        'table' => 'last_modified',
    ],
];
