<?php

namespace Phpprc\Extension\Template;

use Phpactor\Container\Container;
use Phpactor\Container\ContainerBuilder;
use Phpprc\Core\Core\Extension;
use Phpprc\Core\Core\ParameterResolver;
use Phpprc\Extension\Template\Command\TemplateApplyCommand;

class TemplateExtension implements Extension
{
    public function configure(ParameterResolver $optionsResolver)
    {
        $optionsResolver->setDefaults([
            'prototype' => [],
            'packages' => [],
        ]);
    }

    public function register(ContainerBuilder $container)
    {
        $container->register(PackagesFactory::class, function (Container $container) {

        });

        $container->register(TemplateApplyCommand::class, function (Container $container) {
            return new TemplateApplyCommand();
        }, [ 'console.command' => [] ]);
    }
}
