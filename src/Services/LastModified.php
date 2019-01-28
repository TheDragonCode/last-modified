<?php

namespace Helldar\LastModified\Services;

use Illuminate\Database\Eloquent\Collection;

class LastModified
{
    public function collections(Collection ...$collections)
    {
        foreach ((array) $collections as $item) {
            $this->processCollection($item);
        }

        return $this;
    }

    public function models(...$models)
    {
        foreach ((array) $models as $model) {
            $this->processModel($model);
        }

        return $this;
    }

    private function processCollection(Collection $model)
    {
        $model->each(function ($item) {
            $this->processModel($item);
        });
    }

    private function processModel($model)
    {
        $updated_at = $model->updated_at ?? null;

        $this->store($model->url, $updated_at);
    }

    private function store(string $url, \DateTimeInterface $updated_at)
    {
        (new Check)->updateOrCreate($url, $updated_at);
    }
}
