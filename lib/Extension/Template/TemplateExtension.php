<?php

namespace Phpprc\Extension\Template;

class TemplateExtension
{
    public function register(CoreFactory $core)
    {
        $core->addCommand($this->createTemplateApplyCommand());
    }
}
