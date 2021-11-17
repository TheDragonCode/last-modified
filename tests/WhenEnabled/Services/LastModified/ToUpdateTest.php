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

namespace Tests\WhenEnabled\Services\LastModified;

use DragonCode\LastModified\Resources\Item;
use DragonCode\LastModified\Services\LastModified;
use Tests\fixtures\Models\Custom;
use Tests\WhenEnabled\TestCase;

class ToUpdateTest extends TestCase
{
    public function testCollectionModels()
    {
        $this->fakeCustom(30);

        $this->assertSame(30, $this->db()->where('updated_at', $this->today())->count());
        $this->assertSame(0, $this->db()->where('updated_at', $this->yesterday())->count());

        Custom::query()->update(['updated_at' => $this->yesterday()]);

        $collection = Custom::query()->get();

        LastModified::make()
            ->collections($collection)
            ->update();

        $this->assertSame(0, $this->db()->where('updated_at', $this->today())->count());
        $this->assertSame(30, $this->db()->where('updated_at', $this->yesterday())->count());
    }

    public function testCollectionBuilders()
    {
        $this->fakeCustom(30);

        $this->assertSame(30, $this->db()->where('updated_at', $this->today())->count());
        $this->assertSame(0, $this->db()->where('updated_at', $this->yesterday())->count());

        $builder = Custom::query();

        $builder->update(['updated_at' => $this->yesterday()]);

        $collection = collect()->push($builder);

        LastModified::make()
            ->collections($collection)
            ->update();

        $this->assertSame(0, $this->db()->where('updated_at', $this->today())->count());
        $this->assertSame(30, $this->db()->where('updated_at', $this->yesterday())->count());
    }

    public function testCollectionManual()
    {
        $this->fakeCustom(30);

        $this->assertSame(30, $this->db()->where('updated_at', $this->today())->count());
        $this->assertSame(0, $this->db()->where('updated_at', $this->yesterday())->count());

        Custom::query()->update(['updated_at' => $this->yesterday()]);

        $manual = Custom::query()->get()->map(function (Custom $custom) {
            return Item::make($custom->only(['url', 'updated_at']));
        });

        LastModified::make()
            ->collections($manual)
            ->update();

        $this->assertSame(0, $this->db()->where('updated_at', $this->today())->count());
        $this->assertSame(30, $this->db()->where('updated_at', $this->yesterday())->count());
    }

    public function testBuilders()
    {
        $this->fakeCustom(100);

        $this->assertSame(100, $this->db()->where('updated_at', $this->today())->count());
        $this->assertSame(0, $this->db()->where('updated_at', $this->yesterday())->count());

        $builder = Custom::query();

        $builder->update(['updated_at' => $this->yesterday()]);

        LastModified::make()
            ->builders($builder)
            ->update();

        $this->assertSame(0, $this->db()->where('updated_at', $this->today())->count());
        $this->assertSame(100, $this->db()->where('updated_at', $this->yesterday())->count());
    }

    public function testModels()
    {
        $this->fakeCustom(3);

        $this->assertSame(3, $this->db()->where('updated_at', $this->today())->count());
        $this->assertSame(0, $this->db()->where('updated_at', $this->yesterday())->count());

        Custom::query()->update(['updated_at' => $this->yesterday()]);

        $collection = Custom::query()->get();

        $model1 = $collection->get(0);
        $model2 = $collection->get(1);
        $model3 = $collection->get(2);

        LastModified::make()
            ->models($model1, $model2, $model3)
            ->update();

        $this->assertSame(0, $this->db()->where('updated_at', $this->today())->count());
        $this->assertSame(3, $this->db()->where('updated_at', $this->yesterday())->count());
    }

    public function testManual()
    {
        $this->fakeCustom(2);

        $this->assertSame(2, $this->db()->where('updated_at', $this->today())->count());
        $this->assertSame(0, $this->db()->where('updated_at', $this->yesterday())->count());

        Custom::query()->update(['updated_at' => $this->yesterday()]);

        $manual = Custom::query()->get()->map(function (Custom $custom) {
            return Item::make($custom->only(['url', 'updated_at']));
        });

        LastModified::make()
            ->manual($manual[0], $manual[1])
            ->update();

        $this->assertSame(0, $this->db()->where('updated_at', $this->today())->count());
        $this->assertSame(2, $this->db()->where('updated_at', $this->yesterday())->count());
    }
}
