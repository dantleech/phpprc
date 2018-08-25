<?php

namespace Phpprc;

use Phpactor\Container\PhpactorContainer;
use Phpprc\Core\Config\JsonLoader;
use Phpprc\Core\SymfonyParameterResolver;
use Phpprc\Extension\Core\CoreExtension;
use Phpprc\Extension\Template\TemplateExtension;
use Psr\Container\ContainerInterface;

class Phpprc
{
    /**
     * @var Extension[]
     */
    private $extensions = [
        CoreExtension::class,
        TemplateExtension::class,
    ];

    public function container(): ContainerInterface
    {
        $parameterResolver = new SymfonyParameterResolver();

        $configLoader = new JsonLoader();
        $config = $configLoader->load();

        $extensions = array_map(function (string $extension) use ($parameterResolver) {
            $extension = new $extension;
            $extension->configure($parameterResolver);

            return $extension;
        }, $this->extensions);

        $container = new PhpactorContainer($parameterResolver->resolve($config->toArray()));

        foreach ($extensions as $extension) {
            $extension->register($container);
        }

        return $container;
    }
}
