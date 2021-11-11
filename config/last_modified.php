<?php

/*
 * This file is part of the "dragon-code/last-modified" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/last-modified
 */

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

        'chunk' => 1000,
    ],
];
