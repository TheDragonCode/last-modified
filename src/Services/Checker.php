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

namespace DragonCode\LastModified\Services;

use DateTimeInterface;
use DragonCode\LastModified\Concerns\Urlable;
use DragonCode\LastModified\Models\Model;
use DragonCode\Support\Concerns\Makeable;
use Illuminate\Http\Request;

/**
 * @method static Checker make(Request $request = null)
 */
class Checker
{
    use Urlable;
    use Makeable;

    protected $request;

    protected $hash;

    public function __construct(Request $request = null)
    {
        if (! empty($request)) {
            $this->request = $request;

            $this->hash = $this->hashUrl($request->fullUrl());
        }
    }

    public function isNotModified(): bool
    {
        if ($this->doesntRequest()) {
            return false;
        }

        $since = $this->modifiedSince();
        $last  = $this->getDate();

        if (! empty($since) && ! empty($last)) {
            return $since >= $last;
        }

        return false;
    }

    public function getDate(): ?DateTimeInterface
    {
        if ($this->doesntRequest()) {
            return null;
        }

        if ($model = $this->find()) {
            return $model->updated_at;
        }

        return null;
    }

    /**
     * @return \DragonCode\LastModified\Models\Model|\Illuminate\Database\Eloquent\Model|null
     */
    protected function find(): ?Model
    {
        if (! empty($this->hash)) {
            return Model::query()->find($this->hash);
        }

        return null;
    }

    protected function modifiedSince()
    {
        return $this->request->headers->getDate('If-Modified-Since');
    }

    protected function doesntRequest(): bool
    {
        return empty($this->request);
    }
}
