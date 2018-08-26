<?php

namespace Phpprc\Extension\Template\Service;

use Phpprc\Core\Core\Filesystem;
use Phpprc\Core\Core\Config\ConfiguredPackages;
use Phpprc\Core\Core\Package\Packages;
use Phpprc\Core\Template\Templates;
use Phpprc\Core\Template\Templating;
use Twig\Environment;

class TemplateApply
{
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

    /**
     * @var Templating
     */
    private $templating;

    public function __construct(
        Filesystem $filesystem,
        Packages $packages,
        Templates $templates,
        Templating $templating
    ) {
        $this->filesystem = $filesystem;
        $this->packages = $packages;
        $this->templates = $templates;
        $this->templating = $templating;
    }

    public function apply()
    {
        foreach ($this->packages as $package) {
            $this->applyTemplates($package);
        }
    }

    private function applyTemplates(Package $package)
    {
        foreach ($this->templates as $template) {
            $rendered = $this->templating->renderFromTemplate($template->contents(), [
                'package' => $package->variables()
            ]);
        
            $this->filesystem->writeToFile($package->path($template->dest()), $rendered);
        }
    }
}
