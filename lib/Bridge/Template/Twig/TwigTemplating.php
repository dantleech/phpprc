<?php

namespace Phpprc\Bridge\Template\Twig;

use Phpprc\Core\Template\Templating;
use Twig\Environment;
use Twig\Extension\StringLoader;
use Twig\Loader\ArrayLoader;

class TwigTemplating implements Templating
{
    /**
     * @var Environment
     */
    private $twig;

    public function __construct(?Environment $twig = null)
    {
        $this->twig = $twig ?: new Environment(new ArrayLoader(), [
            'strict_variables' => true,
        ]);
    }

    public function renderFromTemplate(string $templateBody, array $parameters): string
    {
        return $this->twig->createTemplate($templateBody)->render($parameters);
    }
}
