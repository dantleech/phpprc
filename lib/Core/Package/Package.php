<?php

namespace Phpprc\Core\Package;

use Prophecy\Exception\InvalidArgumentException;

class Package
{
    private $vendor;
    private $name;
    private $attributes = [];

    public function __construct(string $vendor, string $name)
    {
        $this->vendor = $vendor;
        $this->name = $name;
    }

    public static function fromString($composite): Package
    {
        $parts = array_filter(explode('/', $composite), function ($part) {
            return !empty($part);
        });

        if (count($parts) !== 2) {
            throw new InvalidArgumentException(sprintf(
                'Invalid package name "%s", expected package name of form <vendor>/<name>',
                $composite
            ));
        }

        return new self($parts[0], $parts[1]);
    }

    public function withAttributes(array $attributes)
    {
        $clone = clone $this;
        $clone->attributes = $attributes;

        return $clone;
    }

    public function vendor(): string
    {
        return $this->vendor;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function attributes()
    {
        return $this->attributes;
    }
}
