<?php

namespace Phpprc\Core\Template;

use IteratorAggregate;

class Templates implements IteratorAggregate
{
    private $templates = [];

    public function __construct(array $templates)
    {
        foreach ($templates as $template) {
            $this->add($template);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getIterator()
    {
        foreach ($this->templates as $template) {
            yield $template;
        }
    }

    private function add(Template $template)
    {
        $this->templates[] = $template;
    }
}
