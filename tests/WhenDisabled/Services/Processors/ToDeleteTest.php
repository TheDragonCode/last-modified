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

namespace Tests\WhenDisabled\Services\Processors;

use DragonCode\LastModified\Resources\Item;
use DragonCode\LastModified\Services\Processors\ToDelete;
use Tests\fixtures\Models\Custom;
use Tests\WhenDisabled\TestCase;

class ToDeleteTest extends TestCase
{
    public function testCollectionModels()
    {
        $this->assertDatabaseCount($this->table(), 0, $this->connection());

        $collection = $this->fakeCustom(30);

        $this->assertDatabaseCount($this->table(), 30, $this->connection());

        ToDelete::make()->collections($collection);

        $this->assertDatabaseCount($this->table(), 0, $this->connection());
    }

    public function testCollectionBuilders()
    {
        $this->assertDatabaseCount($this->table(), 0, $this->connection());

        $this->fakeCustom(30);

        $this->assertDatabaseCount($this->table(), 30, $this->connection());

        $builder = Custom::query();

        $collection = collect()->push($builder);

        ToDelete::make()->collections($collection);

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

        ToDelete::make()->collections($manual);

        $this->assertDatabaseCount($this->table(), 0, $this->connection());
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

        $collection = $this->fakeCustom(3);

        $this->assertDatabaseCount($this->table(), 3, $this->connection());

        $model1 = $collection->get(0);
        $model2 = $collection->get(1);
        $model3 = $collection->get(2);

        ToDelete::make()->models($model1, $model2, $model3);

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

        ToDelete::make()->manual($manual[0], $manual[1]);

        $this->assertDatabaseCount($this->table(), 0, $this->connection());
    }
}
