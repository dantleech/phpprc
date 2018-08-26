<?php

namespace Phpprc\Core\Template;

class TemplatesFactory
{
    /**
     * @var TemplateFactory
     */
    private $factory;

    public function __construct(TemplateFactory $factory)
    {
        $this->factory = $factory;
    }

    public function createFromTemplateConfig(array $config)
    {
        return new Templates(array_map(function (array $config) {
            return $this->factory->createFromConfig($config);
        }, $config));
    }
}
