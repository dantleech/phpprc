<?php

namespace Phpprc\Core\Config;

class ConfigFactory
{
    public function fromArray(array $config)
    {
        return Config::fromArray($config);
    }

    public function empty()
    {
        return Config::empty();
    }
}
