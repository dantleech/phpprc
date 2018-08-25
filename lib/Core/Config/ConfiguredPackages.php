<?php

namespace Phpprc\Core\Config;

use IteratorAggregate;

class ConfiguredPackages implements IteratorAggregate
{
    /**
     * @var array
     */
    private $packages;

    public function __construct(array $packages)
    {
        $this->packages = $packages;
    }

    public function getIterator()
    {
        foreach ($this->packages as $package) {
            yield $package;
        }
    }
}
