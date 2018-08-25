<?php

namespace Phpprc\Core\Package;

use Phpprc\Core\ConfigResolver;
use Phpprc\Core\ParameterResolver;

class PackageFactory
{
    /**
     * @var array
     */
    private $prototype;

    public function __construct(array $prototype, ConfigResolver $configResolver)
    {
        $this->prototype = $prototype;
    }

    public function createFromFullNameAndConfig(string $name, array $config)
    {
        $config = array_merge($this->prototype, $config);

        $config = $this->configResolver->resolveConfig($config, function (ParameterResolver $resolver) {
            $resolver->setDefaults([
                'modules' => [],
                'config' => [],
            ]);
            $resolver->setRequired([
                'base_path',
            ]);
            $resolver->setAllowedTypes('modules', ['array']);
            $resolver->setAllowedTypes('config', ['array']);
            $resolver->setAllowedTypes('base_path', ['string']);
        });

        [$vendor, $name] = $this->extractPackageNameParts();

        return new Package([
            $vendor,
            $name,
            $config['base_path'],
            $config['modules'],
            $config['config'],
        ]);
    }

    private function extractPackageNameParts()
    {
        $parts = array_filter(explode('/', $composite), function ($part) {
            return !empty($part);
        });
        
        if (count($parts) !== 2) {
            throw new InvalidArgumentException(sprintf(
                'Invalid package name "%s", expected package name of form <vendor>/<name>',
                $composite
            ));
        }
        return $parts;
    }
}
