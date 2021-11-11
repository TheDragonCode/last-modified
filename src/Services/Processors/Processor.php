<?php

declare(strict_types=1);

namespace DragonCode\LastModified\Services\Processors;

use DateTimeInterface;
use DragonCode\LastModified\Concerns\Urlable;
use DragonCode\LastModified\Facades\Config;
use DragonCode\LastModified\Resources\Item;
use DragonCode\Support\Concerns\Makeable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Psr\Http\Message\UriInterface;

abstract class Processor
{
    use Makeable;
    use Urlable;

    abstract protected function handle(string $hash, UriInterface $url, DateTimeInterface $updated_at);

    public function collections(Collection ...$collections): self
    {
        foreach ($collections as $collection) {
            $collection->each->tap(function (Model $model) {
                $this->models($model);
            });
        }

        return $this;
    }

    public function builders(Builder ...$builders): self
    {
        foreach ($builders as $builder) {
            $builder->chunk($this->chunk(), function (Collection $collection) {
                $this->collections($collection);
            });
        }

        return $this;
    }

    public function models(Model ...$models): self
    {
        foreach ($models as $model) {
            $item = Item::make(
                $model->only(['url', 'updated_at'])
            );

            $this->manual($item);
        }

        return $this;
    }

    public function manual(Item ...$items): self
    {
        foreach ($items as $item) {
            $this->handle($item->hash, $item->url, $item->updated_at);
        }

        return $this;
    }

    protected function chunk(): int
    {
        return Config::databaseChunk();
    }
}
