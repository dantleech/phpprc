<?php

namespace Phpprc\Core\Config;

interface Loader
{
    public function load(): Config;
}
