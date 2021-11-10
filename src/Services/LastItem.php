<?php

namespace Helldar\LastModified\Services;

use DateTimeInterface;
use Helldar\LastModified\Exceptions\IncorrectUrlValueException;
use Illuminate\Support\Facades\Validator;

class LastItem
{
    /** @var string */
    public $url;

    /** @var \DateTimeInterface|null */
    public $updated_at;

    /**
     * @param  string  $url
     * @param  \DateTimeInterface|null  $updated_at
     *
     * @throws \Helldar\LastModified\Exceptions\IncorrectUrlValueException
     */
    public function __construct(string $url, DateTimeInterface $updated_at = null)
    {
        $this->validateUrl($url);

        $this->url        = $url;
        $this->updated_at = $updated_at ?: null;
    }

    /**
     * @param  string  $url
     *
     * @throws \Helldar\LastModified\Exceptions\IncorrectUrlValueException
     */
    private function validateUrl(string $url)
    {
        $validator = Validator::make(compact('url'), $this->rules(), $this->messages($url));

        if ($validator->fails()) {
            throw new IncorrectUrlValueException($validator->errors()->first());
        }
    }

    private function rules(): array
    {
        return ['url' => 'required|url'];
    }

    private function messages(string $url = null)
    {
        return [
            'url.required' => 'The URL field is required.',
            'url.url'      => "URL \"{$url}\" is incorrect!",
        ];
    }
}
