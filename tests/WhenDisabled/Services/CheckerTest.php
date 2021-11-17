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
        $checker1 = Checker::make($this->requestInstance());
        $this->assertFalse($checker1->isNotModified());
        $this->assertNull($checker1->getDate());

        $this->fakeCache();

        $checker2 = Checker::make($this->requestInstance());
        $this->assertFalse($checker2->isNotModified());
        $this->assertNull($checker2->getDate());

        $checker3 = Checker::make($this->requestInstance($this->today()));
        $this->assertFalse($checker3->isNotModified());
        $this->assertNull($checker3->getDate());

        $checker4 = Checker::make($this->requestInstance($this->tomorrow()));
        $this->assertFalse($checker4->isNotModified());
        $this->assertNull($checker4->getDate());

        $checker5 = Checker::make($this->requestInstance($this->yesterday()));
        $this->assertFalse($checker5->isNotModified());
        $this->assertNull($checker5->getDate());
    }
}
