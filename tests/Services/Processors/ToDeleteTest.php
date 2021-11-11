<?php

declare(strict_types=1);

namespace Tests\Services\Processors;

use DragonCode\LastModified\Resources\Item;
use DragonCode\LastModified\Services\Processors\ToDelete;
use Tests\fixtures\Models\Custom;
use Tests\TestCase;

class ToDeleteTest extends TestCase
{
    public function testCollectionModels()
    {
        $this->assertDatabaseCount($this->table(), 0, $this->connection());

        $this->fakeCustom(30);

        $this->assertDatabaseCount($this->table(), 30, $this->connection());

        $models = Custom::query()->get();

        ToDelete::make()->collections($models);

        $this->assertDatabaseCount($this->table(), 0, $this->connection());
    }

    public function testCollectionBuilders()
    {
        $this->assertDatabaseCount($this->table(), 0, $this->connection());

        $this->fakeCustom(30);

        $this->assertDatabaseCount($this->table(), 30, $this->connection());

        $builder = Custom::query();

        ToDelete::make()->collections(collect($builder));

        $this->assertDatabaseCount($this->table(), 0, $this->connection());
    }

    public function testCollectionManual()
    {
        $this->assertDatabaseCount($this->table(), 0, $this->connection());

        $this->fakeCustom(30);

        $this->assertDatabaseCount($this->table(), 30, $this->connection());

        $manual = Custom::query()->get()->map(static function (Custom $custom) {
            return Item::make($custom->only(['url', 'updated_at']));
        });

        ToDelete::make()->collections($manual);
    }

    public function testBuilders()
    {
        $this->assertDatabaseCount($this->table(), 0, $this->connection());

        $this->fakeCustom(100);

        $this->assertDatabaseCount($this->table(), 100, $this->connection());

        $builder = Custom::query();

        ToDelete::make()->builders($builder);

        $this->assertDatabaseCount($this->table(), 0, $this->connection());
    }

    public function testModels()
    {
        $this->assertDatabaseCount($this->table(), 0, $this->connection());

        $this->fakeCustom(3);

        $this->assertDatabaseCount($this->table(), 3, $this->connection());

        $model1 = Custom::query()->find(1);
        $model2 = Custom::query()->find(2);
        $model3 = Custom::query()->find(3);

        ToDelete::make()->models($model1, $model2, $model3);

        $this->assertDatabaseCount($this->table(), 0, $this->connection());
    }

    public function testManual()
    {
        $this->assertDatabaseCount($this->table(), 0, $this->connection());

        $this->fakeCustom(2);

        $this->assertDatabaseCount($this->table(), 2, $this->connection());

        $model1 = Custom::query()->find(1);
        $model2 = Custom::query()->find(2);

        $item1 = Item::make($model1->only(['url', 'updated_at']));
        $item2 = Item::make($model2->only(['url', 'updated_at']));

        ToDelete::make()->manual($item1, $item2);

        $this->assertDatabaseCount($this->table(), 0, $this->connection());
    }
}
