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
use Phpprc\Core\Core\Package\Packages;
use Phpprc\Core\Core\Package\PackagesFactory;
use Phpprc\Core\Core\ParameterResolver;
use Phpprc\Extension\Core\Console\Application;
use Seld\JsonLint\JsonParser;

class CoreExtension implements Extension
{
    const PARAM_PROTOYPE = 'prototype';
    const PARAM_PACKAGES = 'packages';
    const PARAM_MODULES = 'modules';
    const PARAM_CWD = 'cwd';


    public function configure(ParameterResolver $parameters)
    {
        $parameters->setDefaults([
            self::PARAM_PROTOYPE => [],
            self::PARAM_PACKAGES => [],
            self::PARAM_MODULES => [],
        ]);
        $parameters->setRequired([
            self::PARAM_CWD,
        ]);
    }

    public function register(ContainerBuilder $container)
    {
        $this->registerConfig($container);
        $this->registerConsole($container);
        $this->registerPackages($container);
        $container->register(Filesystem::class, function (Container $container) {
            return new Filesystem($container->getParameter(self::PARAM_CWD));
        });
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
        $container->register(Packages::class, function (Container $container) {
            return $container->get(PackagesFactory::class)->createFromArrayOfPackages(
                $container->getParameter(self::PARAM_PACKAGES)
            );
        });

        $container->register(PackageFactory::class, function (Container $container) {
            return new PackageFactory(
                $container->getParameter(self::PARAM_PROTOYPE),
                $container->get(ConfigResolver::class)
            );
        });

        $container->register(PackagesFactory::class, function (Container $container) {
            return new PackagesFactory(
                $container->get(PackageFactory::class),
                $container->getParameter(self::PARAM_PACKAGES)
            );
        });
    }
}
