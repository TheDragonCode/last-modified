<?php

declare(strict_types=1);

namespace Tests\WhenDisabled\Services;

use DragonCode\LastModified\Services\Checker;
use Tests\WhenDisabled\TestCase;

class CheckerTest extends TestCase
{
    public function testDoesntRequest()
    {
        $checker = Checker::make();

        $this->assertFalse($checker->isNotModified());
        $this->assertNull($checker->getDate());
    }

    public function testRequest()
    {
        $this->assertDatabaseCount($this->table(), 0, $this->connection());

        $checker1 = Checker::make($this->requestInstance());
        $this->assertFalse($checker1->isNotModified());
        $this->assertNull($checker1->getDate());

        $this->fakeModel();

        $checker2 = Checker::make($this->requestInstance());
        $this->assertFalse($checker2->isNotModified());
        $this->assertSame($this->today()->toIso8601String(), $checker2->getDate()->toIso8601String());

        $checker3 = Checker::make($this->requestInstance($this->today()));
        $this->assertTrue($checker3->isNotModified());
        $this->assertSame($this->today()->toIso8601String(), $checker3->getDate()->toIso8601String());

        $checker4 = Checker::make($this->requestInstance($this->tomorrow()));
        $this->assertTrue($checker4->isNotModified());
        $this->assertSame($this->today()->toIso8601String(), $checker4->getDate()->toIso8601String());

        $checker5 = Checker::make($this->requestInstance($this->yesterday()));
        $this->assertFalse($checker5->isNotModified());
        $this->assertSame($this->today()->toIso8601String(), $checker5->getDate()->toIso8601String());

        $this->assertDatabaseCount($this->table(), 1, $this->connection());
    }
}
