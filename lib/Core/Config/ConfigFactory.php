<?php

namespace Phpprc\Core\Config;

class ConfigFactory
{
    public function fromArray(array $config): Config
    {
        return Config::fromArray($config);
    }

    public function empty(): Config
    {
        return Config::empty();
    }
}
