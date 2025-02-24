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

namespace DragonCode\LastModified\Services;

use DragonCode\LastModified\Facades\Config;
use DragonCode\LastModified\Resources\Item;
use DragonCode\LastModified\Services\Processors\Processor;
use DragonCode\LastModified\Services\Processors\ToDelete;
use DragonCode\LastModified\Services\Processors\ToUpdate;
use DragonCode\Support\Concerns\Makeable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class LastModified
{
    use Makeable;

    protected array $collections = [];

    protected array $builders = [];

    protected array $models = [];

    protected array $manual = [];

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
            $this->process(ToUpdate::make());
        }
    }

    public function delete(): void
    {
        if ($this->enabled()) {
            $this->process(ToDelete::make());
        }
    }

    protected function process(Processor $processor): void
    {
        $processor
            ->collections(...$this->collections)
            ->builders(...$this->builders)
            ->models(...$this->models)
            ->manual(...$this->manual);
    }

    protected function enabled(): bool
    {
        return Config::enabled();
    }
}
