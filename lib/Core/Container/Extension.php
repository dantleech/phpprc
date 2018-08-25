<?php

namespace Phpprc\Core\Container;

use Phpactor\Container\Container;

interface Extension
{
    public function configure(ParameterResolver $optionsResolver);

    public function register(Container $container);
}
