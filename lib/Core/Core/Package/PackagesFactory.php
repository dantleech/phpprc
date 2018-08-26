<?php

namespace Phpprc\Core\Core\Package;

class PackagesFactory
{
    /**
     * @var PackageFactory
     */
    private $packageFactory;

    public function __construct(PackageFactory $packageFactory)
    {
        $this->packageFactory = $packageFactory;
    }

    public function createFromArrayOfPackages(array $array)
    {
        $packages = array_map(function (string $name, array $config) {
            return $this->packageFactory->createFromFullNameAndConfig($name, $config);
        }, array_keys($array), array_values($array));

        return new Packages($packages);
    }
}
