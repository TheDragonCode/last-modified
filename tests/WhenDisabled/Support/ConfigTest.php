<?php

declare(strict_types=1);

namespace Tests\WhenDisabled\Support;

use DragonCode\LastModified\Facades\Config;
use Tests\WhenDisabled\TestCase;

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
        $this->assertTrue(Config::disabled());
    }

    public function testEnabled()
    {
        $this->assertFalse(Config::enabled());
    }

    public function testDatabaseChunk()
    {
        $this->assertIsNumeric(Config::databaseChunk());

        $this->assertSame(20, Config::databaseChunk());
    }
}