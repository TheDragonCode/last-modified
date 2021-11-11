<?php

declare(strict_types=1);

namespace Tests\Concerns;

use DragonCode\LastModified\Models\Model;
use DragonCode\Support\Facades\Helpers\Str;
use Illuminate\Database\Eloquent\Model as BaseModel;
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

    protected function fakeCustom(int $count, bool $set_last = true): void
    {
        for ($i = 0; $i < $count; $i++) {
            $slug = Str::random();

            $model = Custom::query()->create(compact('slug'));

            if ($set_last) {
                $this->setFakeLastModified($model);
            }
        }
    }

    protected function setFakeLastModified(BaseModel $model): void
    {
        $hash       = $this->hashUrl($model->url);
        $url        = $model->url;
        $updated_at = $model->updated_at;

        Model::create(compact('hash', 'url', 'updated_at'));
    }
}
