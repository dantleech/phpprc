<?php

namespace Phpprc\Bridge\Core\Symfony;

use Phpprc\Core\Core\ParameterResolver;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SymfonyParameterResolver implements ParameterResolver
{
    /**
     * @var OptionsResolver
     */
    private $resolver;

    public function __construct()
    {
        $this->resolver = new OptionsResolver();
    }

    public function setDefaults(array $defaults): void
    {
        $this->resolver->setDefaults($defaults);
    }

    public function setRequired(array $optionNames): void
    {
        $this->resolver->setRequired($optionNames);
    }

    public function setAllowedValues($option, array $allowedValues): void
    {
        $this->resolver->setAllowedValues($option, $allowedValues);
    }

    public function setAllowedTypes($option, array $allowedTypes): void
    {
        $this->resolver->setAllowedTypes($option, $allowedTypes);
    }

    public function resolve(array $options = []): array
    {
        return $this->resolver->resolve($options);
    }
}
