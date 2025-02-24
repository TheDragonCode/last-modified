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

namespace Tests\WhenEnabled\Services\Processors;

use DragonCode\LastModified\Resources\Item;
use DragonCode\LastModified\Services\Processors\ToUpdate;
use Tests\fixtures\Models\Custom;
use Tests\WhenEnabled\TestCase;

class ToUpdateTest extends TestCase
{
    public function testCollectionModels()
    {
        $fakes = $this->fakeCustom(30);

        $this->assertHasManyCache($fakes, $this->today());

        Custom::query()->update(['updated_at' => $this->yesterday()]);

        $collection = Custom::query()->get();

        ToUpdate::make()->collections($collection);

        $this->assertHasManyCache($collection, $this->yesterday());
    }

    public function testCollectionBuilders()
    {
        $fakes = $this->fakeCustom(30);

        $this->assertHasManyCache($fakes, $this->today());

        $builder = Custom::query();

        $builder->update(['updated_at' => $this->yesterday()]);

        $collection = collect()->push($builder);

        ToUpdate::make()->collections($collection);

        $this->assertHasManyCache($builder->get(), $this->yesterday());
    }

    public function testCollectionManual()
    {
        $fakes = $this->fakeCustom(30);

        $this->assertHasManyCache($fakes, $this->today());

        Custom::query()->update(['updated_at' => $this->yesterday()]);

        $manual = Custom::query()->get()->map(function (Custom $custom) {
            return Item::make($custom->only(['url', 'updated_at']));
        });

        ToUpdate::make()->collections($manual);

        $fakes->each->refresh();

        $this->assertHasManyCache($fakes, $this->yesterday());
    }

    public function testBuilders()
    {
        $fakes = $this->fakeCustom(100);

        $this->assertHasManyCache($fakes, $this->today());

        $builder = Custom::query();

        $builder->update(['updated_at' => $this->yesterday()]);

        ToUpdate::make()->builders($builder);

        $this->assertHasManyCache($builder->get(), $this->yesterday());
    }

    public function testModels()
    {
        $fakes = $this->fakeCustom(3);

        $this->assertHasManyCache($fakes, $this->today());

        Custom::query()->update(['updated_at' => $this->yesterday()]);

        $collection = Custom::query()->get();

        $model1 = $collection->get(0);
        $model2 = $collection->get(1);
        $model3 = $collection->get(2);

        ToUpdate::make()->models($model1, $model2, $model3);

        $this->assertHasManyCache($collection, $this->yesterday());
    }

    public function testManual()
    {
        $fakes = $this->fakeCustom(2);

        $this->assertHasManyCache($fakes, $this->today());

        Custom::query()->update(['updated_at' => $this->yesterday()]);

        $manual = Custom::query()->get()->map(function (Custom $custom) {
            return Item::make($custom->only(['url', 'updated_at']));
        });

        ToUpdate::make()->manual($manual[0], $manual[1]);

        $fakes->each->refresh();

        $this->assertHasManyCache($fakes, $this->yesterday());
    }
}
