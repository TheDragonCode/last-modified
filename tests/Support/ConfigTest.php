<?php

declare(strict_types=1);

namespace Tests\Support;

use DragonCode\LastModified\Facades\Config;
use Tests\TestCase;

class ConfigTest extends TestCase
{
    public function testDatabaseConnection()
    {
        $this->assertSame('mysql', Config::databaseConnection());
    }

    public function testDatabaseTable()
    {
        $this->assertSame('last_modified', Config::databaseTable());
    }

    public function testDisabled()
    {
        $this->assertFalse(Config::disabled());
    }

    public function testEnabled()
    {
        $this->assertTrue(Config::enabled());
    }

    public function testDatabaseChunk()
    {
        $this->assertIsNumeric(Config::databaseChunk());

        $this->assertSame(1000, Config::databaseChunk());
    }
}
