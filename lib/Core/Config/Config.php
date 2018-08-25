<?php

namespace Phpprc\Core\Config;

class Config
{
    /**
     * @var array
     */
    private $config;

    private function __construct(array $config)
    {
        $this->config = $config;
    }

    public static function fromArray($config)
    {
        return new self($config);
    }
}
