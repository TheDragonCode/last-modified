<?php

/*
 * This file is part of the "dragon-code/last-modified" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2025 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/last-modified
 */

return [
    /*
     * This option determines if this plugin is allowed to work.
     *
     * Default, true.
     */

    'enabled' => env('LAST_MODIFIED_ENABLED', true),

    /*
     * This option determines the cardinality in a circular query.
     *
     * By default, 1000.
     */

    'chunk' => 1000,

    // This option contains settings for working with the cache.

    'cache' => [
        /*
         * This option sets the time in minutes to keep information in the cache.
         *
         * By default, 30 days (43200 minutes).
         */

        'ttl' => 43200,
    ],

    // This option contains settings for working with requests.

    'requests' => [
        // This option contains ignore settings.

        'ignore' => [
            /*
             * This option contains key patterns to be ignored when retrieving the hash.
             *
             * This is especially useful for SEO.
             *
             * For example,
             *   ['qwe', '*led', 'dat*', '*ifi*']
             *
             *   Before:
             *     /?id=1&qwerty=2&amoled=3&database=4&modified=5
             *   After:
             *     /?id=1&qwerty=2
             */
            'keys' => [],
        ],
    ],
];
