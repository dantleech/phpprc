<?php

namespace Phpprc\Extension\Template\Service;

use Phpprc\Core\Filesystem;
use Phpprc\Core\Package\SelectedPackages;
use Twig\Environment;

class TemplateApply
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var SelectedPackages
     */
    private $packages;

    /**
     * @var Templates
     */
    private $templates;

    public function __construct(
        SelectedPackages $packages,
        Templates $templates,
        Filesystem $filesystem,
        Environment $twig
    ) {
        $this->twig = $twig;
        $this->filesystem = $filesystem;
        $this->packages = $packages;
        $this->templates = $templates;
    }

    public function apply()
    {
        foreach ($this->packages as $package) {
            foreach ($this->templates as $template) {
                $template = $this->twig->createTemplate($template->contents());

                $this->filesystem->writeToFile($template->path(), $template->render([
                    'package' => $package->variables()
                ]));
            }
        }
    }
}
