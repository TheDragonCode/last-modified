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

namespace Tests\WhenEnabled\Resources;

use DragonCode\LastModified\Resources\Item;
use DragonCode\Support\Exceptions\NotValidUrlException;
use Tests\WhenEnabled\TestCase;

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
