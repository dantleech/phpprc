<?php

namespace Phpprc\Core\Config;

use Phpprc\Core\Package\Package;
use Phpprc\Core\Config\ConfiguredPackages;
use Prophecy\Exception\InvalidArgumentException;

class Config
{
    /**
     * @var array
     */
    private $config;

    /**
     * @var SelectedPackages
     */
    private $packages;

    private function __construct(array $config)
    {
        $this->buildConfig($config);
    }

    public static function fromArray(array $config): Config
    {
        return new self($config);
    }

    private function buildConfig(array $config)
    {
        $defaults = [
            'packages' => [],
        ];

        if ($diff = array_diff(array_keys($defaults), array_keys($config))) {
            throw new InvalidConfig(sprintf(
                'Invalid keys "%s", valid keys "%s"',
                implode('", "', $diff),
                implode('", "', array_keys($defaults))
            ));
        }

        $config = array_merge($defaults, $config);

        $this->packages = new ConfiguredPackages(array_map(function ($key, $value) {
            $package = Package::fromString($key);
            return $package;
        }, array_keys($config['packages']), array_values($config['packages'])));
    }

    public function packages(): ConfiguredPackages
    {
        return $this->packages;
    }
}
