<?php

namespace Phpprc\Core\Core\Config;

use Phpprc\Bridge\Core\Seld\SeldJsonParser;
use Phpprc\Core\Core\Filesystem;

class JsonLoader implements Loader
{
    const DIST_FILE = 'phpprc.json.dist';
    const FILE = 'phpprc.json';

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var JsonParser
     */
    private $parser;

    /**
     * @var ConfigFactory
     */
    private $configFactory;

    public function __construct(?Filesystem $filesystem = null, JsonParser $parser = null)
    {
        $this->filesystem = $filesystem ?: new Filesystem(getcwd());
        $this->parser = $parser ?: new SeldJsonParser();
    }

    public function load(): array
    {
        $configFile = null;
        foreach ([
            self::DIST_FILE,
            self::FILE,
        ] as $potentialConfigFile) {
            if ($this->filesystem->existsInCurrentDirectory($potentialConfigFile)) {
                $configFile = $potentialConfigFile;
            }
        }

        if (null === $configFile) {
            return [];
        }

        $configContents = $this->filesystem->readContents($configFile);

        return $this->parser->parse($configContents);

    }
}
