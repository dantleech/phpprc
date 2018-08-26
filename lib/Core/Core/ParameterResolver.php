<?php

namespace Phpprc\Core\Core;

interface ParameterResolver
{
    public function setDefaults(array $defaults): void;

    public function setRequired(array $optionNames): void;

    public function setAllowedValues($option, array $allowedValues): void;

    public function setAllowedTypes($option, array $allowedTypes): void;

    public function resolve(array $options = []): array;
}
