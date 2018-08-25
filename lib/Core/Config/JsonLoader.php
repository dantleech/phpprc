<?php

namespace Phpprc\Core\Config;

use Phpprc\Core\Filesystem;
use Seld\JsonLint\JsonParser;

class JsonLoader
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

    public function __construct(Filesystem $filesystem, JsonParser $parser, ConfigFactory $configFactory)
    {
        $this->filesystem = $filesystem;
        $this->parser = $parser;
        $this->configFactory = $configFactory;
    }

    public function load(): Config
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
            return $this->configFactory->empty();
        }

        $configContents = $this->filesystem->readContents($configFile);

        return $this->configFactory->fromArray($this->parser->parse($configContents, JsonParser::PARSE_TO_ASSOC));
    }
}
