<?php

namespace Phpprc\Core\Core;

use RuntimeException;
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

    public function readContents($path): string
    {
        $path = $this->makeAbsolute($path);
        $this->assertFileExists($path);
        return file_get_contents($path);
    }

    public function writeToFile($file, string $contents)
    {
        $file = $this->makeAbsolute($file);

        if (!file_exists(dirname($file))) {
            mkdir(dirname($file), 0777, true);
        }

        file_put_contents($file, $contents);
    }

    private function assertFileExists($path)
    {
        if (!file_exists($path)) {
            throw new RuntimeException(sprintf(
                'File "%s" does not exist',
                $path
            ));
        }
    }

    private function makeAbsolute(string $path): string
    {
        return Path::makeAbsolute($path, $this->basePath);
    }
}
