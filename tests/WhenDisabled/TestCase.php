<?php

declare(strict_types=1);

namespace Tests\WhenDisabled;

use Tests\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected $enabled = false;
}
