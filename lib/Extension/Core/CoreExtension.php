<?php

namespace Phpprc\Extension\Core;

use Phpactor\Container\Container;
use Phpactor\Container\ContainerBuilder;
use Phpprc\Core\Config\ConfigFactory;
use Phpprc\Core\Config\JsonLoader;
use Phpprc\Core\Config\Loader;
use Phpprc\Core\Extension;
use Phpprc\Core\Filesystem;
use Phpprc\Core\Package\PackageFactory;
use Phpprc\Core\ParameterResolver;
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
        $container->register(Config::class, function (Container $container) {
            return $container->get(Loader::class)->load();
        });
        $container->register(Loader::class, function (Container $container) {
            return new JsonLoader(
                $container->get(Filesystem::class),
                new JsonParser(),
                $container->get(ConfigFactory::class)
            );
        });
        $container->register(Filesystem::class, function (Container $container) {
            return new Filesystem();
        });
            return new ConfigFactory();
        $container->register(ConfigFactory::class, function (Container $container) {
        });
    }

    private function registerPackages(ContainerBuilder $container)
    {
        $container->register(PackageFactory::class, function (Container $container) {
            return new PackageFactory($container->getParameter('prototype'), $container->getParameter('cwd'));
        });
        $container->register(PackagesFactory::class, function (Container $container) {
            return new PackagesFactory($container->get(PackageFactory::class, $container->getParameter('packages')));
        });
    }
}
