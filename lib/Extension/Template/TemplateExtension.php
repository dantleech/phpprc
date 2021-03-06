<?php

namespace Phpprc\Extension\Template;

use Phpactor\Container\Container;
use Phpactor\Container\ContainerBuilder;
use Phpprc\Bridge\Template\Twig\TwigTemplating;
use Phpprc\Core\Core\ConfigResolver;
use Phpprc\Core\Core\Extension;
use Phpprc\Core\Core\Filesystem;
use Phpprc\Core\Core\Package\PackagePathGenerator;
use Phpprc\Core\Core\Package\Packages;
use Phpprc\Core\Core\ParameterResolver;
use Phpprc\Core\Template\TemplateFactory;
use Phpprc\Core\Template\Templates;
use Phpprc\Core\Template\TemplatesFactory;
use Phpprc\Core\Template\Templating;
use Phpprc\Extension\Template\Command\TemplateApplyCommand;
use Phpprc\Extension\Template\Service\TemplateApply;

class TemplateExtension implements Extension
{
    public function configure(ParameterResolver $parameters)
    {
        $parameters->setDefaults([
            'template.apply' => [],
        ]);
    }

    public function register(ContainerBuilder $container)
    {
        $container->register(TemplateApplyCommand::class, function (Container $container) {
            return new TemplateApplyCommand($container->get(TemplateApply::class));
        }, [ 'console.command' => [] ]);

        $container->register(TemplateApply::class, function (Container $container) {
            return new TemplateApply(
                $container->get(Filesystem::class),
                $container->get(Packages::class),
                $container->get(Templates::class),
                $container->get(Templating::class),
                $container->get(PackagePathGenerator::class)
            );
        });

        $container->register(Templating::class, function (Container $container) {
            return new TwigTemplating();
        });

        $container->register(Templates::class, function (Container $container) {
            return $container->get(TemplatesFactory::class)->createFromTemplateConfig(
                $container->getParameter('template.apply')
            );
        });

        $container->register(TemplatesFactory::class, function (Container $container) {
            return new TemplatesFactory($container->get(TemplateFactory::class));
        });

        $container->register(TemplateFactory::class, function (Container $container) {
            return new TemplateFactory($container->get(ConfigResolver::class));
        });
    }
}
