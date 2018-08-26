<?php

namespace Phpprc\Core\Core;

use Closure;
use Phpprc\Bridge\Core\Symfony\SymfonyParameterResolver;

class ConfigResolver
{
    public function resolveConfig(Closure $configurator, array $config)
    {
        $resolver = new SymfonyParameterResolver();
        $configurator($resolver);

        return $resolver->resolve($config);
    }
}
