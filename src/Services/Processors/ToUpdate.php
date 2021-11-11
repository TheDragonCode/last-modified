<?php

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
