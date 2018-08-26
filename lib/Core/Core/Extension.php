<?php

namespace Phpprc\Core\Core;

use Phpactor\Container\ContainerBuilder;

interface Extension
{
    public function configure(ParameterResolver $optionsResolver);

    public function register(ContainerBuilder $container);
}
