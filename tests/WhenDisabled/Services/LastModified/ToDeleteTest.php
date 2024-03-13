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

namespace Tests\WhenDisabled\Services\LastModified;

use DragonCode\LastModified\Resources\Item;
use DragonCode\LastModified\Services\LastModified;
use Tests\fixtures\Models\Custom;
use Tests\WhenDisabled\TestCase;

class ToDeleteTest extends TestCase
{
    public function testCollectionModels()
    {
        $fakes = $this->fakeCustom(30);

        $this->assertDoesntManyCache($fakes);

        LastModified::make()
            ->collections($fakes)
            ->delete();

        $this->assertDoesntManyCache($fakes);
    }

    public function testCollectionBuilders()
    {
        $fakes = $this->fakeCustom(30);

        $this->assertDoesntManyCache($fakes);

        $builder = Custom::query();

        $collection = collect()->push($builder);

        LastModified::make()
            ->collections($collection)
            ->delete();

        $this->assertDoesntManyCache($fakes);
    }

    public function testCollectionManual()
    {
        $fakes = $this->fakeCustom(30);

        $this->assertDoesntManyCache($fakes);

        $manual = $fakes->map(static function (Custom $custom) {
            return Item::make($custom->only(['url', 'updated_at']));
        });

        LastModified::make()
            ->collections($manual)
            ->delete();

        $this->assertDoesntManyCache($fakes);
    }

    public function testBuilders()
    {
        $fakes = $this->fakeCustom(100);

        $this->assertDoesntManyCache($fakes);

        $builder = Custom::query();

        LastModified::make()
            ->builders($builder)
            ->delete();

        $this->assertDoesntManyCache($fakes);
    }

    public function testModels()
    {
        $fakes = $this->fakeCustom(3);

        $this->assertDoesntManyCache($fakes);

        $model1 = $fakes->get(0);
        $model2 = $fakes->get(1);
        $model3 = $fakes->get(2);

        LastModified::make()
            ->models($model1, $model2, $model3)
            ->delete();

        $this->assertDoesntManyCache($fakes);
    }

    public function testManual()
    {
        $fakes = $this->fakeCustom(2);

        $this->assertDoesntManyCache($fakes);

        $manual = $fakes->map(function (Custom $custom) {
            return Item::make($custom->only(['url', 'updated_at']));
        });

        LastModified::make()
            ->manual($manual[0], $manual[1])
            ->delete();

        $this->assertDoesntManyCache($fakes);
    }
}
