<?php

namespace Phpprc;

use Phpactor\Container\PhpactorContainer;
use Phpprc\Core\Config\JsonLoader;
use Phpprc\Core\Config\Loader;
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
        $extensions = $this->resolveExtensions($parameterResolver);
        $config = $this->loadConfig();

        $container = $this->loadContainer($parameterResolver, $extensions, []);

        return $container;
    }

    private function loadContainer(SymfonyParameterResolver $parameterResolver, array $extensions, array $config)
    {
        $container = new PhpactorContainer($parameterResolver->resolve($config));
        
        foreach ($extensions as $extension) {
            $extension->register($container);
        }

        return $container;
    }

    private function resolveExtensions(SymfonyParameterResolver $parameterResolver)
    {
        $extensions = array_map(function (string $extension) use ($parameterResolver) {
            $extension = new $extension;
            $extension->configure($parameterResolver);
        
            return $extension;
        }, $this->extensions);
        return $extensions;
    }

    private function loadConfig()
    {
        $loader = new JsonLoader();
        return $loader->load();
    }
}
