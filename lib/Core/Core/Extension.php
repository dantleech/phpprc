<?php

namespace Phpprc\Core\Core;

use Phpactor\Container\ContainerBuilder;

interface Extension
{
    public function configure(ParameterResolver $parameters);

    public function register(ContainerBuilder $container);
}
