<?php

namespace Phpprc\Core\Core;

use Webmozart\PathUtil\Path;

class Filesystem
{
    /**
     * @var string
     */
    private $basePath;

    public function __construct(string $basePath)
    {
        $basePath = Path::normalize($basePath);

        if (false === file_exists($basePath)) {
            throw new RuntimeException(sprintf(
                'Base directory "%s" does exist',
                $basePath
            ));
        }

        if (false === is_dir($basePath)) {
            throw new RuntimeException(sprintf(
                'Path given as base path to filesystem "%s" is not a directory',
                $basePath
            ));
        }

        $this->basePath = $basePath;
    }

    public function existsInCurrentDirectory($relativePath): bool
    {
        return file_exists(Path::join([$this->basePath, $relativePath]));
    }

    public function readContents($configFile): string
    {
        $this->assertFileExists($configFile);
        return file_get_contents($configFile);
    }

    private function assertFileExists($configFile)
    {
        if (!file_exists($configFile)) {
            throw new RuntimeException(sprintf(
                'File "%s" does not exist',
                $configFile
            ));
        }
    }
}
