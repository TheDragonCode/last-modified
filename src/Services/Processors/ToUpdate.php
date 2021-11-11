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

namespace DragonCode\LastModified\Services\Processors;

use DateTimeInterface;
use DragonCode\LastModified\Models\Model as LastModel;
use Psr\Http\Message\UriInterface;

class ToUpdate extends Processor
{
    protected function handle(string $hash, UriInterface $url, DateTimeInterface $updated_at)
    {
        LastModel::query()->updateOrCreate(
            compact('hash'),
            compact('url', 'updated_at')
        );
    }
}
