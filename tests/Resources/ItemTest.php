<?php

declare(strict_types=1);

namespace Tests\Resources;

use DragonCode\LastModified\Resources\Item;
use DragonCode\Support\Exceptions\NotValidUrlException;
use Tests\TestCase;

class ItemTest extends TestCase
{
    public function testConstruct()
    {
        $hash       = $this->hashUrl($this->url());
        $url        = $this->url();
        $updated_at = $this->today();

        $item = new Item(compact('url', 'updated_at'));

        $this->assertSame($hash, $item->hash);
        $this->assertSame($url, $item->url->toUrl());
        $this->assertSame($updated_at, $item->updated_at);
    }

    public function testMake()
    {
        $hash       = $this->hashUrl($this->url());
        $url        = $this->url();
        $updated_at = $this->today();

        $item = Item::make(compact('url', 'updated_at'));

        $this->assertSame($hash, $item->hash);
        $this->assertSame($url, $item->url->toUrl());
        $this->assertSame($updated_at, $item->updated_at);
    }

    public function testWrongUrl()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectDeprecationMessage('The "foo" is not a valid URL.');

        Item::make(['url' => 'foo']);
    }
}
