<?php

/*
 * This file is part of the "dragon-code/last-modified" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2024 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/last-modified
 */

declare(strict_types=1);

namespace Tests\Concerns;

use DragonCode\LastModified\Concerns\Urlable as BaseUrl;
use Illuminate\Support\Carbon;

trait Urlable
{
    use BaseUrl;

    protected function url(): string
    {
        return 'http://localhost/foo';
    }

    protected function today(): Carbon
    {
        return Carbon::today();
    }

    protected function yesterday(): Carbon
    {
        return Carbon::yesterday();
    }

    protected function tomorrow(): Carbon
    {
        return Carbon::tomorrow();
    }
}
