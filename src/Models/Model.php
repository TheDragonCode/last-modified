<?php

declare(strict_types=1);

namespace Helldar\LastModified\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
    public $timestamps = false;

    public $incrementing = false;

    protected $table = 'last_modified';

    protected $primaryKey = 'key';

    protected $keyType = 'string';

    protected $fillable = ['key', 'url', 'updated_at'];

    protected $casts = [
        'updated_at' => 'datetime',
    ];
}
