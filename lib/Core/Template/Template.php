<?php

namespace Phpprc\Core\Template;

use Webmozart\PathUtil\Path;

class Template
{
    /**
     * @var string
     */
    private $source;

    /**
     * @var string
     */
    private $dest;

    public function __construct(string $source, string $dest)
    {
        $this->source = Path::normalize($source);
        $this->dest = Path::normalize($dest);
    }

    public function dest(): string
    {
        return $this->dest;
    }

    public function source(): string
    {
        return $this->source;
    }
}
