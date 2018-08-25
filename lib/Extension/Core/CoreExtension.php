<?php

namespace Phpprc\Extension\Core;

use Phpactor\Container\Container;
use Phpactor\Container\ContainerBuilder;
use Phpprc\Core\Extension;
use Phpprc\Core\ParameterResolver;
use Phpprc\Extension\Core\Console\Application;

class CoreExtension implements Extension
{
    public function configure(ParameterResolver $optionsResolver)
    {
    }

    public function register(ContainerBuilder $container)
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
}
