<?php

declare(strict_types=1);

namespace Tests\WhenEnabled\Services\LastModified;

use DragonCode\LastModified\Resources\Item;
use DragonCode\LastModified\Services\LastModified;
use Tests\fixtures\Models\Custom;
use Tests\WhenEnabled\TestCase;

class ToDeleteTest extends TestCase
{
    public function testCollectionModels()
    {
        $this->assertDatabaseCount($this->table(), 0, $this->connection());

        $collection = $this->fakeCustom(30);

        $this->assertDatabaseCount($this->table(), 30, $this->connection());

        LastModified::make()
            ->collections($collection)
            ->delete();

        $this->assertDatabaseCount($this->table(), 0, $this->connection());
    }

    public function testCollectionBuilders()
    {
        $this->assertDatabaseCount($this->table(), 0, $this->connection());

        $this->fakeCustom(30);

        $this->assertDatabaseCount($this->table(), 30, $this->connection());

        $builder = Custom::query();

        $collection = collect()->push($builder);

        LastModified::make()
            ->collections($collection)
            ->delete();

        $this->assertDatabaseCount($this->table(), 0, $this->connection());
    }

    public function testCollectionManual()
    {
        $this->assertDatabaseCount($this->table(), 0, $this->connection());

        $collection = $this->fakeCustom(30);

        $this->assertDatabaseCount($this->table(), 30, $this->connection());

        $manual = $collection->map(static function (Custom $custom) {
            return Item::make($custom->only(['url', 'updated_at']));
        });

        LastModified::make()
            ->collections($manual)
            ->delete();

        $this->assertDatabaseCount($this->table(), 0, $this->connection());
    }

    public function testBuilders()
    {
        $this->assertDatabaseCount($this->table(), 0, $this->connection());

        $this->fakeCustom(100);

        $this->assertDatabaseCount($this->table(), 100, $this->connection());

        $builder = Custom::query();

        LastModified::make()
            ->builders($builder)
            ->delete();

        $this->assertDatabaseCount($this->table(), 0, $this->connection());
    }

    public function testModels()
    {
        $this->assertDatabaseCount($this->table(), 0, $this->connection());

        $collection = $this->fakeCustom(3);

        $this->assertDatabaseCount($this->table(), 3, $this->connection());

        $model1 = $collection->get(0);
        $model2 = $collection->get(1);
        $model3 = $collection->get(2);

        LastModified::make()
            ->models($model1, $model2, $model3)
            ->delete();

        $this->assertDatabaseCount($this->table(), 0, $this->connection());
    }

    public function testManual()
    {
        $this->assertDatabaseCount($this->table(), 0, $this->connection());

        $collection = $this->fakeCustom(2);

        $this->assertDatabaseCount($this->table(), 2, $this->connection());

        $manual = $collection->map(function (Custom $custom) {
            return Item::make($custom->only(['url', 'updated_at']));
        });

        LastModified::make()
            ->manual($manual[0], $manual[1])
            ->delete();

        $this->assertDatabaseCount($this->table(), 0, $this->connection());
    }
}
