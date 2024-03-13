<?php

/*
 * This file is part of the "dragon-code/last-modified" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2024 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/last-modified
 */

declare(strict_types=1);

namespace Tests\WhenDisabled\Middlewares;

use Tests\WhenDisabled\TestCase;

class CheckLastModifiedTest extends TestCase
{
    public function testHashed()
    {
        $this->assertDoesntCache($this->url());

        $this->request($this->url())->assertStatus(200);
        $this->request($this->url())->assertStatus(200);
        $this->request($this->url())->assertStatus(200);

        $this->fakeCache();

        $this->request($this->url())->assertStatus(200);
        $this->request($this->url())->assertStatus(200);
        $this->request($this->url())->assertStatus(200);

        $this->request($this->url(), $this->yesterday())->assertStatus(200);
        $this->request($this->url(), $this->yesterday())->assertStatus(200);
        $this->request($this->url(), $this->yesterday())->assertStatus(200);

        $this->request($this->url(), $this->today())->assertStatus(200);
        $this->request($this->url(), $this->today())->assertStatus(200);
        $this->request($this->url(), $this->today())->assertStatus(200);

        $this->request($this->url(), $this->tomorrow())->assertStatus(200);
        $this->request($this->url(), $this->tomorrow())->assertStatus(200);
        $this->request($this->url(), $this->tomorrow())->assertStatus(200);

        $this->assertDoesntCache($this->url());
    }

    public function testDoesntHash()
    {
        $this->assertDoesntCache($this->url());

        $this->request($this->url())->assertStatus(200);
        $this->request($this->url())->assertStatus(200);
        $this->request($this->url())->assertStatus(200);

        $this->request($this->url())->assertStatus(200);
        $this->request($this->url())->assertStatus(200);
        $this->request($this->url())->assertStatus(200);

        $this->request($this->url(), $this->yesterday())->assertStatus(200);
        $this->request($this->url(), $this->yesterday())->assertStatus(200);
        $this->request($this->url(), $this->yesterday())->assertStatus(200);

        $this->request($this->url(), $this->today())->assertStatus(200);
        $this->request($this->url(), $this->today())->assertStatus(200);
        $this->request($this->url(), $this->today())->assertStatus(200);

        $this->request($this->url(), $this->tomorrow())->assertStatus(200);
        $this->request($this->url(), $this->tomorrow())->assertStatus(200);
        $this->request($this->url(), $this->tomorrow())->assertStatus(200);

        $this->assertDoesntCache($this->url());
    }
}
