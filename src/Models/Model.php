<?php

/*
 * This file is part of the "dragon-code/last-modified" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/last-modified
 */

declare(strict_types=1);

namespace DragonCode\LastModified\Models;

use DragonCode\LastModified\Concerns\Migrations\Database;
use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
    use Database;

    public $timestamps = false;

    public $incrementing = false;

    protected $primaryKey = 'hash';

    protected $keyType = 'string';

    protected $fillable = ['hash', 'url', 'updated_at'];

    protected $casts = [
        'updated_at' => 'datetime',
    ];

    public function __construct(array $attributes = [])
    {
        $this->setConnection($this->connection());
        $this->setTable($this->table());

        parent::__construct($attributes);
    }
}
