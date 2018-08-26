<?php

namespace Phpprc\Core\Core\Package;

use InvalidArgumentException;
use Phpprc\Core\Core\ConfigResolver;
use Phpprc\Core\Core\ParameterResolver;

class PackageFactory
{
    /**
     * @var array
     */
    private $prototype;

    /**
     * @var ConfigResolver
     */
    private $configResolver;


    public function __construct(array $prototype, ConfigResolver $configResolver)
    {
        $this->prototype = $prototype;
        $this->configResolver = $configResolver;
    }

    public function createFromFullNameAndConfig(string $name, array $config): Package
    {
        $config = array_merge($this->prototype, $config);

        $config = $this->configResolver->resolveConfig(function (ParameterResolver $resolver) {
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
        }, $config);

        [$vendor, $name] = $this->extractPackageNameParts($name);

        return new Package(
            $vendor,
            $name,
            $config['base_path'],
            $config['modules'],
            $config['config']
        );
    }

    private function extractPackageNameParts(string $fullName)
    {
        $parts = array_filter(explode('/', $fullName), function ($part) {
            return !empty($part);
        });
        
        if (count($parts) !== 2) {
            throw new InvalidArgumentException(sprintf(
                'Invalid package name "%s", expected package name of form <vendor>/<name>',
                $fullName
            ));
        }
        return $parts;
    }
}
