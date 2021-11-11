<?php

declare(strict_types=1);

namespace DragonCode\LastModified\Services;

use DragonCode\LastModified\Facades\Config;
use DragonCode\LastModified\Resources\Item;
use DragonCode\LastModified\Services\Processors\ToDelete;
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

    protected function enabled(): bool
    {
        return Config::enabled();
    }
}
