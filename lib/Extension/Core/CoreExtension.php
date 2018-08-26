<?php

namespace Phpprc\Extension\Core;

use Phpactor\Container\Container;
use Phpactor\Container\ContainerBuilder;
use Phpprc\Core\Core\ConfigResolver;
use Phpprc\Core\Core\Config\JsonLoader;
use Phpprc\Core\Core\Config\Loader;
use Phpprc\Core\Core\Extension;
use Phpprc\Core\Core\Filesystem;
use Phpprc\Core\Core\Package\PackageFactory;
use Phpprc\Core\Core\Package\PackagesFactory;
use Phpprc\Core\Core\ParameterResolver;
use Phpprc\Extension\Core\Console\Application;
use Seld\JsonLint\JsonParser;

class CoreExtension implements Extension
{
    public function configure(ParameterResolver $optionsResolver)
    {
        $optionsResolver->setDefaults([
            'prototype' => [],
            'packages' => [],
        ]);
        $optionsResolver->setRequired([
            'cwd',
        ]);
    }

    public function register(ContainerBuilder $container)
    {
        $this->registerConfig($container);
        $this->registerConsole($container);
        $this->registerPackages($container);
    }

    private function registerConsole(ContainerBuilder $container)
    {
        $container->register(Application::class, function (Container $container) {
            $application = new Application();
        
            foreach ($container->getServiceIdsForTag('console.command') as $serviceId => $attributes) {
                $command = $container->get($serviceId);
                $application->add($command);
            }
        
            return $application;
        });
    }

    private function registerConfig(ContainerBuilder $container)
    {
        $container->register(ConfigResolver::class, function (Container $container) {
            return new ConfigResolver();
        });
    }

    private function registerPackages(ContainerBuilder $container)
    {
        $container->register(PackageFactory::class, function (Container $container) {
            return new PackageFactory($container->getParameter('prototype'), $container->get(ConfigResolver::class));
        });

        $container->register(PackagesFactory::class, function (Container $container) {
            return new PackagesFactory($container->get(PackageFactory::class, $container->getParameter('packages')));
        });
    }
}
