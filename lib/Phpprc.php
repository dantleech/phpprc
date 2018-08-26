<?php

namespace Phpprc;

use Phpactor\Container\PhpactorContainer;
use Phpprc\Core\Core\Config\JsonLoader;
use Phpprc\Bridge\Core\Symfony\SymfonyParameterResolver;
use Phpprc\Core\Core\Filesystem;
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

    public function container(string $cwd): ContainerInterface
    {
        $parameterResolver = new SymfonyParameterResolver();
        $extensions = $this->resolveExtensions($parameterResolver);
        $cwd = $cwd ?: getcwd();
        $config = $this->loadConfig($cwd);
        $config['cwd'] = $cwd;

        $container = $this->loadContainer($parameterResolver, $extensions, $config);

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

    private function loadConfig(string $cwd)
    {
        $loader = new JsonLoader(new Filesystem($cwd));
        return $loader->load();
    }
}
