<?php

declare(strict_types=1);

namespace Tests;

use Carbon\Carbon;
use Helldar\LastModified\Services\LastItem;
use Helldar\LastModified\Services\LastModified;

class MainTest extends TestCase
{
    protected $table = 'last_modified';

    public function testRoute()
    {
        $this->assertDatabaseCount($this->table, 0);

        $this->get('foo')->assertStatus(200);
        $this->get('foo')->assertStatus(200);

        $this->assertDatabaseCount($this->table, 0);
    }

    public function testLastModified()
    {
        $this->assertDatabaseCount($this->table, 0);

        $this->get('foo')->assertStatus(200);
        $this->get('bar')->assertStatus(200);
        $this->get('baz')->assertStatus(200);

        $date = Carbon::now();

        (new LastModified())
            ->manuals(
                (new LastItem('http://localhost/foo', $date)),
                (new LastItem('http://localhost/bar', $date))
            )
            ->update();

        $this->assertDatabaseCount($this->table, 2);

        $this->withHeaders(['if-modified-since' => $date->format('r')])->get('foo')->assertStatus(304);
        $this->withHeaders(['if-modified-since' => $date->format('r')])->get('bar')->assertStatus(304);
        $this->withHeaders(['if-modified-since' => $date->format('r')])->get('baz')->assertStatus(200);

        $this->get('foo')->assertStatus(304);
        $this->get('foo')->assertStatus(304);
        $this->get('foo')->assertStatus(304);

        $this->get('bar')->assertStatus(304);
        $this->get('bar')->assertStatus(304);
        $this->get('bar')->assertStatus(304);
    }
}
