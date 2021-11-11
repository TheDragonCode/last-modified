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

namespace Tests\fixtures\Models;

use DragonCode\Support\Facades\Helpers\Ables\Stringable;
use Illuminate\Database\Eloquent\Model;

class Custom extends Model
{
    protected $table = 'custom';

    protected $fillable = ['slug', 'updated_at'];

    protected function setSlugAttribute(string $slug): void
    {
        $this->attributes['slug'] = Stringable::of($slug)->trim()->slug();
    }

    protected function getUrlAttribute(): string
    {
        $slug = $this->slug;

        return route('slug', compact('slug'));
    }
}
