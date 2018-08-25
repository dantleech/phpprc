<?php

namespace Phpprc;

use Phpactor\Container\PhpactorContainer;
use Phpprc\Bridge\Symfony\Container\SymfonyParameterResolver;
use Phpprc\Core\Extension;
use Phpprc\Extension\Core\CoreExtension;
use Psr\Container\ContainerInterface;

class Phpprc
{
    /**
     * @var Extension[]
     */
    private $extensions = [
        CoreExtension::class
    ];

    public function container(): ContainerInterface
    {
        $parameterResolver = new SymfonyParameterResolver();

        $extensions = array_map(function (string $extension) use ($parameterResolver) {
            $extension = new $extension;
            $extension->configure($parameterResolver);

            return $extension;
        }, $this->extensions);

        $container = new PhpactorContainer($parameterResolver->resolve());

        foreach ($extensions as $extension) {
            $extension->register($container);
        }

        return $container;
    }
}
