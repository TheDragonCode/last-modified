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

namespace DragonCode\LastModified\Services;

use DragonCode\LastModified\Facades\Config;
use DragonCode\LastModified\Resources\Item;
use DragonCode\LastModified\Services\Processors\ToDelete;
use DragonCode\LastModified\Services\Processors\ToFlush;
use DragonCode\LastModified\Services\Processors\ToUpdate;
use DragonCode\Support\Concerns\Makeable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class LastModified
{
    use Makeable;

    protected $collections = [];

    protected $builders = [];

    protected $models = [];

    protected $manual = [];

    public function collections(Collection ...$collections): self
    {
        $this->collections = $collections;

        return $this;
    }

    public function builders(Builder ...$builders): self
    {
        $this->builders = $builders;

        return $this;
    }

    public function models(Model ...$models): self
    {
        $this->models = $models;

        return $this;
    }

    public function manual(Item ...$items): self
    {
        $this->manual = $items;

        return $this;
    }

    public function update(): void
    {
        if ($this->enabled()) {
            ToUpdate::make()
                ->collections(...$this->collections)
                ->builders(...$this->builders)
                ->models(...$this->models)
                ->manual(...$this->manual);
        }
    }

    public function delete(): void
    {
        if ($this->enabled()) {
            ToDelete::make()
                ->collections(...$this->collections)
                ->builders(...$this->builders)
                ->models(...$this->models)
                ->manual(...$this->manual);
        }
    }

    public function flush(): void
    {
        if ($this->enabled()) {
            ToFlush::make()->clean();
        }
    }

    protected function enabled(): bool
    {
        return Config::enabled();
    }
}
