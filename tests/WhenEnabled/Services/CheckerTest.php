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

namespace Tests\WhenEnabled\Services;

use DragonCode\LastModified\Services\Checker;
use Tests\WhenEnabled\TestCase;

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
        $checker1 = Checker::make($this->requestInstance());
        $this->assertFalse($checker1->isNotModified());
        $this->assertNull($checker1->getDate());

        $this->fakeCache();

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
    }
}
