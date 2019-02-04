<?php

namespace Helldar\LastModified\Services;

use Helldar\LastModified\Exceptions\UrlNotFoundException;
use Illuminate\Database\Eloquent\Collection;

class LastModified
{
    private $collections = [];

    private $models = [];

    private $manuals = [];

    public function collections(Collection ...$collections)
    {
        $this->collections = (array) $collections;

        return $this;
    }

    public function models(...$models)
    {
        $this->models = (array) $models;

        return $this;
    }

    public function manuals(LastItem ...$items)
    {
        $this->manuals = (array) $items;

        return $this;
    }

    /**
     * @param bool $force
     *
     * @throws \Helldar\LastModified\Exceptions\UrlNotFoundException
     */
    public function update(bool $force = false)
    {
        if ($this->isDisabled($force)) {
            return;
        }

        foreach ($this->collections as $collection) {
            $collection->each(function ($model) {
                $this->store($model);
            });
        }

        foreach ($this->models as $model) {
            $this->store($model);
        }

        foreach ($this->manuals as $item) {
            $this->updateOrCreate($item->url, $item->updated_at);
        }
    }

    public function delete(bool $force = false)
    {
        if ($this->isDisabled($force)) {
            return;
        }

        foreach ($this->collections as $collection) {
            $collection->each(function ($model) {
                $this->deleteFromTable($model->url);
            });
        }

        foreach ($this->models as $model) {
            $this->deleteFromTable($model->url);
        }

        foreach ($this->manuals as $item) {
            $this->deleteFromTable($item->url);
        }
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @throws \Helldar\LastModified\Exceptions\UrlNotFoundException
     */
    private function store($model)
    {
        if (!isset($model->url)) {
            throw new UrlNotFoundException($model);
        }

        $updated_at = $model->updated_at ?? null;

        $this->updateOrCreate($model->url, $updated_at);
    }

    private function updateOrCreate(string $url, \DateTimeInterface $updated_at = null)
    {
        (new Check)->updateOrCreate($url, $updated_at);
    }

    private function deleteFromTable(string $url)
    {
        (new Check)->delete($url);
    }

    private function isDisabled(bool $force = false): bool
    {
        return !$force && !config('last_modified.enabled');
    }
}
