<?php

namespace Phpprc\Extension\Core\Console;

use Symfony\Component\Console\Application as SymfonyApplication;

class Application extends SymfonyApplication
{
    public function __construct()
    {
        parent::__construct('PHP Package Remote Control');
    }
}
