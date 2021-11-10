<?php

namespace Helldar\LastModified\Services;

use Carbon\Carbon;
use DateTimeInterface;
use Helldar\LastModified\Models\Model;
use Illuminate\Http\Request;

class Check
{
    /** @var \Illuminate\Http\Request */
    private $request;

    /** @var string */
    private $key;

    public function __construct(Request $request = null)
    {
        if (! is_null($request)) {
            $this->setUrlKey($request);

            $this->request = $request;
        }
    }

    public function isNotModified(): bool
    {
        $modified_since = $this->request->headers->getDate('If-Modified-Since');
        $last_modified  = $this->getDate();

        return $modified_since >= $last_modified;
    }

    public function getDate(): DateTimeInterface
    {
        $item = $this->get();
        $date = $item->updated_at ?? date('Y-m-d H:i:s');

        return Carbon::parse($date);
    }

    public function get(): Model
    {
        return Model::find($this->key);
    }

    public function updateOrCreate(string $url, DateTimeInterface $date = null): void
    {
        $key        = $this->hash($url);
        $updated_at = $date ?: Carbon::now();

        Model::query()->updateOrCreate(
            compact('key'),
            compact('updated_at')
        );
    }

    public function delete(string $url): void
    {
        Model::query()
            ->where('key', $this->hash($url))
            ->delete();
    }

    private function setUrlKey(Request $request)
    {
        $absolute_url = config('last_modified.absolute_url', true);

        $url = $absolute_url ? $request->fullUrl() : $request->path();

        $this->key = $this->hash($url);
    }

    private function hash(string $value): string
    {
        return md5(trim($value));
    }
}
