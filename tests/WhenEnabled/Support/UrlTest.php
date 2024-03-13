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

namespace Tests\WhenEnabled\Support;

use DragonCode\LastModified\Facades\Url;
use Tests\WhenEnabled\TestCase;

class UrlTest extends TestCase
{
    public function testParse()
    {
        $url = 'https://example.com/foo/bar?id=1&qwe=rty';

        $value = Url::parse($url);

        $this->assertSame($url, $value->toUrl());
    }

    public function testHash()
    {
        $items = [
            'https://example.com/foo/bar?id=1&foo=bar'             => 'ce620bb9be7299260fd7144652d421f9',
            'https://example.com/foo/bar?id=1&qwe=rty&amoleds=123' => '88a3e09cfc343a4d63671da376463579',
            'https://example.com/foo/bar?id=1&qwe=rty&details=123' => '3217e42fb45cf73fe6d7fb2a3a4a77f8',

            'https://example.com/foo/bar?id=1&qwe=rty&modified=123' => '66691dbad27d95fa743d5c09761fd0cd',
            'https://example.com/foo/bar?id=1&qwe=rty&database=123' => '66691dbad27d95fa743d5c09761fd0cd',
            'https://example.com/foo/bar?id=1&qwe=rty&amoled=123'   => '66691dbad27d95fa743d5c09761fd0cd',
            'https://example.com/foo/bar?id=1&qwe=rty'              => '66691dbad27d95fa743d5c09761fd0cd',
            'https://example.com/foo/bar?id=1'                      => '66691dbad27d95fa743d5c09761fd0cd',

            'https://example.com/foo/bar' => 'f6c18df6c8b2aa33d62818079fe6815d',
        ];

        foreach ($items as $url => $hash) {
            $message = sprintf('Url %s has an invalid hash', $url);

            $this->assertSame($hash, Url::hash($url), $message);
        }
    }
}
