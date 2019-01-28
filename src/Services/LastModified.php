<?php

namespace Helldar\LastModified\Services;

use Illuminate\Database\Eloquent\Collection;

class LastModified
{
    public function models(Collection ...$models)
    {
        foreach ((array) $models as $item) {
            $this->process($item);
        }

        return $this;
    }

    private function process(Collection $model)
    {
        $model
            ->each(function ($item) {
                $updated_at = $item->updated_at ?? null;

                $this->store($item->url, $updated_at);
            });
    }

    private function store(string $url, \DateTimeInterface $updated_at)
    {
        (new Check)->updateOrCreate($url, $updated_at);
    }
}
