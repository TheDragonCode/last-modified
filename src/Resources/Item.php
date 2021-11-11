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

namespace DragonCode\LastModified\Resources;

use DragonCode\LastModified\Concerns\Urlable;
use DragonCode\SimpleDataTransferObject\DataTransferObject;
use Psr\Http\Message\UriInterface;

class Item extends DataTransferObject
{
    use Urlable;

    /** @var string */
    public $hash;

    /** @var \DragonCode\Support\Helpers\Http\Builder */
    public $url;

    /** @var \Carbon\Carbon */
    public $updated_at;

    protected function castUrl($value): UriInterface
    {
        $this->setHash($value);

        return $this->parseUrl($value);
    }

    protected function setHash($uri): void
    {
        $this->hash = $this->hashUrl($uri);
    }
}
