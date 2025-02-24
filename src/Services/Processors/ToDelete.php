<?php

/*
 * This file is part of the "dragon-code/last-modified" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2025 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/last-modified
 */

declare(strict_types=1);

namespace DragonCode\LastModified\Services\Processors;

use Carbon\Carbon;
use DateTimeInterface;
use Psr\Http\Message\UriInterface;

class ToDelete extends Processor
{
    protected function handle(string $hash, UriInterface $url, Carbon|DateTimeInterface $updated_at)
    {
        $this->cache($hash)->forget();
    }
}
