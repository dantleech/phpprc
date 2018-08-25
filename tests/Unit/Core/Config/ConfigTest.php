<?php

namespace Phpprc\Tests\Unit\Core\Config;

use PHPUnit\Framework\TestCase;
use Phpprc\Core\Config\Config;
use Phpprc\Core\Config\ConfiguredPackage;
use Phpprc\Core\Config\ConfiguredPackages;

class ConfigTest extends TestCase
{
    public function testPackages()
    {
        $config = Config::fromArray([
            'packages' => [
                'vendor1/package1' => [],
            ],
        ]);

        $this->assertEquals(new ConfiguredPackages([
            ConfiguredPackage::fromString('vendor1/package1'),
        ]), $config->packages());
    }
}
