<?php

namespace Phpprc\Core\Core\Package;

use Webmozart\PathUtil\Path;

class PackagePathGenerator
{
    /**
     * @var string
     */
    private $cwd;

    public function __construct(string $cwd)
    {
        $this->cwd = $cwd;
    }

    public function generateFor(Package $package, $relativePath)
    {
        return Path::join([
            Path::makeAbsolute($package->basePath(), $this->cwd),
            $package->vendor(),
            $package->name(),
            $relativePath
        ]);
    }
}
