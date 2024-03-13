<?php

/*
 * This file is part of the "dragon-code/last-modified" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2024 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/last-modified
 */

declare(strict_types=1);

namespace Tests\WhenDisabled\Services\Processors;

use DragonCode\LastModified\Resources\Item;
use DragonCode\LastModified\Services\Processors\ToUpdate;
use Tests\fixtures\Models\Custom;
use Tests\WhenDisabled\TestCase;

class ToUpdateTest extends TestCase
{
    public function testCollectionModels()
    {
        $fakes = $this->fakeCustom(30);

        $this->assertDoesntManyCache($fakes);

        Custom::query()->update(['updated_at' => $this->yesterday()]);

        $collection = Custom::query()->get();

        ToUpdate::make()->collections($collection);

        $this->assertDoesntManyCache($fakes);
    }

    public function testCollectionBuilders()
    {
        $fakes = $this->fakeCustom(30);

        $this->assertDoesntManyCache($fakes);

        $builder = Custom::query();

        $builder->update(['updated_at' => $this->yesterday()]);

        $collection = collect()->push($builder);

        ToUpdate::make()->collections($collection);

        $this->assertDoesntManyCache($fakes);
    }

    public function testCollectionManual()
    {
        $fakes = $this->fakeCustom(30);

        $this->assertDoesntManyCache($fakes);

        Custom::query()->update(['updated_at' => $this->yesterday()]);

        $manual = Custom::query()->get()->map(function (Custom $custom) {
            return Item::make($custom->only(['url', 'updated_at']));
        });

        ToUpdate::make()->collections($manual);

        $this->assertDoesntManyCache($fakes);
    }

    public function testBuilders()
    {
        $fakes = $this->fakeCustom(100);

        $this->assertDoesntManyCache($fakes);

        $builder = Custom::query();

        $builder->update(['updated_at' => $this->yesterday()]);

        ToUpdate::make()->builders($builder);

        $this->assertDoesntManyCache($fakes);
    }

    public function testModels()
    {
        $fakes = $this->fakeCustom(3);

        $this->assertDoesntManyCache($fakes);

        Custom::query()->update(['updated_at' => $this->yesterday()]);

        $collection = Custom::query()->get();

        $model1 = $collection->get(0);
        $model2 = $collection->get(1);
        $model3 = $collection->get(2);

        ToUpdate::make()->models($model1, $model2, $model3);

        $this->assertDoesntManyCache($fakes);
    }

    public function testManual()
    {
        $fakes = $this->fakeCustom(2);

        $this->assertDoesntManyCache($fakes);

        Custom::query()->update(['updated_at' => $this->yesterday()]);

        $manual = Custom::query()->get()->map(function (Custom $custom) {
            return Item::make($custom->only(['url', 'updated_at']));
        });

        ToUpdate::make()->manual($manual[0], $manual[1]);

        $this->assertDoesntManyCache($fakes);
    }
}
