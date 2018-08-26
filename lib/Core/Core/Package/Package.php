<?php

namespace Phpprc\Core\Core\Package;

class Package
{
    private $vendor;
    private $name;
    private $config;
    private $basePath;
    private $modules;

    public function __construct(
        string $vendor,
        string $name,
        string $basePath,
        array $modules,
        array $config
    ) {
        $this->vendor = $vendor;
        $this->name = $name;
        $this->config = $config;
        $this->basePath = $basePath;
        $this->modules = $modules;
        $this->config = $config;
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

    public function basePath(): string
    {
        return $this->basePath;
    }

    public function modules(): array
    {
        return $this->modules;
    }
}
