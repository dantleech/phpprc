<?php

namespace Phpprc\Core\Package;

use Prophecy\Exception\InvalidArgumentException;
use Phpprc\Core\Package\Package;

class Package
{
    private $vendor;
    private $name;
    private $config;
    private $basePath;
    private $modules;
    private $config;

    public function __construct(
        string $vendor,
        string $name,
        string $basePath,
        array $modules,
        array $config
    )
    {
        $this->vendor = $vendor;
        $this->name = $name;
        $this->config = $config;
        $this->basePath = $basePath;
        $this->modules = $modules;
        $this->config = $config;
    }

    public static function fromNameAndConfig(string $fullName, array $config): Package
    {
        $parts = $this->extractPackageNameParts();

        return new self($parts[0], $parts[1], $config);
    }

    public function vendor(): string
    {
        return $this->vendor;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function config(): array
    {
        return $this->config;
    }

    private function extractPackageNameParts()
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
        return $parts;
    }
}
