<?php

namespace Helldar\LastModified\Services;

use Helldar\LastModified\Exceptions\IncorrectUrlValueException;
use Illuminate\Support\Facades\Validator;

class Item
{
    /** @var string */
    public $url;

    /** @var \DateTimeInterface|null */
    public $date;

    /**
     * Item constructor.
     *
     * @param string $url
     * @param \DateTimeInterface|null $date
     *
     * @throws \Helldar\LastModified\Exceptions\IncorrectUrlValueException
     */
    public function __construct(string $url, \DateTimeInterface $date = null)
    {
        $this->validateUrl($url);

        $this->url  = $url;
        $this->date = $date ?? null;
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
