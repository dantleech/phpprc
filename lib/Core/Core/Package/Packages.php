<?php

namespace Phpprc\Core\Core\Package;

use IteratorAggregate;

class Packages implements IteratorAggregate
{
    /**
     * @var Package[]
     */
    private $packages;

    public function __construct(array $packages)
    {
        foreach ($packages as $package) {
            $this->add($package);
        }
    }

    private function add(Package $package)
    {
        $this->packages[] = $package;
    }

    /**
     * {@inheritDoc}
     */
    public function getIterator()
    {
        foreach ($this->packages as $package) {
            yield $package;
        }
    }
}
