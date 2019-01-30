<?php

namespace Helldar\LastModified\Services;

use Helldar\LastModified\Exceptions\IncorrectUrlValueException;
use Illuminate\Support\Facades\Validator;

class Item
{
    /** @var string */
    public $url;

    /** @var \DateTimeInterface|null */
    public $updated_at;

    /**
     * Item constructor.
     *
     * @param string $url
     * @param \DateTimeInterface|null $updated_at
     *
     * @throws \Helldar\LastModified\Exceptions\IncorrectUrlValueException
     */
    public function __construct(string $url, \DateTimeInterface $updated_at = null)
    {
        $this->validateUrl($url);

        $this->url        = $url;
        $this->updated_at = $updated_at ?: null;
    }

    /**
     * @param string $url
     *
     * @throws \Helldar\LastModified\Exceptions\IncorrectUrlValueException
     */
    private function validateUrl(string $url)
    {
        $validate = Validator::make(compact('url'), [
            'url' => 'required|url',
        ]);

        if ($validate->fails()) {
            throw new IncorrectUrlValueException($validate->errors()->first());
        }
    }
}
