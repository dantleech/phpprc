<?php

namespace Phpprc\Core\Core\Package;

class Packages
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
}
