<?php

namespace Helldar\LastModified\Services;

use Helldar\LastModified\Exceptions\UrlNotFoundException;
use Illuminate\Database\Eloquent\Collection;

class LastModified
{
    /**
     * @param \Illuminate\Database\Eloquent\Collection ...$collections
     *
     * @throws \Helldar\LastModified\Exceptions\UrlNotFoundException
     *
     * @return $this
     */
    public function collections(Collection ...$collections)
    {
        foreach ((array) $collections as $collection) {
            $collection
                ->each(function ($model) {
                    $this->models($model);
                });
        }

        return $this;
    }

    /**
     * @param mixed ...$models
     *
     * @throws \Helldar\LastModified\Exceptions\UrlNotFoundException
     *
     * @return $this
     */
    public function models(...$models)
    {
        foreach ((array) $models as $model) {
            $this->process($model);
        }

        return $this;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @throws \Helldar\LastModified\Exceptions\UrlNotFoundException
     */
    private function process($model)
    {
        if (!isset($model->url)) {
            throw new UrlNotFoundException($model);
        }

        $updated_at = $model->updated_at ?? null;

        $this->store($model->url, $updated_at);
    }

    /**
     * @param string $url
     * @param \DateTimeInterface $updated_at
     */
    private function store(string $url, \DateTimeInterface $updated_at)
    {
        (new Check)->updateOrCreate($url, $updated_at);
    }
}
