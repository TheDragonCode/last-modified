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

declare(strict_types=1);

namespace Tests\WhenDisabled\Support;

use DragonCode\LastModified\Facades\Config;
use Tests\WhenDisabled\TestCase;

class ConfigTest extends TestCase
{
    public function testEnabled()
    {
        $this->assertFalse(Config::enabled());
    }

    public function testDisabled()
    {
        $this->assertTrue(Config::disabled());
    }

    public function testDatabaseChunk()
    {
        $this->assertIsNumeric(Config::databaseChunk());

        $this->assertSame(20, Config::databaseChunk());
    }

    public function testCacheTtl()
    {
        $this->assertIsNumeric(Config::cacheTtl());

        $this->assertSame(43200, Config::cacheTtl());
    }
}
