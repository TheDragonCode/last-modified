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

namespace Tests\Concerns;

use DragonCode\LastModified\Models\Model;
use DragonCode\Support\Facades\Helpers\Str;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Support\Collection;
use Tests\fixtures\Models\Custom;

trait Fakeable
{
    protected function fakeModel(): void
    {
        Model::query()->create([
            'hash'       => $this->hashUrl($this->url()),
            'url'        => $this->url(),
            'updated_at' => $this->today(),
        ]);
    }

    protected function fakeCustom(int $count, bool $set_last = true): Collection
    {
        $items = collect();

        for ($i = 0; $i < $count; $i++) {
            $slug = Str::random();

            $updated_at = $this->today();

            $model = Custom::query()->create(compact('slug', 'updated_at'));

            $items->push($model);

            if ($set_last) {
                $this->setFakeLastModified($model);
            }
        }

        return $items;
    }

    protected function setFakeLastModified(BaseModel $model): void
    {
        $hash       = $this->hashUrl($model->url);
        $url        = $model->url;
        $updated_at = $model->updated_at;

        Model::create(compact('hash', 'url', 'updated_at'));
    }
}
