<?php

return [
    /*
     * Enable or disable the package.
     *
     * Default, true.
     */

    'enabled' => env('LAST_MODIFIED_ENABLED', true),

    /*
     * The name of the connection to the database in which the `last_modified` table is located.
     *
     * Default, mysql.
     */

    'connection' => env('DB_CONNECTION', 'mysql'),

    /*
     * Check absolute or relative URL.
     *
     * Default, true
     */

    'absolute_url' => true,
];
