<?php

namespace Helldar\LastModified\Services;

use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Check
{
    /** @var string */
    private $db_connection;

    /** @var string */
    private $table_name = 'last_modified';

    /** @var \Illuminate\Http\Request */
    private $request;

    /** @var string */
    private $key;

    public function __construct(Request $request = null)
    {
        $url       = $request->url();
        $this->key = md5(trim($url));

        $this->request = $request;

        $this->db_connection = config('last_modified.connection');
    }

    public function isNotModified(): bool
    {
        $modified_since = $this->request->headers->getDate('If-Modified-Since');
        $last_modified  = $this->getDate();

        return $modified_since >= $last_modified;
    }

    public function getDate(): \DateTimeInterface
    {
        $item = $this->get();
        $date = $item->updated_at ?? date('Y-m-d H:i:s');

        return Carbon::parse($date);
    }

    public function get()
    {
        return $this->db()
            ->where('key', $this->key)
            ->first();
    }

    public function updateOrCreate(string $url, \DateTimeInterface $date): bool
    {
        $key        = md5(trim($url));
        $updated_at = $date ?: Carbon::now();

        return $this->db()
            ->updateOrInsert(compact('key'), compact('updated_at'));
    }

    private function db(): Builder
    {
        return DB::connection($this->db_connection)
            ->table($this->table_name);
    }
}
