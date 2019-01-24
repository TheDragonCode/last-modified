<?php

namespace Helldar\LastModified\Services;

use Illuminate\Database\Query\Builder;

class LastModified
{
    public function builders(Builder ...$builder)
    {
        foreach ((array) $builder as $item) {
            $this->process($item);
        }

        return $this;
    }

    private function process(Builder $builder)
    {
        $builder
            ->get()
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
