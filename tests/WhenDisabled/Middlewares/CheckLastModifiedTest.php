<?php

declare(strict_types=1);

namespace Tests\WhenDisabled\Middlewares;

use Tests\WhenDisabled\TestCase;

class CheckLastModifiedTest extends TestCase
{
    public function testHashed()
    {
        $this->assertDatabaseCount($this->table(), 0, $this->connection());

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

        $this->assertDatabaseCount($this->table(), 1, $this->connection());
    }

    public function testDoesntHash()
    {
        $this->assertDatabaseCount($this->table(), 0, $this->connection());

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

        $this->assertDatabaseCount($this->table(), 0, $this->connection());
    }
}
