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

namespace Tests\WhenDisabled\Middlewares;

use Tests\WhenDisabled\TestCase;

class CheckLastModifiedTest extends TestCase
{
    public function testHashed()
    {
        $this->request($this->url())->assertStatus(200);
        $this->request($this->url())->assertStatus(200);
        $this->request($this->url())->assertStatus(200);

        $this->fakeModel();

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
    }

    public function testDoesntHash()
    {
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
    }
}
