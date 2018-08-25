<?php

namespace Phpprc\Core;

use Closure;

class ConfigResolver
{
    public function resolveConfig(array $config, Closure $configurator)
    {
        $resolver = new SymfonyParameterResolver();
        $configurator($resolver);
        return $resolver->resolve($config);
    }
}
