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

namespace Tests\WhenEnabled\Services\Processors;

use DragonCode\LastModified\Resources\Item;
use DragonCode\LastModified\Services\Processors\ToDelete;
use Tests\fixtures\Models\Custom;
use Tests\WhenEnabled\TestCase;

class ToDeleteTest extends TestCase
{
    public function testCollectionModels()
    {
        $collection = $this->fakeCustom(30);

        ToDelete::make()->collections($collection);
    }

    public function testCollectionBuilders()
    {
        $this->fakeCustom(30);

        $builder = Custom::query();

        $collection = collect()->push($builder);

        ToDelete::make()->collections($collection);
    }

    public function testCollectionManual()
    {
        $collection = $this->fakeCustom(30);

        $manual = $collection->map(static function (Custom $custom) {
            return Item::make($custom->only(['url', 'updated_at']));
        });

        ToDelete::make()->collections($manual);
    }

    public function testBuilders()
    {
        $this->fakeCustom(100);

        $builder = Custom::query();

        ToDelete::make()->builders($builder);
    }

    public function testModels()
    {
        $collection = $this->fakeCustom(3);

        $model1 = $collection->get(0);
        $model2 = $collection->get(1);
        $model3 = $collection->get(2);

        ToDelete::make()->models($model1, $model2, $model3);
    }

    public function testManual()
    {
        $collection = $this->fakeCustom(2);

        $manual = $collection->map(function (Custom $custom) {
            return Item::make($custom->only(['url', 'updated_at']));
        });

        ToDelete::make()->manual($manual[0], $manual[1]);
    }
}
