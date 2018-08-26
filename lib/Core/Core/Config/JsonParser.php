<?php

namespace Phpprc\Core\Core\Config;

interface JsonParser
{
    public function parse(string $jsonString): array;
}
