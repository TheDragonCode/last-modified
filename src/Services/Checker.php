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
use DragonCode\LastModified\Concerns\Cacheable;
use DragonCode\LastModified\Concerns\Urlable;
use DragonCode\Support\Concerns\Makeable;
use Illuminate\Http\Request;
use Lmc\HttpConstants\Header;

/**
 * @method static Checker make(Request $request = null)
 */
class Checker
{
    use Cacheable;
    use Makeable;
    use Urlable;

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

        return $this->find();
    }

    protected function find(): ?DateTimeInterface
    {
        if (! empty($this->hash)) {
            return $this->cache($this->hash)->get();
        }

        return null;
    }

    protected function modifiedSince()
    {
        return $this->request->headers->getDate(Header::IF_MODIFIED_SINCE);
    }

    protected function doesntRequest(): bool
    {
        return empty($this->request);
    }
}
