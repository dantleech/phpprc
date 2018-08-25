<?php

namespace Phpprc\Tests\Unit\Core\Config;

use PHPUnit\Framework\TestCase;
use Phpprc\Core\Config\Config;
use Phpprc\Core\Config\ConfigFactory;
use Phpprc\Core\Config\JsonLoader;
use Phpprc\Core\Filesystem;
use Seld\JsonLint\JsonParser;

class JsonLoaderTest extends TestCase
{
    /**
     * @var ObjectProphecy
     */
    private $filesystem;

    /**
     * @var JsonParser
     */
    private $parser;

    /**
     * @var ObjectProphecy
     */
    private $configFactory;

    /**
     * @var ObjectProphecy
     */
    private $config;

    /**
     * @var JsonLoader
     */
    private $loader;

    public function setUp()
    {
        $this->filesystem = $this->prophesize(Filesystem::class);
        $this->parser = new JsonParser();
        $this->configFactory = $this->prophesize(ConfigFactory::class);
        $this->config = $this->prophesize(Config::class);

        $this->loader = new JsonLoader(
            $this->filesystem->reveal(),
            $this->parser,
            $this->configFactory->reveal()
        );
    }

    public function testEmptyConfigIfNoConfigFound()
    {
        $this->filesystem->existsInCurrentDirectory(JsonLoader::DIST_FILE)->willReturn(false);
        $this->filesystem->existsInCurrentDirectory(JsonLoader::FILE)->willReturn(false);

        $this->configFactory->empty()->willReturn($this->config->reveal());

        $this->assertEquals($this->config->reveal(), $this->loader->load());
    }

    public function testLoadsDistFile()
    {
        $this->filesystem->existsInCurrentDirectory(JsonLoader::DIST_FILE)->willReturn(true);
        $this->filesystem->existsInCurrentDirectory(JsonLoader::FILE)->willReturn(false);

        $this->filesystem->readContents(JsonLoader::DIST_FILE)->willReturn('{"one":"two"}');
        $this->configFactory->fromArray(['one'=>'two'])->willReturn($this->config->reveal());

        $this->assertEquals($this->config->reveal(), $this->loader->load());
    }

    public function testLoadsStandardFile()
    {
        $this->filesystem->existsInCurrentDirectory(JsonLoader::DIST_FILE)->willReturn(true);
        $this->filesystem->existsInCurrentDirectory(JsonLoader::FILE)->willReturn(true);

        $this->filesystem->readContents(JsonLoader::FILE)->willReturn('{"one":"two"}');
        $this->configFactory->fromArray(['one'=>'two'])->willReturn($this->config->reveal());

        $this->assertEquals($this->config->reveal(), $this->loader->load());
    }
}
