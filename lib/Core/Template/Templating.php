<?php

namespace Phpprc\Core\Template;

interface Templating
{
    public function renderFromTemplate(string $templateBody, array $parameters): string;
}
