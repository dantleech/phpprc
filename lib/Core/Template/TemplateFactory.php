<?php

namespace Phpprc\Core\Template;

use Phpprc\Core\Core\ConfigResolver;
use Phpprc\Core\Core\ParameterResolver;

class TemplateFactory
{
    /**
     * @var ConfigResolver
     */
    private $configResolver;

    public function __construct(ConfigResolver $configResolver)
    {
        $this->configResolver = $configResolver;
    }

    public function createFromConfig(array $config)
    {
        $config = $this->configResolver->resolveConfig(function (ParameterResolver $resolver) {
            $resolver->setRequired([
                'source',
                'dest'
            ]);
            $resolver->setAllowedTypes('source', ['string']);
            $resolver->setAllowedTypes('dest', ['string']);
        }, $config);

        return new Template($config['source'], $config['dest']);
    }
}
