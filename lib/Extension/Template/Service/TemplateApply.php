<?php

namespace Phpprc\Extension\Template\Service;

use Phpprc\Core\Core\Filesystem;
use Phpprc\Core\Core\Package\Package;
use Phpprc\Core\Core\Package\PackagePathGenerator;
use Phpprc\Core\Core\Package\Packages;
use Phpprc\Core\Template\Templates;
use Phpprc\Core\Template\Templating;

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

    /**
     * @var PackagePathGenerator
     */
    private $pathGenerator;

    public function __construct(
        Filesystem $filesystem,
        Packages $packages,
        Templates $templates,
        Templating $templating,
        PackagePathGenerator $pathGenerator
    ) {
        $this->filesystem = $filesystem;
        $this->packages = $packages;
        $this->templates = $templates;
        $this->templating = $templating;
        $this->pathGenerator = $pathGenerator;
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
            $rendered = $this->templating->renderFromTemplate($this->filesystem->readContents($template->source()), [
                'package' => $package
            ]);
        
            $this->filesystem->writeToFile(
                $this->pathGenerator->generateFor($package, $template->dest()),
                $rendered
            );
        }
    }
}
