<?php

declare(strict_types=1);

namespace DragonCode\LastModified\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
    public $timestamps = false;

    public $incrementing = false;

    protected $primaryKey = 'key';

    protected $keyType = 'string';

    protected $fillable = ['key', 'url', 'updated_at'];

    protected $casts = [
        'updated_at' => 'datetime',
    ];

    public function __construct(array $attributes = [])
    {
        $this->setConnection(config('last_modified.database.connection'));
        $this->setTable(config('last_modified.database.table'));

        parent::__construct($attributes);
    }
}
