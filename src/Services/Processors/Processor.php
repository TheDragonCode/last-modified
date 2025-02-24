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
use DragonCode\LastModified\Concerns\Cacheable;
use DragonCode\LastModified\Concerns\Urlable;
use DragonCode\LastModified\Constants\Field;
use DragonCode\LastModified\Facades\Config;
use DragonCode\LastModified\Resources\Item;
use DragonCode\Support\Concerns\Makeable;
use DragonCode\Support\Facades\Instances\Instance;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Psr\Http\Message\UriInterface;

abstract class Processor
{
    use Cacheable;
    use Makeable;
    use Urlable;

    abstract protected function handle(string $hash, UriInterface $url, Carbon|DateTimeInterface $updated_at);

    public function collections(Collection ...$collections): self
    {
        foreach ($collections as $collection) {
            $collection->each(function ($item) {
                if (Instance::of($item, Model::class)) {
                    $this->models($item);

                    return;
                }

                if (Instance::of($item, [Builder::class, EloquentBuilder::class])) {
                    $this->builders($item);

                    return;
                }

                $this->manual($item);
            });
        }

        return $this;
    }

    public function builders(Builder|EloquentBuilder ...$builders): self
    {
        foreach ($builders as $builder) {
            $builder->chunkById($this->chunk(), function (Collection $collection) {
                $this->collections($collection);
            });
        }

        return $this;
    }

    public function models(Model ...$models): self
    {
        foreach ($models as $model) {
            $values = $model->only([Field::URL, Field::UPDATED_AT]);

            $item = Item::make($values);

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
        return Config::chunk();
    }
}
