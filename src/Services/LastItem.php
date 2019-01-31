<?php

namespace Helldar\LastModified\Services;

use Helldar\LastModified\Exceptions\IncorrectUrlValueException;

class LastItem
{
    /** @var string */
    public $url;

    /** @var \DateTimeInterface|null */
    public $updated_at;

    /**
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
        $is_not_valid = filter_var($url, FILTER_VALIDATE_URL) === false;

        if ($is_not_valid) {
            throw new IncorrectUrlValueException('The URL attribute must be a valid URL: ' . $url);
        }
    }
}
