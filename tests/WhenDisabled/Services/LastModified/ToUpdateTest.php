<?php

declare(strict_types=1);

namespace Tests\WhenDisabled\Services\LastModified;

use DragonCode\LastModified\Resources\Item;
use DragonCode\LastModified\Services\LastModified;
use Tests\fixtures\Models\Custom;
use Tests\WhenDisabled\TestCase;

class ToUpdateTest extends TestCase
{
    public function testCollectionModels()
    {
        $this->assertDatabaseCount($this->table(), 0, $this->connection());

        $this->fakeCustom(30);

        $this->assertDatabaseCount($this->table(), 30, $this->connection());

        $this->assertSame(30, $this->db()->where('updated_at', $this->today())->count());
        $this->assertSame(0, $this->db()->where('updated_at', $this->yesterday())->count());

        Custom::query()->update(['updated_at' => $this->yesterday()]);

        $collection = Custom::query()->get();

        LastModified::make()
            ->collections($collection)
            ->update();

        $this->assertSame(30, $this->db()->where('updated_at', $this->today())->count());
        $this->assertSame(0, $this->db()->where('updated_at', $this->yesterday())->count());
    }

    public function testCollectionBuilders()
    {
        $this->assertDatabaseCount($this->table(), 0, $this->connection());

        $this->fakeCustom(30);

        $this->assertDatabaseCount($this->table(), 30, $this->connection());

        $this->assertSame(30, $this->db()->where('updated_at', $this->today())->count());
        $this->assertSame(0, $this->db()->where('updated_at', $this->yesterday())->count());

        $builder = Custom::query();

        $builder->update(['updated_at' => $this->yesterday()]);

        $collection = collect()->push($builder);

        LastModified::make()
            ->collections($collection)
            ->update();

        $this->assertSame(30, $this->db()->where('updated_at', $this->today())->count());
        $this->assertSame(0, $this->db()->where('updated_at', $this->yesterday())->count());
    }

    public function testCollectionManual()
    {
        $this->assertDatabaseCount($this->table(), 0, $this->connection());

        $this->fakeCustom(30);

        $this->assertDatabaseCount($this->table(), 30, $this->connection());

        $this->assertSame(30, $this->db()->where('updated_at', $this->today())->count());
        $this->assertSame(0, $this->db()->where('updated_at', $this->yesterday())->count());

        Custom::query()->update(['updated_at' => $this->yesterday()]);

        $manual = Custom::query()->get()->map(function (Custom $custom) {
            return Item::make($custom->only(['url', 'updated_at']));
        });

        LastModified::make()
            ->collections($manual)
            ->update();

        $this->assertSame(30, $this->db()->where('updated_at', $this->today())->count());
        $this->assertSame(0, $this->db()->where('updated_at', $this->yesterday())->count());
    }

    public function testBuilders()
    {
        $this->assertDatabaseCount($this->table(), 0, $this->connection());

        $this->fakeCustom(100);

        $this->assertDatabaseCount($this->table(), 100, $this->connection());

        $this->assertSame(100, $this->db()->where('updated_at', $this->today())->count());
        $this->assertSame(0, $this->db()->where('updated_at', $this->yesterday())->count());

        $builder = Custom::query();

        $builder->update(['updated_at' => $this->yesterday()]);

        LastModified::make()
            ->builders($builder)
            ->update();

        $this->assertSame(100, $this->db()->where('updated_at', $this->today())->count());
        $this->assertSame(0, $this->db()->where('updated_at', $this->yesterday())->count());
    }

    public function testModels()
    {
        $this->assertDatabaseCount($this->table(), 0, $this->connection());

        $this->fakeCustom(3);

        $this->assertDatabaseCount($this->table(), 3, $this->connection());

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

        $this->assertSame(3, $this->db()->where('updated_at', $this->today())->count());
        $this->assertSame(0, $this->db()->where('updated_at', $this->yesterday())->count());
    }

    public function testManual()
    {
        $this->assertDatabaseCount($this->table(), 0, $this->connection());

        $this->fakeCustom(2);

        $this->assertDatabaseCount($this->table(), 2, $this->connection());

        $this->assertSame(2, $this->db()->where('updated_at', $this->today())->count());
        $this->assertSame(0, $this->db()->where('updated_at', $this->yesterday())->count());

        Custom::query()->update(['updated_at' => $this->yesterday()]);

        $manual = Custom::query()->get()->map(function (Custom $custom) {
            return Item::make($custom->only(['url', 'updated_at']));
        });

        LastModified::make()
            ->manual($manual[0], $manual[1])
            ->update();

        $this->assertSame(2, $this->db()->where('updated_at', $this->today())->count());
        $this->assertSame(0, $this->db()->where('updated_at', $this->yesterday())->count());
    }
}
