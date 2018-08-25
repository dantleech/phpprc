<?php

namespace Phpprc\Core\Package;

use IteratorAggregate;

class SelectedPackages implements IteratorAggregate
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
